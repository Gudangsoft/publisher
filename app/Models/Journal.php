<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Journal extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'abstract',
        'keywords',
        'authors',
        'affiliation',
        'doi',
        'volume',
        'issue',
        'pages',
        'publication_date',
        'year',
        'issn',
        'language',
        'file_pdf',
        'cover_image',
        'citation_format',
        'journal_link',
        'views',
        'downloads',
        'is_published',
        'is_featured',
    ];

    protected $casts = [
        'publication_date' => 'date',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($journal) {
            if (empty($journal->slug)) {
                $journal->slug = Str::slug($journal->title) . '-' . time();
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
