<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activity_log', function (Blueprint $table) {
            $table->unsignedBigInteger('admin_id')->nullable()->after('user_id');

            // kalau ada tabel admin dan mau FK (opsional):
            // $table->foreign('admin_id')->references('admin_id')->on('admin')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('activity_log', function (Blueprint $table) {
            // kalau pakai foreign key, drop FK dulu (opsional)
            // $table->dropForeign(['admin_id']);
            $table->dropColumn('admin_id');
        });
    }
};
