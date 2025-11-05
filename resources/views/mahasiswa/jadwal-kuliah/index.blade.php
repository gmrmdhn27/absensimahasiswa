@extends('layouts.app')

@section('title', 'Jadwal Kuliah')

@section('content')
    <div class="space-y-6">
        <div>
            <h3 class="text-2xl font-bold mb-2">📅 Jadwal Kuliah Anda</h3>
            <p class="text-slate-500 dark:text-slate-400">
                Berikut adalah daftar jadwal kuliah Anda berdasarkan kelas dan mata kuliah yang diambil.
            </p>
        </div>

        {{-- Pesan Error jika Mahasiswa belum punya kelas --}}
        @if ($errors->any())
            <div
                class="p-4 rounded-xl bg-yellow-100/80 border border-yellow-300 text-yellow-800 dark:bg-yellow-700/40 dark:text-yellow-200 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Tampilkan jadwal --}}
        @if (isset($jadwalKuliah) && $jadwalKuliah->count() > 0)
            <div
                class="rounded-xl overflow-hidden shadow-sm bg-white/80 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700">

                {{-- Header tabel --}}
                <div class="bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-5 py-3 font-semibold">
                    Jadwal Kuliah
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-slate-700 dark:text-slate-300">
                        <thead class="bg-slate-100/70 dark:bg-slate-700/50 text-slate-800 dark:text-slate-100">
                            <tr>
                                <th class="px-4 py-3 w-12">#</th>
                                <th class="px-4 py-3">Mata Kuliah</th>
                                <th class="px-4 py-3">Dosen Pengampu</th>
                                <th class="px-4 py-3">Kelas</th>
                                <th class="px-4 py-3">Hari / Tanggal</th>
                                <th class="px-4 py-3">Waktu Mulai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwalKuliah as $jadwal)
                                <tr
                                    class="border-t border-slate-200/60 dark:border-slate-700/60 hover:bg-slate-50 dark:hover:bg-slate-700/40 transition">
                                    <td class="px-4 py-3 font-medium text-slate-800 dark:text-slate-100">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $jadwal->mataKuliah?->nama_mk ?? 'N/A' }}
                                        <span
                                            class="text-slate-500 text-xs">({{ $jadwal->mataKuliah?->kode_mk ?? '' }})</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $jadwal->dosen?->nama ?? 'Dosen Tidak Ditetapkan' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $jadwal->kelas?->nama_kelas ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d F Y') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} WIB
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @elseif (isset($jadwalKuliah) && $jadwalKuliah->isEmpty())
            <div
                class="p-6 text-center rounded-xl bg-white/80 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 shadow-sm">
                <p class="text-slate-600 dark:text-slate-300">
                    Tidak ada jadwal kuliah yang ditemukan untuk kelas Anda saat ini.
                </p>
            </div>
        @endif
    </div>
@endsection
