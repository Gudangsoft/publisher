<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepositoryTaruna extends Model
{
    protected $fillable = [
        'name',
        'academic_number',
        'korps',
    ];

    public function submission()
    {
        return $this->hasOne(ThesisSubmission::class);
    }

    public function hasSubmitted(): bool
    {
        return $this->submission()->exists();
    }
}
