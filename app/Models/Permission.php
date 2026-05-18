<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'slug', 'group', 'icon', 'description', 'sort_order'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }

    public static function allGrouped(): \Illuminate\Support\Collection
    {
        return static::orderBy('sort_order')->get()->groupBy('group');
    }
}
