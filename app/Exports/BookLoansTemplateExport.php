<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BookLoansTemplateExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    public function array(): array
    {
        return [
            ['978-3-16-148410-0', 'Contoh Judul Buku', 'Budi Santoso', '2021001', 'mahasiswa', '2026-08-01', '2026-08-15', ''],
        ];
    }

    public function headings(): array
    {
        return [
            'ISBN',
            'Judul Buku',
            'Nama Peminjam',
            'No Identitas',
            'Jenis Peminjam',
            'Tanggal Pinjam',
            'Jatuh Tempo',
            'Tanggal Kembali',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
