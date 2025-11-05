@extends('layouts.app')

@section('title', 'Jadwal Mengajar')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div>
            <h3 class="text-2xl font-bold mb-2">🗓️ Jadwal Mengajar Anda</h3>
            <p class="text-slate-500 dark:text-slate-400">
                Berikut daftar jadwal mengajar yang telah Anda ampu.
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

        {{-- Tabel Jadwal --}}
        <div
            class="rounded-xl overflow-hidden shadow-sm bg-white/80 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700">
            <div class="bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-5 py-3 font-semibold">
                Jadwal Mengajar
            </div>

            <div class="overflow-x-auto w-full">
                <table class="min-w-full text-sm text-left text-slate-700 dark:text-slate-300">
                    <thead class="bg-slate-100/70 dark:bg-slate-700/50 text-slate-800 dark:text-slate-100">
                        <tr>
                            <th class="px-4 py-3 w-12">#</th>
                            <th class="px-4 py-3">Mata Kuliah</th>
                            <th class="px-4 py-3">Kelas</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Waktu Mulai</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jadwals as $jadwal)
                            <tr
                                class="border-t border-slate-200/60 dark:border-slate-700/60 hover:bg-slate-50 dark:hover:bg-slate-700/40 transition">
                                <td class="px-4 py-3 font-medium text-slate-800 dark:text-slate-100">
                                    {{ $loop->iteration + $jadwals->firstItem() - 1 }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $jadwal->mataKuliah->nama_mk ?? 'N/A' }}
                                    <span class="text-xs text-slate-500">
                                        ({{ $jadwal->mataKuliah->kode_mk ?? '' }})
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    {{ $jadwal->kelas->nama_kelas ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d F Y') }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} WIB
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('dosen.show_absensi_form', $jadwal->id) }}"
                                        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-3 py-2 rounded-lg transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Input Absensi
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-slate-500 dark:text-slate-400 text-sm">
                                    Anda tidak memiliki jadwal mengajar saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $jadwals->links() }}
        </div>
    </div>
@endsection
