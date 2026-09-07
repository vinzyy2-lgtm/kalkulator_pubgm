<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUBG Tournament — PMWC 2024 Live Standings</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Teko:wght@500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --bg-base:    #0d1117;
            --bg-card:    #161b2e;
            --bg-card2:   #1a2035;
            --border:     #1e2a4a;
            --gold:       #f59e0b;
            --purple:     #7c3aed;
            --red:        #ef4444;
            --green:      #10b981;
            --blue:       #3b82f6;
            --text-main:  #e2e8f0;
            --text-muted: #64748b;
            --text-dim:   #4a5568;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-base);
            color: var(--text-main);
            min-height: 100vh;
        }
        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: var(--bg-base); }
        ::-webkit-scrollbar-thumb { background: #2a3050; border-radius: 10px; }

        /* ── Navbar ── */
        .pub-navbar {
            background: var(--bg-card);
            border-bottom: 1px solid var(--border);
            padding: 0 24px;
            height: 60px;
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .pub-navbar .brand { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .pub-navbar .brand-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--purple), var(--gold));
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 900; font-size: 14px; color: white;
            flex-shrink: 0;
        }
        .pub-navbar .brand-text { font-size: 15px; font-weight: 800; color: #f1f5f9; letter-spacing: 0.3px; }
        .pub-navbar .brand-sub { font-size: 10px; color: var(--text-muted); font-weight: 500; }
        .pub-navbar .nav-links { display: flex; gap: 4px; margin-left: 32px; }
        .pub-navbar .nav-links a {
            color: var(--text-muted); font-size: 12px; font-weight: 600;
            padding: 6px 12px; border-radius: 6px; text-decoration: none;
            transition: all 0.2s;
        }
        .pub-navbar .nav-links a:hover, .pub-navbar .nav-links a.active {
            background: rgba(255,255,255,0.06); color: #f1f5f9;
        }
        .pub-navbar .nav-links a.active { color: var(--gold); }
        .live-badge {
            display: flex; align-items: center; gap: 6px;
            font-size: 10px; font-weight: 700; text-transform: uppercase;
            color: var(--green); letter-spacing: 1px;
        }
        .live-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: var(--green);
            animation: pulse 1.5s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.8); }
        }

        /* ── Hero Banner ── */
        .hero {
            background: linear-gradient(135deg, #0d1117 0%, #1a1035 50%, #0d1117 100%);
            border-bottom: 1px solid var(--border);
            padding: 40px 24px 32px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(ellipse at 50% 0%, rgba(124,58,237,0.15) 0%, transparent 70%);
        }
        .hero-title {
            font-family: 'Teko', sans-serif;
            font-size: clamp(32px, 6vw, 56px);
            font-weight: 700;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 3px;
            line-height: 1;
            position: relative;
        }
        .hero-sub { font-size: 13px; color: var(--text-muted); margin-top: 6px; position: relative; }

        /* ── Stat Cards ── */
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px;
            display: flex; align-items: center; gap: 16px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(0,0,0,0.4); }
        .stat-icon {
            width: 52px; height: 52px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; flex-shrink: 0;
        }
        .stat-label { font-size: 10px; color: var(--text-muted); text-transform: uppercase; font-weight: 700; letter-spacing: 0.8px; }
        .stat-value { font-size: 30px; font-weight: 800; color: #f1f5f9; line-height: 1.1; font-family: 'Teko', sans-serif; }
        .stat-sub { font-size: 11px; color: var(--text-dim); }

        /* ── Section Title ── */
        .section-title {
            font-size: 14px; font-weight: 700; color: #f1f5f9;
            display: flex; align-items: center; gap: 8px;
        }
        .section-title i { color: var(--gold); font-size: 16px; }

        /* ── Cards ── */
        .card-dark {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
        }
        .card-header-dark {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex; justify-content: space-between; align-items: center;
        }

        /* ── Table ── */
        .pub-table { width: 100%; border-collapse: collapse; }
        .pub-table th {
            background: #0d1117;
            color: var(--text-muted);
            font-size: 10px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.8px;
            padding: 10px 16px;
            border-bottom: 1px solid var(--border);
        }
        .pub-table td {
            padding: 11px 16px;
            border-bottom: 1px solid var(--border);
            font-size: 13px; color: var(--text-main);
            vertical-align: middle;
        }
        .pub-table tbody tr:hover { background: var(--bg-card2) !important; }
        .pub-table tbody tr:last-child td { border-bottom: none; }
        .rank-gold { background: rgba(245,158,11,0.08) !important; }
        .rank-silver { background: rgba(148,163,184,0.04) !important; }
        .rank-bronze { background: rgba(146,64,14,0.06) !important; }

        /* Rank badge */
        .badge-1 { background: linear-gradient(135deg,#f59e0b,#d97706); color:#000; font-weight:700; font-size:11px; padding:3px 8px; border-radius:6px; }
        .badge-2 { background: #94a3b8; color:#000; font-weight:700; font-size:11px; padding:3px 8px; border-radius:6px; }
        .badge-3 { background: #92400e; color:#fff; font-weight:700; font-size:11px; padding:3px 8px; border-radius:6px; }
        .badge-n { color: var(--text-dim); font-size:13px; }

        /* Team avatar */
        .team-avatar {
            width: 30px; height: 30px;
            background: rgba(124,58,237,0.15);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 10px; font-weight: 800; color: var(--purple);
            flex-shrink: 0;
        }

        /* ── Progress bar ── */
        .kill-bar-wrap { display: flex; align-items: center; gap: 8px; }
        .kill-bar { flex: 1; height: 4px; background: var(--border); border-radius: 99px; }
        .kill-bar-fill { height: 100%; border-radius: 99px; }

        /* ── Footer ── */
        .pub-footer {
            background: var(--bg-card); border-top: 1px solid var(--border);
            text-align: center; padding: 16px 24px;
            font-size: 11px; color: var(--text-dim);
        }

        /* ── Tab pills ── */
        .section-tabs { display: flex; gap: 4px; }
        .section-tab {
            padding: 5px 14px; border-radius: 99px; font-size: 12px; font-weight: 600;
            cursor: pointer; border: 1px solid var(--border);
            color: var(--text-muted); background: transparent; transition: all 0.2s;
        }
        .section-tab.active { background: var(--gold); color: #000; border-color: var(--gold); }

        /* Print */
        @media print {
            .pub-navbar, .hero, .no-print, .chart-section { display: none !important; }
            body, .card-dark { background: white !important; color: black !important; border-color: #ccc !important; }
        }
    </style>
</head>
<body>

{{-- ═══ NAVBAR ═══ --}}
<nav class="pub-navbar">
    <a class="brand" href="{{ route('home') }}">
        <div class="brand-icon">PM</div>
        <div>
            <div class="brand-text">PUBG TOURNAMENT</div>
            <div class="brand-sub">PMWC 2024 LIVE STANDINGS</div>
        </div>
    </a>

    <div class="nav-links d-none d-md-flex">
        <a href="{{ route('home') }}" class="active"><i class="bi bi-grid-fill me-1"></i>Dashboard</a>
        <a href="{{ route('standings') }}"><i class="bi bi-trophy me-1"></i>Standings</a>
        <a href="{{ route('mostkills') }}"><i class="bi bi-crosshair me-1"></i>Most Kills</a>
    </div>

    <div class="ms-auto d-flex align-items-center gap-3">
        <div class="live-badge d-none d-sm-flex">
            <div class="live-dot"></div>
            LIVE
        </div>
        {{-- Link admin tersembunyi - hanya teks kecil warna muted --}}
        @if(session('role') === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm"
               style="background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.2);color:#f59e0b;font-size:11px;font-weight:600">
                <i class="bi bi-speedometer2 me-1"></i>Admin Panel
            </a>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-sm" style="background:transparent;border:1px solid var(--border);color:var(--text-dim);font-size:11px">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        @else
            {{-- Link admin tersembunyi - sangat subtle --}}
            <a href="{{ route('login') }}" style="font-size:10px;color:#1e2a4a;text-decoration:none" title="Admin">·</a>
        @endif
    </div>
</nav>

{{-- ═══ HERO ═══ --}}
<div class="hero">
    <div class="hero-title">PUBG Mobile Tournament</div>
    <div class="hero-sub">
        <i class="bi bi-calendar-event me-1"></i>PMWC 2024 Point System &nbsp;·&nbsp;
        <span id="live-clock"></span>
    </div>
</div>

{{-- ═══ MAIN CONTENT ═══ --}}
<div class="container-fluid px-3 px-md-4 py-4">

    {{-- ── STAT CARDS ── --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:rgba(245,158,11,0.12);color:#f59e0b">
                    <i class="bi bi-flag-fill"></i>
                </div>
                <div>
                    <div class="stat-label">Total Match</div>
                    <div class="stat-value">{{ $totalMatches }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:rgba(124,58,237,0.12);color:#7c3aed">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <div class="stat-label">Total Tim</div>
                    <div class="stat-value">{{ $totalTeams }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:rgba(239,68,68,0.12);color:#ef4444">
                    <i class="bi bi-crosshair2"></i>
                </div>
                <div>
                    <div class="stat-label">Total Kills</div>
                    <div class="stat-value">{{ $totalKills }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:rgba(16,185,129,0.12);color:#10b981">
                    <i class="bi bi-crown-fill"></i>
                </div>
                <div>
                    <div class="stat-label">Pemimpin</div>
                    @if($leader)
                        <div style="font-size:15px;font-weight:800;color:#10b981;line-height:1.2">{{ $leader['team']->name }}</div>
                        <div class="stat-sub">{{ $leader['total_pts'] }} pts</div>
                    @else
                        <div class="stat-value" style="font-size:20px">—</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ── CHART ROW ── --}}
    @if($totalMatches > 0)
    <div class="row g-3 mb-4 chart-section">
        {{-- Bar Chart: Total Poin per Tim --}}
        <div class="col-12 col-lg-8">
            <div class="card-dark">
                <div class="card-header-dark">
                    <span class="section-title">
                        <i class="bi bi-bar-chart-fill"></i> Total Poin per Tim (Top 10)
                    </span>
                    <span style="font-size:10px;color:var(--text-dim)">Place Pts + Elim Pts</span>
                </div>
                <div class="p-3" style="height:260px">
                    <canvas id="chartBar"></canvas>
                </div>
            </div>
        </div>
        {{-- Top Killer Doughnut/Stats --}}
        <div class="col-12 col-lg-4">
            <div class="card-dark h-100">
                <div class="card-header-dark">
                    <span class="section-title">
                        <i class="bi bi-trophy-fill" style="color:#f59e0b"></i> Top Terminator
                    </span>
                </div>
                <div class="p-3">
                    @foreach(array_slice($topKillers, 0, 5) as $idx => $killer)
                    @php $maxKills = $topKillers[0]['kills'] ?: 1; @endphp
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div style="width:20px;text-align:center">
                            @if($idx === 0) <span style="color:#f59e0b;font-size:12px;font-weight:800">#1</span>
                            @elseif($idx === 1) <span style="color:#94a3b8;font-size:11px">#2</span>
                            @elseif($idx === 2) <span style="color:#92400e;font-size:11px">#3</span>
                            @else <span style="color:var(--text-dim);font-size:11px">#{{ $idx+1 }}</span>
                            @endif
                        </div>
                        <div style="flex:1;min-width:0">
                            <div style="font-size:12px;font-weight:700;color:#f1f5f9;truncate">
                                {{ $killer['name'] }}
                                @if($killer['slot'] == 4)<span style="font-size:9px;color:#7c3aed;background:rgba(124,58,237,0.1);padding:1px 4px;border-radius:4px;margin-left:3px">R</span>@endif
                            </div>
                            <div style="font-size:10px;color:var(--text-muted)">{{ $killer['team'] }}</div>
                            <div class="kill-bar-wrap mt-1">
                                <div class="kill-bar">
                                    <div class="kill-bar-fill" style="width:{{ $maxKills > 0 ? round($killer['kills']/$maxKills*100) : 0 }}%;background:{{ $idx===0?'#f59e0b':($idx===1?'#94a3b8':($idx===2?'#92400e':'#2a3050')) }}"></div>
                                </div>
                                <span style="font-size:12px;font-weight:800;color:{{ $idx===0?'#f59e0b':'#94a3b8' }};flex-shrink:0;width:30px;text-align:right">{{ $killer['kills'] }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Line Chart: Tren Poin --}}
    @if($totalMatches > 1)
    <div class="row g-3 mb-4 chart-section">
        <div class="col-12">
            <div class="card-dark">
                <div class="card-header-dark">
                    <span class="section-title">
                        <i class="bi bi-graph-up-arrow" style="color:#10b981"></i> Tren Poin Akumulatif — Top 5 Tim
                    </span>
                    <span style="font-size:10px;color:var(--text-dim)">Per Match</span>
                </div>
                <div class="p-3" style="height:240px">
                    <canvas id="chartLine"></canvas>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif

    {{-- ── STANDINGS TABLE ── --}}
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card-dark">
                <div class="card-header-dark">
                    <span class="section-title">
                        <i class="bi bi-list-ol"></i> Overall Team Standings
                    </span>
                    <div class="d-flex align-items-center gap-2 no-print">
                        <span style="font-size:10px;color:var(--text-dim)">Updated {{ now()->format('d M, H:i') }}</span>
                        <button onclick="window.print()" class="btn btn-sm" style="background:transparent;border:1px solid var(--border);color:var(--text-muted);font-size:11px">
                            <i class="bi bi-printer me-1"></i>Print
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="pub-table">
                        <thead>
                            <tr>
                                <th style="width:50px;text-align:center">Rank</th>
                                <th>Nama Tim</th>
                                <th style="text-align:center;width:70px">Match</th>
                                <th style="text-align:center;width:65px">WWCD</th>
                                <th style="text-align:center;width:85px">Place Pts</th>
                                <th style="text-align:center;width:85px">Elim Pts</th>
                                <th style="text-align:center;width:90px">Total Pts</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($standings as $i => $s)
                            <tr class="{{ $i===0?'rank-gold':($i===1?'rank-silver':($i===2?'rank-bronze':'')) }}">
                                <td style="text-align:center">
                                    @if($i===0) <span class="badge-1">1</span>
                                    @elseif($i===1) <span class="badge-2">2</span>
                                    @elseif($i===2) <span class="badge-3">3</span>
                                    @else <span class="badge-n">{{ $i+1 }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="team-avatar">{{ strtoupper(substr($s['team']->name,0,2)) }}</div>
                                        <span style="font-weight:600;color:{{ $i===0?'#f59e0b':'#e2e8f0' }}">{{ $s['team']->name }}</span>
                                    </div>
                                </td>
                                <td style="text-align:center;color:var(--text-muted)">{{ $s['played'] }}</td>
                                <td style="text-align:center">
                                    @if($s['wwcd']>0)
                                        <span style="color:#f59e0b;font-weight:700"><i class="bi bi-trophy-fill" style="font-size:10px"></i> {{ $s['wwcd'] }}</span>
                                    @else
                                        <span style="color:var(--text-dim)">—</span>
                                    @endif
                                </td>
                                <td style="text-align:center;color:#7c3aed;font-weight:600">{{ $s['place_pts'] }}</td>
                                <td style="text-align:center;color:#f59e0b;font-weight:600">{{ $s['elim_pts'] }}</td>
                                <td style="text-align:center">
                                    <span style="font-size:{{ $i<3?'17':'14' }}px;font-weight:800;color:{{ $i===0?'#f59e0b':($i<3?'#10b981':'#f1f5f9') }}">
                                        {{ $s['total_pts'] }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="text-align:center;padding:40px;color:var(--text-dim)">
                                    <i class="bi bi-trophy" style="font-size:32px;display:block;margin-bottom:8px"></i>
                                    Belum ada data pertandingan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ── MOST KILLS TABLE ── --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-6">
            <div class="card-dark">
                <div class="card-header-dark">
                    <span class="section-title">
                        <i class="bi bi-crosshair2" style="color:#ef4444"></i> Most Kills — Top 10 Terminator
                    </span>
                </div>
                <div class="table-responsive">
                    <table class="pub-table">
                        <thead>
                            <tr>
                                <th style="width:40px;text-align:center">#</th>
                                <th>Player</th>
                                <th>Tim</th>
                                <th style="text-align:center;width:70px">Kills</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topKillers as $i => $killer)
                            <tr style="{{ $i===0?'background:rgba(239,68,68,0.06)!important;':'' }}">
                                <td style="text-align:center">
                                    @if($i===0) <span class="badge-1">1</span>
                                    @elseif($i===1) <span class="badge-2">2</span>
                                    @elseif($i===2) <span class="badge-3">3</span>
                                    @else <span class="badge-n">{{ $i+1 }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span style="font-weight:600;color:{{ $i===0?'#ef4444':'#e2e8f0' }}">
                                        {{ $killer['name'] }}
                                    </span>
                                    @if($killer['slot']==4)
                                        <span style="font-size:9px;color:#7c3aed;background:rgba(124,58,237,0.1);padding:1px 5px;border-radius:4px;margin-left:4px">Reserve</span>
                                    @endif
                                </td>
                                <td style="color:var(--text-muted);font-size:12px">{{ $killer['team'] }}</td>
                                <td style="text-align:center;font-weight:800;font-size:{{ $i===0?'16':'13' }}px;color:{{ $i===0?'#ef4444':($i<3?'#f59e0b':'#f1f5f9') }}">
                                    {{ $killer['kills'] }}
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" style="text-align:center;padding:32px;color:var(--text-dim)">Belum ada data kill.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- PMWC Rules Card --}}
        <div class="col-12 col-lg-6">
            <div class="card-dark">
                <div class="card-header-dark">
                    <span class="section-title">
                        <i class="bi bi-clipboard-check"></i> PMWC 2024 Point System
                    </span>
                </div>
                <div class="p-3">
                    <div class="row g-2">
                        @php
                        $pointRules = [
                            ['rank'=>'1st (WWCD)', 'pts'=>10, 'color'=>'#f59e0b'],
                            ['rank'=>'2nd', 'pts'=>6, 'color'=>'#94a3b8'],
                            ['rank'=>'3rd', 'pts'=>5, 'color'=>'#92400e'],
                            ['rank'=>'4th', 'pts'=>4, 'color'=>'#64748b'],
                            ['rank'=>'5th', 'pts'=>3, 'color'=>'#64748b'],
                            ['rank'=>'6th', 'pts'=>2, 'color'=>'#64748b'],
                            ['rank'=>'7th – 8th', 'pts'=>1, 'color'=>'#4a5568'],
                            ['rank'=>'9th – 18th', 'pts'=>0, 'color'=>'#2a3050'],
                        ];
                        @endphp
                        @foreach($pointRules as $rule)
                        <div class="col-6">
                            <div style="display:flex;justify-content:space-between;align-items:center;background:rgba(255,255,255,0.02);border:1px solid var(--border);border-radius:8px;padding:8px 12px">
                                <span style="font-size:12px;color:#94a3b8;font-weight:500">{{ $rule['rank'] }}</span>
                                <span style="font-size:13px;font-weight:800;color:{{ $rule['color'] }}">{{ $rule['pts'] }} pts</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div style="margin-top:12px;background:rgba(245,158,11,0.06);border:1px solid rgba(245,158,11,0.15);border-radius:10px;padding:10px 14px;text-align:center">
                        <span style="color:#f59e0b;font-weight:700;font-size:13px">+ 1 poin per eliminasi/kill</span>
                        <div style="font-size:11px;color:var(--text-muted);margin-top:2px">Total = Place Pts + Kill Pts (tanpa batas)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>{{-- end container --}}

{{-- ═══ FOOTER ═══ --}}
<div class="pub-footer no-print">
    <i class="bi bi-controller me-1" style="color:#f59e0b"></i>
    PMWC 2024 — PUBG Tournament Manager &nbsp;·&nbsp; All rights reserved
    &nbsp;·&nbsp;
    <a href="{{ route('standings') }}" style="color:var(--text-dim);text-decoration:none">Standings</a>
    &nbsp;·&nbsp;
    <a href="{{ route('mostkills') }}" style="color:var(--text-dim);text-decoration:none">Most Kills</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ── Live Clock ──
function updateClock() {
    const now = new Date();
    document.getElementById('live-clock').textContent =
        now.toLocaleDateString('id-ID', {weekday:'short', day:'numeric', month:'short', year:'numeric'}) +
        ' · ' + now.toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit', second:'2-digit'});
}
updateClock();
setInterval(updateClock, 1000);

// ── Chart Defaults ──
const chartDefaults = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: { labels: { color: '#94a3b8', font: { size: 11 }, boxWidth: 12 } },
        tooltip: {
            backgroundColor: '#1e2a4a',
            titleColor: '#f1f5f9',
            bodyColor: '#94a3b8',
            borderColor: '#2a3050',
            borderWidth: 1,
        }
    },
    scales: {
        x: { ticks: { color: '#64748b', font: { size: 10 } }, grid: { color: '#1e2a4a' } },
        y: { ticks: { color: '#64748b', font: { size: 10 } }, grid: { color: '#1e2a4a' } },
    }
};

@if($totalMatches > 0)
// ── Bar Chart: Total Poin per Tim ──
const barCtx = document.getElementById('chartBar');
if (barCtx) {
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: @json($chartBar['labels']),
            datasets: [
                {
                    label: 'Place Pts',
                    data: @json($chartBar['placePts']),
                    backgroundColor: 'rgba(124,58,237,0.75)',
                    borderColor: '#7c3aed',
                    borderWidth: 1,
                    borderRadius: 4,
                },
                {
                    label: 'Elim Pts',
                    data: @json($chartBar['elimPts']),
                    backgroundColor: 'rgba(245,158,11,0.75)',
                    borderColor: '#f59e0b',
                    borderWidth: 1,
                    borderRadius: 4,
                }
            ]
        },
        options: {
            ...chartDefaults,
            scales: {
                x: { stacked: true, ticks: { color: '#64748b', font: { size: 10 } }, grid: { color: '#1e2a4a' } },
                y: { stacked: true, ticks: { color: '#64748b', font: { size: 10 } }, grid: { color: '#1e2a4a' } },
            }
        }
    });
}

@if($totalMatches > 1)
// ── Line Chart: Tren Poin ──
const lineCtx = document.getElementById('chartLine');
if (lineCtx) {
    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: @json($chartLine['labels']),
            datasets: @json($chartLine['datasets'])
        },
        options: {
            ...chartDefaults,
            plugins: {
                ...chartDefaults.plugins,
                tooltip: { ...chartDefaults.plugins.tooltip, mode: 'index', intersect: false }
            }
        }
    });
}
@endif
@endif
</script>
</body>
</html>
