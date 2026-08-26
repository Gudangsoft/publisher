<?php

namespace App\Imports;

use App\Models\RepositoryTaruna;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class RepositoryTarunaImport extends DefaultValueBinder implements ToModel, WithHeadingRow, WithValidation, WithUpserts, SkipsOnFailure, WithCustomValueBinder
{
    use Importable, SkipsFailures;

    /**
     * Force every cell (e.g. a numeric-looking "Nomor Akademik") to be read
     * back as a plain string instead of an int/float.
     */
    public function bindValue(Cell $cell, $value): bool
    {
        $cell->setValueExplicit((string) $value, DataType::TYPE_STRING);

        return true;
    }

    public function model(array $row): RepositoryTaruna
    {
        return new RepositoryTaruna([
            'name' => $row['nama'],
            'academic_number' => trim((string) $row['nomor_akademik']),
            'korps' => $row['korps'] ?? null,
        ]);
    }

    public function uniqueBy(): string
    {
        return 'academic_number';
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'nomor_akademik' => ['required', 'string', 'max:100'],
        ];
    }

    public function customValidationAttributes(): array
    {
        return [
            'nama' => 'Nama',
            'nomor_akademik' => 'Nomor Akademik',
        ];
    }
}
