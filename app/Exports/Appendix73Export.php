<?php

namespace App\Exports;

use App\Models\Rpcppe;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Appendix73Export implements FromCollection, WithHeadings, WithCustomStartCell, ShouldAutoSize, WithEvents
{
    protected $items;

    public function __construct()
    {
        // Fetch all RPCPPE data
        $this->items = Rpcppe::orderBy('id','desc')->get();
    }

    // ✅ Collection of data to export
    public function collection()
    {
        return $this->items->map(function($item){
            return [
                $item->article,
                $item->description,
                $item->property_no,
                $item->unit_of_measure,
                $item->unit_value,
                $item->quantity_per_property_card,
                $item->quantity_per_physical_count,
                $item->shortage_overage_qty,
                $item->shortage_overage_value,
                $item->remarks,
            ];
        });
    }

    // ✅ Column headings
    public function headings(): array
    {
        return [
            'Article',
            'Description',
            'Property No',
            'Unit of Measure',
            'Unit Value',
            'Qty per Property Card',
            'Qty per Physical Count',
            'Shortage/Overage Qty',
            'Shortage/Overage Value',
            'Remarks',
        ];
    }

    // ✅ Start writing headers at this cell (matches your template)
    public function startCell(): string
    {
        return 'C13'; // adjust kung sa template mo ibang row ang header
    }

    // ✅ Apply styles (bold headers + borders)
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $highestRow = $event->sheet->getHighestRow();

                // Bold headers
                $event->sheet->getStyle('C13:L13')->getFont()->setBold(true);

                // Center alignment for headers
                $event->sheet->getStyle('C13:L13')->getAlignment()
                      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                      ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                // Borders for all data
                $event->sheet->getStyle('C13:L'.$highestRow)
                      ->getBorders()
                      ->getAllBorders()
                      ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            },
        ];
    }
}
