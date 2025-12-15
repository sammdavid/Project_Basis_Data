<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bukti_pengaduan', function (Blueprint $table) {
            $table->string('nama_file')->nullable()->after('pengaduan_id');
            $table->unsignedBigInteger('ukuran_file')->nullable()->after('file_path');
        });
    }

    public function down(): void
    {
        Schema::table('bukti_pengaduan', function (Blueprint $table) {
            $table->dropColumn(['nama_file', 'ukuran_file']);
        });
    }
};

