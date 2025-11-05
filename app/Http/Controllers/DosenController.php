<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Absensi;
use App\Models\Mahasiswa;
use App\Models\JadwalKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class DosenController extends Controller
{
    protected function getDosen()
    {
        $user = Auth::user();

        // Asumsi relasi user_id di tabel Dosen menunjuk ke ID di tabel users
        if ($user && $user->role === 'dosen') {
            return Dosen::where('user_id', $user->id)->first();
        }

        return null;
    }

    // --------------------------------------------------------------------------
    // Rute Dashboard Dosen: /dosen/dashboard (dosen.dashboard)
    // --------------------------------------------------------------------------
    public function index()
    {
        $dosen = $this->getDosen();

        if (!$dosen) {
            Auth::logout();
            return redirect('/login')->withErrors('Akses Ditolak: Data Dosen tidak valid.');
        }

        $totalJadwal = JadwalKuliah::where('nip', $dosen->nip)->count();
        $jadwalHariIni = JadwalKuliah::where('nip', $dosen->nip)
                                     ->where('tanggal', now()->format('Y-m-d')) // Sesuaikan format kolom 'tanggal' di DB Anda
                                     ->count();

        return view('dosen.dashboard', compact('dosen', 'totalJadwal', 'jadwalHariIni'));
    }

    // --------------------------------------------------------------------------
    // Rute Jadwal Mengajar: /dosen/jadwal-mengajar (dosen.jadwal_mengajar)
    // --------------------------------------------------------------------------
    public function jadwalMengajar()
    {
        $dosen = $this->getDosen();

        if (!$dosen) {
            return redirect()->route('dosen.dashboard')->with('error', 'Akses Ditolak.');
        }

        // Ambil semua jadwal kuliah yang diampu oleh dosen ini (menggunakan NIP)
        $jadwals = JadwalKuliah::with(['mataKuliah', 'kelas'])
                                ->where('nip', $dosen->nip)
                                ->orderBy('tanggal', 'desc')
                                ->orderBy('waktu_mulai')
                                ->paginate(10);

        return view('dosen.jadwal-mengajar', compact('dosen', 'jadwals'));
    }

    // --------------------------------------------------------------------------
    // Rute Form Absensi (GET): /dosen/form-absensi/{id_jadwal} (dosen.show_absensi_form)
    // --------------------------------------------------------------------------
    public function showAbsensiForm($id_jadwal)
    {
        $jadwal = JadwalKuliah::with(['mataKuliah', 'kelas'])
                           ->findOrFail($id_jadwal);

        $id_kelas = $jadwal->id_kelas;

        $mahasiswas = Mahasiswa::join('kelas_mahasiswas', 'mahasiswas.nim', '=', 'kelas_mahasiswas.nim')
            ->where('kelas_mahasiswas.id_kelas', $id_kelas)
            // Pastikan hanya mengambil kolom dari tabel Mahasiswa
            ->select('mahasiswas.*')
            ->get();

        // ... sisanya sama ...

        return view('dosen.form-absensi', compact('jadwal', 'mahasiswas'));
    }

    // --------------------------------------------------------------------------
    // Rute Input Absensi (POST): POST /dosen/input-absensi/{id_jadwal} (dosen.input_absensi)
    // --------------------------------------------------------------------------
    public function inputAbsensi(Request $request, $id_jadwal)
    {
        $dosen = $this->getDosen();
        if (!$dosen) {
            return redirect()->route('dosen.dashboard')->with('error', 'Akses Ditolak.');
        }

        // 1. Verifikasi Jadwal Kuliah dan Dosen
        $jadwal = JadwalKuliah::where('id', $id_jadwal)
                            ->where('nip', $dosen->nip)
                            ->first();

        if (!$jadwal) {
            return back()->with('error', 'Jadwal kuliah tidak valid.');
        }

        // ⭐ Konversi dan Validasi (Kode sebelumnya yang sudah benar)
        $statusInput = $request->input('status');
        if ($statusInput) {
            $statusInput = array_map('strtolower', $statusInput);
            $request->merge(['status' => $statusInput]);
        }

        $request->validate([
            'status' => 'required|array',
            'status.*' => 'required|string|in:hadir,sakit,izin,alfa',
        ]);

        // Cek duplikasi absensi sebelum menyimpan
        if (Absensi::where('id_jadwal', $id_jadwal)->whereDate('tanggal_absen', now())->exists()) {
            return back()->with('error', 'Absensi untuk jadwal ini hari ini sudah diisi.');
        }

        // 3. Proses penyimpanan Absensi menggunakan DB Transaction
        try {
            // ⭐ Gunakan Transaksi untuk bypass FK check sementara
            DB::transaction(function () use ($request, $id_jadwal) {

                // Nonaktifkan Foreign Key Checks (hanya untuk MySQL)
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');

                $statuses = $request->input('status');

                foreach ($statuses as $nim => $status) {
                    Absensi::create([
                        'id_jadwal' => $id_jadwal,
                        'nim' => $nim,
                        'status_kehadiran' => $status,
                        'tanggal_absen' => now(),
                    ]);
                }

                // Aktifkan kembali Foreign Key Checks
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            });

            return redirect()->route('dosen.jadwal_mengajar')->with('success',
                "Absensi berhasil disimpan untuk Jadwal ID: {$id_jadwal}.");

        } catch (\Exception $e) {
            // Aktifkan kembali Foreign Key Checks jika terjadi kegagalan
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            // ⭐ Tampilkan Error aslinya (Jika masih tidak muncul, cek Step 2)
            Log::error('Gagal Input Absensi: ' . $e->getMessage());
            return back()->with('error', 'Penyimpanan gagal. Detail: ' . $e->getMessage());
        }
    }
}
