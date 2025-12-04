<?php

namespace App\Http\Controllers;

use App\Models\RECAP;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RecapController extends Controller
{
    public function index(Request $request)
    {
        $query = RECAP::query();

        // 🔎 Search by classification code OR acct codes
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('classification_code', 'like', '%' . $request->search . '%')
                  ->orWhere('acct_code_new', 'like', '%' . $request->search . '%')
                  ->orWhere('acct_code_old', 'like', '%' . $request->search . '%');
            });
        }

        // ✅ Always show newest first (latest data on top)
        $recap = $query->orderBy('created_at', 'desc')
                       ->paginate(15)
                       ->appends($request->all());

        return view('recap.index', compact('recap'));
    }

    public function create()
    {
        return view('recap.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'classification_code' => 'required|string|max:255',
            'acct_code_new'       => 'required|string|max:255',
            'acct_code_old'       => 'nullable|string|max:255',
        ]);

        $data = $request->all();

        // Default 0 kung empty
        $data['beginning_balance']       = $request->input('beginning_balance', 0);
        $data['purchase_2024']           = $request->input('purchase_2024', 0);
        $data['reclassified_from_other'] = $request->input('reclassified_from_other', 0);
        $data['reclassified_to_other']   = $request->input('reclassified_to_other', 0);
        $data['disposed']                = $request->input('disposed', 0);
        $data['donated']                 = $request->input('donated', 0);
        $data['cancelled_adjustment']    = $request->input('cancelled_adjustment', 0);
        $data['total_2024']              = $request->input('total_2024', 0);

        RECAP::create($data);

        return redirect()->route('recap.index')->with('action', 'add');
    }

    public function show(RECAP $recap)
    {
        return view('recap.show', compact('recap'));
    }

    public function edit(RECAP $recap)
    {
        return view('recap.edit', compact('recap'));
    }

    public function update(Request $request, RECAP $recap)
    {
        $recap->update($request->all());

        return redirect()->route('recap.index')->with('action', 'edit');
    }

    public function destroy(RECAP $recap)
    {
        $recap->delete();

        return redirect()->route('recap.index')->with('action', 'delete');
    }

    public function printPdf(Request $request)
    {
        $query = RECAP::query();

        // Same filter sa index
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('classification_code', 'like', '%' . $request->search . '%')
                  ->orWhere('acct_code_new', 'like', '%' . $request->search . '%')
                  ->orWhere('acct_code_old', 'like', '%' . $request->search . '%');
            });
        }

        $recap = $query->orderBy('created_at', 'desc')->get();

        // ✅ Fix: removed extra "->" before setPaper
        $pdf = Pdf::loadView('recap.print', compact('recap'))
                  ->setPaper('a4', 'landscape');

        return $pdf->stream('recap-summary.pdf');
    }
}
