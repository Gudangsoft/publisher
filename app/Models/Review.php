<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory, MassPrunable;

    /** Spam karantina dari publik dihapus otomatis setelah 30 hari. */
    public function prunable()
    {
        return static::where('is_spam', true)
            ->where('source', 'public')
            ->where('created_at', '<', now()->subDays(30));
    }

    /** Pilihan kategori responden pada formulir publik. */
    public const ROLES = [
        'Mahasiswa',
        'Taruna/Taruni',
        'Dosen/Pengajar',
        'Peneliti',
        'Penulis',
        'Pegawai/ASN',
        'Masyarakat Umum',
    ];

    protected $fillable = [
        'book_id',
        'reviewer_name',
        'reviewer_email',
        'reviewer_photo',
        'reviewer_role',
        'review_text',
        'rating',
        'type',
        'source',
        'is_approved',
        'is_featured',
        'is_spam',
        'spam_score',
        'spam_reasons',
        'ip_hash',
        'user_agent',
        'content_hash',
        'moderated_at',
        'moderated_by',
    ];

    protected $hidden = [
        'reviewer_email',
        'ip_hash',
        'user_agent',
        'content_hash',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'is_featured' => 'boolean',
        'is_spam' => 'boolean',
        'rating' => 'integer',
        'spam_score' => 'integer',
        'spam_reasons' => 'array',
        'moderated_at' => 'datetime',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderated_by');
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true)->where('is_spam', false);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false)->where('is_spam', false);
    }

    public function scopeSpam($query)
    {
        return $query->where('is_spam', true);
    }

    public function scopeFromPublic($query)
    {
        return $query->where('source', 'public');
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

    /** Inisial aman-multibyte untuk avatar. */
    public function getInitialAttribute(): string
    {
        return mb_strtoupper(mb_substr(trim($this->reviewer_name) ?: '?', 0, 1));
    }
}
