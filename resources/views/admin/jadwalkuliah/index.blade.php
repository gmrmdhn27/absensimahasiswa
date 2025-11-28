@extends('layouts.app')

@section('title', 'Manajemen Jadwal Kuliah')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div>
            <h3 class="text-2xl font-bold mb-2">🗓️ Daftar Jadwal Kuliah</h3>
            <p class="text-slate-500 dark:text-slate-400">
                Kelola jadwal kuliah dengan mudah dan efisien.
            </p>
        </div>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div
                class="p-4 rounded-xl bg-green-100/80 border border-green-300 text-green-800 dark:bg-green-700/40 dark:text-green-100 text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div
                class="p-4 rounded-xl bg-red-100/80 border border-red-300 text-red-800 dark:bg-red-700/40 dark:text-red-100 text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Tombol Tambah --}}
        <div class="flex justify-start mb-3">
            <a href="{{ route('admin.jadwal.create') }}"
                class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 rounded-lg shadow-sm transition">
                + Tambah Jadwal
            </a>
        </div>

        {{-- Tabel Jadwal --}}
        <div
            class="rounded-xl overflow-hidden shadow-sm bg-white/80 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700">
            {{-- Header tabel --}}
            <div class="bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-5 py-3 font-semibold">
                Daftar Jadwal Kuliah
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-slate-700 dark:text-slate-300">
                    <thead class="bg-slate-100/70 dark:bg-slate-700/50 text-slate-800 dark:text-slate-100">
                        <tr>
                            <th class="px-4 py-3 w-12">#</th>
                            <th class="px-4 py-3">Mata Kuliah</th>
                            <th class="px-4 py-3">Kelas</th>
                            <th class="px-4 py-3">Dosen Pengajar</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Mulai</th>
                            <th class="px-4 py-3">Selesai</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jadwalKuliahs as $jadwal)
                            <tr
                                class="border-t border-slate-200/60 dark:border-slate-700/60 hover:bg-slate-50 dark:hover:bg-slate-700/40 transition">
                                <td class="px-4 py-3 font-medium text-slate-800 dark:text-slate-100">
                                    {{ $loop->iteration + $jadwalKuliahs->firstItem() - 1 }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $jadwal->mataKuliah->nama_mk ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3">{{ $jadwal->kelas->nama_kelas ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $jadwal->dosen->nama ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $jadwal->tanggal }}</td>
                                <td class="px-4 py-3">{{ $jadwal->waktu_mulai }}</td>
                                <td class="px-4 py-3">{{ $jadwal->waktu_selesai }}</td>
                                <td class="px-4 py-3 text-center space-x-2">
                                    <a href="{{ route('admin.jadwal.edit', $jadwal->id) }}"
                                        class="inline-block px-3 py-1 text-sm font-medium text-white bg-amber-500 hover:bg-amber-600 rounded-lg transition">
                                        Edit
                                    </a>
                                    <button type="button"
                                        class="open-delete-modal px-3 py-1 text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 rounded-lg transition"
                                        data-url="{{ route('admin.jadwal.destroy', $jadwal->id) }}"
                                        data-name="Jadwal {{ $jadwal->mataKuliah->nama_mk ?? 'N/A' }} kelas {{ $jadwal->kelas->nama_kelas ?? 'N/A' }}">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-slate-600 dark:text-slate-300">
                                    Belum ada Jadwal Kuliah.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $jadwalKuliahs->links('pagination::tailwind') }}
        </div>
    </div>
@endsection
