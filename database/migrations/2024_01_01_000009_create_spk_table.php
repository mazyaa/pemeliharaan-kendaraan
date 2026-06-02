<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_servis_id')->constrained('pengajuan_servis')->cascadeOnDelete();
            $table->string('nomor_spk')->unique();
            $table->date('tanggal_spk');
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spk');
    }
};
