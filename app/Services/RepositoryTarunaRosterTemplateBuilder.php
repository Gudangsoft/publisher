<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

/**
 * Builds an example roster workbook matching the academy's real format:
 * one sheet per korps/pleton, a few title rows, header on row 8, and
 * NO/NAMA/N.AK columns plus the blank manual-tracking columns.
 */
class RepositoryTarunaRosterTemplateBuilder
{
    private const SHEETS = [
        'P1' => [['1', 'Budi Santoso', '2023.001'], ['2', 'Budi Setiawan', '2023.002']],
        'T1' => [['1', 'Citra Dewi', '2023.101']],
    ];

    public function build(): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->removeSheetByIndex(0);

        foreach (self::SHEETS as $sheetName => $rows) {
            $sheet = $spreadsheet->createSheet();
            $sheet->setTitle($sheetName);

            $sheet->setCellValue('A1', 'AKADEMI TNI ANGKATAN LAUT');
            $sheet->setCellValue('A2', 'OPERASI PENGAJARAN');
            $sheet->setCellValue('A5', 'DAFTAR PENGUMPULAN SKRIPSI');
            $sheet->setCellValue('A6', 'TINGKAT III PELAUT 1');

            $headings = ['NO', 'NAMA', 'N.AK', 'COVER', 'DAFTAR PENGESAHAN', 'ABSTRAK', 'FULL NASKAH'];
            $sheet->fromArray($headings, null, 'A8');
            $sheet->getStyle('A8:G8')->getFont()->setBold(true);
            $sheet->getStyle('A8:G8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setWrapText(true);
            $sheet->getStyle('A8:G8')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('EEEEEE');

            $rowIndex = 9;
            foreach ($rows as $row) {
                $sheet->setCellValueExplicit("A{$rowIndex}", $row[0], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit("B{$rowIndex}", $row[1], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit("C{$rowIndex}", $row[2], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $rowIndex++;
            }

            foreach (['A' => 5, 'B' => 30, 'C' => 12, 'D' => 10, 'E' => 16, 'F' => 10, 'G' => 12] as $col => $width) {
                $sheet->getColumnDimension($col)->setWidth($width);
            }
        }

        $spreadsheet->setActiveSheetIndex(0);

        return $spreadsheet;
    }
}
