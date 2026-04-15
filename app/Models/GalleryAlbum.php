<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GalleryAlbum extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'cover_image',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Boot method to auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($album) {
            if (empty($album->slug)) {
                $album->slug = Str::slug($album->name);
            }
            // Ensure unique slug
            $originalSlug = $album->slug;
            $count = 1;
            while (static::where('slug', $album->slug)->exists()) {
                $album->slug = $originalSlug . '-' . $count++;
            }
        });

        static::updating(function ($album) {
            if ($album->isDirty('name') && !$album->isDirty('slug')) {
                $album->slug = Str::slug($album->name);
                $originalSlug = $album->slug;
                $count = 1;
                while (static::where('slug', $album->slug)->where('id', '!=', $album->id)->exists()) {
                    $album->slug = $originalSlug . '-' . $count++;
                }
            }
        });
    }

    /**
     * Relationship: Album has many galleries
     */
    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    /**
     * Scope: only active albums
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: ordered display
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order', 'asc')->orderBy('name', 'asc');
    }

    /**
     * Get the cover image URL or the first gallery item's image
     */
    public function getCoverUrlAttribute()
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }

        // Fallback: use first photo from this album
        $firstPhoto = $this->galleries()
            ->where('type', 'photo')
            ->where('is_active', true)
            ->first();

        if ($firstPhoto && $firstPhoto->file_path) {
            return asset('storage/' . $firstPhoto->file_path);
        }

        return null;
    }

    /**
     * Count active gallery items
     */
    public function getActiveCountAttribute()
    {
        return $this->galleries()->where('is_active', true)->count();
    }
}
