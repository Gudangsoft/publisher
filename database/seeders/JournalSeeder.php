<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Journal;
use App\Models\Category;

class JournalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $journalCategories = Category::where('type', 'journal')->get();

        if ($journalCategories->isEmpty()) {
            $this->command->warn('Tidak ada kategori jurnal. Silakan buat kategori dengan type "journal" terlebih dahulu.');
            return;
        }

        $journals = [
            [
                'category_id' => $journalCategories->first()->id,
                'title' => 'Pengaruh Teknologi Digital terhadap Pendidikan Islam',
                'abstract' => 'Penelitian ini mengkaji dampak teknologi digital terhadap metode pembelajaran pendidikan Islam di era modern. Studi menunjukkan bahwa integrasi teknologi dapat meningkatkan efektivitas pembelajaran.',
                'keywords' => 'teknologi digital, pendidikan Islam, pembelajaran, era digital',
                'authors' => 'Dr. Ahmad Dahlan, M.Pd., Prof. Dr. Siti Nurjannah',
                'affiliation' => 'Universitas Islam Negeri Jakarta',
                'doi' => '10.1234/jurnal.2024.001',
                'volume' => '15',
                'issue' => '2',
                'pages' => '125-145',
                'publication_date' => '2024-06-15',
                'year' => 2024,
                'issn' => '2089-1234',
                'language' => 'id',
                'citation_format' => 'Dahlan, A., & Nurjannah, S. (2024). Pengaruh Teknologi Digital terhadap Pendidikan Islam. Jurnal Pendidikan Islam, 15(2), 125-145. doi:10.1234/jurnal.2024.001',
                'is_published' => true,
            ],
            [
                'category_id' => $journalCategories->first()->id,
                'title' => 'Islamic Finance and Sustainable Development Goals',
                'abstract' => 'This study explores the relationship between Islamic finance principles and the United Nations Sustainable Development Goals (SDGs). The research demonstrates how Islamic financial instruments can contribute to achieving sustainable development.',
                'keywords' => 'Islamic finance, SDGs, sustainable development, ethical finance',
                'authors' => 'Dr. Muhammad Hassan, Prof. Fatimah Al-Zahra',
                'affiliation' => 'International Islamic University Malaysia',
                'doi' => '10.5678/finance.2024.042',
                'volume' => '8',
                'issue' => '1',
                'pages' => '1-20',
                'publication_date' => '2024-03-20',
                'year' => 2024,
                'issn' => '2345-6789',
                'language' => 'en',
                'citation_format' => 'Hassan, M., & Al-Zahra, F. (2024). Islamic Finance and Sustainable Development Goals. Journal of Islamic Economics, 8(1), 1-20. doi:10.5678/finance.2024.042',
                'is_published' => true,
            ],
            [
                'category_id' => $journalCategories->first()->id,
                'title' => 'Metodologi Tafsir Kontemporer: Pendekatan Hermeneutika',
                'abstract' => 'Artikel ini membahas penggunaan pendekatan hermeneutika dalam tafsir Al-Quran kontemporer. Penelitian menunjukkan bahwa pendekatan ini dapat memperkaya pemahaman teks suci dengan tetap mempertahankan prinsip-prinsip dasar tafsir klasik.',
                'keywords' => 'tafsir, hermeneutika, metodologi, Al-Quran kontemporer',
                'authors' => 'Dr. Abdul Malik, M.A., Dr. Khadijah Rahman',
                'affiliation' => 'UIN Sunan Kalijaga Yogyakarta',
                'doi' => '10.9012/tafsir.2024.015',
                'volume' => '12',
                'issue' => '3',
                'pages' => '200-225',
                'publication_date' => '2024-09-10',
                'year' => 2024,
                'issn' => '1234-5678',
                'language' => 'id',
                'citation_format' => 'Malik, A., & Rahman, K. (2024). Metodologi Tafsir Kontemporer: Pendekatan Hermeneutika. Jurnal Studi Al-Quran, 12(3), 200-225. doi:10.9012/tafsir.2024.015',
                'is_published' => true,
            ],
            [
                'category_id' => $journalCategories->first()->id,
                'title' => 'Women\'s Role in Islamic Leadership: A Contemporary Perspective',
                'abstract' => 'This research examines the role of women in Islamic leadership positions from a contemporary perspective, analyzing historical precedents and modern applications in various Muslim-majority countries.',
                'keywords' => 'women leadership, Islam, gender studies, contemporary issues',
                'authors' => 'Prof. Aisha Mahmoud, Dr. Sarah Ibrahim',
                'affiliation' => 'Al-Azhar University, Cairo',
                'doi' => '10.3456/gender.2024.088',
                'volume' => '6',
                'issue' => '4',
                'pages' => '310-335',
                'publication_date' => '2024-12-01',
                'year' => 2024,
                'issn' => '3456-7890',
                'language' => 'en',
                'citation_format' => 'Mahmoud, A., & Ibrahim, S. (2024). Women\'s Role in Islamic Leadership: A Contemporary Perspective. Journal of Islamic Studies, 6(4), 310-335. doi:10.3456/gender.2024.088',
                'is_published' => false,
            ],
        ];

        foreach ($journals as $journalData) {
            Journal::create($journalData);
        }

        $this->command->info('Sample journals have been seeded successfully!');
    }
}
