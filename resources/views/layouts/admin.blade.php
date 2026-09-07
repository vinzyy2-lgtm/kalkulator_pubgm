<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title', 'Admin') — PUBG Tournament</title>

    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #0d1117; color: #e2e8f0; }
        #sidebar { width: 260px; min-height: 100vh; position: fixed; top: 0; left: 0; z-index: 100; background: #161b2e; border-right: 1px solid #1e2a4a; display: flex; flex-direction: column; }
        #main-content { margin-left: 260px; min-height: 100vh; }
        .sidebar-logo { padding: 20px 20px 16px; border-bottom: 1px solid #1e2a4a; }
        .sidebar-section-title { font-size: 10px; font-weight: 700; letter-spacing: 1.2px; color: #4a5568; text-transform: uppercase; padding: 16px 20px 6px; }
        .sidebar-nav .nav-link { color: #94a3b8; padding: 10px 20px; border-radius: 8px; margin: 2px 12px; font-size: 13px; font-weight: 500; display: flex; align-items: center; gap: 10px; transition: all 0.2s; }
        .sidebar-nav .nav-link:hover { background: #1e2a4a; color: #f1f5f9; }
        .sidebar-nav .nav-link.active { color: #f59e0b; background: rgba(245,158,11,0.1); border-left: 3px solid #f59e0b; margin-left: 9px; }
        .sidebar-nav .nav-link i { font-size: 16px; width: 20px; }
        .topbar { background: #161b2e; border-bottom: 1px solid #1e2a4a; padding: 14px 24px; position: sticky; top: 0; z-index: 99; }
        .stat-card { background: #161b2e; border: 1px solid #1e2a4a; border-radius: 12px; padding: 20px; transition: transform 0.2s, box-shadow 0.2s; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.3); }
        .stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; }
        .chart-card { background: #161b2e; border: 1px solid #1e2a4a; border-radius: 12px; padding: 20px; }
        .table-dark-custom { background: #161b2e; border-color: #1e2a4a; }
        .table-dark-custom th { background: #0d1117; color: #64748b; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; border-color: #1e2a4a; }
        .table-dark-custom td { border-color: #1e2a4a; color: #e2e8f0; vertical-align: middle; font-size: 13px; }
        .table-dark-custom tbody tr:hover { background: #1e2a4a !important; }
        .form-control-dark { background: #0d1117; border: 1px solid #1e2a4a; color: #e2e8f0; border-radius: 8px; }
        .form-control-dark:focus { background: #0d1117; border-color: #7c3aed; color: #e2e8f0; box-shadow: 0 0 0 3px rgba(124,58,237,0.15); }
        .form-control-dark::placeholder { color: #4a5568; }
        .form-select-dark { background: #0d1117; border: 1px solid #1e2a4a; color: #e2e8f0; }
        .form-select-dark:focus { background: #0d1117; border-color: #7c3aed; color: #e2e8f0; box-shadow: 0 0 0 3px rgba(124,58,237,0.15); }
        .form-select-dark option { background: #0d1117; color: #e2e8f0; }
        .card-dark { background: #161b2e; border: 1px solid #1e2a4a; border-radius: 12px; }
        .badge-rank-1 { background: linear-gradient(135deg, #f59e0b, #d97706); color: #000; }
        .badge-rank-2 { background: #94a3b8; color: #000; }
        .badge-rank-3 { background: #92400e; color: #fff; }
        .btn-pubg { background: linear-gradient(135deg, #7c3aed, #f59e0b); border: none; color: white; font-weight: 600; }
        .btn-pubg:hover { opacity: 0.9; color: white; }
        .input-kill { width: 60px; text-align: center; }
        .sidebar-bottom { margin-top: auto; padding: 16px 20px; border-top: 1px solid #1e2a4a; }
        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #0d1117; }
        ::-webkit-scrollbar-thumb { background: #2a3050; border-radius: 10px; }
        /* Content wrapper */
        .content-wrapper { padding: 24px; background: #0d1117; min-height: calc(100vh - 57px); }
        /* Toast */
        .toast { min-width: 280px; }
    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar -->
<nav id="sidebar">
    <!-- Logo -->
    <div class="sidebar-logo d-flex align-items-center gap-3">
        <div style="width:40px;height:40px;background:linear-gradient(135deg,#7c3aed,#f59e0b);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:900;color:white;flex-shrink:0">PM</div>
        <div>
            <div style="font-size:13px;font-weight:800;color:#f1f5f9;letter-spacing:0.5px">PUBG TOURNAMENT</div>
            <div style="font-size:10px;color:#f59e0b;font-weight:600;letter-spacing:1px;text-transform:uppercase">Admin Panel</div>
        </div>
    </div>

    <!-- Nav scroll area -->
    <div style="overflow-y:auto;flex:1">
        <!-- Main Menu -->
        <div class="sidebar-section-title">Main Menu</div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </nav>

        <!-- Management -->
        <div class="sidebar-section-title">Management</div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.matches.index') }}"
               class="nav-link {{ request()->routeIs('admin.matches.*') ? 'active' : '' }}">
                <i class="bi bi-controller"></i> Input Match
            </a>
            <a href="{{ route('admin.players.index') }}"
               class="nav-link {{ request()->routeIs('admin.players.*') ? 'active' : '' }}">
                <i class="bi bi-person-gear"></i> Input Player
            </a>
            <a href="{{ route('admin.teams.index') }}"
               class="nav-link {{ request()->routeIs('admin.teams.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Edit Teams
            </a>
        </nav>
    </div>

    <!-- Bottom User Info -->
    <div class="sidebar-bottom">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="d-flex align-items-center gap-2">
                <div style="width:32px;height:32px;background:#1e2a4a;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-person-fill" style="color:#f59e0b;font-size:15px"></i>
                </div>
                <div>
                    <div style="font-size:12px;font-weight:600;color:#f1f5f9">Administrator</div>
                    <span class="badge" style="background:rgba(245,158,11,0.15);color:#f59e0b;font-size:9px;font-weight:700;letter-spacing:0.8px;border:1px solid rgba(245,158,11,0.3)">ADMIN</span>
                </div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm w-100" style="background:#0d1117;border:1px solid #1e2a4a;color:#94a3b8;font-size:12px">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
        </form>
    </div>
</nav>

<!-- Main Content -->
<div id="main-content">
    <!-- Topbar -->
    <div class="topbar d-flex align-items-center justify-content-between">
        <div>
            <h5 class="mb-0 fw-700" style="font-weight:700;color:#f1f5f9;font-size:18px">@yield('page-title', 'Dashboard')</h5>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="badge" style="background:rgba(245,158,11,0.15);color:#f59e0b;border:1px solid rgba(245,158,11,0.3);font-size:11px;font-weight:700;padding:5px 10px">
                <i class="bi bi-shield-fill me-1"></i>ADMIN
            </span>
            <span style="font-size:12px;color:#64748b" id="topbar-datetime"></span>
        </div>
    </div>

    <!-- Content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
</div>

<!-- Toast Notification -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
    <div id="liveToast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body d-flex align-items-center gap-2" id="toastBody" style="background:#161b2e;border:1px solid #1e2a4a;border-radius:10px;color:#e2e8f0;font-size:13px;padding:12px 16px;"></div>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    // Topbar datetime
    function updateDatetime() {
        const now = new Date();
        const options = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
        const el = document.getElementById('topbar-datetime');
        if (el) el.textContent = now.toLocaleDateString('id-ID', options);
    }
    updateDatetime();
    setInterval(updateDatetime, 1000);

    // Toast notification helper
    function showToast(msg, type = 'success') {
        const toast = document.getElementById('liveToast');
        const body = document.getElementById('toastBody');
        body.innerHTML = type === 'success'
            ? `<i class="bi bi-check-circle-fill text-success"></i> ${msg}`
            : `<i class="bi bi-x-circle-fill text-danger"></i> ${msg}`;
        toast.className = 'toast show align-items-center border-0';
        setTimeout(() => { toast.className = 'toast align-items-center border-0'; }, 3500);
    }

    // Dark chart defaults
    const darkChartDefaults = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { labels: { color: '#94a3b8', font: { size: 11 } } },
            tooltip: { backgroundColor: '#1e2a4a', titleColor: '#f1f5f9', bodyColor: '#94a3b8' }
        },
        scales: {
            x: { ticks: { color: '#64748b' }, grid: { color: '#1e2a4a' } },
            y: { ticks: { color: '#64748b' }, grid: { color: '#1e2a4a' } }
        }
    };

    // Show session flash as toast
    @if(session('success'))
        document.addEventListener('DOMContentLoaded', () => showToast(@json(session('success')), 'success'));
    @endif
    @if(session('error'))
        document.addEventListener('DOMContentLoaded', () => showToast(@json(session('error')), 'error'));
    @endif
</script>

@stack('scripts')
</body>
</html>
