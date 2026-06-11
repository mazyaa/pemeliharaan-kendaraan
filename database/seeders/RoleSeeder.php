<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            RoleEnum::ADMIN->value => 'Administrator Sistem',
            RoleEnum::PENGAJU_KENDARAAN->value => 'Pengaju Kendaraan Dinas',
            RoleEnum::KEPALA_BAGIAN->value => 'Kepala Bagian Umum',
            RoleEnum::KEPALA_BIRO->value => 'Kepala Biro Umum',
            RoleEnum::PPTK->value => 'Penyusun Pengguna Teknis Kegiatan',
        ];

        foreach ($roles as $name => $description) {
            Role::updateOrCreate(
                ['name' => $name],
                ['description' => $description]
            );
        }
    }
}
