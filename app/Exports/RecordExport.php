<?php

namespace App\Exports;

use App\Models\Record;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Files\LocalTemporaryFile;

class RecordExport implements WithEvents
{
    protected $record;

    public function __construct(Record $record)
    {
        $this->record = $record;
    }

    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function (BeforeExport $event) {
                $templatePath = storage_path('app/templates/inventory_template.xlsx');
                $templateFile = new LocalTemporaryFile($templatePath);
                $event->writer->reopen($templateFile, Excel::XLSX);
                $sheet = $event->writer->getSheetByIndex(0);

                // 1. Data Initialization (Kopyahin ang logic mula sa recap.index script)
                $recaps = $this->record->recaps;
                
                // Variables para sa sub-computations
                $f101_totals = [
                    'beg' => 0, 'pur' => 0, 'rf' => 0, 'rt' => 0, 
                    'dis' => 0, 'don' => 0, 'adj' => 0, 'tot' => 0
                ];
                $mooe_totals = ['beg' => 0, 'pur' => 0, 'rf' => 0, 'rt' => 0, 'dis' => 0, 'don' => 0, 'adj' => 0, 'tot' => 0];

                // 2. I-map ang data sa Excel Rows
                $row = 9;
                foreach ($recaps as $r) {
                    $isFund = $r->acct_code_new === 'FUND-101';
                    $isMooe = $r->acct_code_new === 'MOOE-101';

                    // Row Calculation (Kopyahin ang logic mula sa controller pdf)
                    $rowTotal = ($r->beginning_balance + $r->purchases + $r->reclass_from) 
                              - ($r->reclass_to + $r->disposed + $r->donated) 
                              + $r->adjustments;

                    if ($isFund) {
                        // Huwag muna isulat ang FUND-101, itatabi muna natin ang row number nito
                        $fundRowNumber = $row;
                    } elseif ($isMooe) {
                        $mooe_totals = [
                            'beg' => $r->beginning_balance, 'pur' => $r->purchases, 'rf' => $r->reclass_from,
                            'rt' => $r->reclass_to, 'dis' => $r->disposed, 'don' => $r->donated,
                            'adj' => $r->adjustments, 'tot' => $rowTotal
                        ];
                    } else {
                        // Regular accounts: I-add sa FUND-101 Subtotal
                        $f101_totals['beg'] += $r->beginning_balance;
                        $f101_totals['pur'] += $r->purchases;
                        $f101_totals['rf']  += $r->reclass_from;
                        $f101_totals['rt']  += $r->reclass_to;
                        $f101_totals['dis'] += $r->disposed;
                        $f101_totals['don'] += $r->donated;
                        $f101_totals['adj'] += $r->adjustments;
                        $f101_totals['tot'] += $rowTotal;
                    }

                    // Isulat ang regular values
                    $sheet->setCellValue("A{$row}", $r->acct_code_new);
                    $sheet->setCellValue("B{$row}", $r->acct_code_old);
                    $sheet->setCellValue("C{$row}", $r->classification);
                    $sheet->setCellValue("D{$row}", ($isFund) ? 0 : $r->beginning_balance); // Temporary 0 muna sa FUND
                    $sheet->setCellValue("E{$row}", $r->purchases);
                    $sheet->setCellValue("F{$row}", $r->reclass_from);
                    $sheet->setCellValue("G{$row}", $r->reclass_to);
                    $sheet->setCellValue("H{$row}", $r->disposed);
                    $sheet->setCellValue("I{$row}", $r->donated);
                    $sheet->setCellValue("J{$row}", $r->adjustments);
                    $sheet->setCellValue("K{$row}", ($isFund) ? 0 : $rowTotal);

                    // Currency Format
                    $sheet->getStyle("D{$row}:K{$row}")->getNumberFormat()->setFormatCode('#,##0.00');
                    $row++;
                }

                // 4. Update FUND-101 Row (Sum of all previous regular accounts)
                if (isset($fundRowNumber)) {
                    $sheet->setCellValue("D{$fundRowNumber}", $f101_totals['beg']);
                    $sheet->setCellValue("K{$fundRowNumber}", $f101_totals['tot']);
                    // Isulat ang zero sa purchases/adjustments ng Fund 101 gaya ng sa PDF
                    $sheet->getStyle("E{$fundRowNumber}:J{$fundRowNumber}")->getNumberFormat()->setFormatCode('"- "');
                }

                // 5. GRAND TOTAL (Row 33) = FUND-101 + MOOE-101
                $sheet->setCellValue('D33', $f101_totals['beg'] + $mooe_totals['beg']);
                $sheet->setCellValue('E33', $f101_totals['pur'] + $mooe_totals['pur']);
                $sheet->setCellValue('F33', $f101_totals['rf'] + $mooe_totals['rf']);
                $sheet->setCellValue('G33', $f101_totals['rt'] + $mooe_totals['rt']);
                $sheet->setCellValue('H33', $f101_totals['dis'] + $mooe_totals['dis']);
                $sheet->setCellValue('I33', $f101_totals['don'] + $mooe_totals['don']);
                $sheet->setCellValue('J33', $f101_totals['adj'] + $mooe_totals['adj']);
                $sheet->setCellValue('K33', $f101_totals['tot'] + $mooe_totals['tot']);

                $sheet->getStyle('D33:K33')->getFont()->setBold(true);
                $sheet->getStyle('D33:K33')->getNumberFormat()->setFormatCode('#,##0.00');
            },
        ];
    }
}