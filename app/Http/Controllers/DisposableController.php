<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disposable;
use App\Models\Rpcppe;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DisposableExport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DisposableController extends Controller
{
    // 1. INDEX (Kasama ang Search Filter sa lahat ng fields pati 'place')
    public function index(Request $request)
    {
        $query = Disposable::query();

        if ($request->has('search') && !empty($request->get('search'))) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('property_number', 'LIKE', "%{$search}%")
                  ->orWhere('WMR_num', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('year', 'LIKE', "%{$search}%")
                  ->orWhere('article', 'LIKE', "%{$search}%")
                  ->orWhere('place', 'LIKE', "%{$search}%")
                  ->orWhere('unit_value', 'LIKE', "%{$search}%")
                  ->orWhere('disposal_type', 'LIKE', "%{$search}%");
            });
        }

        $disposables = $query->latest()->get();
        
        return view('disposable.index', compact('disposables'));
    }

    // 2. CREATE FORM
    public function create()
    {
        return view('disposable.create');
    }

    // 3. STORE RECORD
    public function store(Request $request) 
    {
        $validated = $request->validate([
            'rpcppe_id'       => 'nullable|integer',
            'property_number' => 'required|string|max:255',
            'name'            => 'required|string|max:255',
            'quantity'        => 'required|integer|min:0',
            'article'         => 'nullable|string|max:255',
            'unit_value'      => 'nullable|numeric|min:0',
            'description'     => 'nullable|string',
            'place'           => 'nullable|string|max:255',
            'DateAcquired'    => 'nullable|date',
            'year'            => 'required|integer|min:1900|max:'.(date('Y')+1),
            'WMR_num'         => 'required|string|max:255',
            'disposal_type'   => 'required|in:wmr,disposed',
            'scanned_photos'  => 'nullable|array',
            'scanned_photos.*'=> 'file|mimes:jpeg,png,jpg,pdf|max:10240',
        ]);

        if ($request->hasFile('scanned_photos')) {
            $paths = [];
            foreach ($request->file('scanned_photos') as $file) {
                $paths[] = $file->store('disposal_scans', 'public');
            }
            $validated['scanned_photos'] = $paths;
        }

        Disposable::create($validated);

        return redirect()->route('disposable.index')->with('success', 'Disposable item/WMR recorded successfully.');
    }

    // 4. EDIT FORM
    public function edit($id)
    {
        $disposable = Disposable::findOrFail($id);
        return view('disposable.edit', compact('disposable'));
    }

    // 5. UPDATE RECORD
    public function update(Request $request, $id)
    {
        $item = Disposable::findOrFail($id);

        $validated = $request->validate([
            'property_number' => 'required|string|max:255',
            'name'            => 'required|string|max:255',
            'quantity'        => 'required|integer|min:0',
            'article'         => 'nullable|string|max:255',
            'unit_value'      => 'nullable|numeric|min:0',
            'description'     => 'nullable|string',
            'place'           => 'nullable|string|max:255',
            'DateAcquired'    => 'nullable|date',
            'year'            => 'required|integer|min:1900|max:'.(date('Y')+1),
            'WMR_num'         => 'required|string|max:255',
            'disposal_type'   => 'required|nullable',
            'scanned_photos'  => 'nullable|array',
            'scanned_photos.*'=> 'file|mimes:jpeg,png,jpg,pdf|max:10240',
            'remove_attachments'   => 'nullable|array',
            'remove_attachments.*' => 'string',
        ]);

        $scannedPhotos = $item->scanned_photos ?? [];

        if ($request->has('remove_attachments')) {
            foreach ($request->input('remove_attachments') as $fileToRemove) {
                if (Storage::disk('public')->exists($fileToRemove)) {
                    Storage::disk('public')->delete($fileToRemove);
                }
            }
            $scannedPhotos = array_values(array_diff($scannedPhotos, $request->input('remove_attachments')));
        }

        if ($request->hasFile('scanned_photos')) {
            foreach ($request->file('scanned_photos') as $newFile) {
                $path = $newFile->store('disposal_scans', 'public');
                $scannedPhotos[] = $path;
            }
        }

        $item->property_number = $validated['property_number'];
        $item->name = $validated['name'];
        $item->quantity = $validated['quantity'];
        $item->article = $validated['article'] ?? null;
        $item->unit_value = $validated['unit_value'] ?? null;
        $item->description = $validated['description'] ?? null;
        $item->place = $validated['place'] ?? null;
        $item->DateAcquired = $validated['DateAcquired'] ?? null;
        $item->year = $validated['year'];
        $item->WMR_num = $validated['WMR_num'];
        $item->disposal_type = $validated['disposal_type'];
        $item->scanned_photos = $scannedPhotos;
        
        $item->save();

        return redirect()->route('disposable.index')->with('success', 'Disposable record updated successfully!');
    }

    // 6. DELETE RECORD
    public function destroy($id)
    {
        $disposable = Disposable::findOrFail($id);

        if (!empty($disposable->scanned_photos) && is_array($disposable->scanned_photos)) {
            foreach ($disposable->scanned_photos as $photo) {
                if (Storage::disk('public')->exists($photo)) {
                    Storage::disk('public')->delete($photo);
                }
            }
        }

        $disposable->delete();

        return redirect()->route('disposable.index')->with('success', 'Disposable item deleted successfully.');
    }

    // 7. RESTORE RECORD
    public function restore($id)
    {
        DB::beginTransaction();
        try {
            $disposedItem = Disposable::findOrFail($id);

            $exists = Rpcppe::where('property_no', $disposedItem->property_number)->exists();
            if ($exists) {
                return redirect()->back()->with('error', 'Cannot be restored: This Property Number already exists in the RPCPPE list.');
            }

            $prefix = explode('-', $disposedItem->property_number)[0];
            
            $mapping = [
                '201' => 'LAND', '202' => 'LAND IMPROVEMENT', '211' => 'BUILDING AND STRUCTURE', 
                '215' => 'OTHER STRUCTURES', '221' => 'OFFICE EQUIPMENT', '208' => 'MEDICAL, DENTAL & LABORATORY EQUIPMENT', 
                '241' => 'MOTOR VEHICLES', '236' => 'TECHNICAL & SCIENTIFIC EQUIPMENT', '240' => 'OTHER MACHINERIES & EQUIPMENT', 
                '235' => 'SPORTS EQUIPMENT', '223' => 'INFORMATION AND COMM. TECH. EQUIPMENT', '229' => 'COMMUNICATION EQUIPMENT', 
                '250' => 'HANDS TOOL', '255' => 'INDUSTRIAL MACHINES & IMPLEMENTS', '254' => 'ARTESIAN WELLS', 
                '222' => 'OFFICE FURNITURES', '10605120' => 'PRINTING EQUIPMENT', '10605010' => 'MACHINERY & EQUIPMENT', 
                '10603060' => 'COMMUNICATION NETWORK', 'HV' => 'SEMI-EXPENDABLE (High Value)', 'LV' => 'SEMI-EXPENDABLE (Low Value)', 
                '218' => 'DONATION JICA', 'GIA-13' => 'GIA',
            ];
            $classification = $mapping[$prefix] ?? 'OTHERS';

            Rpcppe::create([
                'property_no'                 => $disposedItem->property_number,
                'article'                     => $disposedItem->article,
                'description'                 => $disposedItem->description,
                'unit_value'                  => $disposedItem->unit_value,
                'quantity_per_physical_count' => $disposedItem->quantity,
                'date_acquired'               => $disposedItem->DateAcquired,
                'accountable_person'          => $disposedItem->name,
                'location'                    => $disposedItem->place,
                'classification'              => $classification,
                'remarks'                     => 'Restored from Disposal List (WMR: ' . $disposedItem->WMR_num . ')',
            ]);

            $disposedItem->delete();

            DB::commit();
            return redirect()->route('disposable.index')->with('success', 'The item has been successfully restored to the RPCPPE list!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Restore Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'May naganap na error sa pag-restore: ' . $e->getMessage());
        }
    }

    // 8. EXPORT TO PDF
    public function exportPDF()
    {
        $disposables = Disposable::all();
        $pdf = Pdf::loadView('disposable.export_template', compact('disposables'))
                    ->setPaper('a4', 'landscape');
        
        return $pdf->download('WMR_Report_'.now()->format('Y-m-d').'.pdf');
    }

    // 9. EXPORT TO EXCEL
    public function exportExcel()
    {
        return Excel::download(new DisposableExport, 'Disposal_Report_'.now()->format('Y-m-d').'.xlsx');
    }
}