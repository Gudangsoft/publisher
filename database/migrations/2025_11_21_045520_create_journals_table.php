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
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('abstract')->nullable();
            $table->text('keywords')->nullable();
            $table->string('authors');
            $table->string('affiliation')->nullable();
            $table->string('doi')->nullable();
            $table->string('volume')->nullable();
            $table->string('issue')->nullable();
            $table->string('pages')->nullable();
            $table->date('publication_date')->nullable();
            $table->integer('year')->nullable();
            $table->string('issn')->nullable();
            $table->string('language')->default('id');
            $table->string('file_pdf')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('citation_format')->nullable();
            $table->integer('views')->default(0);
            $table->integer('downloads')->default(0);
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
