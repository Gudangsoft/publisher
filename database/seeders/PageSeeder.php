<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // About Page
        Page::updateOrCreate(
            ['slug' => 'about'],
            [
                'title' => 'Tentang Kami',
                'slug' => 'about',
                'excerpt' => 'Mengenal lebih dekat tentang visi, misi, dan komitmen kami dalam dunia penerbitan buku berkualitas.',
                'content' => "Selamat datang di penerbit kami!

Kami adalah penerbit buku yang berkomitmen untuk menyediakan bacaan berkualitas bagi masyarakat Indonesia. Dengan pengalaman lebih dari 10 tahun di industri penerbitan, kami telah menerbitkan ratusan judul buku dari berbagai genre.

VISI KAMI
Menjadi penerbit terkemuka yang mencerdaskan bangsa melalui buku-buku berkualitas.

MISI KAMI
1. Menerbitkan buku-buku berkualitas tinggi dari penulis terbaik
2. Mendukung perkembangan literasi di Indonesia
3. Memberikan akses mudah terhadap buku-buku berkualitas
4. Membangun komunitas pembaca yang aktif dan kreatif

NILAI-NILAI KAMI
- Kualitas: Kami berkomitmen untuk selalu menghadirkan buku berkualitas terbaik
- Integritas: Kami menjalankan bisnis dengan kejujuran dan transparansi
- Inovasi: Kami terus berinovasi dalam proses penerbitan dan distribusi
- Edukasi: Kami percaya pada kekuatan pendidikan melalui membaca

LAYANAN KAMI
Kami menyediakan berbagai layanan penerbitan, mulai dari editing, desain cover, hingga distribusi. Tim kami yang berpengalaman siap membantu Anda mewujudkan karya terbaik.

HUBUNGI KAMI
Untuk informasi lebih lanjut tentang layanan kami atau jika Anda tertarik untuk menerbitkan buku bersama kami, silakan hubungi tim kami melalui halaman kontak.",
                'meta_title' => 'Tentang Kami - Penerbit Buku Berkualitas',
                'meta_description' => 'Penerbit buku terpercaya dengan pengalaman lebih dari 10 tahun. Berkomitmen menyediakan bacaan berkualitas untuk mencerdaskan bangsa.',
                'meta_keywords' => 'tentang kami, penerbit buku, visi misi, profil perusahaan',
                'is_published' => true,
                'published_at' => now(),
                'display_order' => 1,
            ]
        );

        // Privacy Policy Page
        Page::updateOrCreate(
            ['slug' => 'privacy-policy'],
            [
                'title' => 'Kebijakan Privasi',
                'slug' => 'privacy-policy',
                'excerpt' => 'Kebijakan privasi dan perlindungan data pribadi pengguna website kami.',
                'content' => "KEBIJAKAN PRIVASI

Terakhir diperbarui: " . now()->format('d F Y') . "

Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda ketika Anda menggunakan website kami.

1. INFORMASI YANG KAMI KUMPULKAN
Kami dapat mengumpulkan informasi berikut:
- Nama dan informasi kontak
- Alamat email
- Informasi pembayaran
- Riwayat pembelian
- Preferensi buku dan bacaan

2. PENGGUNAAN INFORMASI
Informasi yang kami kumpulkan digunakan untuk:
- Memproses pesanan dan transaksi
- Mengirimkan informasi tentang produk dan layanan
- Meningkatkan pengalaman pengguna
- Mengirimkan newsletter (jika Anda berlangganan)

3. PERLINDUNGAN DATA
Kami menggunakan langkah-langkah keamanan yang sesuai untuk melindungi informasi pribadi Anda dari akses, penggunaan, atau pengungkapan yang tidak sah.

4. COOKIE
Website kami menggunakan cookie untuk meningkatkan pengalaman pengguna. Anda dapat menonaktifkan cookie melalui pengaturan browser Anda.

5. HAK ANDA
Anda memiliki hak untuk:
- Mengakses informasi pribadi Anda
- Memperbaiki informasi yang tidak akurat
- Meminta penghapusan informasi Anda
- Menolak pemrosesan data Anda

6. PERUBAHAN KEBIJAKAN
Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu. Perubahan akan diposting di halaman ini.

7. KONTAK
Jika Anda memiliki pertanyaan tentang Kebijakan Privasi ini, silakan hubungi kami melalui halaman kontak.",
                'meta_title' => 'Kebijakan Privasi',
                'meta_description' => 'Kebijakan privasi dan perlindungan data pribadi pengguna.',
                'meta_keywords' => 'kebijakan privasi, privacy policy, perlindungan data',
                'is_published' => true,
                'published_at' => now(),
                'display_order' => 2,
            ]
        );

        // Terms of Service Page
        Page::updateOrCreate(
            ['slug' => 'terms-of-service'],
            [
                'title' => 'Syarat dan Ketentuan',
                'slug' => 'terms-of-service',
                'excerpt' => 'Syarat dan ketentuan penggunaan website dan layanan kami.',
                'content' => "SYARAT DAN KETENTUAN

Dengan menggunakan website ini, Anda menyetujui syarat dan ketentuan berikut:

1. PENGGUNAAN WEBSITE
Website ini disediakan untuk tujuan informasi dan pembelian buku. Anda setuju untuk tidak menggunakan website ini untuk tujuan yang melanggar hukum.

2. HAK KEKAYAAN INTELEKTUAL
Semua konten di website ini, termasuk teks, gambar, logo, dan desain, adalah milik kami dan dilindungi oleh hukum hak cipta.

3. PEMBELIAN DAN PEMBAYARAN
- Semua harga dalam Rupiah (IDR)
- Harga dapat berubah sewaktu-waktu
- Pembayaran harus dilakukan sebelum pengiriman
- Kami berhak menolak atau membatalkan pesanan

4. PENGIRIMAN
- Estimasi waktu pengiriman adalah 3-7 hari kerja
- Biaya pengiriman ditanggung oleh pembeli
- Kami tidak bertanggung jawab atas keterlambatan pengiriman

5. PENGEMBALIAN DAN PENUKARAN
- Barang dapat dikembalikan dalam 7 hari
- Barang harus dalam kondisi asli dan tidak rusak
- Biaya pengiriman pengembalian ditanggung pembeli

6. BATASAN TANGGUNG JAWAB
Kami tidak bertanggung jawab atas kerugian langsung atau tidak langsung yang timbul dari penggunaan website atau produk kami.

7. PERUBAHAN SYARAT
Kami berhak mengubah syarat dan ketentuan ini kapan saja. Perubahan akan berlaku segera setelah diposting di website.

8. HUKUM YANG BERLAKU
Syarat dan ketentuan ini diatur oleh hukum yang berlaku di Indonesia.

Jika Anda memiliki pertanyaan, silakan hubungi kami.",
                'meta_title' => 'Syarat dan Ketentuan',
                'meta_description' => 'Syarat dan ketentuan penggunaan website dan layanan kami.',
                'meta_keywords' => 'syarat ketentuan, terms of service, aturan penggunaan',
                'is_published' => true,
                'published_at' => now(),
                'display_order' => 3,
            ]
        );
    }
}
