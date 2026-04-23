<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Setting;

echo "--- USERS ---\n";
try {
    $users = User::all();
    foreach ($users as $user) {
        echo "ID: {$user->id} | Name: {$user->name} | Email: {$user->email} | Admin: " . ($user->is_admin ? 'YES' : 'NO') . "\n";
    }
} catch (\Exception $e) {
    echo "Error listing users: " . $e->getMessage() . "\n";
}

echo "\n--- SETTINGS ---\n";
try {
    $keys = ['site_name', 'site_tagline', 'meta_description', 'meta_keywords'];
    foreach ($keys as $key) {
        echo "{$key}: " . Setting::get($key) . "\n";
    }
} catch (\Exception $e) {
    echo "Error listing settings: " . $e->getMessage() . "\n";
}
