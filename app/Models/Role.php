<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'color', 'is_system', 'is_active', 'permissions'];

    protected $casts = [
        'is_system'   => 'boolean',
        'is_active'   => 'boolean',
        'permissions' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($role) {
            if (empty($role->slug)) {
                $role->slug = Str::slug($role->name);
            }
        });
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
        return in_array($slug, $this->permissions ?? []);
    }

    // -------------------------------------------------------
    // Static permission list — single source of truth
    // -------------------------------------------------------
    public static function allPermissions(): array
    {
        return [
            'Konten Utama' => [
                'dashboard'  => ['label' => 'Dashboard',          'icon' => '🏠'],
                'books'      => ['label' => 'Manajemen Buku',      'icon' => '📚'],
                'news'       => ['label' => 'Manajemen Berita',    'icon' => '📰'],
                'journals'   => ['label' => 'Manajemen Jurnal',    'icon' => '📄'],
                'galleries'  => ['label' => 'Galeri & Album',      'icon' => '🖼️'],
            ],
            'Website' => [
                'hero-sliders' => ['label' => 'Hero Slider',      'icon' => '🖼'],
                'statistics'   => ['label' => 'Statistik',         'icon' => '📊'],
                'categories'   => ['label' => 'Kategori',          'icon' => '🏷️'],
                'authors'      => ['label' => 'Penulis',           'icon' => '✍️'],
                'pages'        => ['label' => 'Halaman',           'icon' => '📃'],
                'menus'        => ['label' => 'Menu Website',      'icon' => '☰'],
                'reviews'      => ['label' => 'Ulasan',            'icon' => '⭐'],
            ],
            'Operasional' => [
                'submissions' => ['label' => 'Pengajuan Naskah',  'icon' => '📨'],
                'templates'   => ['label' => 'Template Buku',     'icon' => '📋'],
                'orders'      => ['label' => 'Pesanan',           'icon' => '🛒'],
            ],
            'Perpustakaan' => [
                'book-loans'   => ['label' => 'Data Peminjaman', 'icon' => '📖'],
                'visitor-logs' => ['label' => 'Data Pengunjung',  'icon' => '🧾'],
            ],
            'Sistem' => [
                'users'    => ['label' => 'Pengguna',    'icon' => '👥'],
                'settings' => ['label' => 'Pengaturan',  'icon' => '⚙️'],
                'theme'    => ['label' => 'Tema & Layout', 'icon' => '🎨'],
                'reports'  => ['label' => 'Laporan',     'icon' => '📈'],
            ],
        ];
    }

    public static function colorClasses(): array
    {
        return [
            'blue'   => ['bg' => 'bg-blue-100',   'text' => 'text-blue-700'],
            'green'  => ['bg' => 'bg-green-100',  'text' => 'text-green-700'],
            'purple' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700'],
            'red'    => ['bg' => 'bg-red-100',    'text' => 'text-red-700'],
            'orange' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700'],
            'yellow' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700'],
            'teal'   => ['bg' => 'bg-teal-100',   'text' => 'text-teal-700'],
            'pink'   => ['bg' => 'bg-pink-100',   'text' => 'text-pink-700'],
        ];
    }
}
