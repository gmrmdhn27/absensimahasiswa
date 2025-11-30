<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\KelasMahasiswa;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KelasMahasiswaSeeder extends Seeder
{
    public function run()
    {
        // Nonaktifkan pengecekan foreign key untuk mempercepat proses seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Kosongkan tabel terkait untuk menghindari duplikasi jika seeder dijalankan ulang
        // Ini akan menghapus mahasiswa yang dibuat oleh UserSeeder juga
        Mahasiswa::query()->delete();
        KelasMahasiswa::query()->delete();
        // Hapus user dengan role mahasiswa saja
        User::where('role', 'mahasiswa')->delete();

        $this->command->info('Data mahasiswa lama telah dibersihkan.');

        // Ambil semua data yang dibutuhkan di awal untuk efisiensi
        $kelasCollection = Kelas::all();
        $jurusan = Jurusan::first(); // Asumsi semua mahasiswa baru masuk ke jurusan pertama

        if ($kelasCollection->isEmpty() || !$jurusan) {
            $this->command->error('Pastikan ada data di tabel Kelas dan Jurusan sebelum menjalankan seeder ini.');
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return;
        }

        // Inisialisasi Faker untuk data Indonesia
        $faker = Faker::create('id_ID');

        $mahasiswaCounter = 0;
        foreach ($kelasCollection as $kelas) {
            $this->command->info("Memproses Kelas: {$kelas->nama_kelas}");

            // Membuat 30 Mahasiswa untuk setiap kelas
            for ($i = 1; $i <= 30; $i++) {
                $mahasiswaCounter++;
                $nim = '130124' . str_pad($mahasiswaCounter, 5, '0', STR_PAD_LEFT); // NIM unik berurutan
                $namaMahasiswa = $faker->name();
                $email = $faker->unique()->safeEmail();

                // Buat User
                $user = User::create([
                    'name' => $namaMahasiswa,
                    'email' => $email,
                    'password' => Hash::make('mahasiswa'),
                    'role' => 'mahasiswa',
                ]);

                // Buat Mahasiswa
                $mahasiswa = Mahasiswa::create([
                    'nim' => $nim,
                    'nama' => $namaMahasiswa,
                    'angkatan' => '2024',
                    'jurusan_id' => $jurusan->id,
                    'user_id' => $user->id,
                ]);

                // Hubungkan Mahasiswa dengan Kelas
                KelasMahasiswa::create(['nim' => $mahasiswa->nim, 'id_kelas' => $kelas->id]);
            }
            $this->command->info("-> Berhasil membuat dan mendaftarkan 30 mahasiswa.");
        }

        // Aktifkan kembali pengecekan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
