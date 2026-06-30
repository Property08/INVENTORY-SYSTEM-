<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Rpcppe;
use App\Exports\RecordExport;
use App\Exports\FolderExport; 
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class RecordController extends Controller
{
    /**
     * PRIVATE HELPER: Asset Label Mapping
     */
    private function getAssetMapping()
    {
        return [
            '201' => 'LAND', 
            '202' => 'LAND IMPROVEMENT', 
            '211' => 'BUILDING AND STRUCTURE',
            '215' => 'OTHER STRUCTURES', 
            '221' => 'OFFICE EQUIPMENT', 
            '208' => 'MEDICAL, DENTAL & LABORATORY EQUIPMENT',
            '241' => 'MOTOR VEHICLES', 
            '236' => 'TECHNICAL & SCIENTIFIC EQUIPMENT', 
            '240' => 'OTHER MACHINERIES & EQUIPMENT',
            '235' => 'SPORTS EQUIPMENT', 
            '223' => 'INFORMATION AND COMM. TECH. EQUIPMENT', 
            '229' => 'COMMUNICATION EQUIPMENT',
            '250' => 'HANDS TOOL', 
            '255' => 'INDUSTRIAL MACHINES & IMPLEMENTS', 
            '254' => 'ARTESIAN WELLS',
            '222' => 'OFFICE FURNITURES', 
            '10605120' => 'PRINTING EQUIPMENT', 
            '10605010' => 'MACHINERY & EQUIPMENT',
            '10603060' => 'COMMUNICATION NETWORK', 
            'HV' => 'SEMI-EXPENDABLE (High Value)', 
            'LV' => 'SEMI-EXPENDABLE (Low Value)',
            '218' => 'DONATION JICA',
            'GIA-13' => 'GIA',
        ];
    }

    /**
     * 1. MAIN ARCHIVE PAGE
     */
    public function index(Request $request)
    {
        // 1. Retrieve available years for the filter dropdown
        $availableYears = Rpcppe::selectRaw("
                DISTINCT CASE 
                    WHEN date_acquired LIKE '%-%' AND LENGTH(date_acquired) > 4 THEN YEAR(STR_TO_DATE(date_acquired, '%Y-%m-%d'))
                    ELSE LEFT(TRIM(date_acquired), 4)
                END as year
            ")
            ->whereNotNull('date_acquired')
            ->whereRaw("TRIM(date_acquired) != ''")
            ->orderBy('year', 'desc')
            ->pluck('year');

        // 2. Get the selected year from the request input
        $selectedYear = $request->input('year'); 

        // 3. Query folders based on the property number prefix/category
        // INAYOS: Tinanggal ang whereRaw para hindi mabawasan ang records, at nilinis ang ₱ symbol sa math logic.
        $foldersQuery = Rpcppe::selectRaw("
                UPPER(TRIM(SUBSTRING_INDEX(property_no, '-', 1))) as prefix,
                COUNT(*) as total,
                SUM(
                    /* 1. NILINIS ANG UNIT VALUE: Tinanggal ang ₱, kuwit, at space */
                    CAST(
                        REPLACE(
                            REPLACE(
                                REPLACE(IFNULL(unit_value, '0'), '₱', ''), 
                            ',', ''), 
                        ' ', '') 
                    AS DECIMAL(15,4)) 
                    * /* 2. NILINIS ANG QUANTITY: Kung walang physical count, gagamit ng property card qty, kundi laging 1 */
                    CAST(
                        CASE 
                            WHEN quantity_per_physical_count IS NOT NULL AND TRIM(quantity_per_physical_count) != '' AND quantity_per_physical_count != 0 
                                THEN quantity_per_physical_count
                            WHEN quantity_per_property_card IS NOT NULL AND TRIM(quantity_per_property_card) != '' AND quantity_per_property_card != 0 
                                THEN quantity_per_property_card
                            ELSE 1
                        END
                    AS DECIMAL(15,4))
                ) as total_amount
            ");

        // Flexible Year Filtering
        if ($selectedYear) {
            $foldersQuery->where(function ($q) use ($selectedYear) {
                $q->whereYear('date_acquired', $selectedYear)
                  ->orWhere('date_acquired', 'LIKE', $selectedYear . '%');
            });
        }

        $foldersData = $foldersQuery->groupBy('prefix')->get();

        $mapping = $this->getAssetMapping();

        $folders = $foldersData->map(function($f) {
            /** @var \stdClass|\Illuminate\Database\Eloquent\Model $f */
            $f->label = $this->getAssetMapping()[$f->prefix] ?? 'OTHER PROPERTY, PLANT AND EQUIPMENT';
            return $f;
        });

        // 4. Handle sub-views when a specific folder is active
        $inventoryItems = collect();
        if ($request->has('folder')) {
            $itemsQuery = Rpcppe::whereRaw("UPPER(TRIM(SUBSTRING_INDEX(property_no, '-', 1))) = ?", [$request->input('folder')]);
            
            if ($selectedYear) {
                $itemsQuery->where(function ($q) use ($selectedYear) {
                    $q->whereYear('date_acquired', $selectedYear)
                      ->orWhere('date_acquired', 'LIKE', $selectedYear . '%');
                });
            }
            
            /** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */
            $paginator = $itemsQuery->orderBy('property_no')->paginate(15);
            $inventoryItems = $paginator->withQueryString();
        }

        // Fetch generalized records for the alternate view tab
        $records = Record::orderBy('year', 'desc')->get(); 

        return view('records.index', compact('records', 'folders', 'availableYears', 'selectedYear', 'inventoryItems'));
    }

    /**
     * 2. EXPORT FOLDER TO EXCEL
     */
    public function exportFolder(Request $request)
    {
        try {
            $folderName = $request->input('folder');
            $selectedYear = $request->input('year') ?: ''; 
            
            if (!$folderName) {
                return redirect()->back()->with('error', 'No folder specified for export.');
            }

            $mapping = $this->getAssetMapping();
            $exportClass = new FolderExport($folderName, $selectedYear, $mapping);
            
            $yearLabel = $selectedYear ? '_FY' . $selectedYear : '_CONSOLIDATED';
            $fileName = 'RPCPPE_Report_' . $folderName . $yearLabel . '_' . now()->format('Y-m-d') . '.xlsx';

            return Excel::download($exportClass, $fileName);

        } catch (\Exception $e) {
            Log::error('Export Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error during export: ' . $e->getMessage());
        }
    }

    /**
     * Alias method for the export-filtered route mapping
     */
    public function exportFiltered(Request $request)
    {
        return $this->exportFolder($request);
    }

    /**
     * 3. INVENTORY STORAGE (Search View)
     */
    public function inventoryStorage(Request $request)
    {
        $mapping = $this->getAssetMapping();

        $rawFolders = Rpcppe::selectRaw("UPPER(TRIM(SUBSTRING_INDEX(property_no, '-', 1))) as prefix, COUNT(*) as total")
            ->groupBy(DB::raw("UPPER(TRIM(SUBSTRING_INDEX(property_no, '-', 1)))"))
            ->orderBy('prefix')
            ->get();

        $folders = $rawFolders->map(function($f) use ($mapping) {
            /** @var \stdClass|\Illuminate\Database\Eloquent\Model $f */
            $f->label = $mapping[$f->prefix] ?? 'OTHER ASSETS';
            return $f;
        })->filter(function($f) {
            /** @var \stdClass|\Illuminate\Database\Eloquent\Model $f */
            return $f->label !== 'OTHER ASSETS';
        });

        $items = null;
        if ($request->filled('folder') || $request->filled('description')) {
            $query = Rpcppe::query();
            
            if ($request->filled('folder')) {
                $query->whereRaw("UPPER(TRIM(SUBSTRING_INDEX(property_no, '-', 1))) = ?", [$request->folder]);
            }
            
            if ($request->filled('description')) {
                $query->where('description', 'like', '%' . $request->description . '%');
            }
            
            /** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */
            $paginator = $query->orderBy('property_no')->paginate(15);
            $items = $paginator->withQueryString();
        }

        return view('records.inventory_storage', compact('folders', 'items'));
    }

    /**
     * 4. GENERATE PDF REPORT
     */
    public function pdf(Record $record)
    {
        $pdf = Pdf::loadView('records.pdf', compact('record'));
        return $pdf->download('record_' . $record->year . '.pdf');
    }

    /**
     * 5. EXPORT YEARLY RECAP (Excel)
     */
    public function excel(Record $record)
    {
        $record->load('recaps');
        $fileName = 'Yearly_Recap_Report_' . $record->year . '_' . now()->format('Y-m-d') . '.xlsx';
        return Excel::download(new RecordExport($record), $fileName);
    }

    /**
     * 6. DELETE RECORD
     */
    public function destroy(Record $record)
    {
        $record->delete();
        return redirect()->route('records.index')->with('success', 'Record deleted successfully.');
    }
}