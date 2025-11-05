<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Dosen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'), // Password yang di-hash
            'role' => 'admin',
        ]);

        $dosenUser = User::create([
            'name' => 'Rusli Kurniawan',
            'email' => 'rusli@gmail.com',
            'password' => Hash::make('dosen'),
            'role' => 'dosen',
            // ⭐ HAPUS BARIS INI: 'nip' => '12345678',
        ]);

        Dosen::create([
            'user_id' => $dosenUser->id,
            'nip' => '12345678', // NIP hanya ada di tabel Dosen
            'nama' => 'Rusli Kurniawan',
            'departemen' => 'Teknik Informatika',
        ]);
    }
}
