<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'Publisher Bookstore', 'type' => 'text'],
            ['key' => 'site_tagline', 'value' => 'Your Ultimate Book Destination', 'type' => 'text'],
            ['key' => 'site_description', 'value' => 'Toko buku online terlengkap dengan koleksi buku dari berbagai genre.', 'type' => 'textarea'],
            ['key' => 'site_logo', 'value' => '', 'type' => 'image'],
            ['key' => 'site_favicon', 'value' => '', 'type' => 'image'],
            ['key' => 'contact_email', 'value' => 'info@publisher.com', 'type' => 'text'],
            ['key' => 'contact_phone', 'value' => '+62 21 1234 5678', 'type' => 'text'],
            ['key' => 'contact_address', 'value' => 'Jl. Sudirman No. 123, Jakarta Pusat, DKI Jakarta 10110', 'type' => 'textarea'],
            ['key' => 'whatsapp_number', 'value' => '628123456789', 'type' => 'text'],
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/publisherkami', 'type' => 'text'],
            ['key' => 'twitter_url', 'value' => 'https://twitter.com/publisherkami', 'type' => 'text'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/publisherkami', 'type' => 'text'],
            ['key' => 'youtube_url', 'value' => 'https://youtube.com/@publisherkami', 'type' => 'text'],
            ['key' => 'linkedin_url', 'value' => 'https://linkedin.com/company/publisherkami', 'type' => 'text'],
            ['key' => 'meta_keywords', 'value' => 'toko buku, beli buku online, buku murah, buku bestseller', 'type' => 'textarea'],
            ['key' => 'meta_description', 'value' => 'Belanja buku online terlengkap dengan harga terbaik. Dapatkan berbagai pilihan buku dari genre fiksi, non-fiksi, pendidikan, dan lainnya.', 'type' => 'textarea'],
            ['key' => 'google_analytics', 'value' => '', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type' => $setting['type']
                ]
            );
        }
    }
}
