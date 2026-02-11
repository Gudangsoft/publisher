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
            $table->string('publisher')->nullable()->after('author');
            $table->integer('pages')->nullable()->after('description');
            $table->string('language')->default('Indonesia')->after('pages');
            $table->decimal('weight', 8, 2)->nullable()->after('language')->comment('in grams');
            $table->string('dimensions')->nullable()->after('weight')->comment('format: width x height x depth (cm)');
            $table->decimal('price', 10, 2)->nullable()->after('dimensions');
            $table->integer('stock')->default(0)->after('price');
            $table->enum('binding_type', ['Softcover', 'Hardcover'])->default('Softcover')->after('stock');
            $table->enum('paper_type', ['HVS', 'Bookpaper', 'Art Paper', 'Lainnya'])->default('HVS')->after('binding_type');
            $table->string('edition')->nullable()->after('paper_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn([
                'publisher',
                'pages',
                'language',
                'weight',
                'dimensions',
                'price',
                'stock',
                'binding_type',
                'paper_type',
                'edition'
            ]);
        });
    }
};
