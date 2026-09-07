@extends('layouts.public')
@section('page-title', 'Most Kills')

@section('content')

{{-- Page Header --}}
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h4 style="color:#f1f5f9;font-weight:800;font-size:22px;margin:0">
            <i class="bi bi-crosshair2 me-2" style="color:#ef4444"></i>Most Kills
        </h4>
        <p style="color:#64748b;font-size:12px;margin:4px 0 0">PMWC 2024 — Top Terminators Leaderboard</p>
    </div>
    <div class="d-flex gap-2 no-print">
        <button onclick="window.print()" class="btn btn-sm" style="background:#161b2e;border:1px solid #1e2a4a;color:#94a3b8;font-size:12px">
            <i class="bi bi-printer me-1"></i>Print PDF
        </button>
    </div>
</div>

{{-- Stats --}}
@php
    $totalPlayers = count($leaderboard);
    $totalKills   = array_sum(array_column($leaderboard, 'kills'));
    $topKiller    = $leaderboard[0] ?? null;
@endphp
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-4">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:rgba(239,68,68,0.15);color:#ef4444">
                <i class="bi bi-crosshair2"></i>
            </div>
            <div>
                <div style="font-size:10px;color:#64748b;text-transform:uppercase;font-weight:700">Total Players</div>
                <div style="font-size:24px;font-weight:800;color:#f1f5f9;line-height:1.1">{{ $totalPlayers }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-4">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:rgba(245,158,11,0.15);color:#f59e0b">
                <i class="bi bi-fire"></i>
            </div>
            <div>
                <div style="font-size:10px;color:#64748b;text-transform:uppercase;font-weight:700">Total Kills</div>
                <div style="font-size:24px;font-weight:800;color:#f1f5f9;line-height:1.1">{{ $totalKills }}</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:rgba(16,185,129,0.15);color:#10b981">
                <i class="bi bi-trophy-fill"></i>
            </div>
            <div>
                <div style="font-size:10px;color:#64748b;text-transform:uppercase;font-weight:700">Top Killer</div>
                <div style="font-size:13px;font-weight:800;color:#10b981;line-height:1.2">
                    {{ $topKiller ? $topKiller['player']->name : '—' }}
                </div>
                @if($topKiller)
                    <div style="font-size:10px;color:#64748b">{{ $topKiller['kills'] }} kills · {{ $topKiller['team']->name }}</div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Leaderboard Table --}}
<div class="card-dark p-0 overflow-hidden">
    <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-bottom:1px solid #1e2a4a">
        <h6 class="mb-0" style="color:#f1f5f9;font-weight:700;font-size:14px">
            <i class="bi bi-person-fill me-2" style="color:#ef4444"></i>Leaderboard Kills
        </h6>
        <span style="font-size:11px;color:#4a5568">Semua Match · {{ $totalPlayers }} pemain</span>
    </div>

    <div class="table-responsive">
        <table class="table table-dark-custom mb-0">
            <thead>
                <tr>
                    <th style="width:50px">Rank</th>
                    <th>Pemain</th>
                    <th>Tim</th>
                    <th class="text-center" style="width:70px">Slot</th>
                    <th class="text-center" style="width:100px">Total Kills</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leaderboard as $idx => $entry)
                    @php
                        $rank = $idx + 1;
                        $isReserve = $entry['slot_label'] === 'Reserve';
                        $rowBg = '';
                        if ($rank === 1) $rowBg = 'background:rgba(239,68,68,0.07)!important;';
                        elseif ($rank === 2) $rowBg = 'background:rgba(239,68,68,0.04)!important;';
                        elseif ($rank === 3) $rowBg = 'background:rgba(239,68,68,0.02)!important;';
                    @endphp
                    <tr style="{{ $rowBg }}">
                        <td>
                            @if($rank === 1)
                                <span class="badge" style="background:linear-gradient(135deg,#ef4444,#dc2626);color:white;padding:4px 8px">#1</span>
                            @elseif($rank === 2)
                                <span class="badge badge-rank-2 px-2">#2</span>
                            @elseif($rank === 3)
                                <span class="badge badge-rank-3 px-2">#3</span>
                            @else
                                <span style="color:#64748b;font-size:13px">#{{ $rank }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:26px;height:26px;background:rgba(239,68,68,0.12);border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;color:#ef4444;flex-shrink:0">
                                    {{ strtoupper(substr($entry['player']->name, 0, 2)) }}
                                </div>
                                <span style="font-weight:600;color:{{ $rank === 1 ? '#ef4444' : '#e2e8f0' }};font-size:13px">
                                    {{ $entry['player']->name }}
                                </span>
                            </div>
                        </td>
                        <td>
                            <span style="font-size:12px;color:#94a3b8">{{ $entry['team']->name }}</span>
                        </td>
                        <td class="text-center">
                            @if($isReserve)
                                <span class="badge" style="background:rgba(239,68,68,0.15);color:#ef4444;font-size:10px;border:1px solid rgba(239,68,68,0.2)">R</span>
                            @else
                                <span style="font-size:12px;color:#64748b">{{ $entry['slot_label'] }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($entry['kills'] > 0)
                                <div class="d-flex align-items-center justify-content-center gap-1">
                                    <span style="font-size:{{ $rank === 1 ? '18' : '15' }}px;font-weight:800;color:{{ $rank === 1 ? '#ef4444' : ($rank <= 3 ? '#f59e0b' : '#f1f5f9') }}">
                                        {{ $entry['kills'] }}
                                    </span>
                                    @if($rank === 1)
                                        <i class="bi bi-fire" style="color:#ef4444;font-size:12px"></i>
                                    @endif
                                </div>
                                {{-- Kill bar indicator --}}
                                @if($topKiller && $topKiller['kills'] > 0)
                                    <div style="height:3px;background:#1e2a4a;border-radius:2px;margin-top:4px;max-width:80px;margin-left:auto;margin-right:auto">
                                        <div style="height:100%;background:{{ $rank === 1 ? '#ef4444' : '#f59e0b' }};border-radius:2px;width:{{ round(($entry['kills'] / $topKiller['kills']) * 100) }}%"></div>
                                    </div>
                                @endif
                            @else
                                <span style="color:#2a3050;font-size:13px">0</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5" style="color:#4a5568">
                            <i class="bi bi-crosshair2" style="font-size:32px;display:block;margin-bottom:8px"></i>
                            Belum ada data kills.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
