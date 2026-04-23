<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->foreignId('gallery_album_id')->nullable()->after('category')->constrained('gallery_albums')->nullOnDelete();
        });

        // Migrate existing category data to gallery_albums
        $categories = \DB::table('galleries')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category');

        foreach ($categories as $category) {
            $albumId = \DB::table('gallery_albums')->insertGetId([
                'name' => $category,
                'slug' => \Illuminate\Support\Str::slug($category),
                'is_active' => true,
                'display_order' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            \DB::table('galleries')
                ->where('category', $category)
                ->update(['gallery_album_id' => $albumId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropForeign(['gallery_album_id']);
            $table->dropColumn('gallery_album_id');
        });
    }
};
