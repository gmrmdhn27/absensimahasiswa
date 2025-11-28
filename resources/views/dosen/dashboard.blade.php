@extends('layouts.app')

@section('title', 'Dashboard Dosen')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div>
            <h3 class="text-2xl font-bold mb-1">Selamat Datang, {{ $dosen->nama }}! 👋</h3>
            <p class="text-slate-500 dark:text-slate-400">
                Ringkasan cepat kegiatan mengajar Anda.
            </p>
        </div>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div
                class="p-4 rounded-xl bg-green-100/80 border border-green-300 text-green-800 dark:bg-green-700/40 dark:text-green-200 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div
                class="p-4 rounded-xl bg-red-100/80 border border-red-300 text-red-800 dark:bg-red-700/40 dark:text-red-200 text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Kartu Statistik --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Total Jadwal Diampu --}}
            <div
                class="bg-gradient-to-br from-indigo-500 to-violet-600 text-white p-6 rounded-2xl shadow-sm hover:shadow-md transition transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium opacity-90">Total Jadwal Diampu</p>
                        <h4 class="text-2xl font-semibold mt-1">{{ $totalJadwal }} Mata Kuliah</h4>
                    </div>
                    <div class="text-white/70">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Jadwal Hari Ini --}}
            <div
                class="bg-gradient-to-br from-sky-500 to-cyan-500 text-white p-6 rounded-2xl shadow-sm hover:shadow-md transition transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium opacity-90">Jadwal Hari Ini</p>
                        <h4 class="text-2xl font-semibold mt-1">{{ $jadwalHariIni }} Sesi</h4>
                    </div>
                    <div class="text-white/70">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Lihat Detail Jadwal --}}
            <a href="{{ route('dosen.jadwal-mengajar') }}"
                class="block bg-gradient-to-br from-emerald-500 to-green-500 text-white p-6 rounded-2xl shadow-sm hover:shadow-md transition transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium opacity-90">Lihat Detail</p>
                        <h4 class="text-2xl font-semibold mt-1">Jadwal Mengajar</h4>
                    </div>
                    <div class="text-white/70">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
