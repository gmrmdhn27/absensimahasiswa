<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 1. Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);

        // 2. Dosen (7 Dosen)
        $dosens = [
            ['nip' => '198201102005011001', 'nama' => 'Dr. Budi Santoso', 'departemen' => 'Teknik Informatika'],
            ['nip' => '197905152003122002', 'nama' => 'Prof. Citra Lestari', 'departemen' => 'Sistem Informasi'],
            ['nip' => '198503202008011005', 'nama' => 'Ahmad Dahlan, M.Kom.', 'departemen' => 'Teknik Informatika'],
            ['nip' => '199011012015032001', 'nama' => 'Rina Hartati, M.Sc.', 'departemen' => 'Teknik Informatika'],
            ['nip' => '198808252014041002', 'nama' => 'Eko Prasetyo, Ph.D.', 'departemen' => 'Sistem Informasi'],
            ['nip' => '199207192019032003', 'nama' => 'Fitriani, S.Kom., M.T.', 'departemen' => 'Teknik Informatika'],
            ['nip' => '198602142010121003', 'nama' => 'Gunawan, M.Eng.', 'departemen' => 'Sistem Informasi'],
        ];

        foreach ($dosens as $dosenData) {
            $user = User::create([
                'name' => $dosenData['nama'],
                'email' => strtolower(str_replace(['.', ' ', ','], '', explode(' ', $dosenData['nama'])[0])) . '@example.com',
                'password' => Hash::make('dosen'),
                'role' => 'dosen',
            ]);

            Dosen::create([
                'nip' => $dosenData['nip'],
                'nama' => $dosenData['nama'],
                'departemen' => $dosenData['departemen'],
                'user_id' => $user->id,
            ]);
        }
    }
}
