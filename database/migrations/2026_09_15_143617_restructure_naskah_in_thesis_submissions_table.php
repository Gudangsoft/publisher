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
        Schema::table('thesis_submissions', function (Blueprint $table) {
            $table->string('title')->nullable()->after('repository_taruna_id');
            $table->boolean('is_published')->default(false)->after('submission_code');
            $table->timestamp('published_at')->nullable()->after('is_published');

            foreach (['bab1', 'bab2', 'bab3', 'bab4', 'bab5'] as $field) {
                $table->string("{$field}_path")->nullable();
                $table->string("{$field}_original_name")->nullable();
                $table->string("{$field}_url")->nullable();
            }

            $table->dropColumn(['naskah_path', 'naskah_original_name', 'naskah_url']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('thesis_submissions', function (Blueprint $table) {
            $table->string('naskah_path')->nullable();
            $table->string('naskah_original_name')->nullable();
            $table->string('naskah_url')->nullable();

            foreach (['bab1', 'bab2', 'bab3', 'bab4', 'bab5'] as $field) {
                $table->dropColumn(["{$field}_path", "{$field}_original_name", "{$field}_url"]);
            }

            $table->dropColumn(['title', 'is_published', 'published_at']);
        });
    }
};
