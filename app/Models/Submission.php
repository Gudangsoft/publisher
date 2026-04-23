<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'submission_number',
        'title',
        'type',
        'category_id',
        'book_template_id',
        'submitter_name',
        'submitter_email',
        'submitter_phone',
        'submitter_institution',
        'submitter_address',
        'description',
        'synopsis',
        'estimated_pages',
        'target_audience',
        'language',
        'manuscript_file',
        'cover_proposal',
        'additional_files',
        'status',
        'admin_notes',
        'revision_notes',
        'reviewed_by',
        'reviewed_at',
        'estimated_cost',
        'print_quantity',
    ];

    protected $casts = [
        'additional_files' => 'array',
        'reviewed_at' => 'datetime',
        'estimated_cost' => 'decimal:2',
        'estimated_pages' => 'integer',
        'print_quantity' => 'integer',
    ];

    /**
     * Generate unique submission number
     */
    public static function generateSubmissionNumber(): string
    {
        $prefix = 'SUB';
        $year = date('Y');
        $month = date('m');
        
        $lastSubmission = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();
        
        if ($lastSubmission) {
            $lastNumber = (int) substr($lastSubmission->submission_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Relations
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function bookTemplate()
    {
        return $this->belongsTo(BookTemplate::class, 'book_template_id');
    }

    /**
     * Scopes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeReviewing($query)
    {
        return $query->where('status', 'reviewing');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Get status label in Indonesian
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu Review',
            'reviewing' => 'Sedang Direview',
            'revision' => 'Perlu Revisi',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'in_progress' => 'Dalam Proses Cetak',
            'completed' => 'Selesai/Terbit',
            default => 'Unknown'
        };
    }

    /**
     * Get status color for UI
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'reviewing' => 'blue',
            'revision' => 'orange',
            'approved' => 'green',
            'rejected' => 'red',
            'in_progress' => 'purple',
            'completed' => 'emerald',
            default => 'gray'
        };
    }

    /**
     * Get type label in Indonesian
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'book' => 'Buku',
            'journal' => 'Jurnal',
            default => 'Lainnya'
        };
    }
}
