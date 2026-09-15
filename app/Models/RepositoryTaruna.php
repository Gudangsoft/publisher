<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepositoryTaruna extends Model
{
    protected $fillable = [
        'name',
        'academic_number',
        'korps',
        'angkatan',
    ];

    public const KORPS_OPTIONS = ['P', 'T', 'E', 'S', 'M'];

    public function submission()
    {
        return $this->hasOne(ThesisSubmission::class);
    }

    public function hasSubmitted(): bool
    {
        return $this->submission()->exists();
    }

    public static function angkatanOptions()
    {
        return static::whereNotNull('angkatan')
            ->distinct()
            ->orderByDesc('angkatan')
            ->pluck('angkatan');
    }
}
