<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Excel;

class RpcppeExport implements FromCollection, WithMapping, WithEvents, WithCustomStartCell
{
    protected $items;

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function collection()
    {
        return $this->items;
    }

    // DITO NATIN ITATAPAT ANG DATA SA COLUMNS NG TEMPLATE MO
    public function map($item): array
    {
        return [
            $item->property_no,                 // Column A: Property Num.
            $item->article,                     // Column B: Article
            $item->description,                 // Column C: Description
            $item->unit_of_measure,             // Column D: Unit of Measure
            $item->unit_value,                  // Column E: Unit of Value
            $item->quantity_per_property_card,  // Column F: Quantity Card
            $item->quantity_per_physical_count, // Column G: Quantity Physical
            $item->shortage_overage_qty,        // Column H: Storage Qty
            $item->shortage_overage_value,      // Column I: Storage Value
            $item->accountable_person,          // Column J: Accountable Person
            $item->transfer_to,                 // Column K: Transfer to
            $item->location,                    // Column L: Location
            $item->division,                    // Column M: Division
            $item->section_unit,                // Column N: Section Unit
            $item->date_acquired,               // Column O: Date Acquired
            $item->remarks,                     // Column P: Remarks
        ];
    }

    // MAGSISIMULA ANG DATA SA ROW 5 (Dahil Row 4 ang headers)
    public function startCell(): string
    {
        return 'A16';
    }

    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function(BeforeExport $event) {
                // SIGURADUHIN NA TAMA ANG PATH NG TEMPLATE MO
                $templatePath = storage_path('app/templates/Accountability_template.xlsx');
                
                if (file_exists($templatePath)) {
                    $event->writer->reopen(new \Maatwebsite\Excel\Files\LocalTemporaryFile($templatePath), Excel::XLSX);
                    $event->writer->getSheetByIndex(0);
                }
            },
        ];
    }
}