@extends('layouts.admin')
@section('page-title', 'Input Match #{{ $match->match_number }}')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <a href="{{ route('admin.matches.index') }}" class="btn btn-sm" style="background:#161b2e;border:1px solid #1e2a4a;color:#94a3b8">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
    <div style="font-size:12px;color:#64748b">
        <i class="bi bi-info-circle me-1"></i>Rank 1=10pts, 2=6, 3=5, 4=4, 5=3, 6=2, 7-8=1, 9-18=0
    </div>
</div>

@if(session('success'))
    <div class="alert mb-4" style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.3);color:#6ee7b7;border-radius:10px;font-size:13px;padding:12px 16px">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    </div>
@endif

{{-- Search bar --}}
<div class="mb-3">
    <div class="input-group" style="max-width:300px">
        <span class="input-group-text" style="background:#0d1117;border:1px solid #1e2a4a;color:#64748b;border-right:none">
            <i class="bi bi-search"></i>
        </span>
        <input type="text" id="teamSearchInput" class="form-control form-control-dark" placeholder="Filter tim..."
            oninput="filterTeams()" style="border-left:none;font-size:13px">
    </div>
</div>

{{-- Match Form --}}
<form action="{{ route('admin.matches.results.store', $match) }}" method="POST" id="matchForm">
    @csrf

    <div id="teamsContainer" class="row g-3 mb-4">
        @foreach($teams as $team)
            @php
                $result = $resultsMap[$team->id] ?? null;
                $players = $team->players->sortBy('slot');
            @endphp
            <div class="col-12 team-row" data-team="{{ strtolower($team->name) }}">
                <div class="card-dark p-3">
                    <div class="row align-items-start g-3">
                        {{-- Team name + rank --}}
                        <div class="col-12 col-md-3">
                            <div style="font-size:13px;font-weight:700;color:#f1f5f9;margin-bottom:8px">
                                <i class="bi bi-people-fill me-1" style="color:#7c3aed"></i>{{ $team->name }}
                            </div>
                            <label style="font-size:10px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;display:block;margin-bottom:4px">Rank (1-18)</label>
                            <input type="number"
                                name="results[{{ $team->id }}][rank]"
                                id="rank_{{ $team->id }}"
                                class="form-control form-control-dark"
                                style="width:80px;font-size:14px;font-weight:700;text-align:center"
                                min="1" max="18"
                                value="{{ $result ? $result->rank : 18 }}"
                                oninput="calcTeamScore({{ $team->id }})">
                        </div>

                        {{-- Kills per player --}}
                        <div class="col-12 col-md-6">
                            <label style="font-size:10px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;display:block;margin-bottom:4px">Kills per Pemain</label>
                            <div class="d-flex gap-1 flex-wrap">
                                @foreach($players as $player)
                                    <div style="text-align:center;min-width:52px">
                                        <div style="font-size:9px;color:#4a5568;margin-bottom:2px;white-space:nowrap;overflow:hidden;max-width:52px;text-overflow:ellipsis" title="{{ $player->name }}">
                                            {{ $player->getSlotLabel() }}: {{ Str::limit($player->name, 6) }}
                                        </div>
                                        <input type="number"
                                            name="results[{{ $team->id }}][p{{ $player->slot }}_kills]"
                                            id="kill_{{ $team->id }}_{{ $player->slot }}"
                                            class="form-control form-control-dark text-center input-kill"
                                            style="font-size:13px;padding:4px 2px"
                                            min="0" max="99"
                                            value="{{ $result ? $result->{'p' . $player->slot . '_kills'} : 0 }}"
                                            oninput="calcTeamScore({{ $team->id }})">
                                    </div>
                                @endforeach

                                {{-- Fill empty slots if team has less than 5 players --}}
                                @for($slot = $players->count(); $slot < 5; $slot++)
                                    <input type="hidden" name="results[{{ $team->id }}][p{{ $slot }}_kills]" value="0">
                                @endfor
                            </div>
                        </div>

                        {{-- Live Score --}}
                        <div class="col-12 col-md-3">
                            <label style="font-size:10px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;display:block;margin-bottom:4px">Score</label>
                            <div class="d-flex gap-1">
                                <div class="text-center p-1 rounded flex-fill" style="background:#0d1117;border:1px solid #1e2a4a;min-width:40px">
                                    <div style="font-size:8px;color:#7c3aed;font-weight:700">PLACE</div>
                                    <div id="place_{{ $team->id }}" style="font-size:14px;font-weight:800;color:#7c3aed">0</div>
                                </div>
                                <div class="text-center p-1 rounded flex-fill" style="background:#0d1117;border:1px solid #1e2a4a;min-width:40px">
                                    <div style="font-size:8px;color:#f59e0b;font-weight:700">ELIM</div>
                                    <div id="elim_{{ $team->id }}" style="font-size:14px;font-weight:800;color:#f59e0b">0</div>
                                </div>
                                <div class="text-center p-1 rounded flex-fill" style="background:rgba(16,185,129,0.08);border:1px solid rgba(16,185,129,0.25);min-width:40px">
                                    <div style="font-size:8px;color:#10b981;font-weight:700">TOTAL</div>
                                    <div id="total_{{ $team->id }}" style="font-size:14px;font-weight:800;color:#10b981">0</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Submit Button --}}
    <div class="card-dark p-3 d-flex justify-content-between align-items-center">
        <div style="font-size:13px;color:#64748b">
            <i class="bi bi-shield-check me-1" style="color:#10b981"></i>
            Menyimpan hasil untuk <strong style="color:#f1f5f9">{{ $teams->count() }} tim</strong> pada <strong style="color:#f59e0b">Match #{{ $match->match_number }}</strong>
        </div>
        <button type="submit" class="btn btn-pubg" style="font-size:14px;padding:10px 28px">
            <i class="bi bi-cloud-check me-2"></i>Simpan Semua Hasil
        </button>
    </div>
</form>

@endsection

@push('scripts')
<script>
const PMWC_POINTS = {1:10, 2:6, 3:5, 4:4, 5:3, 6:2, 7:1, 8:1};

function calcTeamScore(teamId) {
    const rank = parseInt(document.getElementById('rank_' + teamId).value) || 18;
    const placePts = PMWC_POINTS[rank] || 0;
    let elim = 0;
    for (let i = 0; i < 5; i++) {
        const el = document.getElementById('kill_' + teamId + '_' + i);
        if (el) elim += parseInt(el.value) || 0;
    }
    document.getElementById('place_' + teamId).textContent = placePts;
    document.getElementById('elim_' + teamId).textContent = elim;
    document.getElementById('total_' + teamId).textContent = placePts + elim;
}

function filterTeams() {
    const q = document.getElementById('teamSearchInput').value.toLowerCase();
    document.querySelectorAll('.team-row').forEach(row => {
        row.style.display = row.dataset.team.includes(q) ? '' : 'none';
    });
}

// Init all scores on load
document.addEventListener('DOMContentLoaded', () => {
    @foreach($teams as $team)
        calcTeamScore({{ $team->id }});
    @endforeach
});
</script>
@endpush
