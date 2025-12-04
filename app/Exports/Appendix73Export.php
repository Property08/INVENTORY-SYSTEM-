<?php

namespace App\Exports;

use App\Models\Rpcppe;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class Appendix73Export
{
    public function export()
    {
        // Load Appendix 73 template
        $templatePath = storage_path('app/templates/Appendix 73 - RPCPPE.xls');
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        // Fetch all RPCPPE records
        $items = Rpcppe::all();

        // Starting row for data (adjust as per your template, e.g., row 13)
        $row = 13;
        foreach ($items as $item) {
            $sheet->setCellValue("C{$row}", $item->article);
            $sheet->setCellValue("D{$row}", $item->description);
            $sheet->setCellValue("E{$row}", $item->property_no);
            $sheet->setCellValue("F{$row}", $item->unit_of_measure);
            $sheet->setCellValue("G{$row}", $item->unit_value);
            $sheet->setCellValue("H{$row}", $item->quantity_per_property_card);
            $sheet->setCellValue("I{$row}", $item->quantity_per_physical_count);

            // ✅ Separate shortage/overage Qty & Value
            $sheet->setCellValue("J{$row}", $item->shortage_overage_qty);
            $sheet->setCellValue("K{$row}", $item->shortage_overage_value);

            $sheet->setCellValue("L{$row}", $item->remarks);
            $row++;
        }

        // Output Excel file
        $writer = new Xls($spreadsheet);
        $fileName = 'Appendix_73_Report.xls';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
        ]);
    }
}
