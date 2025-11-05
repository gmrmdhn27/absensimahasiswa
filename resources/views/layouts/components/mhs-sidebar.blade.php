<div class="px-2">
    <h4 class="text-sm uppercase tracking-wide text-slate-500 dark:text-slate-400 mb-3">Mahasiswa Panel</h4>
    <ul class="space-y-1">
        <li><a href="{{ route('mahasiswa.dashboard') }}"
                class="flex items-center gap-2 px-3 py-2 rounded-md text-sm hover:bg-slate-100 dark:hover:bg-slate-700 {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-slate-100 dark:bg-slate-700 font-semibold' : '' }}">🏠
                <span>Dashboard</span></a></li>
        <li><a href="{{ route('mahasiswa.lihat_absensi') }}"
                class="flex items-center gap-2 px-3 py-2 rounded-md text-sm hover:bg-slate-100 dark:hover:bg-slate-700 {{ request()->routeIs('mahasiswa.lihat_absensi') ? 'bg-slate-100 dark:bg-slate-700 font-semibold' : '' }}">📜
                <span>Lihat Absensi</span></a></li>
        <li><a href="{{ route('mahasiswa.jadwal_kuliah') }}"
                class="flex items-center gap-2 px-3 py-2 rounded-md text-sm hover:bg-slate-100 dark:hover:bg-slate-700 {{ request()->routeIs('mahasiswa.jadwal_kuliah') ? 'bg-slate-100 dark:bg-slate-700 font-semibold' : '' }}">🗓️
                <span>Jadwal Kuliah</span></a></li>
    </ul>
</div>
