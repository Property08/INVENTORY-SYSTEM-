<?php

namespace App\Exports;

use App\Models\Rpcppe;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Files\LocalTemporaryFile;

class FolderExport implements WithEvents
{
    protected string $prefix;
    protected string $selectedYear;
    protected array $mapping;

    public function __construct(string $prefix, string $selectedYear, array $mapping = [])
    {
        $this->prefix = $prefix;
        $this->selectedYear = $selectedYear;
        $this->mapping = $mapping;
    }

    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function(BeforeExport $event) {
                $templatePath = storage_path('app/templates/Accountability_template.xlsx');

                if (!file_exists($templatePath)) {
                    throw new \Exception("Template not found at $templatePath");
                }

                // 1. Reopen the template (Mapapanatili ang styling at merged configurations nito)
                $event->writer->reopen(new LocalTemporaryFile($templatePath), Excel::XLSX);
                $sheet = $event->writer->getSheetByIndex(0);

                // 2. Simulan ang query para sa database base sa Category Prefix
                // TANDAAN: Kung gumagamit ka ng SoftDeletes para sa Archived Records mo, 
                // maaari mong palitan ang 'Rpcppe::query()' ng 'Rpcppe::withTrashed()'
                $query = Rpcppe::query()->whereRaw("UPPER(TRIM(SUBSTRING_INDEX(property_no, '-', 1))) = ?", [$this->prefix]);

                // KONDISYON: Kung may piniling taon (hindi empty), i-filter natin sa taong 'yun.
                // Kung walang pinili, lalaktawan ito ng system para i-export LAHAT ng taon sa ilalim ng folder na ito.
                if (!empty($this->selectedYear)) {
                    $query->whereYear('date_acquired', $this->selectedYear);
                }

                // Kunin ang mga items mula sa database
                $items = $query->orderBy('property_no')->get();

                // 3. Fallback at Title generation logic para sa Merged Header text fields
                $equipmentType = $this->mapping[$this->prefix] ?? 'OTHER ASSETS';
                $fundCode = "Fund " . $this->prefix;

                // Dynamic Header Text para sa Petsa/Taon base sa kung may filter o wala
                if (!empty($this->selectedYear)) {
                    $asOfDate = "as of December 31, " . $this->selectedYear; 
                } else {
                    $asOfDate = "CONSOLIDATED REPORT (All Years)";
                }

                // 4. Patungan ang dynamic headers sa Excel Document (Merges: Cell A ang lead target)
                $sheet->setCellValue('A3', strtoupper($equipmentType)); 
                $sheet->setCellValue('A4', $asOfDate);                  
                $sheet->setCellValue('A7', $fundCode);                  

                // 5. Loop implementation para isulat ang database rows simula sa Row 16
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
                    
                    // Lalagyan ng light border lines kada row para malinis tingnan
                    $sheet->getStyle("A{$currentRow}:P{$currentRow}")
                          ->getBorders()
                          ->getAllBorders()
                          ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                    $currentRow++;
                }

                // Sa Maatwebsite Excel 'BeforeExport' event, binabago natin ang object by reference.
                // Hindi na natin kailangang mag-return ng $sheet dito.
            },
        ];
    }
}