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
     * PRIVATE HELPER: Mapping para sa Asset Labels
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
        // 1. Kunin ang mga available na taon para sa filter dropdown (distinct years mula sa date_acquired ng Rpcppe)
        $availableYears = Rpcppe::selectRaw('YEAR(date_acquired) as year')
            ->whereNotNull('date_acquired')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // 2. Kunin ang napiling taon mula sa request para magamit sa filtering at export logic (Kung walang pinili, magiging null o empty string ito)
        $selectedYear = $request->input('year'); 

        // 3. I-query ang folders base sa prefix/category
        $foldersQuery = Rpcppe::selectRaw("
                UPPER(TRIM(SUBSTRING_INDEX(property_no, '-', 1))) as prefix,
                COUNT(*) as total,
                SUM(unit_value * quantity_per_physical_count) as total_amount
            ")
            ->whereRaw("property_no LIKE '%-%'");

        if ($selectedYear) {
            $foldersQuery->whereYear('date_acquired', $selectedYear);
        }

        $foldersData = $foldersQuery->groupBy('prefix')->get();

        $mapping = $this->getAssetMapping();

        $folders = $foldersData->map(function($f) use ($mapping) {
            $f->label = $mapping[$f->prefix] ?? 'OTHER PROPERTY, PLANT AND EQUIPMENT';
            return $f;
        });

        // 4. Kapag may piniling specific folder (Sub-view Inside Folder)
        $inventoryItems = collect();
        if ($request->has('folder')) {
            $itemsQuery = Rpcppe::whereRaw("UPPER(TRIM(SUBSTRING_INDEX(property_no, '-', 1))) = ?", [$request->input('folder')]);
            
            if ($selectedYear) {
                $itemsQuery->whereYear('date_acquired', $selectedYear);
            }
            
            $inventoryItems = $itemsQuery->orderBy('property_no')->paginate(15)->withQueryString();
        }

        // Kunin din ang pangkalahatang records para sa kabilang tab gamit ang Record Model mo
        $records = Record::orderBy('year', 'desc')->get(); 

        return view('records.index', compact('records', 'folders', 'availableYears', 'selectedYear', 'inventoryItems'));
    }

    /**
     * 2. EXPORT FOLDER TO EXCEL (Tugma sa records.export_folder at records.export_filtered)
     */
    public function exportFolder(Request $request)
    {
        try {
            $folderName = $request->input('folder');
            
            // Ligtas na fallback: kung walang year filter, ipasa ang walang laman ('') para mag-consolidate ang Excel
            $selectedYear = $request->input('year') ?: ''; 
            
            if (!$folderName) {
                return redirect()->back()->with('error', 'No folder specified for export.');
            }

            $mapping = $this->getAssetMapping();

            // Tinatawag ang FolderExport class gamit ang malinis na parameters
            $exportClass = new FolderExport($folderName, $selectedYear, $mapping);
            
            // Nagbabago ang filename base sa kung may filter o consolidated ang download state
            $yearLabel = $selectedYear ? '_FY' . $selectedYear : '_CONSOLIDATED';
            $fileName = 'RPCPPE_Report_' . $folderName . $yearLabel . '_' . now()->format('Y-m-d') . '.xlsx';

            return Excel::download($exportClass, $fileName);

        } catch (\Exception $e) {
            Log::error('Export Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error during export: ' . $e->getMessage());
        }
    }

    /**
     * Alias method para sa export-filtered route para sumalo sa iisang download template logic
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
            ->whereRaw("property_no LIKE '%-%'")
            ->groupBy(DB::raw("UPPER(TRIM(SUBSTRING_INDEX(property_no, '-', 1)))"))
            ->orderBy('prefix')
            ->get();

        $folders = $rawFolders->map(function($f) use ($mapping) {
            $f->label = $mapping[$f->prefix] ?? 'OTHER ASSETS';
            return $f;
        })->filter(function($f) {
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
            
            $items = $query->orderBy('property_no')->paginate(15)->withQueryString();
        }

        return view('records.inventory_storage', compact('folders', 'items'));
    }

    /**
     * 4. GENERATE PDF
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