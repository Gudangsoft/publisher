<?php

namespace App\Exports;

use App\Models\VisitorLog;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VisitorLogsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function __construct(private array $filters = [])
    {
    }

    public function collection(): Collection
    {
        $query = VisitorLog::query();

        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('identity_number', 'like', "%{$search}%");
            });
        }

        if (!empty($this->filters['identity_type'])) {
            $query->where('identity_type', $this->filters['identity_type']);
        }

        if (!empty($this->filters['from'])) {
            $query->whereDate('checked_in_at', '>=', $this->filters['from']);
        }

        if (!empty($this->filters['to'])) {
            $query->whereDate('checked_in_at', '<=', $this->filters['to']);
        }

        return $query->orderByDesc('checked_in_at')->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'No Identitas',
            'Jenis',
            'Program Studi',
            'Keperluan',
            'Waktu Masuk',
            'Waktu Keluar',
        ];
    }

    public function map($visitorLog): array
    {
        return [
            $visitorLog->name,
            $visitorLog->identity_number ?? '-',
            VisitorLog::IDENTITY_TYPES[$visitorLog->identity_type] ?? $visitorLog->identity_type,
            $visitorLog->study_program ?? '-',
            $visitorLog->purpose ?? '-',
            optional($visitorLog->checked_in_at)->format('Y-m-d H:i'),
            optional($visitorLog->checked_out_at)->format('Y-m-d H:i') ?? '',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
