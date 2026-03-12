<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Rpcppe;
use App\Exports\RecordExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

// PhpSpreadsheet Imports
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;

class RecordController extends Controller
{
    /**
     * PRIVATE HELPER: Mapping para sa Asset Labels
     * Nilagay ko dito para hindi paulit-ulit ang code sa index at inventoryStorage.
     */
    private function getAssetMapping()
    {
        return [
            '201' => 'LAND', 
            '202' => 'LAND IMPROVEMENT', 
            '211' => 'BUILDING AND STRUCTURE',
            '215' => 'OTHER STRUCTURES', 
            '221' => 'OFFICE EQUIPMENT', 
            '208' => 'MEDICAL, DENTAL & LAB',
            '241' => 'MOTOR VEHICLES', 
            '236' => 'TECHNICAL & SCIENTIFIC', 
            '240' => 'OTHER MACHINERIES',
            '223' => 'ICT EQUIPMENT', 
            '229' => 'COMMUNICATION EQUIPMENT', 
            'HV'  => 'SEMI-EXPENDABLE (HV)',
            'LV'  => 'SEMI-EXPENDABLE (LV)',
            '250' => 'HANDS TOOL',
            '255D' => 'INDUSTRIAL MACHINES & IMPLEMENTS',
            '254' => 'ARTESIAN WELLS',
            '222' => 'OFFICE FURNITURES',
            '10605120' => 'PRINTING EQUIPMENT',
            '10605010' => 'MACHINERY & EQUIPMENT',
            '10603060' => 'NETWORK EQUIPMENT',
             // Add more mappings as needed
        ];
    }

    /**
     * 1. MAIN ARCHIVE PAGE
     */
    public function index(Request $request)
    {
        // Kunin ang lahat ng yearly records
        $records = Record::with('recaps')->orderBy('year', 'desc')->get();

        foreach ($records as $record) {
            $record->totals = [
                'beginning'    => $record->recaps->sum('beginning_balance'),
                'purchases'    => $record->recaps->sum('purchases'),
                'reclass_from' => $record->recaps->sum('reclass_from'),
                'reclass_to'   => $record->recaps->sum('reclass_to'),
                'disposed'     => $record->recaps->sum('disposed'),
                'donated'      => $record->recaps->sum('donated'),
                'adjustments'  => $record->recaps->sum('adjustments'),
                'total'        => $record->recaps->sum('total_as_of'),
            ];
        }

        // Mapping ng Labels
        $mapping = $this->getAssetMapping();

        // QUERY PARA SA FOLDERS
        $rawFolders = Rpcppe::selectRaw("UPPER(TRIM(SUBSTRING_INDEX(property_no, '-', 1))) as prefix, COUNT(*) as total")
            ->groupBy(DB::raw("UPPER(TRIM(SUBSTRING_INDEX(property_no, '-', 1)))"))
            ->orderBy('prefix')
            ->get();

        // Idagdag ang label base sa mapping
        $folders = $rawFolders->map(function($f) use ($mapping) {
            $f->label = $mapping[$f->prefix] ?? 'OTHER ASSETS';
            return $f;
        });

        // QUERY PARA SA ITEMS
        $query = Rpcppe::query();
        if ($request->filled('folder')) {
            $query->whereRaw("UPPER(TRIM(SUBSTRING_INDEX(property_no, '-', 1))) = ?", [$request->folder]);
        }

        $inventoryItems = $query->orderBy('property_no')->paginate(15)->withQueryString();

        return view('records.index', compact('records', 'folders', 'inventoryItems'));
    }

    /**
     * 2. EXPORT FOLDER TO EXCEL (With Template)
     */
    public function exportFolder(Request $request)
    {
        $templatePath = storage_path('app/templates/Accountability_template.xlsx');
        
        if (!file_exists($templatePath)) { 
            return redirect()->back()->with('error', 'Template not found at: ' . $templatePath); 
        }

        try {
            $folderName = $request->input('folder', 'All');
            
            $query = Rpcppe::query();
            if ($request->filled('folder')) {
                $query->whereRaw("UPPER(TRIM(SUBSTRING_INDEX(property_no, '-', 1))) = ?", [$folderName]);
            }

            $items = $query->orderBy('property_no', 'asc')->get();

            if ($items->isEmpty()) {
                return redirect()->back()->with('error', 'Walang data na makita para sa folder: ' . $folderName);
            }

            // Load Template
            $spreadsheet = IOFactory::load($templatePath);
            $sheet = $spreadsheet->getActiveSheet();

            $row = 16; // Start row sa template
            foreach ($items as $item) {
                $sheet->setCellValue("A{$row}", $item->article);
                $sheet->setCellValue("B{$row}", $item->description);
                $sheet->setCellValue("C{$row}", $item->property_no);
                $sheet->setCellValue("D{$row}", $item->unit_of_measure);
                $sheet->setCellValue("E{$row}", $item->unit_value);
                $sheet->setCellValue("F{$row}", $item->quantity_per_property_card);
                $sheet->setCellValue("G{$row}", $item->quantity_per_physical_count);
                $sheet->setCellValue("H{$row}", $item->shortage_overage_qty);
                $sheet->setCellValue("I{$row}", $item->shortage_overage_value);
                $sheet->setCellValue("J{$row}", $item->remarks);

                // Optional/Extra Columns
                $sheet->setCellValue("K{$row}", $item->date_acquired);
                $sheet->setCellValue("L{$row}", $item->accountable_person);
                $sheet->setCellValue("M{$row}", $item->location);
                $sheet->setCellValue("N{$row}", $item->division);
                $sheet->setCellValue("O{$row}", $item->section_unit);

                // Apply Borders
                $sheet->getStyle("A{$row}:P{$row}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                
                $row++;
            }

            $fileName = 'RPCPPE_Report_' . $folderName . '_' . now()->format('Y-m-d') . '.xlsx';
            $writer = new Xlsx($spreadsheet);

            if (ob_get_contents()) ob_end_clean();

            return response()->streamDownload(function() use ($writer) { 
                $writer->save('php://output'); 
            }, $fileName);

        } catch (\Exception $e) {
            Log::error('Export Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error during export: ' . $e->getMessage());
        }
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
            $f->label = $mapping[$f->prefix] ?? 'OTHER ASSETS';
            return $f;
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
     * 4. GENERATE PDF (Yearly Recap)
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
        return Excel::download(new RecordExport($record), 'record_' . $record->year . '.xlsx');
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