<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jurusan::create([
            'kode_jurusan' => 'A54I',
            'nama_jurusan' => 'Teknik Informatika',
            'fakultas' => 'Fakultas Teknik'
        ]);
        Jurusan::create([
            'kode_jurusan' => 'A32I',
            'nama_jurusan' => 'Sistem Informasi',
            'fakultas' => 'Fakultas Teknik'
        ]);
        Jurusan::create([
            'kode_jurusan' => 'A15I',
            'nama_jurusan' => 'Akuntansi',
            'fakultas' => 'Fakultas Manajemen'
        ]);
    }
}
