<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->nullable()->after('id')->constrained('roles')->nullOnDelete();
            $table->string('nip')->nullable()->after('role_id');
            $table->string('position')->nullable()->after('nip');
            $table->string('phone')->nullable()->after('position');
            $table->boolean('is_active')->default(true)->after('phone');
            $table->softDeletes();
            $table->dropColumn('email_verified_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn(['role_id', 'nip', 'position', 'phone', 'is_active', 'deleted_at']);
            $table->timestamp('email_verified_at')->nullable();
        });
    }
};
