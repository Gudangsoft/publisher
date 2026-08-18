<?php

namespace App\Imports;

use App\Models\VisitorLog;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class VisitorLogsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public function model(array $row): VisitorLog
    {
        return new VisitorLog([
            'name' => $row['nama'],
            'identity_number' => $row['no_identitas'] ?? null,
            'identity_type' => $this->normalizeIdentityType($row['jenis'] ?? null),
            'study_program' => $row['program_studi'] ?? null,
            'purpose' => $row['keperluan'] ?? null,
            'checked_in_at' => $this->parseDate($row['waktu_masuk']),
            'checked_out_at' => $this->parseDate($row['waktu_keluar'] ?? null),
        ]);
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'waktu_masuk' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($this->parseDate($value) === null) {
                        $fail('Waktu Masuk tidak dikenali sebagai tanggal/jam yang valid.');
                    }
                },
            ],
        ];
    }

    public function customValidationAttributes(): array
    {
        return [
            'nama' => 'Nama',
            'waktu_masuk' => 'Waktu Masuk',
        ];
    }

    private function normalizeIdentityType(?string $value): string
    {
        $value = strtolower(trim((string) $value));

        return array_key_exists($value, VisitorLog::IDENTITY_TYPES) ? $value : 'tamu';
    }

    private function parseDate($value): ?string
    {
        if (empty($value) || trim((string) $value) === '-') {
            return null;
        }

        if (is_numeric($value)) {
            return ExcelDate::excelToDateTimeObject($value)->format('Y-m-d H:i:s');
        }

        try {
            return Carbon::parse($value)->format('Y-m-d H:i:s');
        } catch (\Exception) {
            return null;
        }
    }
}
