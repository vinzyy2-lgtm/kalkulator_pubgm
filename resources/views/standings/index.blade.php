@extends('layouts.public')
@section('page-title', 'Team Standings')

@section('content')

{{-- Page Header --}}
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h4 style="color:#f1f5f9;font-weight:800;font-size:22px;margin:0">
            <i class="bi bi-trophy-fill me-2" style="color:#f59e0b"></i>Team Standings
        </h4>
        <p style="color:#64748b;font-size:12px;margin:4px 0 0">PMWC 2024 — Live Tournament Rankings</p>
    </div>
    <div class="d-flex gap-2 no-print">
        <button onclick="window.print()" class="btn btn-sm" style="background:#161b2e;border:1px solid #1e2a4a;color:#94a3b8;font-size:12px">
            <i class="bi bi-printer me-1"></i>Print PDF
        </button>
    </div>
</div>

{{-- Stat Cards --}}
@php
    $totalTeams    = $standings->count();
    $totalMatches  = $standings->max('matches_played') ?? 0;
    $totalKills    = $standings->sum('total_kills');
    $leader        = $standings->first();
@endphp
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:rgba(124,58,237,0.15);color:#7c3aed">
                <i class="bi bi-people-fill"></i>
            </div>
            <div>
                <div style="font-size:10px;color:#64748b;text-transform:uppercase;font-weight:700">Tim</div>
                <div style="font-size:24px;font-weight:800;color:#f1f5f9;line-height:1.1">{{ $totalTeams }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:rgba(245,158,11,0.15);color:#f59e0b">
                <i class="bi bi-flag-fill"></i>
            </div>
            <div>
                <div style="font-size:10px;color:#64748b;text-transform:uppercase;font-weight:700">Matches</div>
                <div style="font-size:24px;font-weight:800;color:#f1f5f9;line-height:1.1">{{ $totalMatches }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:rgba(239,68,68,0.15);color:#ef4444">
                <i class="bi bi-crosshair2"></i>
            </div>
            <div>
                <div style="font-size:10px;color:#64748b;text-transform:uppercase;font-weight:700">Total Kills</div>
                <div style="font-size:24px;font-weight:800;color:#f1f5f9;line-height:1.1">{{ $totalKills }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:rgba(16,185,129,0.15);color:#10b981">
                <i class="bi bi-crown-fill"></i>
            </div>
            <div>
                <div style="font-size:10px;color:#64748b;text-transform:uppercase;font-weight:700">Leader</div>
                <div style="font-size:13px;font-weight:800;color:#10b981;line-height:1.2">
                    {{ $leader ? $leader['team']->name : '—' }}
                </div>
                @if($leader)
                    <div style="font-size:10px;color:#64748b">{{ $leader['total_points'] }} pts</div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Standings Table --}}
<div class="card-dark p-0 overflow-hidden">
    <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-bottom:1px solid #1e2a4a">
        <h6 class="mb-0" style="color:#f1f5f9;font-weight:700;font-size:14px">
            <i class="bi bi-table me-2" style="color:#f59e0b"></i>Klasemen Lengkap
        </h6>
        <span style="font-size:11px;color:#4a5568">Last updated: {{ now()->format('d M Y, H:i') }}</span>
    </div>

    <div class="table-responsive">
        <table class="table table-dark-custom mb-0">
            <thead>
                <tr>
                    <th style="width:50px">Rank</th>
                    <th>Tim</th>
                    <th class="text-center" style="width:80px">Matches</th>
                    <th class="text-center" style="width:70px">WWCD</th>
                    <th class="text-center" style="width:90px">Place Pts</th>
                    <th class="text-center" style="width:90px">Elim Pts</th>
                    <th class="text-center" style="width:90px">Total Pts</th>
                    <th class="text-center" style="width:80px">Best Rank</th>
                </tr>
            </thead>
            <tbody>
                @forelse($standings as $idx => $s)
                    @php
                        $rank      = $idx + 1;
                        $team      = $s['team'];
                        $placePts  = $team->matchResults->sum(fn($r) => $r->getPlacePoints());
                        $elimPts   = $team->matchResults->sum(fn($r) => $r->getTotalKills());
                        $wwcd      = $team->matchResults->where('rank', 1)->count();
                        $rowBg     = '';
                        if ($rank === 1)      $rowBg = 'background:rgba(245,158,11,0.08)!important;';
                        elseif ($rank === 2)  $rowBg = 'background:rgba(148,163,184,0.05)!important;';
                        elseif ($rank === 3)  $rowBg = 'background:rgba(146,64,14,0.07)!important;';
                    @endphp
                    <tr style="{{ $rowBg }}">
                        <td>
                            @if($rank === 1)
                                <span class="badge badge-rank-1 px-2 py-1">#1</span>
                            @elseif($rank === 2)
                                <span class="badge badge-rank-2 px-2 py-1">#2</span>
                            @elseif($rank === 3)
                                <span class="badge badge-rank-3 px-2 py-1">#3</span>
                            @else
                                <span style="color:#64748b;font-size:13px">#{{ $rank }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:26px;height:26px;background:rgba(124,58,237,0.15);border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;color:#7c3aed;flex-shrink:0">
                                    {{ strtoupper(substr($team->name, 0, 2)) }}
                                </div>
                                <span style="font-weight:600;color:{{ $rank === 1 ? '#f59e0b' : '#e2e8f0' }};font-size:13px">{{ $team->name }}</span>
                            </div>
                        </td>
                        <td class="text-center" style="color:#94a3b8">{{ $s['matches_played'] }}</td>
                        <td class="text-center">
                            @if($wwcd > 0)
                                <span style="color:#f59e0b;font-weight:700">
                                    <i class="bi bi-trophy-fill" style="font-size:10px"></i> {{ $wwcd }}
                                </span>
                            @else
                                <span style="color:#2a3050">—</span>
                            @endif
                        </td>
                        <td class="text-center"><span style="color:#7c3aed;font-weight:600">{{ $placePts }}</span></td>
                        <td class="text-center"><span style="color:#f59e0b;font-weight:600">{{ $elimPts }}</span></td>
                        <td class="text-center">
                            <span style="font-size:{{ $rank <= 3 ? '16' : '14' }}px;font-weight:800;color:{{ $rank === 1 ? '#f59e0b' : ($rank <= 3 ? '#10b981' : '#f1f5f9') }}">
                                {{ $s['total_points'] }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($s['best_rank'])
                                <span style="color:#{{ $s['best_rank'] === 1 ? 'f59e0b' : '94a3b8' }};font-weight:{{ $s['best_rank'] === 1 ? '700' : '400' }}">
                                    #{{ $s['best_rank'] }}{{ $s['best_rank'] === 1 ? ' 🏆' : '' }}
                                </span>
                            @else
                                <span style="color:#2a3050">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5" style="color:#4a5568">
                            <i class="bi bi-trophy" style="font-size:32px;display:block;margin-bottom:8px"></i>
                            Belum ada data standings.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
