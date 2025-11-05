<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\MataKuliah;
use App\Models\JadwalKuliah;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JadwalKuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🔍 Ambil ID Mata Kuliah Basis Data (INF102)
        $mataKuliah = MataKuliah::where('kode_mk', 'INF102')->first();
        $kelasTIA = Kelas::where('nama_kelas', 'TI-A')->first();

        if (!$mataKuliah || !$kelasTIA) {
             // Pastikan MatakuliahSeeder dan KelasSeeder dijalankan sebelum ini
             echo "Error: Data Mata Kuliah atau Kelas tidak ditemukan!";
             return;
        }

        JadwalKuliah::create([
            'nip' => '12345678',
            'id_kelas' => $kelasTIA->id,

            // ⭐ PERBAIKAN KRUSIAL: Tambahkan foreign key yang hilang
            'id_mata_kuliah' => $mataKuliah->id,

            'tanggal' => now()->addDays(2)->format('Y-m-d'),
            'waktu_mulai' => '09:00:00',
        ]);
    }
}
