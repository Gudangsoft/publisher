<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use Illuminate\Support\Str;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $authors = [
            [
                'name' => 'Dr. Ahmad Tohari',
                'slug' => Str::slug('Dr. Ahmad Tohari'),
                'biography' => 'Ahmad Tohari adalah penulis Indonesia yang terkenal dengan karya-karyanya yang menggambarkan kehidupan masyarakat Jawa. Lahir di Tinggarjaya, Jatilawang, Banyumas pada tahun 1948, beliau dikenal dengan trilogi "Ronggeng Dukuh Paruk" yang telah memenangkan berbagai penghargaan sastra.',
                'email' => 'contact@ahmadtohari.com',
                'is_featured' => true,
                'display_order' => 1,
            ],
            [
                'name' => 'Dee Lestari',
                'slug' => Str::slug('Dee Lestari'),
                'biography' => 'Dewi Lestari Simangunsong atau lebih dikenal sebagai Dee Lestari adalah penulis, penyanyi, dan komposer Indonesia. Karya fenomenalnya "Supernova" telah membuat namanya dikenal luas di dunia sastra Indonesia.',
                'email' => 'dee@deelestari.com',
                'website' => 'https://deelestari.com',
                'facebook' => 'https://facebook.com/deelestari',
                'twitter' => 'https://twitter.com/deelestari',
                'instagram' => 'https://instagram.com/deelestari',
                'is_featured' => true,
                'display_order' => 2,
            ],
            [
                'name' => 'Tere Liye',
                'slug' => Str::slug('Tere Liye'),
                'biography' => 'Tere Liye adalah nama pena dari Darwis, seorang penulis novel Indonesia yang sangat produktif. Karya-karyanya banyak yang menjadi bestseller dan disukai oleh pembaca dari berbagai kalangan usia.',
                'email' => 'info@tereliye.com',
                'website' => 'https://tereliye.com',
                'instagram' => 'https://instagram.com/tere_liye',
                'is_featured' => true,
                'display_order' => 3,
            ],
            [
                'name' => 'Pramoedya Ananta Toer',
                'slug' => Str::slug('Pramoedya Ananta Toer'),
                'biography' => 'Pramoedya Ananta Toer adalah salah satu pengarang Indonesia yang paling produktif dalam sejarah sastra Indonesia. Tetralogi Pulau Buru adalah karya monumentalnya yang dikenal di mancanegara.',
                'email' => 'legacy@pramoedya.org',
                'is_featured' => false,
                'display_order' => 4,
            ],
            [
                'name' => 'Eka Kurniawan',
                'slug' => Str::slug('Eka Kurniawan'),
                'biography' => 'Eka Kurniawan adalah penulis Indonesia yang karyanya telah diterjemahkan ke lebih dari 30 bahasa. Novel "Cantik Itu Luka" dan "Lelaki Harimau" mendapat pengakuan internasional.',
                'email' => 'eka@ekakurniawan.com',
                'website' => 'https://ekakurniawan.com',
                'twitter' => 'https://twitter.com/kurniawan_eka',
                'is_featured' => true,
                'display_order' => 5,
            ],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}
