<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // --- Permissions ---
        $permissions = [
            // Konten Utama
            ['name' => 'Dashboard',          'slug' => 'dashboard',    'group' => 'Konten Utama', 'icon' => '🏠', 'sort_order' => 1],
            ['name' => 'Manajemen Buku',      'slug' => 'books',        'group' => 'Konten Utama', 'icon' => '📚', 'sort_order' => 2],
            ['name' => 'Manajemen Berita',    'slug' => 'news',         'group' => 'Konten Utama', 'icon' => '📰', 'sort_order' => 3],
            ['name' => 'Manajemen Jurnal',    'slug' => 'journals',     'group' => 'Konten Utama', 'icon' => '📄', 'sort_order' => 4],
            ['name' => 'Galeri & Album',      'slug' => 'galleries',    'group' => 'Konten Utama', 'icon' => '🖼️', 'sort_order' => 5],
            // Website
            ['name' => 'Hero Slider',        'slug' => 'hero-sliders', 'group' => 'Website',      'icon' => '🖼', 'sort_order' => 10],
            ['name' => 'Statistik',          'slug' => 'statistics',   'group' => 'Website',      'icon' => '📊', 'sort_order' => 11],
            ['name' => 'Kategori',           'slug' => 'categories',   'group' => 'Website',      'icon' => '🏷️', 'sort_order' => 12],
            ['name' => 'Penulis',            'slug' => 'authors',      'group' => 'Website',      'icon' => '✍️', 'sort_order' => 13],
            ['name' => 'Halaman',            'slug' => 'pages',        'group' => 'Website',      'icon' => '📃', 'sort_order' => 14],
            ['name' => 'Menu Website',       'slug' => 'menus',        'group' => 'Website',      'icon' => '☰',  'sort_order' => 15],
            ['name' => 'Ulasan',             'slug' => 'reviews',      'group' => 'Website',      'icon' => '⭐', 'sort_order' => 16],
            // Operasional
            ['name' => 'Pengajuan Naskah',   'slug' => 'submissions',  'group' => 'Operasional',  'icon' => '📨', 'sort_order' => 20],
            ['name' => 'Template Buku',      'slug' => 'templates',    'group' => 'Operasional',  'icon' => '📋', 'sort_order' => 21],
            ['name' => 'Pesanan',            'slug' => 'orders',       'group' => 'Operasional',  'icon' => '🛒', 'sort_order' => 22],
            // Sistem
            ['name' => 'Pengguna',           'slug' => 'users',        'group' => 'Sistem',       'icon' => '👥', 'sort_order' => 30],
            ['name' => 'Pengaturan',         'slug' => 'settings',     'group' => 'Sistem',       'icon' => '⚙️', 'sort_order' => 31],
            ['name' => 'Tema & Layout',      'slug' => 'theme',        'group' => 'Sistem',       'icon' => '🎨', 'sort_order' => 32],
            ['name' => 'Laporan',            'slug' => 'reports',      'group' => 'Sistem',       'icon' => '📈', 'sort_order' => 33],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['slug' => $perm['slug']], $perm);
        }

        // --- Preset Roles ---
        $roles = [
            [
                'name'        => 'Penulis Berita & Galeri',
                'slug'        => 'penulis-berita-galeri',
                'description' => 'Dapat mengelola berita dan konten galeri',
                'color'       => 'blue',
                'is_system'   => true,
                'permissions' => ['dashboard', 'news', 'galleries', 'categories'],
            ],
            [
                'name'        => 'Input Buku & Jurnal',
                'slug'        => 'input-buku-jurnal',
                'description' => 'Dapat menginput dan mengelola buku serta jurnal',
                'color'       => 'green',
                'is_system'   => true,
                'permissions' => ['dashboard', 'books', 'journals', 'authors', 'categories'],
            ],
        ];

        foreach ($roles as $roleData) {
            $permSlugs = $roleData['permissions'];
            unset($roleData['permissions']);

            $role = Role::firstOrCreate(['slug' => $roleData['slug']], $roleData);
            $permIds = Permission::whereIn('slug', $permSlugs)->pluck('id');
            $role->permissions()->syncWithoutDetaching($permIds);
        }
    }
}
