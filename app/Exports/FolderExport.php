<?php

namespace App\Exports;

use App\Models\Rpcppe;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Files\LocalTemporaryFile;

class FolderExport implements WithEvents
{
    protected $prefix;

    public function __construct($prefix)
    {
        $this->prefix = $prefix;
    }

    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function(BeforeExport $event) {
                $templatePath = storage_path('app/templates/Accountability_template.xlsx');

                if (!file_exists($templatePath)) {
                    throw new \Exception("Template not found at $templatePath");
                }

                // 1. Reopen the template
                $event->writer->reopen(new LocalTemporaryFile($templatePath), Excel::XLSX);
                $sheet = $event->writer->getSheetByIndex(0);

                // 2. Kunin ang data
                $items = Rpcppe::where('property_no', 'like', $this->prefix . '-%')
                               ->orderBy('property_no')
                               ->get();

                // 3. Manual Loop para isulat ang data simula sa Row 16
                // Ito ay para siguradong hindi masira ang format ng template
                $currentRow = 16;
                foreach ($items as $item) {
                    $sheet->setCellValue('A' . $currentRow, $item->article);
                    $sheet->setCellValue('B' . $currentRow, $item->description);
                    $sheet->setCellValue('C' . $currentRow, $item->property_no);
                    $sheet->setCellValue('D' . $currentRow, $item->unit_of_measure);
                    $sheet->setCellValue('E' . $currentRow, $item->unit_value);
                    $sheet->setCellValue('F' . $currentRow, $item->quantity_per_property_card);
                    $sheet->setCellValue('G' . $currentRow, $item->quantity_per_physical_count);
                    $sheet->setCellValue('H' . $currentRow, $item->shortage_overage_qty);
                    $sheet->setCellValue('I' . $currentRow, $item->shortage_overage_value);
                    $sheet->setCellValue('J' . $currentRow, $item->remarks);
                    $sheet->setCellValue('K' . $currentRow, $item->date_acquired);
                    $sheet->setCellValue('L' . $currentRow, $item->accountable_person);
                    $sheet->setCellValue('M' . $currentRow, $item->transfer_to);
                    $sheet->setCellValue('N' . $currentRow, $item->location);
                    $sheet->setCellValue('O' . $currentRow, $item->division);
                    $sheet->setCellValue('P' . $currentRow, $item->section_unit);
                    
                    $currentRow++;
                }

                return $sheet;
            },
        ];
    }
}