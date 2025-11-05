@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
    <div class="mb-10">
        <h2 class="text-3xl font-bold mb-2">
            Selamat Datang, {{ $mahasiswa->nama }}! 👋
        </h2>
        <p class="text-gray-600 dark:text-gray-400">
            Ini adalah ringkasan singkat informasi Anda. Gunakan menu di samping untuk melihat jadwal kuliah dan riwayat
            absensi.
        </p>
    </div>

    <div class="flex">
        <div class="w-full bg-white/70 dark:bg-slate-800/70 rounded-2xl shadow-lg overflow-hidden backdrop-blur">
            {{-- Header card --}}
            <div class="bg-gradient-to-r from-indigo-500 to-violet-600 px-6 py-3">
                <h5 class="text-white font-semibold text-lg">Informasi Akun</h5>
            </div>

            {{-- Body card --}}
            <div class="p-6">
                <table class="w-full text-left text-sm md:text-base">
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        <tr>
                            <th class="py-2 pr-4 text-slate-600 dark:text-slate-400 w-1/3 font-medium">NIM</th>
                            <td class="py-2 text-slate-900 dark:text-slate-100">: {{ $mahasiswa->nim }}</td>
                        </tr>
                        <tr>
                            <th class="py-2 pr-4 text-slate-600 dark:text-slate-400 font-medium">Nama Lengkap</th>
                            <td class="py-2 text-slate-900 dark:text-slate-100">: {{ $mahasiswa->nama }}</td>
                        </tr>
                        <tr>
                            <th class="py-2 pr-4 text-slate-600 dark:text-slate-400 font-medium">Email</th>
                            <td class="py-2 text-slate-900 dark:text-slate-100">: {{ $mahasiswa->user?->email ?? 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="py-2 pr-4 text-slate-600 dark:text-slate-400 font-medium">Jurusan / Prodi</th>
                            <td class="py-2 text-slate-900 dark:text-slate-100">:
                                {{ $mahasiswa->jurusan?->nama_jurusan ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="py-2 pr-4 text-slate-600 dark:text-slate-400 font-medium">Angkatan</th>
                            <td class="py-2 text-slate-900 dark:text-slate-100">: {{ $mahasiswa->angkatan }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
