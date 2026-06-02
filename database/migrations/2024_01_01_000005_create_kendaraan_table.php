<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kendaraan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kendaraan')->unique();
            $table->string('plat_nomor');
            $table->string('nomor_rangka')->nullable();
            $table->string('nomor_mesin')->nullable();
            $table->string('merk');
            $table->string('tipe')->nullable();
            $table->year('tahun')->nullable();
            $table->string('warna')->nullable();
            $table->date('tanggal_perolehan')->nullable();
            $table->enum('status', ['aktif', 'servis', 'rusak', 'nonaktif'])->default('aktif');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kendaraan');
    }
};
