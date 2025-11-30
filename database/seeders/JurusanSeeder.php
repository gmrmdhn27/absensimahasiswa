<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    public function run()
    {
        Jurusan::create([
            'kode_jurusan' => 'IF',
            'nama_jurusan' => 'Teknik Informatika',
            'fakultas' => 'Fakultas Teknik',
        ]);
        Jurusan::create([
            'kode_jurusan' => 'SI',
            'nama_jurusan' => 'Sistem Informasi',
            'fakultas' => 'Fakultas Teknik',
        ]);
    }
}
