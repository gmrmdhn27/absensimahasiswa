<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
// Tambahkan controller untuk Dosen dan Mahasiswa
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('auth.login');
});


// PENTING: Rute Login harus berada di luar middleware 'auth'
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Rute Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // --- 👨‍🎓 Manajemen Mahasiswa ---
    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        // GET /admin/mahasiswa (Index)
        Route::get('/', [AdminController::class, 'mahasiswaIndex'])->name('index');
        // GET /admin/mahasiswa/create (View Create) - Tambahkan ini untuk form
        Route::get('/create', [AdminController::class, 'mahasiswaCreate'])->name('create');
        // POST /admin/mahasiswa (Store/Create)
        Route::post('/', [AdminController::class, 'mahasiswaStore'])->name('store');
        // GET /admin/mahasiswa/{id}/edit (View Edit)
        Route::get('/{id}/edit', [AdminController::class, 'mahasiswaEdit'])->name('edit');
        // PUT/PATCH /admin/mahasiswa/{id} (Update)
        Route::put('/{id}', [AdminController::class, 'mahasiswaUpdate'])->name('update');
        // DELETE /admin/mahasiswa/{id} (Destroy)
        Route::delete('/{id}', [AdminController::class, 'mahasiswaDestroy'])->name('destroy');
    });

    // --- 👥 Manajemen Dosen ---
    Route::prefix('dosen')->name('dosen.')->group(function () {
        // GET /admin/dosen (Index)
        Route::get('/', [AdminController::class, 'dosenIndex'])->name('index');
        // GET /admin/dosen/create
        Route::get('/create', [AdminController::class, 'dosenCreate'])->name('create');
        // POST /admin/dosen (Store/Create)
        Route::post('/', [AdminController::class, 'dosenStore'])->name('store'); // Perlu buat fungsi dosenStore
        // GET /admin/dosen/{id}/edit
        Route::get('/{id}/edit', [AdminController::class, 'dosenEdit'])->name('edit');
        // PUT/PATCH /admin/dosen/{id} (Update)
        Route::put('/{id}', [AdminController::class, 'dosenUpdate'])->name('update');
        // DELETE /admin/dosen/{id} (Destroy)
        Route::delete('/{id}', [AdminController::class, 'dosenDestroy'])->name('destroy');
    });

    // --- 📚 Manajemen Mata Kuliah ---
    Route::prefix('matakuliah')->name('matakuliah.')->group(function () {
        Route::get('/', [AdminController::class, 'mataKuliahIndex'])->name('index');
        Route::get('/create', [AdminController::class, 'mataKuliahCreate'])->name('create'); // Tambahkan rute Create
        Route::post('/', [AdminController::class, 'mataKuliahStore'])->name('store');
        Route::get('/{kode_mk}/edit', [AdminController::class, 'mataKuliahEdit'])->name('edit'); // Tambahkan rute Edit
        Route::put('/{kode_mk}', [AdminController::class, 'mataKuliahUpdate'])->name('update');
        Route::delete('/{kode_mk}', [AdminController::class, 'mataKuliahDestroy'])->name('destroy');
    });

    // --- 🗓️ Manajemen Jadwal Kuliah ---
    Route::prefix('jadwalkuliah')->name('jadwal.')->group(function () {
        Route::get('/', [AdminController::class, 'jadwalKuliahIndex'])->name('index');
        Route::get('/create', [AdminController::class, 'jadwalKuliahCreate'])->name('create'); // Tambahkan rute Create
        Route::post('/', [AdminController::class, 'jadwalKuliahStore'])->name('store');
        Route::get('/{id}/edit', [AdminController::class, 'jadwalKuliahEdit'])->name('edit'); // Tambahkan rute Edit
        Route::put('/{id}', [AdminController::class, 'jadwalKuliahUpdate'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'jadwalKuliahDestroy'])->name('destroy');
    });

    // Anda mungkin juga ingin menambahkan CRUD untuk Jurusan, Kelas, dll. di sini.
});


// =========================================================================
// --- GRUP RUTE DOSEN (Role: dosen) ---
// =========================================================================

Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
    // Rute Dashboard Dosen
    Route::get('/dashboard', [DosenController::class, 'index'])->name('dashboard');

    // Rute lain yang relevan untuk Dosen
    // GET /dosen/jadwal-mengajar
    Route::get('/jadwal-mengajar', [DosenController::class, 'jadwalMengajar'])->name('jadwal-mengajar');
    // GET /dosen/form-absensi/{id_jadwal}
    Route::get('/form-absensi/{id_jadwal}', [DosenController::class, 'showAbsensiForm'])->name('form-absensi');
    // POST /dosen/input-absensi/{id_jadwal}
    Route::post('/input-absensi/{id_jadwal}', [DosenController::class, 'inputAbsensi'])->name('input-absensi');
});


// =========================================================================
// --- GRUP RUTE MAHASISWA (Role: mahasiswa) ---
// =========================================================================

Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    // Rute Dashboard Mahasiswa
    Route::get('/dashboard', [MahasiswaController::class, 'index'])->name('dashboard');

    // Rute lain yang relevan untuk Mahasiswa
    Route::get('/lihat-absensi', [MahasiswaController::class, 'lihatAbsensi'])->name('lihat_absensi');
    Route::get('/jadwal-kuliah', [MahasiswaController::class, 'jadwalKuliah'])->name('jadwal_kuliah');
});
