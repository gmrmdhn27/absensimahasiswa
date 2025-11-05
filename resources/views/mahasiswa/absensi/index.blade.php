@extends('layouts.app')

@section('title', 'Riwayat Absensi')

@section('content')
    <div class="space-y-6">
        <div>
            <h3 class="text-2xl font-bold mb-2">✅ Riwayat Absensi {{ $mahasiswa->nama }}</h3>
            <p class="text-slate-500 dark:text-slate-400">
                Berikut adalah daftar riwayat absensi Anda selama perkuliahan berlangsung.
            </p>
        </div>

        {{-- Jika tidak ada riwayat --}}
        @if ($riwayatAbsensi->isEmpty())
            <div
                class="p-6 text-center rounded-xl bg-white/80 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 shadow-sm">
                <p class="text-slate-600 dark:text-slate-300">Anda belum memiliki riwayat absensi.</p>
            </div>
        @else
            {{-- Card tabel --}}
            <div
                class="rounded-xl overflow-hidden shadow-sm bg-white/80 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700">
                <div class="bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-5 py-3 font-semibold">
                    Riwayat Absensi
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-slate-700 dark:text-slate-300">
                        <thead class="bg-slate-100/70 dark:bg-slate-700/50 text-slate-800 dark:text-slate-100">
                            <tr>
                                <th class="px-4 py-3 w-12">#</th>
                                <th class="px-4 py-3">Mata Kuliah</th>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Waktu</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($riwayatAbsensi as $absensi)
                                <tr
                                    class="border-t border-slate-200/60 dark:border-slate-700/60 hover:bg-slate-50 dark:hover:bg-slate-700/40 transition">
                                    <td class="px-4 py-3 font-medium text-slate-800 dark:text-slate-100">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $absensi->jadwal?->mataKuliah?->nama_mk ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($absensi->jadwal && $absensi->jadwal?->tanggal)
                                            {{ \Carbon\Carbon::parse($absensi->jadwal?->tanggal)->translatedFormat('d F Y') }}
                                        @else
                                            <span class="text-slate-400 italic">Tanggal Tidak Tersedia</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $absensi->jadwal?->waktu_mulai ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $status = $absensi->status_kehadiran ?? 'N/A';
                                            $statusClass = match (strtolower($status)) {
                                                'hadir'
                                                    => 'bg-green-100 text-green-700 dark:bg-green-700/40 dark:text-green-200',
                                                'izin'
                                                    => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-700/40 dark:text-yellow-200',
                                                'alfa'
                                                    => 'bg-red-100 text-red-700 dark:bg-red-700/40 dark:text-red-200',
                                                default
                                                    => 'bg-slate-100 text-slate-600 dark:bg-slate-700/40 dark:text-slate-300',
                                            };
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="p-4 border-t border-slate-200 dark:border-slate-700">
                    {{ $riwayatAbsensi->links('pagination::tailwind') }}
                </div>
            </div>
        @endif
    </div>
@endsection
