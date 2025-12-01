<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin dengan data statistik.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil total data dari masing-masing tabel
        $totalMahasiswa = Mahasiswa::count();
        $totalDosen = Dosen::count();
        $totalMataKuliah = MataKuliah::count();

        // Mengambil total absensi yang dibuat pada hari ini
        $totalAbsensiHariIni = Absensi::whereDate('created_at', Carbon::today())->count();

        // Mengirim data ke view
        return view('admin.dashboard', compact(
            'totalMahasiswa',
            'totalDosen',
            'totalMataKuliah',
            'totalAbsensiHariIni'
        ));
    }
}
