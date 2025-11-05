<div class="px-2">
    <h4 class="text-sm uppercase tracking-wide text-slate-500 dark:text-slate-400 mb-3">Admin Panel</h4>
    <ul class="space-y-1">
        <li>
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-2 px-3 py-2 rounded-md text-sm hover:bg-slate-100 dark:hover:bg-slate-700 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-100 dark:bg-slate-700 font-semibold' : '' }}">📊
                <span>Dashboard</span></a>
        </li>
        <li>
            <a href="{{ route('admin.mahasiswa.index') }}"
                class="flex items-center gap-2 px-3 py-2 rounded-md text-sm hover:bg-slate-100 dark:hover:bg-slate-700 {{ request()->routeIs('admin.mahasiswa.*') ? 'bg-slate-100 dark:bg-slate-700 font-semibold' : '' }}">👨‍🎓
                <span>Mahasiswa</span></a>
        </li>
        <li>
            <a href="{{ route('admin.dosen.index') }}"
                class="flex items-center gap-2 px-3 py-2 rounded-md text-sm hover:bg-slate-100 dark:hover:bg-slate-700 {{ request()->routeIs('admin.dosen.*') ? 'bg-slate-100 dark:bg-slate-700 font-semibold' : '' }}">👥
                <span>Dosen</span></a>
        </li>
        <li>
            <a href="{{ route('admin.matakuliah.index') }}"
                class="flex items-center gap-2 px-3 py-2 rounded-md text-sm hover:bg-slate-100 dark:hover:bg-slate-700 {{ request()->routeIs('admin.matakuliah.*') ? 'bg-slate-100 dark:bg-slate-700 font-semibold' : '' }}">📚
                <span>Mata Kuliah</span></a>
        </li>
        <li>
            <a href="{{ route('admin.jadwal.index') }}"
                class="flex items-center gap-2 px-3 py-2 rounded-md text-sm hover:bg-slate-100 dark:hover:bg-slate-700 {{ request()->routeIs('admin.jadwal.*') ? 'bg-slate-100 dark:bg-slate-700 font-semibold' : '' }}">🗓️
                <span>Jadwal Kuliah</span></a>
        </li>
    </ul>
</div>
