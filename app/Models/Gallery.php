<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'file_path',
        'video_url',
        'thumbnail',
        'category',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Scope: only active items
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: photos only
     */
    public function scopePhotos($query)
    {
        return $query->where('type', 'photo');
    }

    /**
     * Scope: videos only
     */
    public function scopeVideos($query)
    {
        return $query->where('type', 'video');
    }

    /**
     * Scope: ordered display
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order', 'asc')->orderBy('created_at', 'desc');
    }

    /**
     * Get YouTube embed URL from video URL
     */
    public function getYoutubeEmbedUrlAttribute()
    {
        if (!$this->video_url) return null;
        
        $videoId = null;
        
        // Match various YouTube URL formats
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|v\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $this->video_url, $matches)) {
            $videoId = $matches[1];
        }
        
        return $videoId ? "https://www.youtube.com/embed/{$videoId}" : $this->video_url;
    }

    /**
     * Get YouTube thumbnail from video URL
     */
    public function getYoutubeThumbnailAttribute()
    {
        if (!$this->video_url) return null;
        
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|v\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $this->video_url, $matches)) {
            return "https://img.youtube.com/vi/{$matches[1]}/hqdefault.jpg";
        }
        
        return null;
    }

    /**
     * Get display thumbnail - uses uploaded thumbnail or YouTube auto thumbnail
     */
    public function getDisplayThumbnailAttribute()
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        
        if ($this->type === 'video') {
            return $this->youtube_thumbnail;
        }
        
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        
        return null;
    }

    /**
     * Get all distinct categories
     */
    public static function getCategories()
    {
        return static::whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();
    }
}
