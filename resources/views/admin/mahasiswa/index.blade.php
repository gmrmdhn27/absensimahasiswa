@extends('layouts.app')

@section('title', 'Manajemen Mahasiswa')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div>
            <h3 class="text-2xl font-bold mb-2">👨‍🎓 Daftar Mahasiswa</h3>
            <p class="text-slate-500 dark:text-slate-400">
                Kelola data mahasiswa secara efisien dan cepat.
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

        {{-- Form Filter dan Pencarian --}}
        <div class="p-4 rounded-xl bg-white/80 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700">
            <form action="{{ route('admin.mahasiswa.index') }}" method="GET"
                class="flex flex-col sm:flex-row items-end gap-4">
                {{-- Input Pencarian --}}
                <div class="w-full sm:flex-1">
                    <label for="search" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                        Cari Mahasiswa (Nama/NIM)
                    </label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Masukkan Nama atau NIM..."
                        class="block w-full px-3 py-2 bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                {{-- Filter Jurusan --}}
                <div class="w-full sm:flex-1">
                    <label for="jurusan" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                        Filter Berdasarkan Jurusan
                    </label>
                    <select id="jurusan" name="jurusan"
                        class="block w-full px-3 py-2 bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Semua Jurusan</option>
                        @foreach ($jurusans as $jurusan)
                            <option value="{{ $jurusan->id }}" {{ request('jurusan') == $jurusan->id ? 'selected' : '' }}>
                                {{ $jurusan->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center gap-2">
                    <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Filter</button>
                    <a href="{{ route('admin.mahasiswa.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2 border border-slate-300 dark:border-slate-600 text-sm font-medium rounded-md shadow-sm text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-700 hover:bg-slate-50 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Reset</a>
                </div>
            </form>
        </div>

        {{-- Tombol Tambah --}}
        <div class="flex justify-between items-center">
            <a href="{{ route('admin.mahasiswa.create') }}"
                class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 rounded-lg shadow-sm transition">
                + Tambah Mahasiswa
            </a>
        </div>

        {{-- Tabel Mahasiswa --}}
        <div
            class="rounded-xl overflow-hidden shadow-sm bg-white/80 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700">
            {{-- Header tabel --}}
            <div class="bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-5 py-3 font-semibold">
                Daftar Mahasiswa
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-slate-700 dark:text-slate-300">
                    <thead class="bg-slate-100/70 dark:bg-slate-700/50 text-slate-800 dark:text-slate-100">
                        <tr>
                            <th class="px-4 py-3 w-12">#</th>
                            <th class="px-4 py-3">NIM</th>
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Angkatan</th>
                            <th class="px-4 py-3">Jurusan / Prodi</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mahasiswas as $mhs)
                            <tr
                                class="border-t border-slate-200/60 dark:border-slate-700/60 hover:bg-slate-50 dark:hover:bg-slate-700/40 transition">
                                <td class="px-4 py-3 font-medium text-slate-800 dark:text-slate-100">
                                    {{ $loop->iteration + $mahasiswas->firstItem() - 1 }}
                                </td>
                                <td class="px-4 py-3 font-medium text-slate-800 dark:text-slate-100">{{ $mhs->nim }}
                                </td>
                                <td class="px-4 py-3">{{ $mhs->nama }}</td>
                                <td class="px-4 py-3">{{ $mhs->user?->email ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $mhs->angkatan }}</td>
                                <td class="px-4 py-3">{{ $mhs->jurusan?->nama_jurusan ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-center space-x-2">
                                    <a href="{{ route('admin.mahasiswa.edit', $mhs->id) }}"
                                        class="inline-block px-3 py-1 text-sm font-medium text-white bg-amber-500 hover:bg-amber-600 rounded-lg transition">
                                        Edit
                                    </a>
                                    <button type="button"
                                        class="open-delete-modal px-3 py-1 text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 rounded-lg transition"
                                        data-url="{{ route('admin.mahasiswa.destroy', $mhs->id) }}"
                                        data-name="{{ $mhs->nama }}">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-slate-600 dark:text-slate-300">
                                    @if (request()->has('search') || request()->has('jurusan'))
                                        Data mahasiswa tidak ditemukan dengan kriteria pencarian Anda.
                                    @else
                                        Belum ada data mahasiswa.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $mahasiswas->links('vendor.pagination.custom') }}
        </div>
    </div>
@endsection
