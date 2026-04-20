<?php
/**
 * RECOVERY SCRIPT FOR JUDOL INFECTION
 * This script will reset critical site settings to their intended values.
 */

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\DB;

echo "--- STARTING RECOVERY ---\n";

// 1. Reset Metadata & Site Identity
echo "1. Resetting site identity...\n";
Setting::set('site_name', 'Naval Academy Publishing', 'text');
Setting::set('site_tagline', 'Excellence in Naval Literature', 'text');
Setting::set('meta_description', 'Official publishing platform for the Naval Academy.', 'textarea');
Setting::set('meta_keywords', 'naval academy, publishing, literature, maritime books', 'textarea');
echo "   ✅ Site name and metadata reset.\n";

// 2. Scan for unknown Admin Users
echo "\n2. Auditing admin users...\n";
$admins = User::where('is_admin', true)->get();
echo "   Found " . $admins->count() . " administrators:\n";
foreach ($admins as $admin) {
    echo "   - ID: {$admin->id} | Name: {$admin->name} | Email: {$admin->email} (" . $admin->created_at . ")\n";
}
echo "   ⚠️ ACTION REQUIRED: If you see any unknown emails above, delete them immediately via DB or Admin Panel.\n";

// 3. Clear any suspicious content in News or Pages
echo "\n3. Checking for suspicious links in content...\n";
$suspiciousKeywords = ['slot', 'gacor', 'judi', 'togel', 'domino', 'casino', 'poker', 'bola88', 'mpo'];
$tables = ['news', 'pages', 'settings', 'books'];

foreach ($tables as $table) {
    echo "   Scanning table: {$table}...\n";
    foreach ($suspiciousKeywords as $keyword) {
        $count = DB::table($table)->where(function($query) use ($keyword) {
            $query->where('content', 'like', "%{$keyword}%")
                  ->orWhere('title', 'like', "%{$keyword}%")
                  ->orWhere('summary', 'like', "%{$keyword}%")
                  ->orWhere('value', 'like', "%{$keyword}%");
        })->count();
        
        if ($count > 0) {
            echo "   ❌ Found {$count} entries with '{$keyword}' in {$table}!\n";
            // Optional: Auto-delete or flag
            // DB::table($table)->where(...) ->update(['is_active' => false]);
        }
    }
}

// 4. Checking for suspicious files in public/
echo "\n4. Auditing public files...\n";
$publicFiles = scandir(__DIR__ . '/public');
$allowedFiles = ['.', '..', '.htaccess', 'index.php', 'robots.txt', 'favicon.ico', 'storage', 'css', 'js', 'images'];

foreach ($publicFiles as $file) {
    if (!in_array($file, $allowedFiles)) {
        echo "   ⚠️ UNRECOGNIZED FILE: public/{$file}\n";
    }
}

echo "\n--- RECOVERY COMPLETE ---\n";
echo "Please delete this script after use: rescue_site.php\n";
