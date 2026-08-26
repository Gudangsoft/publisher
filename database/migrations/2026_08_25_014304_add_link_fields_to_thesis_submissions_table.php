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
            $table->string('cover_url')->nullable()->after('cover_original_name');
            $table->string('pengesahan_url')->nullable()->after('pengesahan_original_name');
            $table->string('abstrak_url')->nullable()->after('abstrak_original_name');
            $table->string('naskah_url')->nullable()->after('naskah_original_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('thesis_submissions', function (Blueprint $table) {
            $table->dropColumn(['cover_url', 'pengesahan_url', 'abstrak_url', 'naskah_url']);
        });
    }
};
