<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name'        => 'Penulis Berita & Galeri',
                'slug'        => 'penulis-berita-galeri',
                'description' => 'Dapat mengelola berita dan konten galeri',
                'color'       => 'blue',
                'is_system'   => true,
                'is_active'   => true,
                'permissions' => ['dashboard', 'news', 'galleries', 'categories'],
            ],
            [
                'name'        => 'Input Buku & Jurnal',
                'slug'        => 'input-buku-jurnal',
                'description' => 'Dapat menginput dan mengelola buku serta jurnal',
                'color'       => 'green',
                'is_system'   => true,
                'is_active'   => true,
                'permissions' => ['dashboard', 'books', 'journals', 'authors', 'categories'],
            ],
            [
                'name'        => 'Staf Operasional',
                'slug'        => 'staf-operasional',
                'description' => 'Mengelola pesanan dan pengajuan naskah',
                'color'       => 'orange',
                'is_system'   => true,
                'is_active'   => true,
                'permissions' => ['dashboard', 'submissions', 'orders', 'templates'],
            ],
        ];

        foreach ($roles as $data) {
            Role::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
