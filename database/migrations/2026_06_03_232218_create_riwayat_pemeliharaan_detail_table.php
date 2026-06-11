<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_pemeliharaan_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('riwayat_pemeliharaan_id')->constrained('riwayat_pemeliharaan')->cascadeOnDelete();
            $table->foreignId('jenis_pemeliharaan_id')->constrained('master_jenis_pemeliharaan')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_pemeliharaan_detail');
    }
};
