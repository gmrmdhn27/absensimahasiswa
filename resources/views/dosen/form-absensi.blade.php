@extends('layouts.app')

@section('title', 'Input Absensi')

@section('content')
    <div class="page-wrapper space-y-6">
        {{-- Header --}}
        <div>
            <h3 class="text-2xl font-bold mb-2">📋 Input Absensi</h3>
            <p class="text-slate-500 dark:text-slate-400">
                Silakan isi kehadiran mahasiswa sesuai jadwal yang Anda pilih.
            </p>
        </div>

        {{-- Error Alert --}}
        @if ($errors->any())
            <div
                class="p-4 rounded-xl bg-red-100/80 border border-red-300 text-red-800 dark:bg-red-700/40 dark:text-red-200 text-sm">
                <p class="font-semibold mb-1">Gagal menyimpan absensi.</p>
                <p class="mb-2 text-sm">Harap pastikan Anda sudah mengisi status untuk <strong>semua</strong> mahasiswa.</p>
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Info Jadwal --}}
        <div
            class="rounded-xl border border-slate-200 dark:border-slate-700 bg-gradient-to-r from-indigo-600 to-blue-600 text-white p-5 shadow-sm">
            <p class="font-semibold text-lg mb-1">{{ $jadwal->mataKuliah->nama_mk ?? 'N/A' }}</p>
            <p class="text-sm opacity-90">
                Kelas {{ $jadwal->kelas->nama_kelas ?? 'N/A' }} •
                {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y') }} •
                {{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} WIB
            </p>
        </div>

        {{-- Form --}}
        <form action="{{ route('dosen.input-absensi', ['id_jadwal' => $jadwal->id]) }}" method="POST" class="space-y-6">
            @csrf

            {{-- Tabel Mahasiswa --}}
            <div
                class="rounded-xl overflow-hidden shadow-sm bg-white/80 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700">
                <div
                    class="bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-5 py-3 font-semibold flex justify-between items-center">
                    <span>Daftar Mahasiswa</span>
                    <a href="#" id="select-all-hadir"
                        class="px-3 py-1 text-xs font-medium bg-white/20 hover:bg-white/30 rounded-md transition">
                        Pilih Semua Hadir
                    </a>
                </div>

                <div class="overflow-x-auto w-full">
                    <table class="min-w-full text-sm text-left text-slate-700 dark:text-slate-300">
                        <thead class="bg-slate-100/70 dark:bg-slate-700/50 text-slate-800 dark:text-slate-100">
                            <tr>
                                <th class="px-4 py-3 w-12">#</th>
                                <th class="px-4 py-3">NIM</th>
                                <th class="px-4 py-3">Nama Mahasiswa</th>
                                <th class="px-4 py-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mahasiswas as $mhs)
                                <tr
                                    class="border-t border-slate-200/60 dark:border-slate-700/60 hover:bg-slate-50 dark:hover:bg-slate-700/40 transition">
                                    <td class="px-4 py-3 font-medium text-slate-800 dark:text-slate-100">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-3">{{ $mhs->nim }}</td>
                                    <td class="px-4 py-3">{{ $mhs->nama }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center flex-wrap gap-3">
                                            @foreach (['hadir' => 'Hadir', 'izin' => 'Izin', 'sakit' => 'Sakit', 'alfa' => 'Alpha'] as $value => $label)
                                                <label class="flex items-center gap-2 cursor-pointer">
                                                    <input type="radio" name="status[{{ $mhs->nim }}]"
                                                        value="{{ $value }}"
                                                        id="{{ $value }}_{{ $mhs->nim }}" class="hidden peer"
                                                        required>

                                                    <span class="custom-radio"></span>

                                                    <span class="text-slate-700 dark:text-slate-300 text-sm">
                                                        {{ $label }}
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4"
                                        class="px-4 py-6 text-center text-slate-500 dark:text-slate-400 text-sm">
                                        Tidak ada mahasiswa terdaftar di kelas ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end items-center gap-3 pt-4 border-t border-slate-200 dark:border-slate-700">
                <a href="{{ route('dosen.jadwal-mengajar') }}"
                    class="px-4 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:border-slate-600 dark:hover:bg-slate-700 transition">
                    Batal
                </a>
                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();"
                    class="px-5 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-medium shadow-sm transition">
                    Simpan Absensi
                </a>
            </div>
        </form>
    </div>
@endsection

<style>
    /* ==== Custom Radio Button Modern ==== */
    .custom-radio {
        position: relative;
        width: 18px;
        height: 18px;
        border-radius: 6px;
        border: 2px solid #cbd5e1;
        /* slate-300 */
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.25s ease;
    }

    .custom-radio:hover {
        border-color: #6366f1;
        /* indigo-500 */
    }

    .custom-radio::after {
        content: "";
        width: 10px;
        height: 10px;
        background: #6366f1;
        border-radius: 4px;
        transform: scale(0);
        transition: 0.2s ease;
    }

    input[type="radio"]:checked+.custom-radio {
        border-color: #6366f1;
        background: #eef2ff;
        /* indigo-50 */
    }

    input[type="radio"]:checked+.custom-radio::after {
        transform: scale(1);
    }
</style>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllHadirBtn = document.getElementById('select-all-hadir');

            if (selectAllHadirBtn) {
                selectAllHadirBtn.addEventListener('click', function(event) {
                    event.preventDefault(); // Mencegah link berpindah halaman

                    // Dapatkan semua radio button dengan nilai 'hadir'
                    const hadirRadioButtons = document.querySelectorAll(
                        'input[type="radio"][value="hadir"]');

                    // Centang setiap radio button 'hadir'
                    hadirRadioButtons.forEach(radio => {
                        radio.checked = true;
                    });
                });
            }
        });
    </script>
@endpush
