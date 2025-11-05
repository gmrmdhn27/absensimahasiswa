@extends('layouts.app')

@section('title', 'Tambah Dosen')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div>
            <h3 class="text-2xl font-bold mb-2">➕ Tambah Dosen Baru</h3>
            <p class="text-slate-500 dark:text-slate-400">
                Isi formulir berikut untuk menambahkan dosen baru ke sistem.
            </p>
        </div>

        {{-- Validasi Error --}}
        @if ($errors->any())
            <div
                class="p-4 rounded-xl bg-red-100/80 border border-red-300 text-red-800 dark:bg-red-700/40 dark:text-red-100 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Tambah Dosen --}}
        <div class="rounded-xl bg-white/80 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 shadow-sm p-6">
            <form action="{{ route('admin.dosen.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="nip"
                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">NIP</label>
                    <input type="text" id="nip" name="nip" value="{{ old('nip') }}" required
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 focus:ring-2 focus:ring-indigo-500 dark:bg-slate-900 dark:text-slate-100 transition">
                </div>

                <div>
                    <label for="nama" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                        Nama Lengkap
                    </label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 focus:ring-2 focus:ring-indigo-500 dark:bg-slate-900 dark:text-slate-100 transition">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                        Email (Login)
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 focus:ring-2 focus:ring-indigo-500 dark:bg-slate-900 dark:text-slate-100 transition">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                        Password (Min. 6 karakter)
                    </label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 focus:ring-2 focus:ring-indigo-500 dark:bg-slate-900 dark:text-slate-100 transition">
                </div>

                <div>
                    <label for="departemen" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                        Departemen / Fakultas
                    </label>
                    <input type="text" id="departemen" name="departemen" value="{{ old('departemen') }}" required
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 focus:ring-2 focus:ring-indigo-500 dark:bg-slate-900 dark:text-slate-100 transition">
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex justify-end space-x-3 pt-4">
                    <a href="{{ route('admin.dosen.index') }}"
                        class="px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-200 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-lg transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 rounded-lg shadow-sm transition">
                        💾 Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
