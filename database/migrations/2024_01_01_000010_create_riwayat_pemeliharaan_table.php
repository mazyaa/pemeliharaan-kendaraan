<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_pemeliharaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spk_id')->constrained('spk')->cascadeOnDelete();
            $table->date('tanggal_masuk');
            $table->date('tanggal_selesai')->nullable();
            $table->string('nama_bengkel');
            $table->text('hasil_pemeliharaan')->nullable();
            $table->decimal('biaya', 15, 2)->default(0);
            $table->string('status')->default('diproses');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_pemeliharaan');
    }
};
