<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\JadwalKuliah;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\KelasMahasiswa;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Buat User Admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin'),
                'role' => 'admin',
            ]
        );

        // 2. Buat Jurusan
        $jurusan = Jurusan::firstOrCreate(
            ['kode_jurusan' => 'TIF'],
            [
                'nama_jurusan' => 'Teknik Informatika',
                'fakultas' => 'Fakultas Teknik'
            ]
        );

        // 3. Buat 10 Kelas
        $kelasCollection = collect();
        for ($i = 1; $i <= 10; $i++) {
            $namaKelas = '05TPLP' . str_pad($i, 3, '0', STR_PAD_LEFT);
            $kelas = Kelas::create([
                'nama_kelas' => $namaKelas,
                'tahun_ajaran' => '2024/2025',
                'semester' => 'Ganjil'
            ]);
            $kelasCollection->push($kelas);
        }
        $kelasUtama = $kelasCollection->first(); // Kelas "05TPLP001" untuk 30 mahasiswa

        // 4. Buat 30 Mahasiswa dalam satu kelas (05TPLP001)
        for ($i = 0; $i < 30; $i++) {
            $namaMahasiswa = $faker->name;
            $nim = '2024' . $faker->unique()->numerify('#####');

            $user = User::create([
                'name' => $namaMahasiswa,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'), // password default
                'role' => 'mahasiswa',
            ]);

            $mahasiswa = Mahasiswa::create([
                'nim' => $nim,
                'nama' => $namaMahasiswa,
                'angkatan' => '2024',
                'jurusan_id' => $jurusan->id,
                'user_id' => $user->id,
            ]);

            // Masukkan mahasiswa ke kelas utama
            KelasMahasiswa::create([
                'nim' => $mahasiswa->nim,
                'id_kelas' => $kelasUtama->id,
            ]);
        }

        // 5. Buat 8 Mata Kuliah
        $mataKuliahsData = [
            ['kode_mk' => 'INF101', 'nama_mk' => 'Algoritma & Pemrograman', 'sks' => 3],
            ['kode_mk' => 'INF102', 'nama_mk' => 'Kalkulus I', 'sks' => 3],
            ['kode_mk' => 'INF103', 'nama_mk' => 'Sistem Digital', 'sks' => 2],
            ['kode_mk' => 'INF104', 'nama_mk' => 'Basis Data', 'sks' => 3],
            ['kode_mk' => 'INF201', 'nama_mk' => 'Struktur Data', 'sks' => 3],
            ['kode_mk' => 'INF202', 'nama_mk' => 'Jaringan Komputer', 'sks' => 3],
            ['kode_mk' => 'UMB101', 'nama_mk' => 'Pendidikan Pancasila', 'sks' => 2],
            ['kode_mk' => 'UMB102', 'nama_mk' => 'Bahasa Inggris', 'sks' => 2],
        ];

        foreach ($mataKuliahsData as $mk) {
            MataKuliah::updateOrCreate(['kode_mk' => $mk['kode_mk']], $mk);
        }
        $allMataKuliah = MataKuliah::all();

        // 6. Buat 5 Dosen
        $dosens = collect();
        for ($i = 0; $i < 5; $i++) {
            $namaDosen = $faker->name;
            $nip = 'D' . $faker->unique()->numerify('#########');
            $user = User::create([
                'name' => $namaDosen,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'role' => 'dosen',
            ]);
            $dosen = Dosen::create([
                'nip' => $nip,
                'nama' => $namaDosen,
                'departemen' => 'Teknik Informatika',
                'user_id' => $user->id,
            ]);
            $dosens->push($dosen);
        }

        // 7. Buat Jadwal Kuliah per hari untuk SEMUA kelas
        $jadwalHarian = [
            ['hari' => 1, 'waktu_mulai' => '08:00', 'waktu_selesai' => '10:30', 'kode_mk' => 'INF101'],
            ['hari' => 1, 'waktu_mulai' => '13:00', 'waktu_selesai' => '15:30', 'kode_mk' => 'INF102'],
            ['hari' => 2, 'waktu_mulai' => '09:00', 'waktu_selesai' => '11:00', 'kode_mk' => 'INF103'],
            ['hari' => 3, 'waktu_mulai' => '08:00', 'waktu_selesai' => '10:30', 'kode_mk' => 'INF104'],
            ['hari' => 3, 'waktu_mulai' => '13:00', 'waktu_selesai' => '15:30', 'kode_mk' => 'INF201'],
            ['hari' => 4, 'waktu_mulai' => '09:00', 'waktu_selesai' => '11:30', 'kode_mk' => 'INF202'],
            ['hari' => 5, 'waktu_mulai' => '08:00', 'waktu_selesai' => '10:00', 'kode_mk' => 'UMB101'],
            ['hari' => 5, 'waktu_mulai' => '10:00', 'waktu_selesai' => '12:00', 'kode_mk' => 'UMB102'],
        ];

        $tanggalAwal = now()->startOfWeek();

        foreach ($kelasCollection as $kelas) {
            foreach ($jadwalHarian as $jadwal) {
                $mataKuliah = $allMataKuliah->where('kode_mk', $jadwal['kode_mk'])->first();
                JadwalKuliah::create([
                    'id_mata_kuliah' => $mataKuliah->id,
                    'id_kelas' => $kelas->id,
                    'nip' => $dosens->random()->nip,
                    'tanggal' => $tanggalAwal->copy()->addDays($jadwal['hari'] - 1)->toDateString(),
                    'waktu_mulai' => $jadwal['waktu_mulai'],
                    'waktu_selesai' => $jadwal['waktu_selesai'],
                ]);
            }
        }

        $this->command->info('Database seeding completed successfully.');
    }
}
