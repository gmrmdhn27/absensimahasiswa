@extends('layouts.app')

@section('title', 'Manajemen Mata Kuliah')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div>
            <h3 class="text-2xl font-bold mb-2">📚 Daftar Mata Kuliah</h3>
            <p class="text-slate-500 dark:text-slate-400">
                Kelola data mata kuliah dengan mudah dan efisien.
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
            <a href="{{ route('admin.matakuliah.create') }}"
                class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 rounded-lg shadow-sm transition">
                + Tambah Mata Kuliah
            </a>

            <form action="{{ route('admin.matakuliah.index') }}" method="GET" class="flex gap-2 w-full sm:w-auto">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Kode atau Nama MK..."
                    class="w-full sm:w-64 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/90 dark:bg-slate-800/60 text-slate-700 dark:text-slate-200 px-3 py-2 text-sm outline-none transition">
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-100 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-lg transition">
                    Cari
                </button>
            </form>
        </div>

        {{-- Tabel Mata Kuliah --}}
        <div
            class="rounded-xl overflow-hidden shadow-sm bg-white/80 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700">
            {{-- Header tabel --}}
            <div class="bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-5 py-3 font-semibold">
                Daftar Mata Kuliah
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-slate-700 dark:text-slate-300">
                    <thead class="bg-slate-100/70 dark:bg-slate-700/50 text-slate-800 dark:text-slate-100">
                        <tr>
                            <th class="px-4 py-3 w-12">#</th>
                            <th class="px-4 py-3">Kode MK</th>
                            <th class="px-4 py-3">Nama Mata Kuliah</th>
                            <th class="px-4 py-3">SKS</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mataKuliahs as $mk)
                            <tr
                                class="border-t border-slate-200/60 dark:border-slate-700/60 hover:bg-slate-50 dark:hover:bg-slate-700/40 transition">
                                <td class="px-4 py-3 font-medium text-slate-800 dark:text-slate-100">
                                    {{ $loop->iteration + $mataKuliahs->firstItem() - 1 }}
                                </td>
                                <td class="px-4 py-3 font-medium text-slate-800 dark:text-slate-100">
                                    {{ $mk->kode_mk }}
                                </td>
                                <td class="px-4 py-3">{{ $mk->nama_mk }}</td>
                                <td class="px-4 py-3 text-center">{{ $mk->sks }}</td>
                                <td class="px-4 py-3 text-center space-x-2">
                                    <a href="{{ route('admin.matakuliah.edit', $mk->kode_mk) }}"
                                        class="inline-block px-3 py-1 text-sm font-medium text-white bg-amber-500 hover:bg-amber-600 rounded-lg transition">
                                        Edit
                                    </a>
                                    <button type="button"
                                        class="open-delete-modal px-3 py-1 text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 rounded-lg transition"
                                        data-url="{{ route('admin.matakuliah.destroy', $mk->kode_mk) }}"
                                        data-name="{{ $mk->nama_mk }} ({{ $mk->kode_mk }})">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-slate-600 dark:text-slate-300">
                                    Data Mata Kuliah tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $mataKuliahs->links('vendor.pagination.custom') }}
        </div>
    </div>
@endsection
