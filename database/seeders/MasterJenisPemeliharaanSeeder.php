<?php

namespace Database\Seeders;

use App\Models\MasterJenisPemeliharaan;
use Illuminate\Database\Seeder;

class MasterJenisPemeliharaanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kategori' => 'Mesin', 'nama' => 'Ganti Oli Mesin', 'interval_hari' => 90, 'deskripsi' => 'Ganti oli mesin setiap 3 bulan'],
            ['kategori' => 'Mesin', 'nama' => 'Ganti Filter Oli', 'interval_hari' => 180, 'deskripsi' => 'Ganti filter oli setiap 6 bulan'],
            ['kategori' => 'Mesin', 'nama' => 'Tune Up Mesin', 'interval_hari' => 365, 'deskripsi' => 'Tune up mesin setiap 1 tahun'],
            ['kategori' => 'Mesin', 'nama' => 'Overhaul Mesin', 'interval_hari' => 1800, 'deskripsi' => 'Overhaul mesin setiap 5 tahun'],
            ['kategori' => 'Kelistrikan', 'nama' => 'Ganti Aki', 'interval_hari' => 730, 'deskripsi' => 'Ganti aki setiap 2 tahun'],
            ['kategori' => 'Kelistrikan', 'nama' => 'Perbaikan Starter', 'interval_hari' => 365, 'deskripsi' => 'Perbaikan starter jika diperlukan'],
            ['kategori' => 'Kelistrikan', 'nama' => 'Perbaikan Alternator', 'interval_hari' => 365, 'deskripsi' => 'Perbaikan alternator jika diperlukan'],
            ['kategori' => 'Kelistrikan', 'nama' => 'Perbaikan Kelistrikan', 'interval_hari' => 180, 'deskripsi' => 'Perbaikan kelistrikan ringan'],
            ['kategori' => 'Rem', 'nama' => 'Servis Rem', 'interval_hari' => 180, 'deskripsi' => 'Servis rem setiap 6 bulan'],
            ['kategori' => 'Rem', 'nama' => 'Ganti Kampas Rem', 'interval_hari' => 365, 'deskripsi' => 'Ganti kampas rem setiap 1 tahun'],
            ['kategori' => 'Rem', 'nama' => 'Ganti Minyak Rem', 'interval_hari' => 730, 'deskripsi' => 'Ganti minyak rem setiap 2 tahun'],
            ['kategori' => 'Ban dan Kaki-Kaki', 'nama' => 'Ganti Ban', 'interval_hari' => 730, 'deskripsi' => 'Ganti ban setiap 2 tahun'],
            ['kategori' => 'Ban dan Kaki-Kaki', 'nama' => 'Perbaikan Shockbreaker', 'interval_hari' => 365, 'deskripsi' => 'Perbaikan shockbreaker setiap 1 tahun'],
            ['kategori' => 'Pendingin dan AC', 'nama' => 'Servis AC', 'interval_hari' => 365, 'deskripsi' => 'Servis AC setiap 1 tahun'],
            ['kategori' => 'Pendingin dan AC', 'nama' => 'Perbaikan Radiator', 'interval_hari' => 365, 'deskripsi' => 'Perbaikan radiator setiap 1 tahun'],
        ];

        foreach ($data as $item) {
            MasterJenisPemeliharaan::create($item);
        }
    }
}
