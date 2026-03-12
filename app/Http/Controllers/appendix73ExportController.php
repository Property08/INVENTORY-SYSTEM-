<?php

namespace App\Http\Controllers;
use App\Models\Rpcppe;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class RpcppeController extends Controller
{
    // ---------- DYNAMIC APPENDIX 73 EXCEL EXPORT ----------
    public function appendix73Export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 1️⃣ Define headers
        $headers = [
            'Article', 'Description', 'Property No', 'Unit of Measure', 'Unit Value',
            'Qty per Property Card', 'Qty per Physical Count', 'Shortage/Overage', 'Remarks'
        ];

        // Put headers starting at column C, row 12 (like official template)
        $startCol = 'C';
        $headerRow = 15;
        $col = $startCol;

        foreach ($headers as $header) {
            $sheet->setCellValue($col.$headerRow, $header);

            // Style: bold + center alignment + border
            $sheet->getStyle($col.$headerRow)
                  ->getFont()->setBold(true);
            $sheet->getStyle($col.$headerRow)
                  ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
                                  ->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle($col.$headerRow)
                  ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            $col++;
        }

        // 2️⃣ Fetch RPCPPE data
        $items = Rpcppe::orderBy('id','desc')->get();

        // 3️⃣ Write data starting after headers
        $row = $headerRow + 1;
        foreach ($items as $item) {
            $sheet->setCellValue("C{$row}", $item->article);
            $sheet->setCellValue("D{$row}", $item->description);
            $sheet->setCellValue("E{$row}", $item->property_no);
            $sheet->setCellValue("F{$row}", $item->unit_of_measure);
            $sheet->setCellValue("G{$row}", $item->unit_value);
            $sheet->setCellValue("H{$row}", $item->quantity_per_property_card);
            $sheet->setCellValue("I{$row}", $item->quantity_per_physical_count);
            $sheet->setCellValue("J{$row}", $item->shortage_overage_qty.' / '.$item->shortage_overage_value);
            $sheet->setCellValue("K{$row}", $item->remarks);

            // Optional: Align text left and center vertically
            $sheet->getStyle("C{$row}:K{$row}")
                  ->getAlignment()
                  ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                  ->setVertical(Alignment::VERTICAL_CENTER);

            // Optional: Thin borders for all cells
            $sheet->getStyle("C{$row}:K{$row}")
                  ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            $row++;
        }

        // 4️⃣ Auto column width
        foreach(range('C','K') as $colLetter) {
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }

        // 5️⃣ Generate file
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Appendix_73_Report_'.date('Ymd_His').'.xlsx';

        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
        ]);
    }
}
