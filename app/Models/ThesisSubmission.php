<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThesisSubmission extends Model
{
    protected $fillable = [
        'repository_taruna_id',
        'submission_code',
        'cover_path',
        'cover_original_name',
        'cover_url',
        'pengesahan_path',
        'pengesahan_original_name',
        'pengesahan_url',
        'abstrak_path',
        'abstrak_original_name',
        'abstrak_url',
        'naskah_path',
        'naskah_original_name',
        'naskah_url',
    ];

    public const FILE_FIELDS = [
        'cover' => 'Cover',
        'pengesahan' => 'Halaman Pengesahan',
        'abstrak' => 'Abstrak',
        'naskah' => 'Naskah Skripsi',
    ];

    public function taruna()
    {
        return $this->belongsTo(RepositoryTaruna::class, 'repository_taruna_id');
    }

    public function isComplete(): bool
    {
        foreach (array_keys(self::FILE_FIELDS) as $field) {
            if (!$this->hasDocument($field)) {
                return false;
            }
        }

        return true;
    }

    public function hasDocument(string $field): bool
    {
        return !empty($this->{"{$field}_path"}) || !empty($this->{"{$field}_url"});
    }

    public function isLink(string $field): bool
    {
        return empty($this->{"{$field}_path"}) && !empty($this->{"{$field}_url"});
    }

    public function documentUrl(string $field): ?string
    {
        if ($this->{"{$field}_url"}) {
            return $this->{"{$field}_url"};
        }

        if ($this->{"{$field}_path"}) {
            return asset('storage/' . $this->{"{$field}_path"});
        }

        return null;
    }

    public function documentLabel(string $field): ?string
    {
        return $this->{"{$field}_original_name"} ?? $this->{"{$field}_url"};
    }
}
