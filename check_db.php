<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

// In Laravel 11, bootstrap is slightly different if using the new structure
// but this should work for most cases to just get the container
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Setting;

echo "Site Name: " . Setting::get('site_name') . "\n";
echo "Site Tagline: " . Setting::get('site_tagline') . "\n";
echo "Meta Description: " . Setting::get('meta_description') . "\n";
echo "Meta Keywords: " . Setting::get('meta_keywords') . "\n";
