<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Absensi</title>
    @vite('resources/css/app.css')
</head>

<body class="relative bg-slate-100 dark:bg-slate-900 flex items-center justify-center min-h-screen overflow-hidden">

    <!-- Rain Canvas Background -->
    <div id="rain-container" class="absolute inset-0 pointer-events-none"></div>

    <!-- Login Card -->
    <div
        class="relative z-10 w-full max-w-md p-8
           bg-white/15 dark:bg-slate-800/20
           backdrop-blur-2xl
           rounded-2xl shadow-[0_8px_32px_rgba(0,0,0,0.25)]
           border border-white/20 dark:border-white/10
           animate-fadeIn
           login-card">

        <div class="text-center mb-6">
            <h2 class="text-3xl font-extrabold text-slate-800 dark:text-white tracking-wide drop-shadow-sm">
                Selamat Datang
            </h2>
            <p class="text-sm text-slate-600 dark:text-slate-300 mt-1">Login Admin, Dosen & Mahasiswa</p>
        </div>

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

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1">Alamat Email /
                    Username</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="input-beauty">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1">Password</label>
                <input type="password" name="password" required class="input-beauty">
            </div>

            <div class="flex items-center mb-4">
                <input type="checkbox" id="remember" name="remember"
                    class="h-4 w-4 rounded border-slate-300 dark:border-slate-600 dark:bg-slate-800 text-indigo-600 focus:ring-indigo-500">
                <label for="remember" class="ml-2 text-sm text-slate-700 dark:text-slate-300">Ingat Saya</label>
            </div>

            <button type="submit" class="btn-login">
                Login
            </button>
        </form>
    </div>


    <!-- Snow Script -->
    <script>
        const rainContainer = document.getElementById("rain-container");

        function createSnow() {
            const snow = document.createElement("div");
            const size = Math.random() * 4 + 2;
            const posX = Math.random() * window.innerWidth;
            const duration = Math.random() * 3 + 4;

            snow.classList.add("snowflake");
            snow.style.width = `${size}px`;
            snow.style.height = `${size}px`;
            snow.style.left = `${posX}px`;
            snow.style.animationDuration = `${duration}s`;

            rainContainer.appendChild(snow);

            setTimeout(() => snow.remove(), duration * 1000);
        }

        setInterval(createSnow, 120);
    </script>

    <style>
        .snowflake {
            position: absolute;
            top: -10px;
            background: white;
            border-radius: 50%;
            opacity: 0.8;
            filter: blur(1px);
            animation: snowFall linear infinite;
        }

        /* CARD ANIMATION */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* BEAUTIFUL LOGIN CARD */
        .login-card {
            position: relative;
            overflow: hidden;
            transition: 0.4s ease;
        }

        .login-card:hover {
            transform: scale(1.015);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.35);
        }

        /* AURA GLOW */
        .login-card::before {
            content: "";
            position: absolute;
            inset: -20px;
            background: radial-gradient(circle at top left, rgba(99, 102, 241, 0.4), transparent 60%),
                radial-gradient(circle at bottom right, rgba(236, 72, 153, 0.35), transparent 60%);
            z-index: -1;
            filter: blur(40px);
        }

        /* INPUT BEAUTY */
        .input-beauty {
            width: 100%;
            padding: 10px 14px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            color: #fff;
            outline: none;
            transition: 0.25s;
        }

        .dark .input-beauty {
            background: rgba(0, 0, 0, 0.3);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .input-beauty:focus {
            border-color: #818cf8;
            background: rgba(255, 255, 255, 0.35);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3);
        }

        /* LOGIN BUTTON */
        .btn-login {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            font-weight: 600;
            transition: 0.3s;
            box-shadow: 0 0 10px rgba(99, 102, 241, 0.4);
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            box-shadow: 0 0 18px rgba(99, 102, 241, 0.6);
            transform: translateY(-2px);
        }

        @keyframes snowFall {
            to {
                transform: translateY(110vh) translateX(20px);
                opacity: 0;
            }
        }
    </style>


</body>


</html>
