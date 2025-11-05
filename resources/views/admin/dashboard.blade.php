@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="space-y-8">
        {{-- Header --}}
        <div>
            <h3 class="text-2xl font-bold mb-2">👋 Selamat Datang, Administrator!</h3>
            <p class="text-slate-500 dark:text-slate-400">
                Ringkasan cepat sistem absensi mahasiswa dan aktivitas terbaru.
            </p>
        </div>

        {{-- Statistik Kartu --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Total Mahasiswa --}}
            <div
                class="rounded-xl shadow-sm bg-gradient-to-br from-indigo-600 to-blue-600 text-white p-5 flex items-center justify-between transition hover:shadow-md">
                <div>
                    <p class="text-sm font-medium text-indigo-100 uppercase">Total Mahasiswa</p>
                    <h4 class="text-3xl font-bold mt-1">{{ $totalMahasiswa }}</h4>
                </div>
                <div class="opacity-80">
                    <i class="fas fa-users fa-3x"></i>
                </div>
            </div>

            {{-- Total Dosen --}}
            <div
                class="rounded-xl shadow-sm bg-gradient-to-br from-green-600 to-emerald-600 text-white p-5 flex items-center justify-between transition hover:shadow-md">
                <div>
                    <p class="text-sm font-medium text-emerald-100 uppercase">Total Dosen</p>
                    <h4 class="text-3xl font-bold mt-1">{{ $totalDosen }}</h4>
                </div>
                <div class="opacity-80">
                    <i class="fas fa-user-tie fa-3x"></i>
                </div>
            </div>

            {{-- Total Mata Kuliah --}}
            <div
                class="rounded-xl shadow-sm bg-gradient-to-br from-sky-500 to-cyan-500 text-white p-5 flex items-center justify-between transition hover:shadow-md">
                <div>
                    <p class="text-sm font-medium text-cyan-100 uppercase">Total Mata Kuliah</p>
                    <h4 class="text-3xl font-bold mt-1">{{ $totalMataKuliah }}</h4>
                </div>
                <div class="opacity-80">
                    <i class="fas fa-book fa-3x"></i>
                </div>
            </div>

            {{-- Total Absensi Hari Ini --}}
            <div
                class="rounded-xl shadow-sm bg-gradient-to-br from-amber-500 to-yellow-500 text-slate-800 p-5 flex items-center justify-between transition hover:shadow-md">
                <div>
                    <p class="text-sm font-medium text-slate-700 uppercase">Absensi Hari Ini</p>
                    <h4 class="text-3xl font-bold mt-1">{{ $totalAbsensiHariIni }}</h4>
                </div>
                <div class="text-slate-700 opacity-80">
                    <i class="fas fa-check-circle fa-3x"></i>
                </div>
            </div>
        </div>

        {{-- Info Tambahan --}}
        <div
            class="rounded-xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-800/60 p-6 shadow-sm">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-3">
                🧾 Informasi Sistem
            </h4>
            <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
                Sistem ini dirancang untuk membantu pengelolaan absensi mahasiswa secara digital.
                Administrator dapat mengelola data dosen, mahasiswa, mata kuliah, serta memantau absensi harian.
            </p>
        </div>
    </div>
@endsection
