<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Mahasiswa;
use App\Models\JadwalKuliah;
use Illuminate\Http\Request;
use App\Models\KelasMahasiswa;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    private function getMahasiswa()
    {
        $user = Auth::user();
        if ($user && $user->role === 'mahasiswa') {
            return Mahasiswa::where('user_id', $user->id)
                            ->with(['user', 'jurusan']) // Tambahkan with di sini
                            ->first(); // ⭐ WAJIB: Akhiri query dengan first()
        }
        return null;
    }

    public function index()
    {
        $mahasiswa = $this->getMahasiswa();

        if (!$mahasiswa) {
            // Jika getMahasiswa() mengembalikan null, logout dan redirect
            Auth::logout();
            return redirect('/login')->withErrors('Data Mahasiswa tidak ditemukan atau sesi berakhir.');
        }

        return view('mahasiswa.dashboard', compact('mahasiswa'));
    }

    public function lihatAbsensi()
    {
        $mahasiswa = $this->getMahasiswa();

        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.dashboard')->withErrors('Akses ditolak.');
        }

        $riwayatAbsensi = Absensi::where('nim', $mahasiswa->nim)
            ->with([
                'jadwal' => [
                    'mataKuliah',
                    'kelas'
                ]
            ])
            ->orderBy('tanggal_absen', 'desc') // ⭐ Pastikan nama kolom tanggal absensi benar
            ->paginate(15);

            // dd($riwayatAbsensi->items());

        return view('mahasiswa.absensi.index', compact('mahasiswa', 'riwayatAbsensi'));
    }

    public function jadwalKuliah()
    {
        $mahasiswa = $this->getMahasiswa();

        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.dashboard')->withErrors('Akses ditolak.');
        }

        // 1. Ambil ID Kelas mahasiswa
        // Asumsi: Mahasiswa terdaftar di Kelas melalui tabel pivot 'kelas_mahasiswas'
        $kelasMahasiswa = KelasMahasiswa::where('nim', $mahasiswa->nim)->first();

        if (!$kelasMahasiswa) {
            // Jika mahasiswa belum terdaftar di kelas manapun, kembalikan koleksi kosong
            $jadwalKuliah = collect();
            return view('mahasiswa.jadwal-kuliah.index', compact('mahasiswa', 'jadwalKuliah'))
                ->with("info", 'Anda belum terdaftar di kelas manapun.');
        }

        // 2. Ambil semua jadwal yang terkait dengan id_kelas tersebut
        $jadwalKuliah = JadwalKuliah::where('id_kelas', $kelasMahasiswa->id_kelas)
            ->with(['mataKuliah', 'dosen', 'kelas']) // Eager Load Mata Kuliah dan Dosen
            ->orderBy('tanggal')
            ->orderBy('waktu_mulai')
            ->get(); // Menggunakan get() karena biasanya jadwal tidak terlalu banyak

        // dd($jadwalKuliah);

        return view('mahasiswa.jadwal-kuliah.index', compact('mahasiswa', 'jadwalKuliah'));
    }
}
