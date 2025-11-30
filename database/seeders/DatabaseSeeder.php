<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Panggil seeder dalam urutan yang benar untuk menghindari error foreign key
        $this->call([
            JurusanSeeder::class,
            KelasSeeder::class,
            MataKuliahSeeder::class,
            UserSeeder::class, // Akan membuat User, Dosen, dan Mahasiswa
            KelasMahasiswaSeeder::class, // Menghubungkan Mahasiswa ke Kelas
            JadwalKuliahSeeder::class, // Membuat jadwal berdasarkan data di atas
        ]);
    }
}
