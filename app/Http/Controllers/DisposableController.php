<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disposable;

class DisposableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all disposable items from DB
        $disposables = Disposable::all();
        return view('disposable.index', compact('disposables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('disposable.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
        ]);

        Disposable::create($request->all());

        return redirect()->route('disposable.index')
                         ->with('success', 'Disposable item added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $disposable = Disposable::findOrFail($id);
        return view('disposable.edit', compact('disposable'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
        ]);

        $disposable = Disposable::findOrFail($id);
        $disposable->update($request->all());

        return redirect()->route('disposable.index')
                         ->with('success', 'Disposable item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $disposable = Disposable::findOrFail($id);
        $disposable->delete();

        return redirect()->route('disposable.index')
                         ->with('success', 'Disposable item deleted successfully.');
    }
}
