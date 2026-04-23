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
}
