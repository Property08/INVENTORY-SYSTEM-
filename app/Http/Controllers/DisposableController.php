<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disposable;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DisposableExport;


class DisposableController extends Controller
{
    public function index(Request $request)
    {
        $query = Disposable::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('property_number', 'LIKE', "%{$search}%")
                  ->orWhere('WMR_num', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('year', 'LIKE', "%{$search}%")
                  ->orWhere('article', 'LIKE', "%{$search}%")
                  ->orWhere('unit_value', 'LIKE', "%{$search}%");
            });
        }

        $disposables = $query->latest()->get();
        
        return view('disposable.index', compact('disposables'));
    }

    public function create()
    {
        return view('disposable.create');
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'property_number' => 'required|string|max:255',
            'name'            => 'required|string|max:255',
            'quantity'        => 'required|integer|min:0',
            'article'         => 'nullable|string|max:255',
            'unit_value'      => 'nullable|numeric|min:0|max:9999999999.99',
            'description'     => 'nullable|string',
            'DateAcquired'    => 'nullable|date',
            'year'            => 'required|integer|min:1900|max:'.(date('Y')+1),
            'WMR_num'         => 'required|string|max:255',
        ]);

        Disposable::create($validated);
        return redirect()->route('disposable.index')->with('success', 'Disposable item added successfully.');
    }

    // --- RESTORED EDIT METHOD ---
    public function edit($id)
    {
        $disposable = Disposable::findOrFail($id);
        return view('disposable.edit', compact('disposable'));
    }

    public function update(Request $request, $id) 
    {
        $validated = $request->validate([
            'property_number' => 'required|string|max:255',
            'name'            => 'required|string|max:255',
            'quantity'        => 'required|integer|min:0',
            'description'     => 'nullable|string',
            'DateAcquired'    => 'nullable|date',
            'year'            => 'required|integer|min:1900|max:'.(date('Y')+1),
            'WMR_num'         => 'required|string|max:255',
            'article'         => 'nullable|string|max:255',
            'unit_value'      => 'nullable|numeric|min:0|max:9999999999.99',
        ]);

        $disposable = Disposable::findOrFail($id);
        $disposable->update($validated);
        return redirect()->route('disposable.index')->with('success', 'Disposable item updated successfully.');
    }

    public function destroy($id)
    {
        $disposable = Disposable::findOrFail($id);
        $disposable->delete();
        return redirect()->route('disposable.index')->with('success', 'Disposable item deleted successfully.');
    }

    public function exportPDF()
    {
        $disposables = Disposable::all();
        $pdf = Pdf::loadView('disposable.export_template', compact('disposables'))
                  ->setPaper('a4', 'landscape');
        
        return $pdf->download('WMR_Report_'.now()->format('Y-m-d').'.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new DisposableExport, 'Disposal_Report_'.now()->format('Y-m-d').'.xlsx');
    }
}