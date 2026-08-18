<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookLoan extends Model
{
    protected $fillable = [
        'book_id',
        'book_title_snapshot',
        'borrower_name',
        'borrower_identity_number',
        'borrower_type',
        'loaned_at',
        'due_at',
        'returned_at',
        'status',
    ];

    protected $casts = [
        'loaned_at' => 'datetime',
        'due_at' => 'date',
        'returned_at' => 'datetime',
    ];

    public const BORROWER_TYPES = [
        'mahasiswa' => 'Mahasiswa',
        'dosen' => 'Dosen',
        'staf' => 'Staf',
        'tamu' => 'Tamu',
    ];

    public const STATUSES = [
        'dipinjam' => 'Dipinjam',
        'dikembalikan' => 'Dikembalikan',
        'terlambat' => 'Terlambat',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function displayTitle(): string
    {
        return $this->book->title ?? $this->book_title_snapshot ?? '-';
    }
}
