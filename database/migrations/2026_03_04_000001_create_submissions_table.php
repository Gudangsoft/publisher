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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->string('submission_number')->unique(); // Nomor pengajuan unik
            $table->string('title'); // Judul naskah
            $table->enum('type', ['book', 'journal'])->default('book'); // Jenis: buku atau jurnal
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            
            // Informasi Pengaju
            $table->string('submitter_name'); // Nama pengaju
            $table->string('submitter_email'); // Email pengaju
            $table->string('submitter_phone'); // Telepon pengaju
            $table->string('submitter_institution')->nullable(); // Institusi pengaju
            $table->text('submitter_address')->nullable(); // Alamat pengaju
            
            // Detail Naskah
            $table->text('description'); // Deskripsi singkat naskah
            $table->text('synopsis')->nullable(); // Sinopsis
            $table->integer('estimated_pages')->nullable(); // Estimasi halaman
            $table->string('target_audience')->nullable(); // Target pembaca
            $table->string('language')->default('Indonesia');
            
            // File Upload
            $table->string('manuscript_file'); // File naskah (PDF/DOC)
            $table->string('cover_proposal')->nullable(); // Proposal cover (jika ada)
            $table->json('additional_files')->nullable(); // File tambahan
            
            // Status & Review
            $table->enum('status', [
                'pending',      // Menunggu review
                'reviewing',    // Sedang direview
                'revision',     // Perlu revisi
                'approved',     // Disetujui
                'rejected',     // Ditolak
                'in_progress',  // Dalam proses cetak
                'completed'     // Selesai/Terbit
            ])->default('pending');
            
            $table->text('admin_notes')->nullable(); // Catatan dari admin
            $table->text('revision_notes')->nullable(); // Catatan revisi
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            
            // Pricing (jika disetujui)
            $table->decimal('estimated_cost', 12, 2)->nullable();
            $table->integer('print_quantity')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
