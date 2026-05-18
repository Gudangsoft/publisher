<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'color', 'is_system', 'is_active'];

    protected $casts = ['is_system' => 'boolean', 'is_active' => 'boolean'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($role) {
            if (empty($role->slug)) {
                $role->slug = Str::slug($role->name);
            }
        });
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function hasPermission(string $slug): bool
    {
        return $this->permissions->contains('slug', $slug);
    }

    public static function colorClasses(): array
    {
        return [
            'blue'   => ['bg' => 'bg-blue-100',   'text' => 'text-blue-700',   'border' => 'border-blue-300'],
            'green'  => ['bg' => 'bg-green-100',  'text' => 'text-green-700',  'border' => 'border-green-300'],
            'purple' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'border' => 'border-purple-300'],
            'red'    => ['bg' => 'bg-red-100',    'text' => 'text-red-700',    'border' => 'border-red-300'],
            'orange' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'border' => 'border-orange-300'],
            'yellow' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'border' => 'border-yellow-300'],
            'teal'   => ['bg' => 'bg-teal-100',   'text' => 'text-teal-700',   'border' => 'border-teal-300'],
            'pink'   => ['bg' => 'bg-pink-100',   'text' => 'text-pink-700',   'border' => 'border-pink-300'],
        ];
    }

    public function badgeClass(): string
    {
        $classes = self::colorClasses();
        $c = $classes[$this->color] ?? $classes['blue'];
        return "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {$c['bg']} {$c['text']} border {$c['border']}";
    }
}
