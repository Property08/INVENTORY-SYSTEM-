<?php

namespace App\Http\Controllers;

use App\Models\Rpcppe;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RpcppeExport;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xls; // use Xlsx if template is .xlsx

class RpcppeController extends Controller
{
    /**
     * Build the base query with optional search & filter.
     */
    private function buildQuery(Request $request)
    {
        $query = Rpcppe::query();

        // Text search across several columns
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('article', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('property_no', 'like', "%{$search}%")
                  ->orWhere('accountable_person', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('division', 'like', "%{$search}%")
                  ->orWhere('section_unit', 'like', "%{$search}%")
                  ->orWhere('remarks', 'like', "%{$search}%");
            });
        }

        // Optional filter column (whitelisted)
        $allowedFilters = [
            'article','description','property_no','accountable_person',
            'location','division','section_unit','remarks'
        ];
        if ($request->filled('filter') && $request->filled('search')) {
            $filter = $request->input('filter');
            if (in_array($filter, $allowedFilters, true)) {
                $query->where($filter, 'like', "%{$request->search}%");
            }
        }

        return $query;
    }

    /* ---------- LIST ---------- */
    public function index(Request $request)
    {
        $items = $this->buildQuery($request)
                      ->orderBy('id', 'desc') // ✅ latest data first using ID
                      ->paginate(10);

        return view('rpcppe.index', compact('items'));
    }

    /* ---------- CREATE / STORE ---------- */
    public function create()
    {
        return view('rpcppe.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'article'                    => 'required|string|max:255',
            'description'                => 'nullable|string',
            'property_no'                => 'required|string|max:255',
            'unit_value'                 => 'nullable|numeric',
            'unit_of_measure'            => 'nullable|string|max:255',
            'quantity_per_property_card'  => 'nullable|integer',
            'quantity_per_physical_count' => 'nullable|integer',
            'remarks'                    => 'nullable|string',
            'date_acquired'              => 'nullable|date',
            'accountable_person'         => 'nullable|string|max:255',
            'location'                   => 'nullable|string|max:255',
            'ptsd'                       => 'nullable|string|max:255',
            'division'                   => 'nullable|string|max:255',
            'section_unit'               => 'nullable|string|max:255',
            'transfer_to'                => 'nullable|string|max:255',
            'shortage_overage_qty'       => 'nullable|integer',
            'shortage_overage_value'     => 'nullable|numeric',
        ]);

        Rpcppe::create($validated);
        return redirect()->route('rpcppe.index')->with('action', 'add');
    }

    /* ---------- EDIT / UPDATE ---------- */
    public function edit(int $id)
    {
        $rpcppe = Rpcppe::findOrFail($id);
        return view('rpcppe.edit', compact('rpcppe'));
    }

    public function update(Request $request, int $id)
    {
        $rpcppe = Rpcppe::findOrFail($id);

        $validated = $request->validate([
            'property_no'        => 'required|string|max:255',
            'article'            => 'required|string|max:255',
            'description'        => 'nullable|string',
            'remarks'            => 'nullable|string',
            'accountable_person' => 'nullable|string|max:255',
            'location'           => 'nullable|string|max:255',
            'ptsd'               => 'nullable|string|max:255',
            'division'           => 'nullable|string|max:255',
            'section_unit'       => 'nullable|string|max:255',
            'transfer_to'        => 'nullable|string|max:255',
        ]);

        $rpcppe->update($validated);
        return redirect()->route('rpcppe.index')->with('action', 'edit');
    }

    /* ---------- DELETE ---------- */
    public function destroy(int $id)
    {
        Rpcppe::findOrFail($id)->delete();
        return redirect()->route('rpcppe.index')->with('action', 'delete');
    }

    /* ---------- PDF REPORTS ---------- */
    public function printTable()
    {
        $items = Rpcppe::orderBy('id','desc')->get(); // ✅ keep same order
        $pdf   = Pdf::loadView('rpcppe.reports.table', compact('items'))
                    ->setPaper('a4', 'landscape');
        return $pdf->stream('rpcppe_table.pdf');
    }

    public function appendix73()
    {
        $items = Rpcppe::orderBy('id','desc')->get();
        $pdf   = Pdf::loadView('rpcppe.reports.appendix73', compact('items'))
                    ->setPaper('legal', 'landscape');
        return $pdf->stream('rpcppe_appendix73.pdf');
    }

    public function printFilteredTable(Request $request)
    {
        $items = $this->buildQuery($request)
                      ->orderBy('id','desc')
                      ->get();

        $pdf   = Pdf::loadView('rpcppe.reports.table', compact('items'))
                    ->setPaper('a4', 'landscape');
        return $pdf->stream('rpcppe_filtered_table.pdf');
    }

    /* ---------- EXCEL EXPORTS ---------- */
    public function exportExcel()
    {
        return Excel::download(new RpcppeExport, 'rpcppe.xlsx');
    }

    public function appendix73Export()
    {
        $templatePath = storage_path('app/templates/Appendix 73 - RPCPPE.xls');
        if (!file_exists($templatePath)) {
            abort(404, 'Template file not found at '.$templatePath);
        }

        $spreadsheet = IOFactory::load($templatePath);
        $sheet       = $spreadsheet->getActiveSheet();
        $items       = Rpcppe::orderBy('id','desc')->get();

        // start row (adjust to match your template)
        $row = 12;
        foreach ($items as $item) {
            $sheet->setCellValue("C{$row}", $item->article);
            $sheet->setCellValue("D{$row}", $item->description);
            $sheet->setCellValue("E{$row}", $item->property_no);
            $sheet->setCellValue("F{$row}", $item->unit_of_measure);
            $sheet->setCellValue("G{$row}", $item->unit_value);
            $sheet->setCellValue("H{$row}", $item->quantity_per_property_card);
            $sheet->setCellValue("I{$row}", $item->quantity_per_physical_count);
            $sheet->setCellValue("J{$row}", $item->shortage_overage_qty.' / '.$item->shortage_overage_value);
            $sheet->setCellValue("L{$row}", $item->remarks);
            $row++;
        }

        $writer   = new Xls($spreadsheet);   // switch to Xlsx if needed
        $fileName = 'Appendix_73_Report.xls';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type'        => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
        ]);
    }
}
