@extends('layouts.app')

@section('title', 'Edit Jadwal Kuliah: ' . $jadwal->id)

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div>
            <h3 class="text-2xl font-bold mb-2">✏️ Edit Jadwal Kuliah</h3>
            <p class="text-slate-500 dark:text-slate-400">
                Perbarui data jadwal kuliah dengan mudah.
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
            <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Mata Kuliah --}}
                <div>
                    <label for="kode_mk" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Mata
                        Kuliah</label>
                    <select id="kode_mk" name="kode_mk" required
                        class="w-full p-2 rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 focus:ring-indigo-500 focus:border-indigo-500 transition mb-2">
                        <option value="">-- Pilih Mata Kuliah --</option>
                        @foreach ($mataKuliahs as $mk)
                            <option value="{{ $mk->kode_mk }}"
                                {{ old('kode_mk', $jadwal->mataKuliah->kode_mk ?? '') == $mk->kode_mk ? 'selected' : '' }}>
                                {{ $mk->nama_mk }} ({{ $mk->kode_mk }})
                            </option>
                        @endforeach
                    </select>
                    @error('kode_mk')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kelas --}}
                <div>
                    <label for="id_kelas"
                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Kelas</label>
                    <select id="id_kelas" name="id_kelas" required
                        class="w-full p-2 rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 focus:ring-indigo-500 focus:border-indigo-500 transition mb-2">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelas as $kls)
                            <option value="{{ $kls->id }}"
                                {{ old('id_kelas', $jadwal->id_kelas) == $kls->id ? 'selected' : '' }}>
                                {{ $kls->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_kelas')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Dosen --}}
                <div>
                    <label for="dosen_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Dosen
                        Pengajar</label>
                    <select id="dosen_id" name="dosen_id" required
                        class="w-full p-2 rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 focus:ring-indigo-500 focus:border-indigo-500 transition mb-2">
                        <option value="">-- Pilih Dosen --</option>
                        @foreach ($dosens as $dosen)
                            <option value="{{ $dosen->id }}"
                                {{ old('dosen_id', $jadwal->dosen->id ?? '') == $dosen->id ? 'selected' : '' }}>
                                {{ $dosen->nama }} (NIP: {{ $dosen->nip }})
                            </option>
                        @endforeach
                    </select>
                    @error('nip_dosen')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal --}}
                <div>
                    <label for="tanggal"
                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" required
                        value="{{ old('tanggal', $jadwal->tanggal) }}"
                        class="w-full p-2 rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 focus:ring-indigo-500 focus:border-indigo-500 transition mb-2">
                    @error('tanggal')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Waktu Mulai --}}
                <div>
                    <label for="waktu_mulai" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Waktu
                        Mulai</label>
                    <input type="time" id="waktu_mulai" name="waktu_mulai" required
                        value="{{ old('waktu_mulai', $jadwal->waktu_mulai) }}"
                        class="w-full p-2 rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 focus:ring-indigo-500 focus:border-indigo-500 transition mb-2">
                    @error('waktu_mulai')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="waktu_selesai"
                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Waktu
                        Selesai</label>
                    <input type="time" id="waktu_selesai" name="waktu_selesai" required
                        value="{{ old('waktu_selesai', $jadwal->waktu_selesai) }}"
                        class="w-full p-2 rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 focus:ring-indigo-500 focus:border-indigo-500 transition mb-2">
                    @error('waktu_selesai')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="flex gap-2">
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition">
                        Simpan Perubahan Jadwal
                    </button>
                    <a href="{{ route('admin.jadwal.index') }}"
                        class="px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-100 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-lg transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
