<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title', 'PUBG Tournament') — PMWC 2024</title>

    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #0d1117; color: #e2e8f0; margin: 0; }
        .navbar-brand-logo { width: 36px; height: 36px; background: linear-gradient(135deg, #7c3aed, #f59e0b); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 900; color: white; flex-shrink: 0; }
        .navbar-custom { background: #161b2e !important; border-bottom: 1px solid #1e2a4a; }
        .navbar-custom .nav-link { color: #94a3b8 !important; font-size: 13px; font-weight: 500; transition: color 0.2s; padding: 8px 14px !important; border-radius: 6px; }
        .navbar-custom .nav-link:hover { color: #f1f5f9 !important; background: rgba(255,255,255,0.05); }
        .navbar-custom .nav-link.active { color: #f59e0b !important; }
        .main-content { background: #0d1117; min-height: 100vh; }
        .stat-card { background: #161b2e; border: 1px solid #1e2a4a; border-radius: 12px; padding: 20px; transition: transform 0.2s, box-shadow 0.2s; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.3); }
        .stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; }
        .table-dark-custom { background: #161b2e; border-color: #1e2a4a; }
        .table-dark-custom th { background: #0d1117; color: #64748b; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; border-color: #1e2a4a; }
        .table-dark-custom td { border-color: #1e2a4a; color: #e2e8f0; vertical-align: middle; font-size: 13px; }
        .table-dark-custom tbody tr:hover { background: #1e2a4a !important; }
        .card-dark { background: #161b2e; border: 1px solid #1e2a4a; border-radius: 12px; }
        .badge-rank-1 { background: linear-gradient(135deg, #f59e0b, #d97706); color: #000 !important; }
        .badge-rank-2 { background: #94a3b8; color: #000 !important; }
        .badge-rank-3 { background: #92400e; color: #fff !important; }
        .footer-pub { background: #161b2e; border-top: 1px solid #1e2a4a; padding: 16px 24px; font-size: 12px; color: #4a5568; text-align: center; }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #0d1117; }
        ::-webkit-scrollbar-thumb { background: #2a3050; border-radius: 10px; }
        @media print {
            .navbar, .no-print, form { display: none !important; }
            body, .main-content { background: white !important; color: black !important; }
            .table-dark-custom th, .table-dark-custom td { color: black !important; border-color: #ccc !important; }
            .table-dark-custom th { background: #f0f0f0 !important; }
            .card-dark, .stat-card { background: white !important; border: 1px solid #ccc !important; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-custom sticky-top navbar-dark">
    <div class="container-fluid px-4">
        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('standings') }}">
            <div class="navbar-brand-logo">PM</div>
            <span style="font-size:14px;font-weight:800;color:#f1f5f9;letter-spacing:0.5px">PUBG TOURNAMENT MANAGER</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Nav Links -->
            <ul class="navbar-nav me-auto ms-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('standings') ? 'active' : '' }}" href="{{ route('standings') }}">
                        <i class="bi bi-trophy me-1"></i> Team Standings
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('mostkills') ? 'active' : '' }}" href="{{ route('mostkills') }}">
                        <i class="bi bi-crosshair me-1"></i> Most Kills
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#rulesModal">
                        <i class="bi bi-info-circle me-1"></i> Rules
                    </a>
                </li>
            </ul>

            <!-- Right side -->
            <div class="d-flex align-items-center gap-2">
                @if(session('role') === 'admin')
                    <span class="badge" style="background:rgba(245,158,11,0.15);color:#f59e0b;border:1px solid rgba(245,158,11,0.3);font-size:10px;font-weight:700;padding:4px 8px">
                        <i class="bi bi-shield-fill me-1"></i>ADMIN
                    </span>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm" style="background:#1e2a4a;border:1px solid #2a3a5e;color:#f59e0b;font-size:11px;font-weight:600">
                        <i class="bi bi-speedometer2 me-1"></i>Dashboard
                    </a>
                @else
                    <span class="badge" style="background:rgba(124,58,237,0.15);color:#a78bfa;border:1px solid rgba(124,58,237,0.3);font-size:10px;font-weight:700;padding:4px 8px">
                        <i class="bi bi-eye me-1"></i>PENONTON
                    </span>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm" style="background:#0d1117;border:1px solid #1e2a4a;color:#64748b;font-size:11px">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="main-content">
    <div class="container-fluid px-4 py-4">
        @yield('content')
    </div>
</div>

<!-- Footer -->
<div class="footer-pub">
    <i class="bi bi-controller me-1" style="color:#f59e0b"></i>
    PMWC 2024 — PUBG Tournament Manager &nbsp;·&nbsp; All rights reserved
</div>

<!-- Rules Modal -->
<div class="modal fade" id="rulesModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background:#161b2e;border:1px solid #1e2a4a;">
            <div class="modal-header" style="border-bottom:1px solid #1e2a4a">
                <h5 class="modal-title" style="color:#f1f5f9;font-weight:700"><i class="bi bi-clipboard-check me-2 text-warning"></i>Aturan PMWC Points</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="color:#94a3b8;font-size:13px">
                <p class="mb-3">Sistem poin PMWC (PUBG Mobile World Championship):</p>
                <table class="table table-sm" style="color:#e2e8f0">
                    <thead><tr style="background:#0d1117;color:#64748b;font-size:11px;text-transform:uppercase"><th>Rank</th><th>Place Points</th></tr></thead>
                    <tbody>
                        <tr><td>#1 (WWCD)</td><td style="color:#f59e0b;font-weight:700">10 pts</td></tr>
                        <tr><td>#2</td><td>6 pts</td></tr>
                        <tr><td>#3</td><td>5 pts</td></tr>
                        <tr><td>#4</td><td>4 pts</td></tr>
                        <tr><td>#5</td><td>3 pts</td></tr>
                        <tr><td>#6</td><td>2 pts</td></tr>
                        <tr><td>#7 – #8</td><td>1 pt</td></tr>
                        <tr><td>#9 – #18</td><td>0 pts</td></tr>
                    </tbody>
                </table>
                <p style="font-size:12px;color:#64748b">+ 1 poin per eliminasi. Total poin = Place Points + Eliminasi.</p>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')
</body>
</html>
