<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'type'
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }
}
