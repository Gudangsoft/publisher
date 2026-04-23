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
        Schema::create('book_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama template
            $table->string('book_type'); // Jenis buku: novel, textbook, journal, thesis, etc
            $table->string('page_size'); // A4, A5, B5, etc
            $table->string('orientation')->default('portrait'); // portrait, landscape
            $table->json('margins')->nullable(); // top, bottom, left, right margins
            $table->string('font_family')->nullable(); // Times New Roman, Arial, etc
            $table->integer('font_size')->nullable(); // 11, 12, etc
            $table->decimal('line_spacing', 3, 2)->nullable(); // 1.5, 2, etc
            $table->text('description')->nullable();
            $table->string('preview_image')->nullable(); // Preview gambar template
            $table->string('template_file')->nullable(); // File template (docx/pdf)
            $table->json('specifications')->nullable(); // Spesifikasi tambahan dalam JSON
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });

        // Add template_id to submissions table
        Schema::table('submissions', function (Blueprint $table) {
            $table->foreignId('book_template_id')->nullable()->after('category_id')->constrained('book_templates')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropForeign(['book_template_id']);
            $table->dropColumn('book_template_id');
        });
        
        Schema::dropIfExists('book_templates');
    }
};
