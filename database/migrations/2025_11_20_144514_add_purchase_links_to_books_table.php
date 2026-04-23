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
        Schema::table('books', function (Blueprint $table) {
            $table->boolean('has_print_version')->default(false)->after('edition');
            $table->string('print_version_link')->nullable()->after('has_print_version');
            $table->boolean('has_digital_version')->default(false)->after('print_version_link');
            $table->string('digital_version_link')->nullable()->after('has_digital_version');
            $table->string('whatsapp_link')->nullable()->after('digital_version_link');
            $table->string('shopee_link')->nullable()->after('whatsapp_link');
            $table->string('tokopedia_link')->nullable()->after('shopee_link');
            $table->string('lazada_link')->nullable()->after('tokopedia_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn([
                'has_print_version',
                'print_version_link',
                'has_digital_version',
                'digital_version_link',
                'whatsapp_link',
                'shopee_link',
                'tokopedia_link',
                'lazada_link'
            ]);
        });
    }
};
