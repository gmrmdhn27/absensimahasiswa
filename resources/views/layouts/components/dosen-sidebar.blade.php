<div class="px-2">
    <h4 class="text-sm uppercase tracking-wide text-slate-500 dark:text-slate-400 mb-3">Dosen Panel</h4>
    <ul class="space-y-1">
        <li><a href="{{ route('dosen.dashboard') }}"
                class="flex items-center gap-2 px-3 py-2 rounded-md text-sm hover:bg-slate-100 dark:hover:bg-slate-700 {{ request()->routeIs('dosen.dashboard') ? 'bg-slate-100 dark:bg-slate-700 font-semibold' : '' }}">🏠
                <span>Dashboard</span></a></li>
        <li><a href="{{ route('dosen.jadwal_mengajar') }}"
                class="flex items-center gap-2 px-3 py-2 rounded-md text-sm hover:bg-slate-100 dark:hover:bg-slate-700 {{ request()->routeIs('dosen.jadwal_mengajar') ? 'bg-slate-100 dark:bg-slate-700 font-semibold' : '' }}">📅
                <span>Jadwal & Absensi</span></a></li>
    </ul>
</div>
