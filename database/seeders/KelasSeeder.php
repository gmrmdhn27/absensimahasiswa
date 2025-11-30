<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            Kelas::create([
                'nama_kelas' => '05TPLP' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'tahun_ajaran' => '2024/2025',
                'semester' => 'Ganjil',
            ]);
        }
    }
}
