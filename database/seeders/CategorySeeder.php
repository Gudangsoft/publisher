<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Book Categories
            [
                'name' => 'Fiksi',
                'slug' => 'fiksi',
                'description' => 'Buku-buku fiksi meliputi novel, cerpen, dan karya sastra imajinatif lainnya',
                'type' => 'book'
            ],
            [
                'name' => 'Non-Fiksi',
                'slug' => 'non-fiksi',
                'description' => 'Buku-buku non-fiksi berdasarkan fakta, biografi, dan karya ilmiah',
                'type' => 'book'
            ],
            [
                'name' => 'Anak-anak',
                'slug' => 'anak-anak',
                'description' => 'Buku-buku edukatif dan cerita untuk anak-anak',
                'type' => 'book'
            ],
            [
                'name' => 'Bisnis & Ekonomi',
                'slug' => 'bisnis-ekonomi',
                'description' => 'Buku tentang bisnis, keuangan, dan ekonomi',
                'type' => 'book'
            ],
            [
                'name' => 'Pengembangan Diri',
                'slug' => 'pengembangan-diri',
                'description' => 'Buku self-improvement, motivasi, dan pengembangan pribadi',
                'type' => 'book'
            ],
            [
                'name' => 'Teknologi',
                'slug' => 'teknologi',
                'description' => 'Buku tentang teknologi, komputer, dan pemrograman',
                'type' => 'book'
            ],
            [
                'name' => 'Agama & Spiritual',
                'slug' => 'agama-spiritual',
                'description' => 'Buku tentang keagamaan dan spiritualitas',
                'type' => 'book'
            ],
            [
                'name' => 'Pendidikan',
                'slug' => 'pendidikan',
                'description' => 'Buku-buku pendidikan dan akademik',
                'type' => 'book'
            ],
            
            // News Categories
            [
                'name' => 'Peluncuran Buku',
                'slug' => 'peluncuran-buku',
                'description' => 'Berita tentang peluncuran buku-buku baru',
                'type' => 'news'
            ],
            [
                'name' => 'Promo & Diskon',
                'slug' => 'promo-diskon',
                'description' => 'Informasi promo dan diskon spesial',
                'type' => 'news'
            ],
            [
                'name' => 'Event & Workshop',
                'slug' => 'event-workshop',
                'description' => 'Pengumuman event, workshop, dan acara lainnya',
                'type' => 'news'
            ],
            [
                'name' => 'Rekomendasi',
                'slug' => 'rekomendasi',
                'description' => 'Rekomendasi buku dan artikel pilihan',
                'type' => 'news'
            ],
            [
                'name' => 'Tips & Artikel',
                'slug' => 'tips-artikel',
                'description' => 'Tips membaca dan artikel edukatif',
                'type' => 'news'
            ],
            
            // Journal Categories
            [
                'name' => 'Sains & Teknologi',
                'slug' => 'sains-teknologi',
                'description' => 'Journal penelitian di bidang sains dan teknologi',
                'type' => 'journal'
            ],
            [
                'name' => 'Sosial & Humaniora',
                'slug' => 'sosial-humaniora',
                'description' => 'Journal penelitian sosial dan humaniora',
                'type' => 'journal'
            ],
            [
                'name' => 'Kesehatan',
                'slug' => 'kesehatan',
                'description' => 'Journal penelitian medis dan kesehatan',
                'type' => 'journal'
            ],
            [
                'name' => 'Ekonomi & Manajemen',
                'slug' => 'ekonomi-manajemen',
                'description' => 'Journal penelitian ekonomi dan manajemen bisnis',
                'type' => 'journal'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
