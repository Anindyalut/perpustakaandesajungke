<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('ukuran')->nullable()->after('isbn');
            $table->integer('jumlah_halaman')->nullable()->after('ukuran');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['ukuran', 'jumlah_halaman']);
        });
    }
};
