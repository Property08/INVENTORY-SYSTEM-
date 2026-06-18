<?php

namespace App\Http\Controllers;

use App\Models\Rpcppe;
use App\Models\Disposable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Imports\RpcppeImport;
use Illuminate\Support\Facades\Log;

class RpcppeController extends Controller
{
    // Ginagamit para sa consistent na mapping sa buong controller
    private function getClassificationMapping($prefix)
    {
        $prefix = strtoupper(trim($prefix));
        $mapping = [
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
            'GIA-13 ' => 'GIA',
        ];

        return $mapping[$prefix] ?? 'OTHERS';
    }

    private function buildQuery(Request $request)
    {
        $query = Rpcppe::query();

        if ($request->filled('article')) {
            $query->where('article', 'like', "%{$request->article}%");
        }
        if ($request->filled('property_no')) {
            $query->where('property_no', 'like', "%{$request->property_no}%");
        }

        // GENERAL SEARCH (People / Remarks)
        if ($request->filled('search_general')) {
            $search = $request->search_general;
            $query->where(function($q) use ($search) {
                $q->where('accountable_person', 'LIKE', "%{$search}%")
                  ->orWhere('transfer_to', 'LIKE', "%{$search}%")
                  ->orWhere('remarks', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('location')) {
            $query->where('location', 'LIKE', '%' . $request->location . '%');
        }
        if ($request->filled('division')) {
            $query->where('division', 'LIKE', '%' . $request->division . '%');
        }
        if ($request->filled('description')) {
            $query->where('description', 'like', "%{$request->description}%");
        }

        if ($request->filled('date_acquired')) {
            $query->where('date_acquired', 'LIKE', '%' . $request->date_acquired . '%');
        }

        return $query;
    }

    public function index(Request $request)
    {
        $allPropertyNumbers = Rpcppe::distinct()->pluck('property_no')->sort();
        $locations = Rpcppe::whereNotNull('location')->distinct()->pluck('location')->sort();
        
        $names1 = Rpcppe::whereNotNull('accountable_person')->distinct()->pluck('accountable_person');
        $names2 = Rpcppe::whereNotNull('transfer_to')->distinct()->pluck('transfer_to');
        $allNames = $names1->merge($names2)->unique()->sort();
        
        $items = $this->buildQuery($request)
                    ->orderBy('property_no', 'asc')
                    ->orderBy('date_acquired', 'desc')
                    ->paginate(50) 
                    ->withQueryString();

        return view('rpcppe.index', compact('items', 'locations', 'allNames', 'allPropertyNumbers'));
    }

    public function create()
    {
        return view('rpcppe.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_no' => 'required|string|unique:rpcppe,property_no', 
            'article' => 'nullable|string',
            'description' => 'nullable|string',
            'unit_of_measure' => 'nullable|string',
            'unit_value' => 'nullable|numeric',
            'quantity_per_property_card' => 'nullable|integer',
            'quantity_per_physical_count' => 'nullable|integer',
            'shortage_overage_qty' => 'nullable|integer',
            'shortage_overage_value' => 'nullable|numeric',
            'remarks' => 'nullable|string',
            'date_acquired' => 'nullable|string|max:255',
            'accountable_person' => 'nullable|string',
            'location' => 'nullable|string',
            'division' => 'nullable|string',
            'section_unit' => 'nullable|string',
            'ptsd' => 'nullable|string',
            'transfer_to' => 'nullable|string',
        ], [
            'property_no.unique' => ' (' . $request->property_no . ') nauna nang nakarehistro.',
        ]);

        $prefix = explode('-', $request->property_no)[0];
        $validated['classification'] = $this->getClassificationMapping($prefix);

        Rpcppe::create($validated);
        return redirect()->route('rpcppe.index')->with('success', 'New record added successfully!');
    }

    public function edit(int $id)
    {
        $rpcppe = Rpcppe::findOrFail($id);
        return view('rpcppe.edit', compact('rpcppe'));
    }

    public function update(Request $request, int $id)
    {
        $rpcppe = Rpcppe::findOrFail($id);
        
        $validated = $request->validate([
            'property_no' => 'required|string|unique:rpcppe,property_no,' . $id, 
            'article' => 'nullable|string',
            'description' => 'nullable|string',
            'unit_of_measure' => 'nullable|string',
            'unit_value' => 'nullable|numeric',
            'quantity_per_property_card' => 'nullable|integer',
            'quantity_per_physical_count' => 'nullable|integer',
            'shortage_overage_qty' => 'nullable|integer',
            'shortage_overage_value' => 'nullable|numeric',
            'remarks' => 'nullable|string',
            'date_acquired' => 'nullable|string|max:255',
            'accountable_person' => 'nullable|string',
            'location' => 'nullable|string',
            'division' => 'nullable|string',
            'section_unit' => 'nullable|string',
            'ptsd' => 'nullable|string', 
            'transfer_to' => 'nullable|string', 
        ]);

        $prefix = explode('-', $request->property_no)[0];
        $validated['classification'] = $this->getClassificationMapping($prefix);

        $rpcppe->update($validated);

        return redirect()->route('rpcppe.index', ['folder' => strtoupper($prefix)])
                         ->with('success', 'Record updated and moved to ' . $validated['classification']);
    }

    public function destroy(Request $request, int $id)
    {
        $item = Rpcppe::findOrFail($id);

        if ($request->action_type === 'permanent') {
            $item->delete();
            return redirect()->route('rpcppe.index')->with('success', 'Record permanently deleted.');
        }

        DB::beginTransaction();
        try {
            $rawDate = $item->date_acquired;
            $formattedDate = null;

            if (!empty($rawDate)) {
                try {
                    $formattedDate = Carbon::parse($rawDate)->format('Y-m-d');
                } catch (\Exception $e) {
                    if (preg_match('/(\d{4})/', $rawDate, $matches)) {
                        $formattedDate = $matches[1] . "-01-01";
                    }
                }
            }

            Disposable::create([
                'property_number' => $item->property_no,
                'name'            => $item->accountable_person ?? 'N/A',
                'quantity'        => $item->quantity_per_physical_count ?? 0,
                'description'     => $item->description,
                'DateAcquired'    => $formattedDate,
                'year'            => preg_replace('/[^0-9]/', '', $item->date_acquired) ?: date('Y'),
                'WMR_num'         => 'WMR-' . now()->format('Ymd') . '-' . $item->id, 
                'unit_value'      => $item->unit_value ?? 0,
                'article'         => $item->article ?? 'N/A',
            ]);

            $item->delete(); 
            DB::commit();
            return redirect()->route('rpcppe.index')->with('success', 'Item moved to Disposal list.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Disposal Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Database Error: ' . $e->getMessage());
        }
    }

    public function printTable(Request $request)
    {
        set_time_limit(300); 
        $items = $this->buildQuery($request)->orderBy('property_no', 'asc')->get();
        $pdf = Pdf::loadView('rpcppe.reports.table', compact('items'))->setPaper('a4', 'landscape');
        return $pdf->stream('rpcppe_table.pdf');
    }

    public function appendix73(Request $request)
    {
        set_time_limit(0); 
        ini_set('memory_limit', '1G'); 
        $items = $this->buildQuery($request)->orderBy('property_no', 'asc')->get();
        $pdf = Pdf::loadView('rpcppe.reports.appendix73', compact('items'))->setPaper('legal', 'landscape');
        return $pdf->stream('rpcppe_appendix73.pdf');
    }

    // 🏆 FIXED WITH TWISTS: DIREKTA SA TEMPLATE MO + SEARCH FILTER + COMBINED REMARKS
    public function appendix73Export(Request $request)
    {
        $templatePath = storage_path('app/templates/Appendix73-RPCPPE..xlsx');
        
        if (!file_exists($templatePath)) { 
            return redirect()->back()->with('error', 'Excel template not found sa: storage/app/templates/Appendix73-RPCPPE..xlsx'); 
        }

        try {
            $spreadsheet = IOFactory::load($templatePath);
            $sheet = $spreadsheet->getActiveSheet();

            // TWIST 2: Sumusunod sa kung ano lang ang aktwal na hinahanap sa search fields
            $items = $this->buildQuery($request)->orderBy('property_no', 'asc')->get();

            if ($items->isEmpty()) {
                return redirect()->back()->with('error', 'Walang nahanap na records base sa iyong search para i-export.');
            }

            $row = 16; 
            foreach ($items as $item) {
                // Column C to I: Standard cells
               $sheet->setCellValue("C{$row}", $item->article);
                $sheet->setCellValue("D{$row}", $item->description);
                $sheet->setCellValue("E{$row}", $item->property_no);
                $sheet->setCellValue("F{$row}", $item->unit_of_measure);
                $sheet->setCellValue("G{$row}", $item->unit_value);
                $sheet->setCellValue("H{$row}", $item->quantity_per_property_card);
                $sheet->setCellValue("I{$row}", $item->quantity_per_physical_count);

                // HIWALAY NA COLUMN PARA SA QTY AT VALUE (Para hindi mag-overlap)
                $sheet->setCellValue("J{$row}", $item->shortage_overage_qty);
                $sheet->setCellValue("K{$row}", $item->shortage_overage_value);

                // TWIST 1: Ilagay ang pinagsamang extra details sa Column L (Remarks)
                $extraDetails = [];
                if (!empty($item->date_acquired))      $extraDetails[] = "Date: " . $item->date_acquired;
                if (!empty($item->location))           $extraDetails[] = "Loc: " . $item->location;
                if (!empty($item->accountable_person)) $extraDetails[] = "Acct Person: " . $item->accountable_person;
                if (!empty($item->division))           $extraDetails[] = "Div: " . $item->division;
                if (!empty($item->section_unit))       $extraDetails[] = "Sec: " . $item->section_unit;
                if (!empty($item->remarks))            $extraDetails[] = "Remarks: " . $item->remarks;

                $combinedRemarks = implode(' | ', $extraDetails);
                $sheet->setCellValue("L{$row}", $combinedRemarks); // Inilipat sa Column L

                // Siguraduhing kasama ang Column L sa border styling
                $sheet->getStyle("C{$row}:L{$row}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $row++;
            }

            $fileName = 'Appendix_73_Filtered_Report_' . now()->format('Ymd_His') . '.xlsx';
            $writer = new Xlsx($spreadsheet);
            
            if (ob_get_contents()) ob_end_clean();
            return response()->streamDownload(function() use ($writer) { 
                $writer->save('php://output'); 
            }, $fileName, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);

        } catch (\Exception $e) {
            Log::error('Appendix 73 Template Export Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Export failed: ' . $e->getMessage());
        }
    }

    public function exportExcel(Request $request)
    {
        $templatePath = storage_path('app/templates/Accountability_template.xlsx');
        if (!file_exists($templatePath)) { 
            return redirect()->back()->with('error', 'Excel template not found.'); 
        }

        try {
            $spreadsheet = IOFactory::load($templatePath);
            $sheet = $spreadsheet->getActiveSheet();

            $items = $request->has('all') 
                ? Rpcppe::orderBy('property_no', 'asc')->get() 
                : $this->buildQuery($request)->orderBy('property_no', 'asc')->get();

            if ($items->isEmpty()) {
                return redirect()->back()->with('error', 'No records found to export.');
            }

            $row = 16; 
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
                $sheet->setCellValue("K{$row}", $item->date_acquired);
                $sheet->setCellValue("L{$row}", $item->accountable_person);
                $sheet->setCellValue("M{$row}", $item->transfer_to);
                $sheet->setCellValue("N{$row}", $item->location);
                $sheet->setCellValue("O{$row}", $item->division);
                $sheet->setCellValue("P{$row}", $item->section_unit);

                $sheet->getStyle("A{$row}:P{$row}")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $row++;
            }

            $fileName = 'RPCPPE_Export_' . now()->format('Y-m-d') . '.xlsx';
            $writer = new Xlsx($spreadsheet);
            
            if (ob_get_contents()) ob_end_clean();
            return response()->streamDownload(function() use ($writer) { 
                $writer->save('php://output'); 
            }, $fileName);

        } catch (\Exception $e) {
            Log::error('Excel Export Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Export failed: ' . $e->getMessage());
        }
    }

    public function importExcel(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        try {
            Excel::import(new RpcppeImport, $request->file('file'));
            return redirect()->route('rpcppe.index')->with('success', 'Data imported successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import Error: ' . $e->getMessage());
        }
    }

    public function archiveIndex(Request $request)
    {
        $request->merge(['is_archive' => true]);

        $availableYears = Rpcppe::selectRaw('LEFT(date_acquired, 4) as year')
            ->whereNotNull('date_acquired')
            ->whereRaw("date_acquired REGEXP '^[0-9]{4}'")
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $folders = Rpcppe::select(
                'classification',
                DB::raw('COUNT(*) as total_records'),
                DB::raw('SUM(unit_value) as total_value')
            )
            ->when($request->filled('archive_year'), function($q) use ($request) {
                return $q->where('date_acquired', 'LIKE', "{$request->archive_year}%");
            })
            ->groupBy('classification')
            ->orderBy('classification', 'asc')
            ->get();

        return view('rpcppe.archive.index', compact('folders', 'availableYears'));
    }

    public function archiveFolder(Request $request, $classification)
    {
        $classification = urldecode($classification);
        $request->merge([
            'is_archive' => true,
            'archive_classification' => $classification
        ]);

        $items = $this->buildQuery($request)
                    ->orderBy('property_no', 'asc')
                    ->paginate(50)
                    ->withQueryString();

        return view('rpcppe.archive.folder', compact('items', 'classification'));
    }
}