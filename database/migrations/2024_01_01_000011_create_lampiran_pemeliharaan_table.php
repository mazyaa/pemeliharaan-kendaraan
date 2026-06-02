<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lampiran_pemeliharaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('riwayat_pemeliharaan_id')->constrained('riwayat_pemeliharaan')->cascadeOnDelete();
            $table->string('file_name');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lampiran_pemeliharaan');
    }
};
