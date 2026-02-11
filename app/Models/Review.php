<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'reviewer_name',
        'reviewer_email',
        'reviewer_photo',
        'review_text',
        'rating',
        'type',
        'is_approved',
        'is_featured',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'is_featured' => 'boolean',
        'rating' => 'integer',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeForBook($query)
    {
        return $query->where('type', 'book')->whereNotNull('book_id');
    }

    public function scopeForPublisher($query)
    {
        return $query->where('type', 'publisher');
    }
}
