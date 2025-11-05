<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kelas::create([
            'nama_kelas' => 'TI-A',
            'tahun_ajaran' => "2025",
            'semester' => "5"
        ]);
        Kelas::create([
            'nama_kelas' => 'SI-B',
            'tahun_ajaran' => "2025",
            'semester' => "5"
        ]);
        Kelas::create([
            'nama_kelas' => 'AK-A',
            'tahun_ajaran' => "2025",
            'semester' => "5"
        ]);
    }
}
