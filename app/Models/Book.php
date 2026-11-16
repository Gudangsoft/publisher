<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'category_id', 'author_id', 'title', 'author', 'publisher', 'isbn', 'description', 'cover', 'images', 
        'published_at', 'pages', 'language', 'weight', 'dimensions', 'price', 'stock', 
        'binding_type', 'paper_type', 'edition',
        'has_print_version', 'print_version_link', 'has_digital_version', 'digital_version_link',
        'whatsapp_link', 'shopee_link', 'tokopedia_link', 'lazada_link'
    ];

    protected $casts = [
        'published_at' => 'date',
        'images' => 'array',
        'price' => 'decimal:2',
        'weight' => 'decimal:2',
        'stock' => 'integer',
        'pages' => 'integer',
        'has_print_version' => 'boolean',
        'has_digital_version' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function authorProfile()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->approved()->latest();
    }

    public function averageRating()
    {
        return $this->reviews()->approved()->avg('rating') ?? 0;
    }

    public function citations(): array
    {
        $author = trim((string) $this->author) ?: 'n.a.';
        $title = trim((string) $this->title);
        $publisher = trim((string) $this->publisher) ?: null;
        $year = $this->published_at ? $this->published_at->format('Y') : 'n.d.';
        $edition = $this->editionOrdinal();

        return [
            'apa' => $this->citationApa($author, $title, $publisher, $year, $edition),
            'chicago' => $this->citationChicago($author, $title, $publisher, $year, $edition),
            'mla' => $this->citationMla($author, $title, $publisher, $year, $edition),
        ];
    }

    private function citationApa(string $author, string $title, ?string $publisher, string $year, ?string $edition): string
    {
        $parts = [
            "{$author} ({$year}).",
            "{$title}" . ($edition ? " ({$edition} ed.)" : '') . '.',
        ];

        if ($publisher) {
            $parts[] = "{$publisher}.";
        }

        return implode(' ', $parts);
    }

    private function citationChicago(string $author, string $title, ?string $publisher, string $year, ?string $edition): string
    {
        $parts = [
            "{$author}.",
            "{$title}.",
        ];

        if ($edition) {
            $parts[] = "{$edition} ed.";
        }

        $parts[] = $publisher ? "{$publisher}, {$year}." : rtrim($year, '.') . '.';

        return implode(' ', $parts);
    }

    private function citationMla(string $author, string $title, ?string $publisher, string $year, ?string $edition): string
    {
        $parts = [
            "{$author}.",
            "{$title}.",
        ];

        if ($edition) {
            $parts[] = "{$edition} ed.,";
        }

        $parts[] = $publisher ? "{$publisher}, {$year}." : rtrim($year, '.') . '.';

        return implode(' ', $parts);
    }

    private function editionOrdinal(): ?string
    {
        $edition = trim((string) $this->edition);

        if ($edition === '') {
            return null;
        }

        if (!ctype_digit($edition)) {
            return $edition;
        }

        $number = (int) $edition;
        $suffix = 'th';

        if (!in_array($number % 100, [11, 12, 13], true)) {
            $suffix = match ($number % 10) {
                1 => 'st',
                2 => 'nd',
                3 => 'rd',
                default => 'th',
            };
        }

        return $number . $suffix;
    }
}
