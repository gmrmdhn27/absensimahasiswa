<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Absensi | @yield('title')</title>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.29.1/dist/feather.min.js"></script>
    @vite('resources/css/app.css')
</head>

<body class="h-full flex bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 transition-colors duration-300">

    <div id="page-transition"
        class="fixed inset-0 bg-gray-900/90 opacity-0 pointer-events-none z-[9998]
           transition-opacity duration-500 flex items-center justify-center">
        <div class="animate-spin rounded-full h-14 w-14 border-t-4 border-b-4 border-indigo-400"></div>
    </div>

    <div id="app" class="min-h-screen w-full md:flex md:overflow-x-hidden">

        {{-- Sidebar desktop --}}
        <aside id="sidebar"
            class="hidden sm:flex sm:w-64 sm:flex-col
       bg-white/80 dark:bg-slate-800/80
       border-r border-slate-200 dark:border-slate-700
       backdrop-blur p-4 justify-between">

            {{-- Logo & Judul --}}
            <div class="flex items-center gap-3 px-2 mb-4">
                <div
                    class="h-10 w-10 rounded-lg bg-gradient-to-br from-slate-700 to-indigo-600 flex items-center justify-center text-white font-semibold">
                    SA
                </div>
                <div>
                    <div class="text-lg font-semibold">Sistem Absensi</div>
                    <div class="text-xs text-slate-500 dark:text-slate-400">Sistem Absensi Kampus</div>
                </div>
            </div>

            {{-- Navigasi --}}
            <nav class="flex-1 p-2 space-y-2 overflow-auto">
                @auth
                    @if (Auth::user()->role === 'admin')
                        @include('layouts.components.admin-sidebar')
                    @elseif (Auth::user()->role === 'dosen')
                        @include('layouts.components.dosen-sidebar')
                    @elseif (Auth::user()->role === 'mahasiswa')
                        @include('layouts.components.mhs-sidebar')
                    @endif
                @endauth
            </nav>

            {{-- Tombol keluar --}}
            <div class="mt-4 px-2">
                <form id="logout-form-desktop" method="POST" action="{{ route('logout') }}" class="hidden">
                    @csrf
                </form>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();"
                    class="block w-full text-left px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors cursor-pointer">
                    Keluar
                </a>
            </div>
        </aside>

        {{-- Header mobile --}}
        <header
            class="md:hidden w-full bg-white/60 dark:bg-slate-800/60 border-b border-slate-200 dark:border-slate-700 backdrop-blur p-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <button id="btn-open-sidebar" aria-label="Open sidebar"
                    class="p-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <span class="text-lg font-semibold">Sistem Absensi</span>
            </div>

            @auth
                <div class="text-sm">{{ Auth::user()->name }}</div>
            @endauth
        </header>

        {{-- Sidebar mobile --}}
        <div id="mobile-sidebar"
            class="fixed inset-0 z-40 transform -translate-x-full transition-transform duration-300 md:hidden">
            <div id="mobile-overlay" class="absolute inset-0 bg-black/40"></div>

            <aside class="relative w-64 h-full bg-white dark:bg-slate-800 p-4 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="h-10 w-10 rounded-lg bg-gradient-to-br from-slate-700 to-indigo-600 flex items-center justify-center text-white font-semibold">
                            SA
                        </div>
                        <div>
                            <div class="text-lg font-semibold">Sistem Absensi</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">Sistem Absensi Kampus</div>
                        </div>
                    </div>

                    <nav class="space-y-2 overflow-auto">
                        @auth
                            @if (Auth::user()->role === 'admin')
                                @include('layouts.components.admin-sidebar')
                            @elseif (Auth::user()->role === 'dosen')
                                @include('layouts.components.dosen-sidebar')
                            @elseif (Auth::user()->role === 'mahasiswa')
                                @include('layouts.components.mhs-sidebar')
                            @endif
                        @endauth
                    </nav>
                </div>

                <div class="mt-4">
                    <form id="logout-form-mobile" method="POST" action="{{ route('logout') }}" class="hidden">
                        @csrf
                    </form>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();"
                        class="block w-full cursor-pointer text-left px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                        Keluar
                    </a>
                </div>
            </aside>
        </div>

        {{-- Konten utama --}}
        <div class="flex-1 flex flex-col w-full">
            <header
                class="w-full p-4 bg-white/80 dark:bg-gray-800/80 shadow-sm border-b border-gray-100 dark:border-gray-700 backdrop-blur">
                <h1 class="text-xl font-semibold">@yield('title', 'Dashboard')</h1>
                {{-- <p>Gema, Didik, Andi</p> --}}
            </header>

            <main class="flex-1 p-8 overflow-y-auto">
                <div class="flex w-full justify-center align-items-center mb-5">
                    <div class="w-full bg-gray-800/80 py-3 px-3 rounded-xl shadow-md shadow-indigo-600">
                        <h1 class="text-2xl mb-5">This System Made By&trade;</h1>
                        <p>Gema Ramadhan</p>
                        <p>Didik Kusuma Rahmat</p>
                        <p>M. Andi Yanuar Ibrahim</p>
                    </div>
                </div>

                <div class="page-wrapper w-full">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div id="delete-modal"
        class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/60 backdrop-blur-sm transition-opacity duration-300"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div
            class="w-full max-w-md transform rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all dark:bg-slate-800">
            <h3 class="text-lg font-bold leading-6 text-slate-900 dark:text-slate-100" id="modal-title">
                Konfirmasi Penghapusan
            </h3>
            <div class="mt-2">
                <p class="text-sm text-slate-500 dark:text-slate-400" id="modal-body">
                    Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>

            <form id="delete-form" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" id="close-modal-btn"
                        class="px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-100 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-lg transition">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 rounded-lg transition">Ya,
                        Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .page-exit-right {
            animation: exitRight 0.50s ease forwards;
        }

        @keyframes exitRight {
            0% {
                opacity: 1;
                transform: translateX(0);
            }

            100% {
                opacity: 0;
                transform: translateX(60px);
            }
        }


        .page-enter-right {
            opacity: 0;
            transform: translateX(50px);
            animation: enterRight 0.50s ease-out forwards;
        }

        @keyframes enterRight {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>


    {{-- Script toggle sidebar mobile --}}
    <script>
        const btn = document.getElementById('btn-open-sidebar');
        const mobile = document.getElementById('mobile-sidebar');
        const overlay = document.getElementById('mobile-overlay');

        if (btn) btn.addEventListener('click', () => mobile.classList.remove('-translate-x-full'));
        if (overlay) overlay.addEventListener('click', () => mobile.classList.add('-translate-x-full'));

        // Logika Modal Hapus
        const deleteModal = document.getElementById('delete-modal');
        if (deleteModal) {
            const closeModalBtn = document.getElementById('close-modal-btn');
            const deleteForm = document.getElementById('delete-form');
            const modalBody = document.getElementById('modal-body');

            document.querySelectorAll('.open-delete-modal').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const url = this.getAttribute('data-url');
                    const name = this.getAttribute('data-name');

                    // Set action form
                    deleteForm.setAttribute('action', url);

                    // Set pesan konfirmasi
                    modalBody.innerHTML =
                        `Apakah Anda yakin ingin menghapus data <strong>${name}</strong>? Tindakan ini tidak dapat dibatalkan.`;

                    // Tampilkan modal
                    deleteModal.classList.remove('hidden');
                    deleteModal.classList.add('flex');
                });
            });

            const closeModal = () => {
                deleteModal.classList.add('hidden');
                deleteModal.classList.remove('flex');
            };

            closeModalBtn.addEventListener('click', closeModal);
            deleteModal.addEventListener('click', (e) => {
                if (e.target === deleteModal) {
                    closeModal();
                }
            });
        }

        document.addEventListener("DOMContentLoaded", () => {
            const links = document.querySelectorAll(".sidebar-link");
            const page = document.querySelector(".page-wrapper");

            const EXIT_CLASS = "page-exit-right"; // ⬅ tinggal ganti
            const ENTER_CLASS = "page-enter-right"; // ⬅ tinggal ganti

            links.forEach(link => {
                link.addEventListener("click", function(e) {
                    const url = this.getAttribute("href");
                    e.preventDefault();

                    page.classList.add(EXIT_CLASS);

                    setTimeout(() => {
                        window.location.href = url;
                    }, 400);
                });
            });

            // Ketika halaman tujuan dibuka → animasi masuk
            page.classList.add(ENTER_CLASS);
        });
    </script>
    @stack('scripts')
    <script>
        feather.replace();
    </script>

</body>

</html>
