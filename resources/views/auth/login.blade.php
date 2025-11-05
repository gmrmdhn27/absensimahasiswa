<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Absensi</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-100 dark:bg-slate-900 flex items-center justify-center min-h-screen">
    <div
        class="w-full max-w-md p-6 bg-white/90 dark:bg-slate-800/60 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">Login Admin, Dosen & Mahasiswa</h2>
        </div>

        {{-- Notifikasi --}}
        @if ($errors->any())
            <div
                class="p-3 mb-4 rounded-lg bg-red-100/80 border border-red-300 text-red-800 dark:bg-red-700/40 dark:text-red-100 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div
                class="p-3 mb-4 rounded-lg bg-green-100/80 border border-green-300 text-green-800 dark:bg-green-700/40 dark:text-green-100 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div
                class="p-3 mb-4 rounded-lg bg-yellow-100/80 border border-yellow-300 text-yellow-800 dark:bg-yellow-700/40 dark:text-yellow-100 text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Alamat
                    Email / Username</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full p-2 rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 focus:ring-indigo-500 focus:border-indigo-500 transition">
            </div>

            <div>
                <label for="password"
                    class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Password</label>
                <input type="password" id="password" name="password" required autocomplete="current-password"
                    class="w-full p-2 rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 focus:ring-indigo-500 focus:border-indigo-500 transition">
            </div>

            <div class="flex items-center mb-4">
                <input type="checkbox" id="remember" name="remember"
                    class="h-4 w-4 rounded border-slate-300 dark:border-slate-600 dark:bg-slate-800 text-indigo-600 focus:ring-indigo-500">
                <label for="remember" class="ml-2 text-sm text-slate-700 dark:text-slate-300">Ingat Saya</label>
            </div>

            <button type="submit"
                class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition">
                Login
            </button>
        </form>
    </div>
</body>

</html>
