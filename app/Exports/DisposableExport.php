<?php

namespace App\Exports;

use App\Models\Disposable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DisposableExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        return view('disposable.export_template', [
            'disposables' => Disposable::all()
        ]);
    }
}