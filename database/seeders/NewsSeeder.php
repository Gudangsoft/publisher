<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        // Get news categories
        $peluncuran = Category::where('slug', 'peluncuran-buku')->first();
        $promo = Category::where('slug', 'promo-diskon')->first();
        $event = Category::where('slug', 'event-workshop')->first();
        $rekomendasi = Category::where('slug', 'rekomendasi')->first();
        $tips = Category::where('slug', 'tips-artikel')->first();
        
        $newsItems = [
            [
                'category_id' => $peluncuran?->id,
                'title' => 'Launching Buku Terbaru "Perjalanan Mencari Makna"',
                'summary' => 'Peluncuran buku terbaru dari penulis bestseller Indonesia akan diadakan minggu depan di Jakarta.',
                'content' => 'Kami dengan bangga mengumumkan peluncuran buku terbaru "Perjalanan Mencari Makna" karya penulis bestseller nasional. Buku ini mengisahkan perjalanan spiritual seorang pemuda dalam mencari jati diri di tengah hiruk pikuk kehidupan modern. Acara peluncuran akan diadakan pada Sabtu, 25 November 2025 di Gramedia Matraman, Jakarta Timur mulai pukul 14.00 WIB. Akan ada sesi tanya jawab dengan penulis dan meet & greet. Dapatkan diskon 30% untuk pembelian di hari peluncuran!',
                'published_at' => '2025-11-18 10:00:00',
            ],
            [
                'category_id' => $promo?->id,
                'title' => 'Promo Spesial: Beli 2 Gratis 1 untuk Semua Buku Fiksi',
                'summary' => 'Nikmati promo spesial beli 2 gratis 1 untuk semua kategori buku fiksi selama bulan November.',
                'content' => 'Kabar gembira untuk para pecinta buku fiksi! Kami mengadakan promo spesial "Beli 2 Gratis 1" untuk semua koleksi buku fiksi di toko kami. Promo berlaku mulai 20 November hingga 30 November 2025. Kategori yang termasuk dalam promo: Novel Indonesia, Novel Terjemahan, Fiksi Ilmiah, dan Fantasi. Syarat dan ketentuan berlaku. Buruan kunjungi toko atau belanja online untuk mendapatkan penawaran terbaik ini!',
                'published_at' => '2025-11-17 09:30:00',
            ],
            [
                'category_id' => $event?->id,
                'title' => 'Workshop Menulis Kreatif untuk Pemula',
                'summary' => 'Bergabunglah dengan workshop menulis kreatif bersama penulis profesional untuk mengasah kemampuan menulis Anda.',
                'content' => 'Publisher Bookstore mengadakan Workshop Menulis Kreatif untuk Pemula yang akan dibawakan oleh penulis profesional dengan pengalaman lebih dari 10 tahun. Workshop ini akan membahas teknik dasar penulisan, pengembangan karakter, plot, dan tips menerbitkan buku. Acara diadakan pada Minggu, 3 Desember 2025 pukul 09.00-15.00 WIB. Biaya pendaftaran Rp 250.000 sudah termasuk materi, sertifikat, dan makan siang. Tempat terbatas hanya 30 orang. Daftar sekarang!',
                'published_at' => '2025-11-16 14:00:00',
            ],
            [
                'category_id' => $peluncuran?->id,
                'title' => 'Koleksi Buku Anak Terbaru: Seri Petualangan Si Kancil',
                'summary' => 'Kenalkan anak-anak pada budaya Indonesia melalui seri buku petualangan Si Kancil yang penuh pembelajaran moral.',
                'content' => 'Kami dengan senang hati mempersembahkan koleksi buku anak terbaru: "Seri Petualangan Si Kancil" yang terdiri dari 5 judul. Setiap buku mengisahkan petualangan Si Kancil dengan tokoh-tokoh hewan lain sambil menyisipkan nilai-nilai moral yang penting untuk perkembangan karakter anak. Buku ini dilengkapi dengan ilustrasi full color yang menarik dan bahasa yang mudah dipahami anak usia 5-10 tahun. Harga spesial Rp 45.000 per buku atau Rp 200.000 untuk paket 5 buku.',
                'published_at' => '2025-11-15 11:00:00',
            ],
            [
                'category_id' => $rekomendasi?->id,
                'title' => 'Rekomendasi Buku Bisnis Best Seller 2025',
                'summary' => 'Daftar 10 buku bisnis terlaris tahun 2025 yang wajib dibaca para entrepreneur dan profesional.',
                'content' => 'Tahun 2025 menghadirkan banyak buku bisnis berkualitas yang memberikan insight berharga untuk para entrepreneur dan profesional. Berikut 10 buku bisnis best seller yang paling banyak diburu pembaca: 1) "Atomic Habits" - James Clear, 2) "The Psychology of Money" - Morgan Housel, 3) "Think and Grow Rich" - Napoleon Hill, 4) "Start With Why" - Simon Sinek, 5) "Good to Great" - Jim Collins, dan masih banyak lagi. Dapatkan semua buku ini dengan diskon hingga 25% di toko kami!',
                'published_at' => '2025-11-14 08:00:00',
            ],
            [
                'category_id' => $event?->id,
                'title' => 'Event Meet & Greet dengan Penulis Terkenal',
                'summary' => 'Kesempatan emas bertemu langsung dengan penulis favorit Anda dalam acara meet & greet eksklusif.',
                'content' => 'Publisher Bookstore menghadirkan acara meet & greet eksklusif dengan 3 penulis terkenal Indonesia: Andrea Hirata, Dee Lestari, dan Ahmad Fuadi. Acara akan diadakan pada Sabtu, 10 Desember 2025 di Store Central Park Mall, Jakarta Barat. Anda dapat berbincang langsung, bertanya tentang proses kreatif mereka, dan mendapatkan tanda tangan di buku favorit Anda. Tiket gratis untuk pembelian minimal Rp 150.000. Daftar melalui website atau aplikasi kami. Slot terbatas!',
                'published_at' => '2025-11-13 15:30:00',
            ],
            [
                'category_id' => $promo?->id,
                'title' => 'Pre-Order Buku "Filosofi Kopi" Edisi Khusus',
                'summary' => 'Pre-order sekarang untuk mendapatkan "Filosofi Kopi" edisi khusus dengan cover eksklusif dan bonus bookmark.',
                'content' => 'Kabar gembira untuk penggemar "Filosofi Kopi"! Kami membuka pre-order untuk edisi khusus yang akan terbit bulan Desember 2025. Edisi khusus ini hadir dengan cover hard cover eksklusif, kertas premium, dan bonus bookmark berbahan metal. Harga pre-order Rp 120.000 (harga normal Rp 150.000). Periode pre-order hingga 30 November 2025. Buku akan mulai dikirim pada 15 Desember 2025. Jangan sampai kehabisan, stock terbatas hanya 1000 eksemplar!',
                'published_at' => '2025-11-12 10:00:00',
            ],
            [
                'category_id' => $tips?->id,
                'title' => 'Tips Memilih Buku yang Tepat untuk Anak Sesuai Usia',
                'summary' => 'Panduan lengkap memilih buku bacaan yang sesuai dengan tahap perkembangan anak Anda.',
                'content' => 'Memilih buku yang tepat untuk anak sangat penting untuk menumbuhkan minat baca sejak dini. Untuk usia 0-3 tahun, pilih buku board book dengan gambar besar dan warna cerah. Usia 4-6 tahun cocok dengan buku bergambar dengan cerita sederhana. Usia 7-9 tahun sudah bisa membaca chapter books dengan ilustrasi. Usia 10+ dapat mulai membaca novel anak dan remaja. Pastikan konten sesuai nilai yang ingin Anda tanamkan dan pilih buku dengan bahasa yang mudah dipahami sesuai level anak.',
                'published_at' => '2025-11-11 13:00:00',
            ],
        ];

        foreach ($newsItems as $newsData) {
            News::create([
                'category_id' => $newsData['category_id'],
                'title' => $newsData['title'],
                'slug' => Str::slug($newsData['title']) . '-' . time() . rand(100, 999),
                'summary' => $newsData['summary'],
                'content' => $newsData['content'],
                'published_at' => $newsData['published_at'],
            ]);
        }
    }
}
