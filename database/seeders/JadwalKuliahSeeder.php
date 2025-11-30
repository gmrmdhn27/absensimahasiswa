<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\MataKuliah;
use App\Models\JadwalKuliah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalKuliahSeeder extends Seeder
{
    public function run()
    {
        // Nonaktifkan pengecekan foreign key untuk bypass error truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Kosongkan tabel jadwal kuliah untuk menghindari duplikasi
        DB::table('jadwal_kuliahs')->truncate();
        $this->command->info('Tabel jadwal_kuliahs telah dikosongkan.');

        // Ambil semua data yang diperlukan
        $dosens = Dosen::all();
        $kelasCollection = Kelas::all();
        $mataKuliahCollection = MataKuliah::all();

        if ($dosens->isEmpty() || $kelasCollection->isEmpty() || $mataKuliahCollection->isEmpty()) {
            $this->command->error('Data Dosen, Kelas, atau Mata Kuliah tidak ditemukan. Seeder JadwalKuliah dibatalkan.');
            // Aktifkan kembali foreign key jika terjadi error di sini
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return;
        }

        foreach ($dosens as $dosen) {
            $this->command->info("Membuat jadwal untuk Dosen: {$dosen->nama}");

            // Ambil 5 kelas acak yang unik untuk dosen ini
            // Jika total kelas kurang dari 5, ambil seadanya
            $kelasUntukDosen = $kelasCollection->random(min(5, $kelasCollection->count()))->unique('id');

            foreach ($kelasUntukDosen as $index => $kelas) {
                $mataKuliah = $mataKuliahCollection->random();
                $hari = $index + 1; // Jadwal untuk 5 hari ke depan (hari ke-1, ke-2, dst.)
                $jam_mulai = rand(8, 15); // Jam mulai antara 08:00 - 15:00

                JadwalKuliah::create([
                    'id_mata_kuliah' => $mataKuliah->kode_mk,
                    'id_kelas' => $kelas->id,
                    'nip' => $dosen->nip,
                    'tanggal' => now()->addDays($hari)->toDateString(),
                    'waktu_mulai' => str_pad($jam_mulai, 2, '0', STR_PAD_LEFT) . ':00',
                    'waktu_selesai' => str_pad($jam_mulai + 2, 2, '0', STR_PAD_LEFT) . ':00', // Durasi 2 jam
                ]);
            }
            $this->command->info("-> Berhasil membuat {$kelasUntukDosen->count()} jadwal mengajar.");
        }

        // Aktifkan kembali pengecekan foreign key setelah seeder selesai
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
