<?php
// Temporary fix file - DELETE after use
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$messages = [];
$errors = [];

// 1. Fix: Add 'model' column if missing
try {
    $hasModel = \Illuminate\Support\Facades\Schema::hasColumn('hero_sliders', 'model');
    if (!$hasModel) {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `hero_sliders` ADD COLUMN `model` ENUM('full_image','text_overlay','compact') NOT NULL DEFAULT 'full_image' AFTER `button_link`");
        $messages[] = "✅ Kolom 'model' berhasil ditambahkan ke tabel hero_sliders.";
    } else {
        $messages[] = "✅ Kolom 'model' sudah ada.";
    }
} catch (\Exception $e) {
    $errors[] = "❌ Gagal tambah kolom 'model': " . $e->getMessage();
}

// 2. Fix: Create storage symlink if missing
$storagePath = __DIR__ . '/../storage/app/public';
$linkPath = __DIR__ . '/storage';
if (!file_exists($linkPath)) {
    try {
        symlink($storagePath, $linkPath);
        $messages[] = "✅ Storage symlink berhasil dibuat.";
    } catch (\Exception $e) {
        $errors[] = "❌ Gagal buat storage symlink: " . $e->getMessage();
    }
} elseif (!is_link($linkPath)) {
    $errors[] = "⚠️ /public/storage ada tapi bukan symlink — hapus dan buat ulang via cPanel atau SSH: php artisan storage:link";
} else {
    $messages[] = "✅ Storage symlink sudah ada.";
}

// 3. Show all sliders
$sliders = \Illuminate\Support\Facades\DB::table('hero_sliders')->get();

// 4. Activate all sliders that have an image
$activated = 0;
foreach ($sliders as $s) {
    if (!empty($s->image) && !$s->is_active) {
        \Illuminate\Support\Facades\DB::table('hero_sliders')->where('id', $s->id)->update(['is_active' => 1]);
        $activated++;
    }
}
if ($activated > 0) {
    $messages[] = "✅ {$activated} slider diaktifkan.";
}

// Re-fetch after fixes
$sliders = \Illuminate\Support\Facades\DB::table('hero_sliders')->get();

?><!DOCTYPE html>
<html>
<head><title>Hero Slider Fix</title><style>
body { font-family: sans-serif; padding: 20px; max-width: 800px; }
.ok { color: green; } .err { color: red; } .warn { color: orange; }
table { border-collapse: collapse; width: 100%; margin-top: 10px; }
td, th { border: 1px solid #ccc; padding: 8px; text-align: left; font-size: 13px; }
th { background: #f0f0f0; }
</style></head>
<body>
<h2>Hero Slider - Auto Fix Tool</h2>

<h3>Hasil Fix:</h3>
<?php foreach ($messages as $m): ?>
<p class="ok"><?= $m ?></p>
<?php endforeach; ?>
<?php foreach ($errors as $e): ?>
<p class="err"><?= $e ?></p>
<?php endforeach; ?>

<h3>Semua Slider di DB (<?= count($sliders) ?> total):</h3>
<table>
<tr><th>ID</th><th>Title</th><th>is_active</th><th>Image Path</th><th>File Ada?</th><th>URL Preview</th></tr>
<?php foreach ($sliders as $s):
    $imgPath = $storagePath . '/' . $s->image;
    $fileExists = !empty($s->image) && file_exists($imgPath);
?>
<tr>
    <td><?= $s->id ?></td>
    <td><?= htmlspecialchars($s->title) ?></td>
    <td><?= $s->is_active ? '<span class="ok">AKTIF</span>' : '<span class="err">TIDAK AKTIF</span>' ?></td>
    <td style="word-break:break-all;font-size:11px"><?= htmlspecialchars($s->image ?? '-') ?></td>
    <td><?= $fileExists ? '<span class="ok">YA</span>' : '<span class="err">TIDAK</span>' ?></td>
    <td><?php if (!empty($s->image)): ?><a href="/storage/<?= $s->image ?>" target="_blank">Cek Gambar</a><?php endif; ?></td>
</tr>
<?php endforeach; ?>
</table>

<br><p style="color:red;font-weight:bold">⚠️ HAPUS file ini setelah selesai: public/check_storage.php</p>
</body></html>
