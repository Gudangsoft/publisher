<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'book_type',
        'page_size',
        'orientation',
        'margins',
        'font_family',
        'font_size',
        'line_spacing',
        'description',
        'preview_image',
        'template_file',
        'specifications',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'margins' => 'array',
        'specifications' => 'array',
        'is_active' => 'boolean',
        'line_spacing' => 'decimal:2',
    ];

    /**
     * Jenis buku yang tersedia
     */
    public static function bookTypes(): array
    {
        return [
            'novel' => 'Novel/Fiksi',
            'textbook' => 'Buku Teks/Ajar',
            'journal' => 'Jurnal Ilmiah',
            'thesis' => 'Skripsi/Tesis/Disertasi',
            'monograph' => 'Monograf',
            'reference' => 'Buku Referensi',
            'anthology' => 'Antologi',
            'children' => 'Buku Anak',
            'biography' => 'Biografi',
            'other' => 'Lainnya',
        ];
    }

    /**
     * Ukuran halaman yang tersedia
     */
    public static function pageSizes(): array
    {
        return [
            'A4' => 'A4 (210 x 297 mm)',
            'A5' => 'A5 (148 x 210 mm)',
            'B5' => 'B5 (176 x 250 mm)',
            'Letter' => 'Letter (216 x 279 mm)',
            'Legal' => 'Legal (216 x 356 mm)',
            'Custom' => 'Custom',
        ];
    }

    /**
     * Get book type label
     */
    public function getBookTypeLabelAttribute(): string
    {
        return self::bookTypes()[$this->book_type] ?? $this->book_type;
    }

    /**
     * Get page size label
     */
    public function getPageSizeLabelAttribute(): string
    {
        return self::pageSizes()[$this->page_size] ?? $this->page_size;
    }

    /**
     * Scope for active templates
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for specific book type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('book_type', $type);
    }

    /**
     * Get submissions using this template
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class, 'book_template_id');
    }

    /**
     * Get formatted margins
     */
    public function getFormattedMarginsAttribute(): string
    {
        if (!$this->margins) return '-';
        
        $m = $this->margins;
        return sprintf(
            'Atas: %s, Bawah: %s, Kiri: %s, Kanan: %s',
            $m['top'] ?? '-',
            $m['bottom'] ?? '-',
            $m['left'] ?? '-',
            $m['right'] ?? '-'
        );
    }
}
