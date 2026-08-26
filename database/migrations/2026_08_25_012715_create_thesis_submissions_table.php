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
        Schema::create('thesis_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repository_taruna_id')->unique()->constrained('repository_tarunas')->cascadeOnDelete();
            $table->string('submission_code')->unique();

            $table->string('cover_path')->nullable();
            $table->string('cover_original_name')->nullable();

            $table->string('pengesahan_path')->nullable();
            $table->string('pengesahan_original_name')->nullable();

            $table->string('abstrak_path')->nullable();
            $table->string('abstrak_original_name')->nullable();

            $table->string('naskah_path')->nullable();
            $table->string('naskah_original_name')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thesis_submissions');
    }
};
