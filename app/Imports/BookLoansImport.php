<?php

namespace App\Imports;

use App\Models\Book;
use App\Models\BookLoan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class BookLoansImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public function model(array $row): BookLoan
    {
        $isbn = isset($row['isbn']) ? trim((string) $row['isbn']) : '';
        $book = $isbn !== '' ? Book::where('isbn', $isbn)->first() : null;

        $loanedAt = $this->parseDate($row['tanggal_pinjam']) ?? now();
        $dueAt = $this->parseDate($row['jatuh_tempo']);
        $returnedAt = $this->parseDate($row['tanggal_kembali'] ?? null);

        return new BookLoan([
            'book_id' => $book?->id,
            'book_title_snapshot' => $row['judul_buku'] ?? $book?->title,
            'borrower_name' => $row['nama_peminjam'],
            'borrower_identity_number' => $row['no_identitas'] ?? null,
            'borrower_type' => $this->normalizeBorrowerType($row['jenis_peminjam'] ?? null),
            'loaned_at' => $loanedAt,
            'due_at' => $dueAt,
            'returned_at' => $returnedAt,
            'status' => $this->resolveStatus($dueAt, $returnedAt),
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_peminjam' => ['required', 'string', 'max:255'],
            'tanggal_pinjam' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($this->parseDate($value) === null) {
                        $fail('Tanggal Pinjam tidak dikenali sebagai tanggal yang valid.');
                    }
                },
            ],
            'jatuh_tempo' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($this->parseDate($value) === null) {
                        $fail('Jatuh Tempo tidak dikenali sebagai tanggal yang valid.');
                    }
                },
            ],
            'isbn' => ['required_without:judul_buku'],
            'judul_buku' => ['required_without:isbn'],
        ];
    }

    public function customValidationAttributes(): array
    {
        return [
            'nama_peminjam' => 'Nama Peminjam',
            'tanggal_pinjam' => 'Tanggal Pinjam',
            'jatuh_tempo' => 'Jatuh Tempo',
            'isbn' => 'ISBN',
            'judul_buku' => 'Judul Buku',
        ];
    }

    private function normalizeBorrowerType(?string $value): string
    {
        $value = strtolower(trim((string) $value));

        return array_key_exists($value, BookLoan::BORROWER_TYPES) ? $value : 'mahasiswa';
    }

    private function resolveStatus(?string $dueAt, ?string $returnedAt): string
    {
        if ($returnedAt !== null) {
            return 'dikembalikan';
        }

        if ($dueAt !== null && Carbon::parse($dueAt)->lt(now()->startOfDay())) {
            return 'terlambat';
        }

        return 'dipinjam';
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
