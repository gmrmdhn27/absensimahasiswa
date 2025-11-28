<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Absensi;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\JadwalKuliah;
use Illuminate\Http\Request;
use App\Models\KelasMahasiswa;
use GuzzleHttp\Promise\Create;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index() {
        $totalMahasiswa = Mahasiswa::count();
        $totalDosen = Dosen::count();
        $totalMataKuliah = MataKuliah::count();
        $totalAbsensiHariIni = Absensi::whereDate("created_at", today())->count();

        return view ("admin.dashboard", compact(
            "totalMahasiswa",
            "totalDosen",
            "totalMataKuliah",
            "totalAbsensiHariIni"
        ));
    }

    // Mahasiswa
    public function mahasiswaIndex(Request $request)
    {
        // Ambil data jurusan untuk dropdown filter
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();

        // Mulai query Mahasiswa dengan relasi yang dibutuhkan
        $query = Mahasiswa::with(['user', 'jurusan']);

        // Terapkan filter pencarian (search) jika ada
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama', 'like', "%{$searchTerm}%")
                  ->orWhere('nim', 'like', "%{$searchTerm}%");
            });
        }

        // Terapkan filter jurusan jika ada
        if ($request->filled('jurusan')) {
            $query->where('jurusan_id', $request->jurusan);
        }

        $mahasiswas = $query->orderBy('nama', 'asc')->paginate(10)->withQueryString();

        return view("admin.mahasiswa.index", compact('mahasiswas', 'jurusans'));
    }

    public function mahasiswaCreate() {
        $jurusans = Jurusan::all();

        // 2. Ambil semua data Kelas dari tabel kelas
        $kelas = Kelas::all();

        // Kirim data ke view
        return view("admin.mahasiswa.create", compact("jurusans", "kelas"));
    }

    public function mahasiswaStore(Request $request) {
        $request->validate([
            "nim" => "required|string|unique:mahasiswas,nim",
            "nama" => "required|string|max:255",
            "email" => "required|email|unique:users,email",
            "password" => "required|string|min:3",
            "angkatan" => "required|string",
            "jurusan_id" => "required|exists:jurusans,id",
            "id_kelas" => "required|exists:kelas,id"
        ]);

        // Create User
        $user = User::create([
            "name" => $request->nama,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "role" => "mahasiswa",
            "nim" => $request->nim
        ]);
        // Create Mahasiswa
        $mahasiswa = Mahasiswa::create([
            "nim" => $request->nim,
            "nama" => $request->nama,
            "angkatan" => $request->angkatan,
            "jurusan_id" => $request->jurusan_id,
            // "id_kelas" => $request->id_kelas,
            "user_id" => $user->id
        ]);

        KelasMahasiswa::create([
            "nim" => $mahasiswa->nim,
            "id_kelas" => $request->id_kelas
        ]);

        return redirect()->route("admin.mahasiswa.index")
            ->with("succes", "Data Mahasiswa Berhasil Ditambahkan");
    }

    public function mahasiswaEdit($id) {
        $mahasiswa = Mahasiswa::with("user", "kelasMahasiswa")->findOrFail($id);


        $kelas = Kelas::all();
        $jurusans = Jurusan::all();

        return view("admin.mahasiswa.edit", compact(
            "mahasiswa",
            "kelas",
            "jurusans"
        ));
    }

    public function mahasiswaUpdate(Request $request, $id) {
        $mahasiswa = Mahasiswa::findOrFail($id);
        // dd($mahasiswa->toArray());
        $request->validate([
            'nim' => 'required|string|unique:mahasiswas,nim,'.$id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.
            $mahasiswa->user_id,
            "angkatan" => "required|string",
            "id_kelas" => "required|exists:kelas,id",
            "jurusan_id" => "required|exists:jurusans,id"
        ]);
        // Update User
        $userData = [
            "name" => $request->nama,
            "email" => $request->email,
            "nim" => $request->nim,
        ];

        if($request->filled("password")) {
            $userData["password"] = Hash::make($request->password);
        }
        // Update Mahasiswa
        $mahasiswa->update([
            "nim" => $request->nim,
            "nama" => $request->nama,
            "angkatan" => $request->angkatan,
            // "id_kelas" => $request->id_kelas,
            "jurusan_id" => $request->jurusan_id,
        ]);

        KelasMahasiswa::updateOrCreate(
            ['nim' => $mahasiswa->nim], // Cari berdasarkan NIM Mahasiswa
            ['id_kelas' => $request->id_kelas] // Update ID Kelas
        );

        return redirect()->route("admin.mahasiswa.index")
            ->with("success", "Data Mahasiswa Berhasil Diperbarui");
    }

    public function mahasiswaDestroy($id) {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $mahasiswa->user->delete();

        return redirect()->route("admin.mahasiswa.index")
            ->with("success", "Data Mahasiswa Berhasil Dihapus");
    }

    // Dosen
    public function dosenIndex(Request $request)
    {
        $query = Dosen::with("user", "jadwalKuliahs");

        // Filter by fakultas
        if ($request->filled('departemen')) {
            $query->where('departemen', $request->departemen);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // 1. Search berdasarkan Nama Dosen (Kolom 'Nama_Dosen' di tabel Dosen)
                $q->where('nama', 'like', "%{$search}%")
                // 2. Search berdasarkan NIP (Kolom 'NIP' di tabel Dosen)
                ->orWhere('nip', 'like', "%{$search}%")
                // 3. Search berdasarkan Email (menggunakan relasi 'user')
                ->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('email', 'like', "%{$search}%");
                });
            });
        }

        $dosens = $query->orderBy('nama', 'asc')->paginate(10)->withQueryString();

        return view("admin.dosen.index", compact('dosens'));
    }

    public function dosenCreate() {
        return view("admin.dosen.create");
    }

    public function dosenStore(Request $request) {
        $request->validate([
            "nip" => "required|string|unique:dosens,nip",
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'departemen' => 'required|string',
        ]);
        // Create user
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'dosen',
            'nip' => $request->nip,
        ]);
        // Create dosen
        Dosen::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'departemen' => $request->departemen,
            'user_id' => $user->id,
        ]);

        return redirect()->route("admin.dosen.index")
            ->with("success", "Data Dosen Berhasil Ditambahkan");
    }

    public function dosenEdit($id) {
        $dosen = Dosen::with("user")->findOrFail($id);

        return view('admin.dosen.edit', compact('dosen'));
    }

    public function dosenUpdate(Request $request, $id) {
        $dosen = Dosen::findOrFail($id);

        $request->validate([
            'nip' => 'required|string|unique:dosens,nip,'.$id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.
            $dosen->user_id,
            'departemen' => 'required|string',
        ]);

        // Update user
        $userData = [
            'name' => $request->nama,
            'email' => $request->email,
            'nip' => $request->nip,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $dosen->user->update($userData);

        // Update dosen
        $dosen->update([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'email' => $request->email,
            'departemen' => $request->departemen,
        ]);

        return redirect()->route("admin.dosen.index")
            ->with("success", "Data Dosen Berhasil Diperbarui");
    }

    public function dosenDestroy($id) {
        $dosen = Dosen::findOrFail($id);

        // Delete user first (will cascade delete dosen)
        $dosen->user->delete();

        return redirect()->route('admin.dosen.index')
            ->with('success', 'Data dosen berhasil dihapus!');
    }

    // Matkul

    public function mataKuliahIndex(Request $request)
    {
        $query = MataKuliah::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // Mencari berdasarkan Nama MK atau Kode MK
                $q->where('nama_mk', 'like', "%{$search}%")
                ->orWhere('kode_mk', 'like', "%{$search}%");
            });
        }

        $mataKuliahs = $query->orderBy('nama_mk', 'asc')->paginate(10)->withQueryString();
        return view("admin.matakuliah.index", compact('mataKuliahs'));
    }

    public function mataKuliahCreate() {
        // Anda bisa mengirimkan data tambahan jika ada, tapi untuk form sederhana, cukup return view.
        return view("admin.matakuliah.create");
    }

    public function mataKuliahStore(Request $request) {
        $request->validate([
            // Validasi Kode_MK sebagai Primary Key
            "kode_mk" => "required|string|unique:mata_kuliahs,kode_mk",
            "nama_mk" => "required|string|max:255",
            "sks" => "required|integer|min:1|max:6",
        ]);

        MataKuliah::create([
            "kode_mk" => $request->kode_mk,
            "nama_mk" => $request->nama_mk,
            "sks" => $request->sks,
        ]);

        return redirect()->route("admin.matakuliah.index")
            ->with("success", "Mata Kuliah Berhasil Ditambahkan");
    }

    // ... dalam class AdminController ...

    public function mataKuliahUpdate(Request $request, $kode_mk) {
        // Cari berdasarkan Kode_MK karena itu Primary Key
        $mk = MataKuliah::where('kode_mk', $kode_mk)->firstOrFail();

        $request->validate([
            // Abaikan Kode_MK milik MK yang sedang diedit
            "kode_mk" => "required|string|unique:mata_kuliahs,kode_mk," . $mk->kode_mk . ",kode_mk",
            "nama_mk" => "required|string|max:255",
            "sks" => "required|integer|min:1|max:6",
        ]);

        $mk->update([
            "kode_mk" => $request->kode_mk,
            "nama_mk" => $request->nama_mk,
            "sks" => $request->sks,
        ]);

        return redirect()->route("admin.matakuliah.index")
            ->with("success", "Mata Kuliah Berhasil Diperbarui");
    }

    public function mataKuliahEdit($kode_mk) {
        // Cari Mata Kuliah berdasarkan Kode_MK
        $mataKuliah = MataKuliah::findOrFail($kode_mk);

        // Kirim data ke view
        return view("admin.matakuliah.edit", compact("mataKuliah"));
    }

    public function mataKuliahDestroy($kode_mk) {
        $mk = MataKuliah::where('kode_mk', $kode_mk)->firstOrFail();

        // PENTING: Pastikan tidak ada Jadwal Kuliah yang menggunakan Kode_MK ini
        // Jika ada, Anda harus mengatur cascading delete atau mencegah penghapusan
        if ($mk->jadwalKuliahs()->exists()) {
            return redirect()->route("admin.matakuliah.index")
                ->with("error", "Mata Kuliah tidak dapat dihapus karena masih digunakan dalam Jadwal Kuliah.");
        }

        $mk->delete();

        return redirect()->route("admin.matakuliah.index")
            ->with("success", "Mata Kuliah Berhasil Dihapus");
    }

    // Jadwal Kuliah
    public function jadwalKuliahIndex() {
        // Eager loading semua relasi FK
        $query = JadwalKuliah::with(['mataKuliah', 'kelas', 'dosen']);

        // Ambil tanggal dari request, jika tidak ada, gunakan tanggal hari ini.
        $tanggalFilter = request('tanggal', now()->toDateString());

        // Terapkan filter berdasarkan tanggal
        $query->whereDate('tanggal', $tanggalFilter);

        // Urutkan berdasarkan waktu mulai
        $jadwalKuliahs = $query->orderBy('waktu_mulai')->paginate(10);

        // Siapkan data FK untuk view filtering/creating
        $mataKuliahs = MataKuliah::all();
        $dosens = Dosen::all();
        $kelas = Kelas::all();

        return view("admin.jadwalkuliah.index", compact("jadwalKuliahs", "mataKuliahs", "dosens", "kelas", "tanggalFilter"));
    }

    public function jadwalKuliahCreate() {
        // Ambil data yang dibutuhkan untuk dropdown di form
        $mataKuliahs = MataKuliah::all();
        $dosens = Dosen::all();
        $kelas = Kelas::all(); // Asumsi ada model Kelas

        return view("admin.jadwalkuliah.create", compact("mataKuliahs", "dosens", "kelas"));
    }

    public function jadwalKuliahEdit($id)
    {
        // 1. Cari Jadwal Kuliah berdasarkan ID
        $jadwal = JadwalKuliah::findOrFail($id);

        // 2. Ambil data pendukung untuk dropdown (sama seperti method Create)
        $mataKuliahs = MataKuliah::all();
        $dosens = Dosen::all();
        $kelas = Kelas::all();

        // 3. Kirim data ke view
        return view("admin.jadwalkuliah.edit", compact("jadwal", "mataKuliahs", "dosens", "kelas"));
    }

    public function jadwalKuliahStore(Request $request) {
        $request->validate([
            "kode_mk" => "required|exists:mata_kuliahs,kode_mk",
            "id_kelas" => "required|exists:kelas,id",
            'nip_dosen' => "required|exists:dosens,nip",
            "tanggal" => "required|date",
            "waktu_mulai" => "required|date_format:H:i",
            "waktu_selesai" => "required|date_format:H:i"
        ]);

        $mataKuliah = MataKuliah::where('kode_mk', $request->kode_mk)->first();

        if (!$mataKuliah) {
            // Ini seharusnya sudah tertangkap oleh validasi exists:mata_kuliahs,kode_mk
            return back()->withInput()->withErrors(['kode_mk' => 'Kode Mata Kuliah tidak ditemukan.']);
        }

        JadwalKuliah::create([
            "id_mata_kuliah" => $mataKuliah->id,
            "id_kelas" => $request->id_kelas,
            "nip" => $request->nip_dosen, // ✅ Menggunakan NIP Dosen yang sedang login
            "tanggal" => $request->tanggal,
            "waktu_mulai" => $request->waktu_mulai,
            "waktu_selesai" => $request->waktu_selesai,
        ]);

        return redirect()->route("admin.jadwal.index")
            ->with("success", "Jadwal Kuliah Berhasil Ditambahkan");
    }

    public function jadwalKuliahUpdate(Request $request, $id) {
        $jadwal = JadwalKuliah::findOrFail($id);

        $mataKuliah = MataKuliah::where('kode_mk', $request->kode_mk)->firstOrFail();

        $request->validate([
            "kode_mk" => "required|exists:mata_kuliahs,kode_mk",
            "id_kelas" => "required|exists:kelas,id",
            "nip_dosen" => "required|exists:dosens,nip",
            "tanggal" => "required|date",
            "waktu_mulai" => "required|date_format:H:i",
            "waktu_selesai" => "required|date_format:H:i"
        ]);

        $jadwal->update([
            "id_mata_kuliah" => $mataKuliah->id,
            "id_kelas" => $request->id_kelas,
            "nip" => $request->nip_dosen,
            "tanggal" => $request->tanggal,
            "waktu_mulai" => $request->waktu_mulai,
            "waktu_selesai" => $request->waktu_selesai
        ]);

        return redirect()->route("admin.jadwal.index")
            ->with("success", "Jadwal Kuliah Berhasil Diperbarui");
    }

    public function jadwalKuliahDestroy($id) {
        $jadwal = JadwalKuliah::findOrFail($id);

        // PENTING: Pastikan tidak ada catatan Absensi yang merujuk ke ID_Jadwal ini
        if ($jadwal->absensi()->exists()) {
            return redirect()->route("admin.jadwal.index")
                ->with("error", "Jadwal Kuliah tidak dapat dihapus karena memiliki catatan Absensi.");
        }

        $jadwal->delete();

        return redirect()->route("admin.jadwal.index")
            ->with("success", "Jadwal Kuliah Berhasil Dihapus");
    }
}
