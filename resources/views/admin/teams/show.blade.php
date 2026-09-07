@extends('layouts.admin')
@section('page-title', 'Detail Tim: {{ $team->name }}')

@section('content')

<div class="d-flex align-items-center mb-4">
    <a href="{{ route('admin.teams.index') }}" class="btn btn-sm me-3" style="background:#161b2e;border:1px solid #1e2a4a;color:#94a3b8">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
    <a href="{{ route('admin.teams.edit', $team) }}" class="btn btn-sm btn-pubg">
        <i class="bi bi-pencil me-1"></i>Edit Tim
    </a>
</div>

<div class="row g-4">
    {{-- Team Info --}}
    <div class="col-12 col-md-5">
        <div class="card-dark p-4">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div style="width:52px;height:52px;background:linear-gradient(135deg,#7c3aed,#f59e0b);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:900;color:white">
                    {{ strtoupper(substr($team->name, 0, 2)) }}
                </div>
                <div>
                    <h5 style="color:#f1f5f9;font-weight:800;margin:0;font-size:18px">{{ $team->name }}</h5>
                    <span style="font-size:11px;color:#64748b">Tim #{{ $team->order }}</span>
                </div>
            </div>

            {{-- Stats --}}
            @php
                $stats = $team->getStandingsData();
                $placePts = $team->matchResults->sum(fn($r) => $r->getPlacePoints());
                $elimPts  = $team->matchResults->sum(fn($r) => $r->getTotalKills());
                $wwcd     = $team->matchResults->where('rank', 1)->count();
            @endphp
            <div class="row g-2">
                <div class="col-6">
                    <div class="p-2 rounded" style="background:#0d1117;border:1px solid #1e2a4a;text-align:center">
                        <div style="font-size:10px;color:#64748b;font-weight:700;text-transform:uppercase">Total Pts</div>
                        <div style="font-size:20px;font-weight:800;color:#f59e0b">{{ $stats['total_points'] }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-2 rounded" style="background:#0d1117;border:1px solid #1e2a4a;text-align:center">
                        <div style="font-size:10px;color:#64748b;font-weight:700;text-transform:uppercase">Total Kills</div>
                        <div style="font-size:20px;font-weight:800;color:#ef4444">{{ $stats['total_kills'] }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-2 rounded" style="background:#0d1117;border:1px solid #1e2a4a;text-align:center">
                        <div style="font-size:10px;color:#64748b;font-weight:700;text-transform:uppercase">Matches</div>
                        <div style="font-size:20px;font-weight:800;color:#7c3aed">{{ $stats['matches_played'] }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-2 rounded" style="background:#0d1117;border:1px solid #1e2a4a;text-align:center">
                        <div style="font-size:10px;color:#64748b;font-weight:700;text-transform:uppercase">WWCD</div>
                        <div style="font-size:20px;font-weight:800;color:#10b981">{{ $wwcd }}</div>
                    </div>
                </div>
            </div>

            {{-- Players --}}
            <div class="mt-4">
                <div style="font-size:11px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:10px">Roster</div>
                @foreach($team->players->sortBy('slot') as $player)
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge" style="background:{{ $player->slot === 4 ? 'rgba(239,68,68,0.15)' : 'rgba(124,58,237,0.15)' }};color:{{ $player->slot === 4 ? '#ef4444' : '#a78bfa' }};font-size:10px;min-width:36px;text-align:center">
                            {{ $player->getSlotLabel() }}
                        </span>
                        <span style="font-size:13px;color:#e2e8f0">{{ $player->name }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Match Results History --}}
    <div class="col-12 col-md-7">
        <div class="card-dark p-4">
            <h6 class="mb-3" style="color:#f1f5f9;font-weight:700;font-size:14px">
                <i class="bi bi-clock-history me-2" style="color:#f59e0b"></i>Riwayat Match
            </h6>

            <div class="table-responsive">
                <table class="table table-dark-custom mb-0">
                    <thead>
                        <tr>
                            <th>Match</th>
                            <th class="text-center">Rank</th>
                            <th class="text-center">Place Pts</th>
                            <th class="text-center">Kills</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($team->matchResults->sortBy('game_match_id') as $result)
                            <tr>
                                <td>
                                    <span style="color:#94a3b8;font-size:12px">Match #{{ $result->gameMatch->match_number }}</span>
                                </td>
                                <td class="text-center">
                                    @if($result->rank === 1)
                                        <span class="badge badge-rank-1">#1 WWCD</span>
                                    @elseif($result->rank <= 3)
                                        <span style="color:#10b981;font-weight:700">#{{ $result->rank }}</span>
                                    @else
                                        <span style="color:#64748b">#{{ $result->rank }}</span>
                                    @endif
                                </td>
                                <td class="text-center"><span style="color:#7c3aed;font-weight:600">{{ $result->getPlacePoints() }}</span></td>
                                <td class="text-center"><span style="color:#f59e0b;font-weight:600">{{ $result->getTotalKills() }}</span></td>
                                <td class="text-center"><span style="color:#10b981;font-weight:700">{{ $result->getTotalPoints() }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4" style="color:#4a5568">Belum ada hasil match.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
