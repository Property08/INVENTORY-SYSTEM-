<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles; 
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Excel as ExcelType;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RpcppeExport implements FromCollection, WithMapping, WithEvents, WithCustomStartCell, WithStyles
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

    /**
    * SAKTONG ALIGNMENT BASE SA TEMPLATE MO:
    * Ang Column D (Property Number) ang mismong gagawin nating Barcode!
    */
    public function map($item): array
    {
        return [
            '',                                                 // Column A: Blangko (Para sumakto ang layout)
            $item->article,                                     // Column B: ARTICLE
            $item->description,                                 // Column C: DESCRIPTION
            
            // COLUMN D: Binalot natin ng asterisk ang Property No para basahin ng font bilang Barcode
            '*' . trim($item->property_no) . '*',               // Column D: PROPERTY NUMBER (BARCODE)
            
            $item->unit_of_measure,                             // Column E: UNIT OF MEASURE
            $item->unit_value,                                  // Column F: UNIT VALUE
            $item->quantity_per_property_card,                  // Column G: PER CARD (Qty)
            $item->quantity_per_physical_count,                 // Column H: PER COUNT (Qty)
            $item->shortage_overage_qty,                        // Column I: SHORTAGE/OVERAGE (Qty)
            $item->shortage_overage_value,                      // Column J: SHORTAGE/OVERAGE (Value)
            $item->remarks,                                     // Column K: REMARKS
            $item->date_acquired,                               // Column L: DATE ACQUIRED
            $item->accountable_person,                          // Column M: ACCOUNTABLE PERSON
            $item->transfer_to,                                 // Column N: TRANSFER TO
            $item->location,                                    // Column O: LOCATION
            $item->division,                                    // Column P: DIVISION
            $item->section_unit,                                // Column Q: SECTION
        ];
    }

    public function startCell(): string
    {
        return 'A16';
    }

    /**
    * AUTOMATIC FONT APPLICATOR:
    * Pinupwersa nito ang Column D na magbago ang anyo gamit ang "3 of 9 Barcode"
    */
    public function styles(Worksheet $sheet)
    {
        $totalItems = $this->items->count();
        
        if ($totalItems > 0) {
            $startRow = 16;
            $endRow = $startRow + $totalItems - 1;

            // Dito natin selyado na gagamitin ang eksaktong font name na na-install mo
            $sheet->getStyle("D{$startRow}:D{$endRow}")->getFont()->setName('3 of 9 Barcode');
            $sheet->getStyle("D{$startRow}:D{$endRow}")->getFont()->setSize(36); // Laking sapat para sa scanner gun
            $sheet->getStyle("D{$startRow}:D{$endRow}")->getAlignment()->setHorizontal('center');
            $sheet->getStyle("D{$startRow}:D{$endRow}")->getAlignment()->setVertical('center');
        }

        return [];
    }

    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function(BeforeExport $event) {
                $templatePath = storage_path('app/templates/Accountability_template.xlsx');
                if (file_exists($templatePath)) {
                    $event->writer->reopen(new \Maatwebsite\Excel\Files\LocalTemporaryFile($templatePath), ExcelType::XLSX);
                    $event->writer->getSheetByIndex(0);
                }
            },
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $totalItems = $this->items->count();
                
                if ($totalItems > 0) {
                    $startRow = 16;
                    $endRow = $startRow + $totalItems - 1;
                    
                    // Lwangan natin ang Column D para hindi maging siksikan ang mga guhit ng barcode
                    $sheet->getColumnDimension('D')->setWidth(40);
                    
                    // Gumuhit ng thin borders mula Column B (Article) hanggang Column Q (Section)
                    $sheet->getStyle("B{$startRow}:Q{$endRow}")
                        ->getBorders()
                        ->getAllBorders()
                        ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                    // Taasan ang row height para maging parang sticker square ang pwesto ng barcode
                    for ($row = $startRow; $row <= $endRow; $row++) {
                        $sheet->getRowDimension($row)->setRowHeight(55);
                    }
                }
            }
        ];
    }
}