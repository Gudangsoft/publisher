# Menu Pengaturan Admin

Menu pengaturan pada admin panel telah diaktifkan dan dapat diakses melalui:
- URL: `/admin/settings`
- Menu: Sidebar Admin > Pengaturan

## Fitur yang Tersedia

### 1. Pengaturan Umum
- Nama Website
- Tagline
- Deskripsi Website
- Logo Website (upload gambar)
- Email Kontak
- Nomor Telepon
- Nomor WhatsApp
- Alamat

### 2. Media Sosial
- Facebook URL
- Twitter/X URL
- Instagram URL
- YouTube URL
- LinkedIn URL

### 3. SEO
- Meta Keywords
- Meta Description
- Google Analytics ID

## Database

Tabel `settings` telah dibuat dengan struktur:
- `id` - Primary key
- `key` - Nama pengaturan (unique)
- `value` - Nilai pengaturan
- `type` - Tipe input (text, textarea, image, boolean)
- `timestamps` - Created at & Updated at

## Cara Menggunakan

1. Login ke admin panel
2. Klik menu "Pengaturan" di sidebar
3. Isi form dengan informasi website Anda
4. Klik "Simpan Perubahan"

## Data Awal

Sistem telah diisi dengan data default:
- Nama Website: "Publisher Bookstore"
- Tagline: "Your Ultimate Book Destination"
- Email: info@publisher.com
- Telepon: +62 21 1234 5678
- Dan lainnya...

## Mengakses Pengaturan di View

Untuk menggunakan pengaturan di view publik, gunakan:

```php
use App\Models\Setting;

$siteName = Setting::get('site_name', 'Default Name');
$contactEmail = Setting::get('contact_email');
```

## Upload Logo

Logo website akan disimpan di folder:
- Storage: `storage/app/public/settings/`
- Public URL: `/storage/settings/logo.jpg`

Pastikan symbolic link storage sudah dibuat dengan:
```bash
php artisan storage:link
```
