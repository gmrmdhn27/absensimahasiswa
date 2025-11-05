@extends('layouts.app')

@section('title', 'Edit Mahasiswa: ' . $mahasiswa->nama)

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div>
            <h3 class="text-2xl font-bold mb-2">✏️ Edit Mahasiswa: {{ $mahasiswa->nama }}</h3>
            <p class="text-slate-500 dark:text-slate-400">
                Ubah data mahasiswa dengan teliti dan pastikan semua informasi benar.
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

        {{-- Form Edit --}}
        <div class="rounded-xl shadow-sm bg-white/80 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700">
            {{-- Header Form --}}
            <div class="bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-5 py-3 font-semibold rounded-t-xl">
                Formulir Edit Mahasiswa
            </div>

            <form action="{{ route('admin.mahasiswa.update', $mahasiswa->id) }}" method="POST" class="p-6 space-y-5">
                @csrf
                @method('PUT')

                {{-- NIM --}}
                <div>
                    <label for="nim"
                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">NIM</label>
                    <input type="text" id="nim" name="nim" value="{{ old('nim', $mahasiswa->nim) }}"
                        class="w-full p-2 rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        required>
                </div>

                {{-- Nama Lengkap --}}
                <div>
                    <label for="nama" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama
                        Lengkap</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $mahasiswa->nama) }}"
                        class="w-full p-2  rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        required>
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Email
                        (Login)</label>
                    <input type="email" id="email" name="email"
                        value="{{ old('email', $mahasiswa->user->email ?? '') }}"
                        class="w-full p-2  rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        required>
                </div>

                {{-- Password Baru --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Password
                        Baru (Opsional)</label>
                    <input type="password" id="password" name="password" placeholder="Min. 3 karakter"
                        class="w-full p-2  rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    <p class="text-xs text-slate-500 mt-1">Kosongkan jika tidak ingin mengubah password.</p>
                </div>

                <div>
                    <label for="id_kelas"
                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Kelas</label>
                    <select id="id_kelas" name="id_kelas"
                        class="w-full p-2 rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        required>
                        <option value="">Pilih Kelas</option>
                        {{-- Asumsi variable $kelas berisi daftar Kelas --}}
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}"
                                {{ old('id_kelas', $mahasiswa->kelasMahasiswa->id_kelas ?? '') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }} (ID: {{ $k->id }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="jurusan_id"
                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Jurusan</label>
                    <select id="jurusan_id" name="jurusan_id"
                        class="w-full p-2 rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        required>
                        <option value="">Pilih Jurusan</option>
                        {{-- Asumsi variable $jurusans berisi daftar Jurusan --}}
                        @foreach ($jurusans as $j)
                            <option value="{{ $j->id }}"
                                {{ old('jurusan_id', $mahasiswa->jurusan_id ?? '') == $j->id ? 'selected' : '' }}>
                                {{ $j->nama_jurusan }} (ID: {{ $j->id }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Angkatan --}}
                <div>
                    <label for="angkatan"
                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Angkatan</label>
                    <input type="number" id="angkatan" name="angkatan"
                        value="{{ old('angkatan', $mahasiswa->angkatan) }}"
                        class="w-full p-2  rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        required>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center gap-3 pt-4">
                    <button type="submit"
                        class="px-5 py-2 text-sm font-medium text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 rounded-lg shadow-sm transition">
                        💾 Perbarui Data
                    </button>
                    <a href="{{ route('admin.mahasiswa.index') }}"
                        class="px-5 py-2 text-sm font-medium text-slate-700 bg-slate-200 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 dark:text-slate-100 rounded-lg transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
