@extends('layouts.app')

@section('title', 'Manajemen Dosen')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div>
            <h3 class="text-2xl font-bold mb-2">👥 Daftar Dosen</h3>
            <p class="text-slate-500 dark:text-slate-400">
                Kelola data dosen dengan mudah dan efisien.
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

        {{-- Tombol Tambah & Pencarian --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <a href="{{ route('admin.dosen.create') }}"
                class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 rounded-lg shadow-sm transition">
                + Tambah Dosen
            </a>

            <form action="{{ route('admin.dosen.index') }}" method="GET" class="flex gap-2 w-full sm:w-auto">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari Nama / NIP / Email..."
                    class="w-full sm:w-64 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/90 dark:bg-slate-800/60 text-slate-700 dark:text-slate-200 px-3 py-2 text-sm outline-none transition">
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-100 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-lg transition">
                    Cari
                </button>
            </form>
        </div>

        {{-- Tabel Dosen --}}
        <div
            class="rounded-xl overflow-hidden shadow-sm bg-white/80 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700">
            {{-- Header tabel --}}
            <div class="bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-5 py-3 font-semibold">
                Daftar Dosen
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-slate-700 dark:text-slate-300">
                    <thead class="bg-slate-100/70 dark:bg-slate-700/50 text-slate-800 dark:text-slate-100">
                        <tr>
                            <th class="px-4 py-3 w-12">#</th>
                            <th class="px-4 py-3">NIP</th>
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Departemen</th>
                            <th class="px-4 py-3 text-center">Jumlah Jadwal</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dosens as $dosen)
                            <tr
                                class="border-t border-slate-200/60 dark:border-slate-700/60 hover:bg-slate-50 dark:hover:bg-slate-700/40 transition">
                                <td class="px-4 py-3 font-medium text-slate-800 dark:text-slate-100">
                                    {{ $loop->iteration + $dosens->firstItem() - 1 }}
                                </td>
                                <td class="px-4 py-3 font-medium text-slate-800 dark:text-slate-100">
                                    {{ $dosen->nip }}
                                </td>
                                <td class="px-4 py-3">{{ $dosen->nama }}</td>
                                <td class="px-4 py-3">{{ $dosen->user->email ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $dosen->departemen ?? '-' }}</td>
                                <td class="px-4 py-3 text-center">{{ $dosen->jadwalKuliahs->count() }}</td>
                                <td class="px-4 py-3 text-center space-x-2">
                                    <a href="{{ route('admin.dosen.edit', $dosen->id) }}"
                                        class="inline-block px-3 py-1 text-sm font-medium text-white bg-amber-500 hover:bg-amber-600 rounded-lg transition">
                                        Edit
                                    </a>
                                    <button type="button"
                                        class="open-delete-modal px-3 py-1 text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 rounded-lg transition"
                                        data-url="{{ route('admin.dosen.destroy', $dosen->id) }}"
                                        data-name="{{ $dosen->nama }}">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-slate-600 dark:text-slate-300">
                                    Data Dosen tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $dosens->links('vendor.pagination.custom') }}
        </div>
    </div>
@endsection
