<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Book;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Get some books if they exist
        $books = Book::take(5)->get();

        $publisherReviews = [
            [
                'reviewer_name' => 'Dr. Siti Nurhaliza',
                'reviewer_email' => 'siti.n@university.ac.id',
                'review_text' => 'Publisher ini sangat profesional dalam menerbitkan buku-buku berkualitas. Proses penerbitan sangat transparan dan komunikasi yang baik. Sangat merekomendasikan untuk penulis yang ingin menerbitkan karyanya.',
                'rating' => 5,
                'type' => 'publisher',
                'is_approved' => true,
                'is_featured' => true,
            ],
            [
                'reviewer_name' => 'Budi Santoso',
                'reviewer_email' => 'budi.santoso@email.com',
                'review_text' => 'Pelayanan yang sangat memuaskan! Tim editorial memberikan feedback yang konstruktif dan membantu meningkatkan kualitas naskah. Proses dari naskah hingga buku jadi sangat smooth.',
                'rating' => 5,
                'type' => 'publisher',
                'is_approved' => true,
                'is_featured' => true,
            ],
            [
                'reviewer_name' => 'Prof. Ahmad Wijaya',
                'reviewer_email' => 'ahmad.wijaya@gmail.com',
                'review_text' => 'Sebagai akademisi, saya sangat terbantu dengan proses penerbitan jurnal dan buku ilmiah di publisher ini. Standar kualitas yang tinggi dan proses review yang ketat membuat karya yang diterbitkan sangat kredibel.',
                'rating' => 5,
                'type' => 'publisher',
                'is_approved' => true,
                'is_featured' => true,
            ],
            [
                'reviewer_name' => 'Dewi Lestari S.',
                'reviewer_email' => 'dewi.lestari@yahoo.com',
                'review_text' => 'Koleksi buku yang sangat lengkap dan beragam. Website mudah dinavigasi dan informasi buku sangat detail. Pengalaman berbelanja yang menyenangkan!',
                'rating' => 5,
                'type' => 'publisher',
                'is_approved' => true,
                'is_featured' => false,
            ],
            [
                'reviewer_name' => 'Rudi Hartono',
                'reviewer_email' => 'rudi.h@outlook.com',
                'review_text' => 'Harga yang kompetitif dan kualitas buku yang bagus. Pengiriman cepat dan packaging rapi. Akan order lagi untuk koleksi selanjutnya.',
                'rating' => 4,
                'type' => 'publisher',
                'is_approved' => true,
                'is_featured' => false,
            ],
            [
                'reviewer_name' => 'Rina Kusuma',
                'reviewer_email' => 'rina.kusuma@email.com',
                'review_text' => 'Publisher yang sangat supportive terhadap penulis baru. Mereka memberikan bimbingan dan arahan yang jelas. Sangat grateful bisa bekerja sama dengan mereka.',
                'rating' => 5,
                'type' => 'publisher',
                'is_approved' => true,
                'is_featured' => true,
            ],
        ];

        // Create publisher testimonials
        foreach ($publisherReviews as $review) {
            Review::create($review);
        }

        // Create some book reviews if books exist
        if ($books->count() > 0) {
            $bookReviews = [
                [
                    'book_id' => $books[0]->id ?? null,
                    'reviewer_name' => 'Andi Wijaya',
                    'reviewer_email' => 'andi.w@gmail.com',
                    'review_text' => 'Buku yang sangat menginspirasi! Bahasanya mudah dipahami dan kontennya sangat relevan dengan kehidupan sehari-hari. Highly recommended!',
                    'rating' => 5,
                    'type' => 'book',
                    'is_approved' => true,
                    'is_featured' => false,
                ],
                [
                    'book_id' => $books[1]->id ?? null,
                    'reviewer_name' => 'Maya Sari',
                    'reviewer_email' => 'maya.sari@yahoo.com',
                    'review_text' => 'Ceritanya menarik dan penuh makna. Setiap bab memberikan pelajaran hidup yang berharga. Tidak sabar menunggu karya selanjutnya dari penulis ini.',
                    'rating' => 5,
                    'type' => 'book',
                    'is_approved' => true,
                    'is_featured' => false,
                ],
                [
                    'book_id' => $books[2]->id ?? null,
                    'reviewer_name' => 'Fajar Ramadhan',
                    'reviewer_email' => 'fajar.r@email.com',
                    'review_text' => 'Buku yang bagus untuk dibaca di waktu senggang. Plot cerita yang tidak terduga dan karakter yang well-developed. Worth the price!',
                    'rating' => 4,
                    'type' => 'book',
                    'is_approved' => true,
                    'is_featured' => false,
                ],
            ];

            foreach ($bookReviews as $review) {
                if ($review['book_id']) {
                    Review::create($review);
                }
            }
        }
    }
}
