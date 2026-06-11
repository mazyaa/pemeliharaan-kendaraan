<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('riwayat_pemeliharaan', function (Blueprint $table) {
            $table->dropColumn('biaya');
        });
    }

    public function down(): void
    {
        Schema::table('riwayat_pemeliharaan', function (Blueprint $table) {
            $table->decimal('biaya', 15, 2)->default(0)->after('hasil_pemeliharaan');
        });
    }
};
