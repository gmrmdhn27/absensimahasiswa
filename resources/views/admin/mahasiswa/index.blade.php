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
                                    <form action="{{ route('admin.mahasiswa.destroy', $mhs->id) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('Yakin hapus {{ $mhs->nama }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 rounded-lg transition">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-slate-600 dark:text-slate-300">
                                    Data Mahasiswa tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $mahasiswas->links('pagination::tailwind') }}
        </div>
    </div>
@endsection
