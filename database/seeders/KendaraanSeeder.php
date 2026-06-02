<?php

namespace Database\Seeders;

use App\Models\Kendaraan;
use Illuminate\Database\Seeder;

class KendaraanSeeder extends Seeder
{
    public function run(): void
    {
        $kendaraan = [
            [
                'kode_kendaraan' => 'KR-001',
                'plat_nomor' => 'A 1234 B',
                'nomor_rangka' => 'MHFJA123456789',
                'nomor_mesin' => 'JA12345678',
                'merk' => 'Toyota',
                'tipe' => 'Avanza',
                'tahun' => 2022,
                'warna' => 'Putih',
                'tanggal_perolehan' => '2022-01-15',
                'status' => 'aktif',
                'keterangan' => 'Kendaraan dinas operasional',
            ],
            [
                'kode_kendaraan' => 'KR-002',
                'plat_nomor' => 'A 5678 B',
                'nomor_rangka' => 'MHFJA987654321',
                'nomor_mesin' => 'JA98765432',
                'merk' => 'Honda',
                'tipe' => 'HR-V',
                'tahun' => 2023,
                'warna' => 'Hitam',
                'tanggal_perolehan' => '2023-03-20',
                'status' => 'aktif',
                'keterangan' => 'Kendaraan dinas pimpinan',
            ],
            [
                'kode_kendaraan' => 'KR-003',
                'plat_nomor' => 'A 9012 B',
                'nomor_rangka' => 'MHFJA112233445',
                'nomor_mesin' => 'JA11223344',
                'merk' => 'Daihatsu',
                'tipe' => 'Xenia',
                'tahun' => 2021,
                'warna' => 'Silver',
                'tanggal_perolehan' => '2021-06-10',
                'status' => 'servis',
                'keterangan' => 'Sedang dalam perbaikan',
            ],
            [
                'kode_kendaraan' => 'KR-004',
                'plat_nomor' => 'A 3456 B',
                'nomor_rangka' => 'MHFJA556677889',
                'nomor_mesin' => 'JA55667788',
                'merk' => 'Suzuki',
                'tipe' => 'Ertiga',
                'tahun' => 2020,
                'warna' => 'Abu-abu',
                'tanggal_perolehan' => '2020-09-05',
                'status' => 'rusak',
                'keterangan' => 'Mesin perlu perbaikan',
            ],
            [
                'kode_kendaraan' => 'KR-005',
                'plat_nomor' => 'A 7890 B',
                'nomor_rangka' => 'MHFJA998877665',
                'nomor_mesin' => 'JA99887766',
                'merk' => 'Toyota',
                'tipe' => 'Innova Reborn',
                'tahun' => 2023,
                'warna' => 'Putih',
                'tanggal_perolehan' => '2023-07-01',
                'status' => 'aktif',
                'keterangan' => 'Kendaraan dinas operasional',
            ],
            [
                'kode_kendaraan' => 'KR-006',
                'plat_nomor' => 'A 2345 B',
                'nomor_rangka' => 'MHFJA443322110',
                'nomor_mesin' => 'JA44332211',
                'merk' => 'Mitsubishi',
                'tipe' => 'Xpander',
                'tahun' => 2022,
                'warna' => 'Merah',
                'tanggal_perolehan' => '2022-11-15',
                'status' => 'aktif',
                'keterangan' => 'Kendaraan dinas bagian',
            ],
            [
                'kode_kendaraan' => 'KR-007',
                'plat_nomor' => 'A 6789 B',
                'nomor_rangka' => 'MHFJA776655443',
                'nomor_mesin' => 'JA77665544',
                'merk' => 'Hyundai',
                'tipe' => 'Creta',
                'tahun' => 2024,
                'warna' => 'Biru',
                'tanggal_perolehan' => '2024-01-10',
                'status' => 'aktif',
                'keterangan' => 'Kendaraan dinas terbaru',
            ],
            [
                'kode_kendaraan' => 'KR-008',
                'plat_nomor' => 'A 0123 B',
                'nomor_rangka' => 'MHFJA112233000',
                'nomor_mesin' => 'JA11223300',
                'merk' => 'Nissan',
                'tipe' => 'Livina',
                'tahun' => 2019,
                'warna' => 'Putih',
                'tanggal_perolehan' => '2019-12-20',
                'status' => 'nonaktif',
                'keterangan' => 'Sudah tidak layak pakai',
            ],
        ];

        foreach ($kendaraan as $data) {
            Kendaraan::updateOrCreate(
                ['kode_kendaraan' => $data['kode_kendaraan']],
                $data
            );
        }
    }
}
