<?php

namespace Database\Seeders;

use App\Models\MataKuliah;
use Illuminate\Database\Seeder;

class MataKuliahSeeder extends Seeder
{
    public function run()
    {
        $mataKuliahs = [
            ['kode_mk' => 'MK001', 'nama_mk' => 'Pemrograman Web Lanjut', 'sks' => 3],
            ['kode_mk' => 'MK002', 'nama_mk' => 'Kecerdasan Buatan', 'sks' => 3],
            ['kode_mk' => 'MK003', 'nama_mk' => 'Jaringan Komputer', 'sks' => 3],
            ['kode_mk' => 'MK004', 'nama_mk' => 'Sistem Basis Data', 'sks' => 3],
            ['kode_mk' => 'MK005', 'nama_mk' => 'Analisis dan Perancangan Sistem', 'sks' => 4],
            ['kode_mk' => 'MK006', 'nama_mk' => 'Manajemen Proyek TI', 'sks' => 2],
            ['kode_mk' => 'MK007', 'nama_mk' => 'Keamanan Informasi', 'sks' => 3],
            ['kode_mk' => 'MK008', 'nama_mk' => 'Pemrograman Berorientasi Objek', 'sks' => 3],
        ];

        foreach ($mataKuliahs as $mk) {
            MataKuliah::create($mk);
        }
    }
}
