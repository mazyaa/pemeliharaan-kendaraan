<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_servis_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_servis_id')->constrained()->cascadeOnDelete();
            $table->foreignId('jenis_pemeliharaan_id')->constrained('master_jenis_pemeliharaan')->cascadeOnDelete();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_servis_detail');
    }
};
