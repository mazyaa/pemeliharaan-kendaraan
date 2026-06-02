<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', RoleEnum::ADMIN->value)->first();
        $pengelolaRole = Role::where('name', RoleEnum::PENGELOLA_KENDARAAN->value)->first();
        $kabagRole = Role::where('name', RoleEnum::KEPALA_BAGIAN->value)->first();
        $kabiroRole = Role::where('name', RoleEnum::KEPALA_BIRO->value)->first();
        $pptkRole = Role::where('name', RoleEnum::PPTK->value)->first();

        $users = [
            [
                'role_id' => $adminRole?->id,
                'nip' => '198501012010011001',
                'name' => 'Administrator',
                'email' => 'admin@banten.go.id',
                'password' => Hash::make('password'),
                'position' => 'Admin Sistem',
                'phone' => '081234567890',
                'is_active' => true,
            ],
            [
                'role_id' => $pengelolaRole?->id,
                'nip' => '199001012015011001',
                'name' => 'Budi Santoso',
                'email' => 'pengelola@banten.go.id',
                'password' => Hash::make('password'),
                'position' => 'Pengelola Kendaraan',
                'phone' => '081234567891',
                'is_active' => true,
            ],
            [
                'role_id' => $kabagRole?->id,
                'nip' => '198001012005011001',
                'name' => 'Siti Rahayu',
                'email' => 'kabag@banten.go.id',
                'password' => Hash::make('password'),
                'position' => 'Kepala Bagian Umum',
                'phone' => '081234567892',
                'is_active' => true,
            ],
            [
                'role_id' => $kabiroRole?->id,
                'nip' => '197501012000011001',
                'name' => 'Hendra Wijaya',
                'email' => 'kabiro@banten.go.id',
                'password' => Hash::make('password'),
                'position' => 'Kepala Biro Umum',
                'phone' => '081234567893',
                'is_active' => true,
            ],
            [
                'role_id' => $pptkRole?->id,
                'nip' => '199201012018011001',
                'name' => 'Dewi Lestari',
                'email' => 'pptk@banten.go.id',
                'password' => Hash::make('password'),
                'position' => 'PPTK',
                'phone' => '081234567894',
                'is_active' => true,
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
