<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PUBG Tournament Manager')</title>

    <!-- Google Fonts: Inter + Teko -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Teko:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'pubg-dark':   '#0b0816',
                        'pubg-card':   '#18142a',
                        'pubg-border': '#2a2444',
                        'pubg-gold':   '#f59e0b',
                        'pubg-purple': '#7c3aed',
                        'pubg-red':    '#dc2626',
                        'pubg-muted':  '#6b7280',
                    },
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                        'display': ['Teko', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        body { background-color: #0b0816; }
        .font-teko { font-family: 'Teko', sans-serif; }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #18142a; }
        ::-webkit-scrollbar-thumb { background: #2a2444; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #7c3aed; }

        /* Table striping */
        .pubg-table tr:nth-child(even) { background-color: rgba(42,36,68,0.3); }
        .pubg-table tr:hover { background-color: rgba(124,58,237,0.1); transition: background 0.15s; }

        /* Toast animation */
        .toast-enter { animation: slideInRight 0.4s ease forwards; }
        @keyframes slideInRight {
            from { transform: translateX(120%); opacity: 0; }
            to   { transform: translateX(0);    opacity: 1; }
        }

        /* Nav active glow */
        .nav-active {
            color: #f59e0b !important;
            border-bottom: 2px solid #f59e0b;
        }

        /* Print styles */
        @media print {
            header, footer, .no-print { display: none !important; }
            body { background: white !important; color: black !important; }
            .print-table { color: black !important; }
        }

        /* Input focus ring */
        .pubg-input:focus {
            outline: none;
            border-color: #7c3aed;
            box-shadow: 0 0 0 2px rgba(124,58,237,0.25);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-pubg-dark text-gray-100 font-sans min-h-screen flex flex-col">

    {{-- ===== HEADER / NAV ===== --}}
    <header class="sticky top-0 z-50 bg-pubg-card border-b border-pubg-border shadow-lg" style="backdrop-filter:blur(8px);">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">

                {{-- Logo + Title --}}
                <a href="{{ route('standings') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center font-teko font-bold text-xl"
                         style="background: linear-gradient(135deg, #7c3aed, #f59e0b);">
                        PM
                    </div>
                    <span class="font-teko font-semibold text-xl tracking-wider text-white group-hover:text-pubg-gold transition-colors hidden sm:block">
                        PUBG TOURNAMENT MANAGER
                    </span>
                </a>

                {{-- Desktop Nav --}}
                <nav class="hidden md:flex items-center gap-1">
                    <a href="{{ route('standings') }}"
                       class="flex items-center gap-1.5 px-3 py-2 rounded-md text-sm font-medium transition-colors
                              {{ request()->routeIs('standings') ? 'text-pubg-gold border-b-2 border-pubg-gold' : 'text-gray-300 hover:text-white hover:bg-pubg-border' }}">
                        <i class="fas fa-trophy text-xs"></i>
                        Team Standings
                    </a>
                    <a href="{{ route('mostkills') }}"
                       class="flex items-center gap-1.5 px-3 py-2 rounded-md text-sm font-medium transition-colors
                              {{ request()->routeIs('mostkills') ? 'text-pubg-gold border-b-2 border-pubg-gold' : 'text-gray-300 hover:text-white hover:bg-pubg-border' }}">
                        <i class="fas fa-crosshairs text-xs"></i>
                        Most Kills
                    </a>
                    <a href="#rules"
                       class="flex items-center gap-1.5 px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-white hover:bg-pubg-border transition-colors">
                        <i class="fas fa-book text-xs"></i>
                        Rules
                    </a>

                    @if(session('role') === 'admin')
                        <div class="w-px h-5 bg-pubg-border mx-1"></div>
                        <a href="{{ route('admin.matches.index') }}"
                           class="flex items-center gap-1.5 px-3 py-2 rounded-md text-sm font-medium transition-colors
                                  {{ request()->routeIs('admin.matches.*') ? 'text-pubg-gold border-b-2 border-pubg-gold' : 'text-gray-300 hover:text-white hover:bg-pubg-border' }}">
                            <i class="fas fa-gamepad text-xs"></i>
                            Input Match
                        </a>
                        <a href="{{ route('admin.teams.index') }}"
                           class="flex items-center gap-1.5 px-3 py-2 rounded-md text-sm font-medium transition-colors
                                  {{ request()->routeIs('admin.teams.*') ? 'text-pubg-gold border-b-2 border-pubg-gold' : 'text-gray-300 hover:text-white hover:bg-pubg-border' }}">
                            <i class="fas fa-users text-xs"></i>
                            Edit Teams
                        </a>
                        <a href="{{ route('admin.players.index') }}"
                           class="flex items-center gap-1.5 px-3 py-2 rounded-md text-sm font-medium transition-colors
                                  {{ request()->routeIs('admin.players.*') ? 'text-pubg-gold border-b-2 border-pubg-gold' : 'text-gray-300 hover:text-white hover:bg-pubg-border' }}">
                            <i class="fas fa-user-edit text-xs"></i>
                            Input Player
                        </a>
                        <a href="{{ route('admin.dashboard') }}"
                           class="flex items-center gap-1.5 px-3 py-2 rounded-md text-sm font-medium transition-colors
                                  {{ request()->routeIs('admin.dashboard') ? 'text-pubg-gold border-b-2 border-pubg-gold' : 'text-gray-300 hover:text-white hover:bg-pubg-border' }}">
                            <i class="fas fa-chart-bar text-xs"></i>
                            Dashboard Admin
                        </a>
                    @endif
                </nav>

                {{-- Right: badge + logout --}}
                <div class="flex items-center gap-3">
                    @if(session('role') === 'admin')
                        <span class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-500/20 text-amber-400 border border-amber-500/30">
                            <i class="fas fa-shield-halved text-xs"></i>Admin
                        </span>
                    @else
                        <span class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-pubg-purple/20 text-purple-400 border border-pubg-purple/30">
                            <i class="fas fa-eye text-xs"></i>Penonton
                        </span>
                    @endif

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="flex items-center gap-1.5 px-3 py-1.5 rounded-md text-sm font-medium text-gray-400 hover:text-red-400 hover:bg-red-900/20 border border-pubg-border hover:border-red-500/30 transition-colors">
                            <i class="fas fa-right-from-bracket text-xs"></i>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>

                    {{-- Mobile menu button --}}
                    <button id="mobile-menu-btn" class="md:hidden p-2 rounded-md text-gray-400 hover:text-white hover:bg-pubg-border transition-colors">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Nav --}}
        <div id="mobile-menu" class="hidden md:hidden border-t border-pubg-border">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('standings') }}" class="flex items-center gap-2 px-3 py-2 rounded-md text-sm text-gray-300 hover:text-white hover:bg-pubg-border">
                    <i class="fas fa-trophy w-4"></i>Team Standings
                </a>
                <a href="{{ route('mostkills') }}" class="flex items-center gap-2 px-3 py-2 rounded-md text-sm text-gray-300 hover:text-white hover:bg-pubg-border">
                    <i class="fas fa-crosshairs w-4"></i>Most Kills
                </a>
                <a href="#rules" class="flex items-center gap-2 px-3 py-2 rounded-md text-sm text-gray-300 hover:text-white hover:bg-pubg-border">
                    <i class="fas fa-book w-4"></i>Rules
                </a>
                @if(session('role') === 'admin')
                    <div class="border-t border-pubg-border my-2"></div>
                    <a href="{{ route('admin.matches.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-md text-sm text-gray-300 hover:text-white hover:bg-pubg-border">
                        <i class="fas fa-gamepad w-4"></i>Input Match
                    </a>
                    <a href="{{ route('admin.teams.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-md text-sm text-gray-300 hover:text-white hover:bg-pubg-border">
                        <i class="fas fa-users w-4"></i>Edit Teams
                    </a>
                    <a href="{{ route('admin.players.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-md text-sm text-gray-300 hover:text-white hover:bg-pubg-border">
                        <i class="fas fa-user-edit w-4"></i>Input Player
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-md text-sm text-gray-300 hover:text-white hover:bg-pubg-border">
                        <i class="fas fa-chart-bar w-4"></i>Dashboard Admin
                    </a>
                @endif
            </div>
        </div>
    </header>

    {{-- ===== TOAST NOTIFICATIONS ===== --}}
    @if(session('success') || session('error'))
    <div class="fixed top-20 right-4 z-50 space-y-2 no-print" id="toast-container">
        @if(session('success'))
        <div class="toast-enter flex items-center gap-3 px-4 py-3 rounded-lg shadow-xl border max-w-sm
                    bg-emerald-900/90 border-emerald-500/40 text-emerald-300" id="toast-success">
            <i class="fas fa-circle-check text-emerald-400"></i>
            <span class="text-sm">{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="ml-auto text-emerald-400 hover:text-white">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>
        @endif
        @if(session('error'))
        <div class="toast-enter flex items-center gap-3 px-4 py-3 rounded-lg shadow-xl border max-w-sm
                    bg-red-900/90 border-red-500/40 text-red-300" id="toast-error">
            <i class="fas fa-circle-exclamation text-red-400"></i>
            <span class="text-sm">{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-white">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>
        @endif
    </div>
    <script>
        setTimeout(() => {
            document.querySelectorAll('#toast-container > div').forEach(t => {
                t.style.transition = 'opacity 0.5s';
                t.style.opacity = '0';
                setTimeout(() => t.remove(), 500);
            });
        }, 4000);
    </script>
    @endif

    {{-- ===== MAIN CONTENT ===== --}}
    <main class="flex-1 max-w-screen-xl mx-auto w-full px-4 py-6">
        @if($errors->any())
        <div class="mb-4 flex items-start gap-3 px-4 py-3 rounded-lg bg-red-900/40 border border-red-500/30 text-red-300">
            <i class="fas fa-triangle-exclamation mt-0.5"></i>
            <ul class="text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="border-t border-pubg-border bg-pubg-card py-4 no-print">
        <div class="max-w-screen-xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-gray-500">
            <span class="font-teko text-sm tracking-wider text-gray-400">PUBG TOURNAMENT MANAGER</span>
            <span>&copy; {{ date('Y') }} &bull; All rights reserved</span>
        </div>
    </footer>

    {{-- Mobile menu toggle --}}
    <script>
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>

    @stack('scripts')
</body>
</html>
