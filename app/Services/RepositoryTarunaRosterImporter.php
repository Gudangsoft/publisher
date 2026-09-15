<?php

namespace App\Services;

use App\Models\RepositoryTaruna;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Imports the academy's real roster workbook: one sheet per korps/pleton
 * (e.g. "P1", "T2", "S", "M1"), a few decorative title rows before the
 * real header, and columns for NO/NAMA/N.AK plus blank manual-tracking
 * columns (Cover, Pengesahan, Abstrak, Naskah) that carry no import data.
 *
 * Korps is derived from the sheet name's first letter; Angkatan is derived
 * from the leading 4-digit year in "N.AK" (e.g. "2022.396" -> 2022).
 */
class RepositoryTarunaRosterImporter
{
    private const MAX_HEADER_SEARCH_ROWS = 15;
    private const NAME_HEADER_ALIASES = ['NAMA'];
    private const ACADEMIC_NUMBER_HEADER_ALIASES = ['N.AK', 'N AK', 'NAK', 'NOMOR AKADEMIK', 'NO AKADEMIK', 'NO. AKADEMIK'];

    /**
     * @return array{imported: int, updated: int, skipped: array<int, array{sheet: string, row: int|null, reason: string}>}
     */
    public function import(string $filePath): array
    {
        // Force every cell to be read back as a plain string so a value like
        // "2022.396" never gets silently coerced into a float.
        Cell::setValueBinder(new class extends DefaultValueBinder {
            public function bindValue(Cell $cell, $value): bool
            {
                $cell->setValueExplicit((string) $value, DataType::TYPE_STRING);

                return true;
            }
        });

        $spreadsheet = IOFactory::load($filePath);

        $imported = 0;
        $updated = 0;
        $skipped = [];

        foreach ($spreadsheet->getAllSheets() as $sheet) {
            $sheetName = trim($sheet->getTitle());
            $korps = strtoupper(substr($sheetName, 0, 1));

            if (!in_array($korps, RepositoryTaruna::KORPS_OPTIONS, true)) {
                $skipped[] = ['sheet' => $sheetName, 'row' => null, 'reason' => "Nama tab '{$sheetName}' tidak dikenali sebagai korps (P/T/E/S/M), sheet dilewati."];
                continue;
            }

            $header = $this->findHeaderColumns($sheet);

            if (!$header) {
                $skipped[] = ['sheet' => $sheetName, 'row' => null, 'reason' => "Baris header (kolom NAMA & N.AK) tidak ditemukan di " . self::MAX_HEADER_SEARCH_ROWS . " baris pertama, sheet dilewati."];
                continue;
            }

            [$headerRow, $nameCol, $academicNumberCol] = $header;
            $maxRow = $sheet->getHighestDataRow();

            for ($row = $headerRow + 1; $row <= $maxRow; $row++) {
                $name = trim((string) $sheet->getCell($nameCol . $row)->getValue());
                $academicNumber = trim((string) $sheet->getCell($academicNumberCol . $row)->getValue());

                if ($name === '' && $academicNumber === '') {
                    continue;
                }

                if ($name === '' || $academicNumber === '') {
                    $skipped[] = ['sheet' => $sheetName, 'row' => $row, 'reason' => 'Nama atau N.AK kosong.'];
                    continue;
                }

                if (!preg_match('/^(\d{4})/', $academicNumber, $matches)) {
                    $skipped[] = ['sheet' => $sheetName, 'row' => $row, 'reason' => "Angkatan tidak bisa ditentukan dari N.AK '{$academicNumber}' (harus diawali 4 digit tahun)."];
                    continue;
                }

                $angkatan = $matches[1];

                $taruna = RepositoryTaruna::updateOrCreate(
                    ['academic_number' => $academicNumber],
                    ['name' => $name, 'korps' => $korps, 'angkatan' => $angkatan]
                );

                if ($taruna->wasRecentlyCreated) {
                    $imported++;
                } else {
                    $updated++;
                }
            }
        }

        return ['imported' => $imported, 'updated' => $updated, 'skipped' => $skipped];
    }

    /**
     * @return array{0: int, 1: string, 2: string}|null [headerRow, nameColumn, academicNumberColumn]
     */
    private function findHeaderColumns(Worksheet $sheet): ?array
    {
        $maxRow = min($sheet->getHighestDataRow(), self::MAX_HEADER_SEARCH_ROWS);
        $maxCol = $sheet->getHighestDataColumn();

        for ($row = 1; $row <= $maxRow; $row++) {
            $nameCol = null;
            $academicNumberCol = null;

            foreach ($sheet->getRowIterator($row, $row)->current()->getCellIterator('A', $maxCol) as $cell) {
                $value = strtoupper(trim((string) $cell->getValue()));

                if ($value === '') {
                    continue;
                }

                if (in_array($value, self::NAME_HEADER_ALIASES, true)) {
                    $nameCol = $cell->getColumn();
                }

                if (in_array($value, self::ACADEMIC_NUMBER_HEADER_ALIASES, true)) {
                    $academicNumberCol = $cell->getColumn();
                }
            }

            if ($nameCol && $academicNumberCol) {
                return [$row, $nameCol, $academicNumberCol];
            }
        }

        return null;
    }
}
