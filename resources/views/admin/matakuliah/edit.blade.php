@extends('layouts.app')

@section('title', 'Edit Mata Kuliah: ' . $mataKuliah->nama_mk)

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div>
            <h3 class="text-2xl font-bold mb-2">✏️ Edit Mata Kuliah: {{ $mataKuliah->nama_mk }}</h3>
            <p class="text-slate-500 dark:text-slate-400">
                Perbarui data mata kuliah dengan mudah.
            </p>
        </div>

        {{-- Notifikasi Error --}}
        @if ($errors->any())
            <div
                class="p-4 rounded-xl bg-red-100/80 border border-red-300 text-red-800 dark:bg-red-700/40 dark:text-red-100 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <div
            class="rounded-xl overflow-hidden shadow-sm bg-white/80 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 p-6">
            <form action="{{ route('admin.matakuliah.update', $mataKuliah->kode_mk) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Kode Mata Kuliah --}}
                <div>
                    <label for="kode_mk" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Kode Mata
                        Kuliah</label>
                    <input type="text" id="kode_mk" name="kode_mk" required
                        value="{{ old('kode_mk', $mataKuliah->kode_mk) }}"
                        class="w-full p-2 rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 focus:ring-indigo-500 focus:border-indigo-500 transition mb-2">
                    @error('kode_mk')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nama Mata Kuliah --}}
                <div>
                    <label for="nama_mk" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama
                        Mata Kuliah</label>
                    <input type="text" id="nama_mk" name="nama_mk" required
                        value="{{ old('nama_mk', $mataKuliah->nama_mk) }}"
                        class="w-full p-2 rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 focus:ring-indigo-500 focus:border-indigo-500 transition mb-2">
                    @error('nama_mk')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- SKS --}}
                <div>
                    <label for="sks"
                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">SKS</label>
                    <input type="number" id="sks" name="sks" min="1" max="6" required
                        value="{{ old('sks', $mataKuliah->sks) }}"
                        class="w-full p-2 rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 focus:ring-indigo-500 focus:border-indigo-500 transition mb-2">
                    @error('sks')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="flex gap-2">
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.matakuliah.index') }}"
                        class="px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-100 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-lg transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
