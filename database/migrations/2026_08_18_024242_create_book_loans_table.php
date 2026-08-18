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
        Schema::create('book_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->nullable()->constrained('books')->nullOnDelete();
            $table->string('book_title_snapshot')->nullable();
            $table->string('borrower_name');
            $table->string('borrower_identity_number')->nullable();
            $table->enum('borrower_type', ['mahasiswa', 'dosen', 'staf', 'tamu'])->default('mahasiswa');
            $table->dateTime('loaned_at');
            $table->date('due_at');
            $table->dateTime('returned_at')->nullable();
            $table->enum('status', ['dipinjam', 'dikembalikan', 'terlambat'])->default('dipinjam');
            $table->timestamps();

            $table->index('loaned_at');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_loans');
    }
};
