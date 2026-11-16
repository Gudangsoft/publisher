<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Profesi / kategori responden (Mahasiswa, Dosen, Umum, dst.)
            $table->string('reviewer_role', 50)->nullable()->after('reviewer_photo');
            // Asal ulasan: diinput admin atau dikirim publik lewat formulir
            $table->string('source', 20)->default('admin')->after('type');
            // Hasil pemeriksaan anti-spam (untuk bahan moderasi admin)
            $table->boolean('is_spam')->default(false)->after('is_featured');
            $table->unsignedSmallInteger('spam_score')->default(0)->after('is_spam');
            $table->json('spam_reasons')->nullable()->after('spam_score');
            // Jejak pengirim (IP disimpan dalam bentuk hash, bukan IP mentah)
            $table->string('ip_hash', 64)->nullable()->after('spam_reasons');
            $table->string('user_agent', 255)->nullable()->after('ip_hash');
            $table->string('content_hash', 64)->nullable()->after('user_agent');
            $table->timestamp('moderated_at')->nullable()->after('content_hash');
            $table->foreignId('moderated_by')->nullable()->after('moderated_at')->constrained('users')->nullOnDelete();

            $table->index(['ip_hash', 'created_at']);
            $table->index('content_hash');
            $table->index(['is_approved', 'is_spam']);
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropConstrainedForeignId('moderated_by');
            $table->dropIndex(['ip_hash', 'created_at']);
            $table->dropIndex(['content_hash']);
            $table->dropIndex(['is_approved', 'is_spam']);
            $table->dropColumn([
                'reviewer_role', 'source', 'is_spam', 'spam_score', 'spam_reasons',
                'ip_hash', 'user_agent', 'content_hash', 'moderated_at',
            ]);
        });
    }
};
