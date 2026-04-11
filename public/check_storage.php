<?php
// Temporary diagnostic file - DELETE after use
$storagePath = __DIR__ . '/../storage/app/public';
$linkPath = __DIR__ . '/storage';

echo "<h3>Storage Diagnostic</h3>";
echo "Storage path exists: " . (is_dir($storagePath) ? 'YES' : 'NO') . "<br>";
echo "Public storage link exists: " . (file_exists($linkPath) ? 'YES' : 'NO') . "<br>";
echo "Public storage is symlink: " . (is_link($linkPath) ? 'YES' : 'NO') . "<br>";

// List hero-slider images
$heroDir = $storagePath . '/hero-sliders';
echo "<br><h3>Hero Slider Images:</h3>";
if (is_dir($heroDir)) {
    $files = scandir($heroDir);
    foreach ($files as $f) {
        if ($f !== '.' && $f !== '..') {
            echo "- " . $f . "<br>";
        }
    }
} else {
    echo "hero-sliders directory NOT FOUND in storage<br>";
}

// Check DB
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$sliders = DB::table('hero_sliders')->where('is_active', 1)->get(['id', 'title', 'image']);
echo "<br><h3>Active Sliders in DB:</h3>";
foreach ($sliders as $s) {
    $imgPath = $storagePath . '/' . $s->image;
    echo "ID {$s->id}: {$s->title}<br>";
    echo "&nbsp;&nbsp;image: {$s->image}<br>";
    echo "&nbsp;&nbsp;file exists: " . (file_exists($imgPath) ? '<span style=\"color:green\">YES</span>' : '<span style=\"color:red\">NO</span>') . "<br>";
    echo "&nbsp;&nbsp;URL: <a href='/storage/{$s->image}'>/storage/{$s->image}</a><br><br>";
}
