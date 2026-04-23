<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        // Get book categories
        $fiksi = Category::where('slug', 'fiksi')->first();
        $nonFiksi = Category::where('slug', 'non-fiksi')->first();
        $bisnis = Category::where('slug', 'bisnis-ekonomi')->first();
        $pengembanganDiri = Category::where('slug', 'pengembangan-diri')->first();
        
        $books = [
            [
                'category_id' => $fiksi?->id,
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'isbn' => '978-979-22-3896-4',
                'description' => 'Novel pertama karya Andrea Hirata yang bercerita tentang kehidupan 10 anak dari keluarga miskin yang bersekolah di SD Muhammadiyah di Belitung. Kisah inspiratif tentang perjuangan mendapatkan pendidikan.',
                'published_at' => '2005-09-01',
            ],
            [
                'category_id' => $fiksi?->id,
                'title' => 'Negeri 5 Menara',
                'author' => 'Ahmad Fuadi',
                'isbn' => '978-602-8811-03-4',
                'description' => 'Novel yang mengangkat kisah kehidupan santri di Pondok Madani (dalam novel disebut Pondok Madani). Novel ini mengajarkan pentingnya mimpi dan kerja keras untuk meraihnya.',
                'published_at' => '2009-03-01',
            ],
            [
                'category_id' => $fiksi?->id,
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'isbn' => '978-602-06-1949-7',
                'description' => 'Novel pertama dari Tetralogi Buru yang bercerita tentang perjalanan seorang tokoh bernama Minke, seorang pribumi yang pintar menulis. Novel ini mengangkat isu kolonialisme di Indonesia.',
                'published_at' => '1980-08-01',
            ],
            [
                'category_id' => $pengembanganDiri?->id,
                'title' => 'Filosofi Teras',
                'author' => 'Henry Manampiring',
                'isbn' => '978-602-03-7565-1',
                'description' => 'Buku self-help yang membahas filosofi Stoikisme dengan cara yang praktis dan mudah dipahami. Membantu pembaca menghadapi masalah hidup dengan lebih tenang.',
                'published_at' => '2018-11-01',
            ],
            [
                'category_id' => $pengembanganDiri?->id,
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'isbn' => '978-0-7352-1129-2',
                'description' => 'Buku yang mengajarkan cara membangun kebiasaan baik dan menghilangkan kebiasaan buruk melalui perubahan-perubahan kecil yang konsisten. Best seller New York Times.',
                'published_at' => '2018-10-16',
            ],
            [
                'category_id' => $nonFiksi?->id,
                'title' => 'Sapiens: A Brief History of Humankind',
                'author' => 'Yuval Noah Harari',
                'isbn' => '978-0-06-231609-7',
                'description' => 'Buku yang mengeksplorasi sejarah umat manusia dari zaman batu hingga era modern. Memberikan perspektif baru tentang evolusi manusia dan peradaban.',
                'published_at' => '2011-09-04',
            ],
            [
                'category_id' => $bisnis?->id,
                'title' => 'The Psychology of Money',
                'author' => 'Morgan Housel',
                'isbn' => '978-0-85774-656-7',
                'description' => 'Buku yang membahas aspek psikologi dalam pengelolaan uang. Mengajarkan bahwa sukses finansial lebih banyak tentang perilaku dibandingkan pengetahuan teknis.',
                'published_at' => '2020-09-08',
            ],
            [
                'category_id' => $fiksi?->id,
                'title' => 'Sang Pemimpi',
                'author' => 'Andrea Hirata',
                'isbn' => '978-979-22-3898-8',
                'description' => 'Sekuel dari Laskar Pelangi yang bercerita tentang Ikal dan Arai yang bermimpi bisa kuliah di Prancis meskipun berasal dari keluarga sederhana.',
                'published_at' => '2006-05-01',
            ],
            [
                'category_id' => $fiksi?->id,
                'title' => 'Ronggeng Dukuh Paruk',
                'author' => 'Ahmad Tohari',
                'isbn' => '978-979-22-0000-0',
                'description' => 'Trilogi novel yang mengisahkan kehidupan seorang ronggeng bernama Srintil dan cintanya dengan Rasus. Mengangkat tradisi ronggeng di sebuah desa terpencil.',
                'published_at' => '1982-01-01',
            ],
            [
                'category_id' => $fiksi?->id,
                'title' => 'Supernova: Kesatria, Putri, dan Bintang Jatuh',
                'author' => 'Dee Lestari',
                'isbn' => '978-979-22-3456-0',
                'description' => 'Novel fiksi ilmiah yang memadukan cinta, filosofi, dan sains. Karya pertama Dee Lestari yang fenomenal dan menjadi bestseller.',
                'published_at' => '2001-12-01',
            ],
            [
                'category_id' => $bisnis?->id,
                'title' => 'Humble Leadership',
                'author' => 'Edgar Schein & Peter Schein',
                'isbn' => '978-1-5230-8701-0',
                'description' => 'Buku tentang kepemimpinan yang menekankan pentingnya kerendahan hati dalam memimpin. Cocok untuk para pemimpin di era modern.',
                'published_at' => '2018-02-20',
            ],
            [
                'category_id' => $fiksi?->id,
                'title' => 'Perahu Kertas',
                'author' => 'Dee Lestari',
                'isbn' => '978-602-7888-23-8',
                'description' => 'Novel yang bercerita tentang Kugy dan Keenan yang memiliki impian besar namun terhalang berbagai rintangan. Kisah tentang mimpi, cinta, dan perjuangan.',
                'published_at' => '2009-06-01',
            ],
            [
                'category_id' => $fiksi?->id,
                'title' => 'Cantik Itu Luka',
                'author' => 'Eka Kurniawan',
                'isbn' => '978-979-22-2914-6',
                'description' => 'Novel yang menceritakan kisah Dewi Ayu, seorang pelacur cantik, dan keempat putrinya. Memadukan realisme magis dengan sejarah Indonesia.',
                'published_at' => '2002-01-01',
            ],
            [
                'category_id' => $bisnis?->id,
                'title' => 'Think and Grow Rich',
                'author' => 'Napoleon Hill',
                'isbn' => '978-1-5853-4200-2',
                'description' => 'Buku klasik tentang kesuksesan dan kekayaan yang telah menginspirasi jutaan orang. Membahas 13 prinsip kesuksesan.',
                'published_at' => '1937-01-01',
            ],
            [
                'category_id' => $bisnis?->id,
                'title' => 'Start With Why',
                'author' => 'Simon Sinek',
                'isbn' => '978-1-59184-280-4',
                'description' => 'Buku yang mengajarkan pentingnya memahami "mengapa" sebelum "bagaimana" dan "apa". Inspirasi untuk pemimpin dan organisasi.',
                'published_at' => '2009-10-29',
            ],
        ];

        foreach ($books as $bookData) {
            Book::create($bookData);
        }
    }
}
