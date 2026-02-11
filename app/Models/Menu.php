<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'label',
        'url',
        'parent_id',
        'icon',
        'target',
        'display_order',
        'is_active',
        'location',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('display_order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order', 'asc');
    }

    public function scopeHeader($query)
    {
        return $query->whereIn('location', ['header', 'both']);
    }

    public function scopeFooter($query)
    {
        return $query->whereIn('location', ['footer', 'both']);
    }

    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }
}
