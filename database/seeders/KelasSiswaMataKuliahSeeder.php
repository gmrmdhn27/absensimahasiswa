<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\JadwalKuliah;
use Illuminate\Support\Str;
use App\Models\KelasMahasiswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KelasSiswaMataKuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nonaktifkan pengecekan foreign key untuk mempercepat proses seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Ambil semua data yang dibutuhkan di awal untuk efisiensi
        $kelasCollection = Kelas::all();
        $mataKuliahCollection = MataKuliah::all();
        $dosenCollection = Dosen::all();
        $jurusan = Jurusan::first(); // Asumsi semua mahasiswa baru masuk ke jurusan pertama

        if ($mataKuliahCollection->isEmpty() || $dosenCollection->isEmpty() || !$jurusan) {
            $this->command->error('Pastikan ada data di tabel Mata Kuliah, Dosen, dan Jurusan sebelum menjalankan seeder ini.');
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return;
        }

        foreach ($kelasCollection as $kelas) {
            $this->command->info("Memproses Kelas: {$kelas->nama_kelas}");

            // 1. Membuat 30 Mahasiswa untuk setiap kelas
            for ($i = 1; $i <= 30; $i++) {
                $uniqueSuffix = $kelas->id . str_pad($i, 2, '0', STR_PAD_LEFT);
                $namaMahasiswa = "Siswa {$uniqueSuffix}";

                // Buat User
                $user = User::create([
                    'name' => $namaMahasiswa,
                    'email' => "siswa{$uniqueSuffix}@example.com",
                    'password' => Hash::make('password'),
                    'role' => 'mahasiswa',
                ]);

                // Buat Mahasiswa
                $mahasiswa = Mahasiswa::create([
                    'nim' => 'NIM' . Str::padLeft($uniqueSuffix, 8, '0'), // Contoh format NIM
                    'nama' => $namaMahasiswa,
                    'angkatan' => '2024',
                    'jurusan_id' => $jurusan->id,
                    'user_id' => $user->id,
                ]);

                // Hubungkan Mahasiswa dengan Kelas
                KelasMahasiswa::create([
                    'nim' => $mahasiswa->nim,
                    'id_kelas' => $kelas->id,
                ]);
            }
            $this->command->info("-> Berhasil membuat 30 mahasiswa.");

            // 2. Membuat 8 Jadwal Kuliah untuk setiap kelas
            // Ambil 8 mata kuliah secara acak, jika kurang dari 8, ambil seadanya
            $randomMataKuliah = $mataKuliahCollection->random(min(8, $mataKuliahCollection->count()));

            foreach ($randomMataKuliah as $index => $mataKuliah) {
                $dosen = $dosenCollection->random(); // Pilih dosen secara acak

                JadwalKuliah::create([
                    'id_mata_kuliah' => $mataKuliah->kode_mk,
                    'id_kelas' => $kelas->id,
                    'nip' => $dosen->nip,
                    'tanggal' => now()->addDays($index + 1)->format('Y-m-d'), // Jadwal untuk beberapa hari ke depan
                    'waktu_mulai' => '08:00',
                    'waktu_selesai' => '10:00',
                ]);
            }
            $this->command->info("-> Berhasil membuat " . $randomMataKuliah->count() . " jadwal kuliah.");
        }

        // Aktifkan kembali pengecekan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
