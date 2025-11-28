@extends('layouts.app')

@section('title', 'Input Absensi')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div>
            <h3 class="text-2xl font-bold mb-2">📋 Input Absensi</h3>
            <p class="text-slate-500 dark:text-slate-400">
                Silakan isi kehadiran mahasiswa sesuai jadwal yang Anda pilih.
            </p>
        </div>

        {{-- Error Alert --}}
        @if ($errors->any())
            <div
                class="p-4 rounded-xl bg-red-100/80 border border-red-300 text-red-800 dark:bg-red-700/40 dark:text-red-200 text-sm">
                <p class="font-semibold mb-1">Gagal menyimpan absensi.</p>
                <p class="mb-2 text-sm">Harap pastikan Anda sudah mengisi status untuk <strong>semua</strong> mahasiswa.</p>
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Info Jadwal --}}
        <div
            class="rounded-xl border border-slate-200 dark:border-slate-700 bg-gradient-to-r from-indigo-600 to-blue-600 text-white p-5 shadow-sm">
            <p class="font-semibold text-lg mb-1">{{ $jadwal->mataKuliah->nama_mk ?? 'N/A' }}</p>
            <p class="text-sm opacity-90">
                Kelas {{ $jadwal->kelas->nama_kelas ?? 'N/A' }} •
                {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y') }} •
                {{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} WIB
            </p>
        </div>

        {{-- Form --}}
        <form action="{{ route('dosen.input-absensi', ['id_jadwal' => $jadwal->id]) }}" method="POST" class="space-y-6">
            @csrf

            {{-- Tabel Mahasiswa --}}
            <div
                class="rounded-xl overflow-hidden shadow-sm bg-white/80 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700">
                <div class="bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-5 py-3 font-semibold">
                    Daftar Mahasiswa
                </div>

                <div class="overflow-x-auto w-full">
                    <table class="min-w-full text-sm text-left text-slate-700 dark:text-slate-300">
                        <thead class="bg-slate-100/70 dark:bg-slate-700/50 text-slate-800 dark:text-slate-100">
                            <tr>
                                <th class="px-4 py-3 w-12">#</th>
                                <th class="px-4 py-3">NIM</th>
                                <th class="px-4 py-3">Nama Mahasiswa</th>
                                <th class="px-4 py-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mahasiswas as $mhs)
                                <tr
                                    class="border-t border-slate-200/60 dark:border-slate-700/60 hover:bg-slate-50 dark:hover:bg-slate-700/40 transition">
                                    <td class="px-4 py-3 font-medium text-slate-800 dark:text-slate-100">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-3">{{ $mhs->nim }}</td>
                                    <td class="px-4 py-3">{{ $mhs->nama }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center flex-wrap gap-3">
                                            @foreach (['hadir' => 'Hadir', 'izin' => 'Izin', 'sakit' => 'Sakit', 'alfa' => 'Alpha'] as $value => $label)
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" name="status[{{ $mhs->nim }}]"
                                                        value="{{ $value }}"
                                                        id="{{ $value }}_{{ $mhs->nim }}"
                                                        class="text-indigo-600 border-slate-300 focus:ring-indigo-500"
                                                        required>
                                                    <span
                                                        class="text-slate-700 dark:text-slate-300 text-sm">{{ $label }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4"
                                        class="px-4 py-6 text-center text-slate-500 dark:text-slate-400 text-sm">
                                        Tidak ada mahasiswa terdaftar di kelas ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end items-center gap-3 pt-4 border-t border-slate-200 dark:border-slate-700">
                <a href="{{ route('dosen.jadwal-mengajar') }}"
                    class="px-4 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:border-slate-600 dark:hover:bg-slate-700 transition">
                    Batal
                </a>
                <button type="submit"
                    class="px-5 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-medium shadow-sm transition">
                    Simpan Absensi
                </button>
            </div>
        </form>
    </div>
@endsection
