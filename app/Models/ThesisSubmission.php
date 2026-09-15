<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThesisSubmission extends Model
{
    protected $fillable = [
        'repository_taruna_id',
        'title',
        'submission_code',
        'is_published',
        'published_at',
        'cover_path',
        'cover_original_name',
        'cover_url',
        'pengesahan_path',
        'pengesahan_original_name',
        'pengesahan_url',
        'abstrak_path',
        'abstrak_original_name',
        'abstrak_url',
        'bab1_path',
        'bab1_original_name',
        'bab1_url',
        'bab2_path',
        'bab2_original_name',
        'bab2_url',
        'bab3_path',
        'bab3_original_name',
        'bab3_url',
        'bab4_path',
        'bab4_original_name',
        'bab4_url',
        'bab5_path',
        'bab5_original_name',
        'bab5_url',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public const FILE_FIELDS = [
        'cover' => 'Cover',
        'pengesahan' => 'Lembar Pengesahan',
        'abstrak' => 'Abstrak',
        'bab1' => 'Judul s.d. Bab I',
        'bab2' => 'Bab II',
        'bab3' => 'Bab III',
        'bab4' => 'Bab IV',
        'bab5' => 'Bab V',
    ];

    // Visible on the public collection page once the submission is published.
    public const PUBLIC_FIELDS = ['cover', 'pengesahan', 'abstrak', 'bab1', 'bab2', 'bab3'];

    // Never exposed publicly, regardless of publish status.
    public const HIDDEN_FIELDS = ['bab4', 'bab5'];

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

    public static function isPublicField(string $field): bool
    {
        return in_array($field, self::PUBLIC_FIELDS, true);
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
