<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing menus
        Menu::truncate();

        // Create header menus
        $menus = [
            [
                'label' => 'Beranda',
                'url' => '/',
                'icon' => '🏠',
                'display_order' => 1,
                'location' => 'header',
                'is_active' => true,
            ],
            [
                'label' => 'Katalog Buku',
                'url' => '/books',
                'icon' => '📚',
                'display_order' => 2,
                'location' => 'header',
                'is_active' => true,
            ],
            [
                'label' => 'Kategori',
                'url' => '#',
                'icon' => '📂',
                'display_order' => 3,
                'location' => 'header',
                'is_active' => true,
                'children' => [
                    ['label' => 'Buku Pendidikan', 'url' => '/books?category=pendidikan', 'display_order' => 1],
                    ['label' => 'Buku Novel', 'url' => '/books?category=novel', 'display_order' => 2],
                    ['label' => 'Buku Bisnis', 'url' => '/books?category=bisnis', 'display_order' => 3],
                    ['label' => 'Semua Kategori', 'url' => '/books', 'display_order' => 4],
                ],
            ],
            [
                'label' => 'Berita',
                'url' => '/news',
                'icon' => '📰',
                'display_order' => 4,
                'location' => 'header',
                'is_active' => true,
            ],
            [
                'label' => 'Jurnal',
                'url' => '/journals',
                'icon' => '📄',
                'display_order' => 5,
                'location' => 'header',
                'is_active' => true,
            ],
            [
                'label' => 'Penulis',
                'url' => '/authors',
                'icon' => '👥',
                'display_order' => 6,
                'location' => 'header',
                'is_active' => true,
            ],
            [
                'label' => 'Tentang Kami',
                'url' => '/about',
                'icon' => 'ℹ️',
                'display_order' => 7,
                'location' => 'both',
                'is_active' => true,
            ],
            [
                'label' => 'Kontak',
                'url' => '/contact',
                'icon' => '📧',
                'display_order' => 8,
                'location' => 'both',
                'is_active' => true,
            ],
        ];

        foreach ($menus as $menuData) {
            $children = $menuData['children'] ?? [];
            unset($menuData['children']);
            
            $menu = Menu::create($menuData);
            
            foreach ($children as $childData) {
                $childData['parent_id'] = $menu->id;
                $childData['location'] = 'header';
                $childData['is_active'] = true;
                Menu::create($childData);
            }
        }

        $this->command->info('Menu seeded successfully!');
    }
}
