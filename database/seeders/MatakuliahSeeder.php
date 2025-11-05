<?php

namespace Database\Seeders;

use App\Models\MataKuliah;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MatakuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MataKuliah::create(['kode_mk' => 'INF101', 'nama_mk' => 'Algoritma dan Struktur Data', 'sks' => 3]);
        MataKuliah::create(['kode_mk' => 'INF102', 'nama_mk' => 'Basis Data', 'sks' => 4]);
        MataKuliah::create(['kode_mk' => 'SI201', 'nama_mk' => 'Analisis dan Desain Sistem', 'sks' => 3]);
    }
}
