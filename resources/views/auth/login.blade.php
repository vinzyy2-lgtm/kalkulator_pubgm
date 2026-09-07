<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — PUBG Tournament Manager</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Teko:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pubg-dark': '#0b0816',
                        'pubg-card': '#18142a',
                        'pubg-border': '#312a4d',
                        'pubg-gold': '#f59e0b',
                        'pubg-purple': '#7c3aed',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Teko', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <style>
        body { background-color: #0b0816; }
        .bg-grid {
            background-image:
                linear-gradient(rgba(124, 58, 237, 0.07) 1px, transparent 1px),
                linear-gradient(90deg, rgba(124, 58, 237, 0.07) 1px, transparent 1px);
            background-size: 38px 38px;
        }
        .login-card { box-shadow: 0 24px 80px rgba(0, 0, 0, 0.45), 0 0 50px rgba(124, 58, 237, 0.14); }
        .pubg-input {
            background: rgba(11, 8, 22, 0.7);
            border: 1px solid #312a4d;
            color: #f3f4f6;
        }
        .pubg-input:focus {
            outline: none;
            border-color: #a855f7;
            box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.18);
        }
        .pubg-input::placeholder { color: #6b7280; }
    </style>
</head>
<body class="bg-pubg-dark bg-grid min-h-screen overflow-x-hidden font-sans text-gray-100">
    <div class="pointer-events-none fixed -left-40 top-10 h-96 w-96 rounded-full bg-violet-600/20 blur-3xl"></div>
    <div class="pointer-events-none fixed -bottom-32 -right-24 h-96 w-96 rounded-full bg-amber-500/15 blur-3xl"></div>

    <main class="relative mx-auto flex min-h-screen w-full max-w-6xl items-center justify-center px-4 py-10 sm:px-6">
        <section class="w-full max-w-md">
            <div class="mb-7 text-center">
                <div class="mb-5 inline-flex h-20 w-20 items-center justify-center rounded-2xl border border-white/20 bg-gradient-to-br from-violet-600 to-amber-500 shadow-lg shadow-violet-950/60">
                    <span class="font-display text-4xl font-bold tracking-wide text-white">PM</span>
                </div>
                <p class="mb-1 text-xs font-semibold uppercase tracking-[0.28em] text-amber-400">Control Center</p>
                <h1 class="font-display text-5xl font-semibold leading-none tracking-wide text-white sm:text-6xl">PUBG TOURNAMENT</h1>
                <p class="mt-3 text-sm text-gray-400">Masuk untuk mengelola pertandingan dan klasemen.</p>
            </div>

            <div class="login-card overflow-hidden rounded-3xl border border-pubg-border bg-pubg-card/95 backdrop-blur">
                <div class="border-b border-pubg-border bg-white/[0.025] px-6 py-5 sm:px-8">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-400/10 text-amber-400">
                            <i class="fas fa-shield-halved"></i>
                        </span>
                        <div>
                            <h2 class="font-semibold text-white">Login Admin</h2>
                            <p class="mt-0.5 text-xs text-gray-500">Akses terbatas untuk administrator.</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 sm:p-8">
                    @if(session('error'))
                        <div class="mb-5 flex items-start gap-3 rounded-xl border border-red-500/30 bg-red-950/40 px-4 py-3 text-sm text-red-200" role="alert">
                            <i class="fas fa-circle-exclamation mt-0.5"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    @error('password')
                        <div class="mb-5 flex items-start gap-3 rounded-xl border border-red-500/30 bg-red-950/40 px-4 py-3 text-sm text-red-200" role="alert">
                            <i class="fas fa-circle-exclamation mt-0.5"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror

                    <form action="{{ route('login.submit') }}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label for="admin-password" class="mb-2 block text-sm font-medium text-gray-300">Password admin</label>
                            <div class="relative">
                                <input
                                    type="password"
                                    id="admin-password"
                                    name="password"
                                    placeholder="Masukkan password Anda"
                                    autocomplete="current-password"
                                    class="pubg-input w-full rounded-xl px-4 py-3.5 pr-12 text-sm transition"
                                    required
                                    autofocus
                                >
                                <button type="button" id="password-toggle" aria-label="Tampilkan password" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg p-2 text-gray-500 transition hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-violet-500">
                                    <i id="eye-icon" class="fas fa-eye text-sm"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 px-4 py-3.5 text-sm font-bold text-white shadow-lg shadow-amber-950/30 transition hover:brightness-110 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:ring-offset-2 focus:ring-offset-pubg-card active:scale-[0.98]">
                            <i class="fas fa-right-to-bracket"></i>
                            Masuk ke Dashboard
                        </button>
                    </form>
                </div>
            </div>

            <p class="mt-6 text-center text-xs text-gray-600">PUBG Tournament Manager <span class="mx-1">•</span> {{ date('Y') }}</p>
        </section>
    </main>

    <script>
        const passwordInput = document.getElementById('admin-password');
        const passwordToggle = document.getElementById('password-toggle');
        const eyeIcon = document.getElementById('eye-icon');

        passwordToggle.addEventListener('click', () => {
            const isPasswordVisible = passwordInput.type === 'text';

            passwordInput.type = isPasswordVisible ? 'password' : 'text';
            passwordToggle.setAttribute('aria-label', isPasswordVisible ? 'Tampilkan password' : 'Sembunyikan password');
            eyeIcon.className = isPasswordVisible ? 'fas fa-eye text-sm' : 'fas fa-eye-slash text-sm';
        });
    </script>
</body>
</html>
