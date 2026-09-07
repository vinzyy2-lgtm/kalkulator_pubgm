@extends('layouts.admin')
@section('page-title', 'Dashboard')

@section('content')

{{-- ===================== BARIS 1: STAT CARDS ===================== --}}
<div class="row g-3 mb-4">
    {{-- Card 1: Total Match --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:rgba(245,158,11,0.15);color:#f59e0b">
                <i class="bi bi-flag-fill"></i>
            </div>
            <div>
                <div style="font-size:11px;color:#64748b;text-transform:uppercase;font-weight:700;letter-spacing:0.5px">Total Match</div>
                <div style="font-size:28px;font-weight:800;color:#f1f5f9;line-height:1.1">{{ $totalMatches }}</div>
            </div>
        </div>
    </div>

    {{-- Card 2: Total Tim --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:rgba(124,58,237,0.15);color:#7c3aed">
                <i class="bi bi-people-fill"></i>
            </div>
            <div>
                <div style="font-size:11px;color:#64748b;text-transform:uppercase;font-weight:700;letter-spacing:0.5px">Total Tim</div>
                <div style="font-size:28px;font-weight:800;color:#f1f5f9;line-height:1.1">{{ $totalTeams }}</div>
            </div>
        </div>
    </div>

    {{-- Card 3: Total Kills --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:rgba(239,68,68,0.15);color:#ef4444">
                <i class="bi bi-crosshair2"></i>
            </div>
            <div>
                <div style="font-size:11px;color:#64748b;text-transform:uppercase;font-weight:700;letter-spacing:0.5px">Total Kills</div>
                <div style="font-size:28px;font-weight:800;color:#f1f5f9;line-height:1.1">{{ $totalKills }}</div>
            </div>
        </div>
    </div>

    {{-- Card 4: Pemimpin Sementara --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:rgba(16,185,129,0.15);color:#10b981">
                <i class="bi bi-crown-fill"></i>
            </div>
            <div>
                <div style="font-size:11px;color:#64748b;text-transform:uppercase;font-weight:700;letter-spacing:0.5px">Pemimpin Sementara</div>
                <div style="font-size:16px;font-weight:800;color:#10b981;line-height:1.2">
                    {{ $standings->first() ? $standings->first()['team']->name : '—' }}
                </div>
                @if($standings->first())
                    <div style="font-size:11px;color:#64748b">{{ $standings->first()['total_points'] }} pts</div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ===================== BARIS 2: CHARTS ROW 1 ===================== --}}
<div class="row g-3 mb-4">
    {{-- Chart 1: Bar Stacked - Poin per Tim --}}
    <div class="col-12 col-lg-6">
        <div class="chart-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0 fw-700" style="color:#f1f5f9;font-weight:700;font-size:14px">
                    <i class="bi bi-bar-chart-fill me-2" style="color:#7c3aed"></i>Total Poin per Tim (Top 10)
                </h6>
            </div>
            <div style="height:280px;position:relative">
                <canvas id="chartTeamPoints"></canvas>
            </div>
        </div>
    </div>

    {{-- Chart 2: Horizontal Bar - Top Killers --}}
    <div class="col-12 col-lg-6">
        <div class="chart-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0" style="color:#f1f5f9;font-weight:700;font-size:14px">
                    <i class="bi bi-person-fill me-2" style="color:#ef4444"></i>Top 10 Terminators
                </h6>
            </div>
            <div style="height:280px;position:relative">
                <canvas id="chartTopKillers"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- ===================== BARIS 3: CHARTS ROW 2 ===================== --}}
<div class="row g-3 mb-4">
    {{-- Chart 3: Doughnut --}}
    <div class="col-12 col-lg-4">
        <div class="chart-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0" style="color:#f1f5f9;font-weight:700;font-size:14px">
                    <i class="bi bi-pie-chart-fill me-2" style="color:#10b981"></i>Komposisi Poin
                </h6>
            </div>
            <div style="height:240px;position:relative">
                <canvas id="chartDoughnut"></canvas>
            </div>
        </div>
    </div>

    {{-- Chart 4: Line - Tren Top 5 --}}
    <div class="col-12 col-lg-8">
        <div class="chart-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0" style="color:#f1f5f9;font-weight:700;font-size:14px">
                    <i class="bi bi-graph-up me-2" style="color:#f59e0b"></i>Tren Poin Top 5 Tim
                </h6>
            </div>
            <div style="height:240px;position:relative">
                <canvas id="chartLine"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- ===================== BARIS 4: QUICK INPUT ===================== --}}
<div class="row g-3 mb-4">
    {{-- Panel 1: Quick Input Pemain --}}
    <div class="col-12 col-lg-6">
        <div class="card-dark p-4">
            <h6 class="mb-3" style="color:#f1f5f9;font-weight:700;font-size:14px">
                <i class="bi bi-person-gear me-2" style="color:#7c3aed"></i>Quick Input Pemain
            </h6>

            <div class="mb-3">
                <label class="form-label" style="font-size:11px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.5px">Pilih Tim</label>
                <select id="teamSelect" class="form-select form-select-dark" onchange="loadTeamPlayers()">
                    <option value="">— Pilih Tim —</option>
                    @foreach($allTeams as $team)
                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row g-2 mb-3">
                @foreach([0 => 'Player 1', 1 => 'Player 2', 2 => 'Player 3', 3 => 'Player 4', 4 => 'Reserve'] as $slot => $label)
                <div class="col-12">
                    <label class="form-label mb-1" style="font-size:11px;color:#64748b;font-weight:600">{{ $label }}</label>
                    <input type="text" id="player_{{ $slot }}" class="form-control form-control-dark" placeholder="{{ $label }}..." style="font-size:13px">
                </div>
                @endforeach
            </div>

            <button onclick="savePlayerQuick()" class="btn btn-pubg w-100" style="font-size:13px">
                <i class="bi bi-check-circle me-2"></i>Simpan Pemain
            </button>
        </div>
    </div>

    {{-- Panel 2: Quick Input Score --}}
    <div class="col-12 col-lg-6">
        <div class="card-dark p-4">
            <h6 class="mb-3" style="color:#f1f5f9;font-weight:700;font-size:14px">
                <i class="bi bi-controller me-2" style="color:#f59e0b"></i>Quick Input Score
            </h6>

            <div class="row g-2 mb-3">
                <div class="col-6">
                    <label class="form-label" style="font-size:11px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.5px">Pilih Match</label>
                    <select id="scoreMatchSelect" class="form-select form-select-dark" onchange="loadScoreData()" style="font-size:13px">
                        <option value="">— Match —</option>
                        @foreach($allMatches as $match)
                            <option value="{{ $match->id }}">Match #{{ $match->match_number }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label" style="font-size:11px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.5px">Pilih Tim</label>
                    <select id="scoreTeamSelect" class="form-select form-select-dark" onchange="loadScoreData()" style="font-size:13px">
                        <option value="">— Tim —</option>
                        @foreach($allTeams as $team)
                            <option value="{{ $team->id }}" data-id="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" style="font-size:11px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.5px">Rank (1-18)</label>
                <input type="number" id="rankInput" class="form-control form-control-dark" min="1" max="18" value="18" oninput="calcScore()" style="font-size:13px;width:100px">
            </div>

            <div class="mb-3">
                <label class="form-label" style="font-size:11px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.5px">Kills per Pemain</label>
                <div class="row g-1">
                    @foreach([0 => 'P1', 1 => 'P2', 2 => 'P3', 3 => 'P4', 4 => 'Res'] as $slot => $label)
                    <div class="col">
                        <label style="font-size:10px;color:#64748b;display:block;text-align:center">{{ $label }}</label>
                        <input type="number" id="kill_{{ $slot }}" class="form-control form-control-dark text-center input-kill" min="0" value="0" oninput="calcScore()" style="font-size:13px;padding:4px 2px">
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Live Calc --}}
            <div class="d-flex gap-2 mb-3">
                <div class="flex-fill text-center p-2 rounded" style="background:#0d1117;border:1px solid #1e2a4a">
                    <div style="font-size:10px;color:#64748b;font-weight:700">PLACE</div>
                    <div id="calcPlace" style="font-size:18px;font-weight:800;color:#7c3aed">0</div>
                </div>
                <div class="flex-fill text-center p-2 rounded" style="background:#0d1117;border:1px solid #1e2a4a">
                    <div style="font-size:10px;color:#64748b;font-weight:700">ELIM</div>
                    <div id="calcElim" style="font-size:18px;font-weight:800;color:#f59e0b">0</div>
                </div>
                <div class="flex-fill text-center p-2 rounded" style="background:rgba(16,185,129,0.08);border:1px solid rgba(16,185,129,0.3)">
                    <div style="font-size:10px;color:#64748b;font-weight:700">TOTAL</div>
                    <div id="calcTotal" style="font-size:18px;font-weight:800;color:#10b981">0</div>
                </div>
            </div>

            <button onclick="saveScoreQuick()" class="btn btn-pubg w-100" style="font-size:13px">
                <i class="bi bi-cloud-check me-2"></i>Simpan Score
            </button>
        </div>
    </div>
</div>

{{-- ===================== BARIS 5: STANDINGS TABLE ===================== --}}
<div class="card-dark p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0" style="color:#f1f5f9;font-weight:700;font-size:14px">
            <i class="bi bi-trophy-fill me-2" style="color:#f59e0b"></i>Standings Ringkasan
        </h6>
        <a href="{{ route('standings') }}" target="_blank" class="btn btn-sm" style="background:#1e2a4a;border:1px solid #2a3a5e;color:#94a3b8;font-size:11px">
            <i class="bi bi-box-arrow-up-right me-1"></i>Lihat Lengkap
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-dark-custom mb-0">
            <thead>
                <tr>
                    <th style="width:40px">#</th>
                    <th>Tim</th>
                    <th class="text-center">Match</th>
                    <th class="text-center">WWCD</th>
                    <th class="text-center">Place Pts</th>
                    <th class="text-center">Elim Pts</th>
                    <th class="text-center">Total Pts</th>
                </tr>
            </thead>
            <tbody>
                @forelse($standings as $idx => $s)
                    @php
                        $rank = $idx + 1;
                        $rowStyle = '';
                        if ($rank === 1) $rowStyle = 'background:rgba(245,158,11,0.07)!important;';
                        elseif ($rank === 2) $rowStyle = 'background:rgba(148,163,184,0.05)!important;';
                        elseif ($rank === 3) $rowStyle = 'background:rgba(146,64,14,0.07)!important;';
                        $team = $s['team'];
                        $placePts = $team->matchResults->sum(fn($r) => $r->getPlacePoints());
                        $elimPts  = $team->matchResults->sum(fn($r) => $r->getTotalKills());
                        $wwcd     = $team->matchResults->where('rank', 1)->count();
                    @endphp
                    <tr style="{{ $rowStyle }}">
                        <td>
                            @if($rank === 1)
                                <span class="badge badge-rank-1 px-2">#1</span>
                            @elseif($rank === 2)
                                <span class="badge badge-rank-2 px-2">#2</span>
                            @elseif($rank === 3)
                                <span class="badge badge-rank-3 px-2">#3</span>
                            @else
                                <span style="color:#64748b;font-weight:600">#{{ $rank }}</span>
                            @endif
                        </td>
                        <td>
                            <span style="font-weight:600;color:{{ $rank === 1 ? '#f59e0b' : '#e2e8f0' }}">{{ $team->name }}</span>
                        </td>
                        <td class="text-center">{{ $s['matches_played'] }}</td>
                        <td class="text-center">
                            @if($wwcd > 0)
                                <span style="color:#f59e0b;font-weight:700"><i class="bi bi-trophy-fill me-1" style="font-size:10px"></i>{{ $wwcd }}</span>
                            @else
                                <span style="color:#4a5568">0</span>
                            @endif
                        </td>
                        <td class="text-center"><span style="color:#7c3aed;font-weight:600">{{ $placePts }}</span></td>
                        <td class="text-center"><span style="color:#f59e0b;font-weight:600">{{ $elimPts }}</span></td>
                        <td class="text-center">
                            <span style="font-size:15px;font-weight:800;color:{{ $rank === 1 ? '#10b981' : '#f1f5f9' }}">{{ $s['total_points'] }}</span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-4" style="color:#4a5568">Belum ada data standings.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ===================== DATA =====================
const teamsData = @json($allTeams->map(fn($t) => [
    'id'      => $t->id,
    'name'    => $t->name,
    'players' => $t->players->sortBy('slot')->values()
]));

const PMWC_POINTS = {1:10, 2:6, 3:5, 4:4, 5:3, 6:2, 7:1, 8:1};

// ===================== CHARTS =====================
document.addEventListener('DOMContentLoaded', function() {
    // --- Chart 1: Bar Stacked ---
    const barLabels   = @json($chartData['bar']['labels']);
    const barPlace    = @json($chartData['bar']['placePts']);
    const barElim     = @json($chartData['bar']['elimPts']);

    new Chart(document.getElementById('chartTeamPoints'), {
        type: 'bar',
        data: {
            labels: barLabels,
            datasets: [
                { label: 'Place Pts', data: barPlace, backgroundColor: 'rgba(124,58,237,0.7)', borderRadius: 4 },
                { label: 'Elim Pts',  data: barElim,  backgroundColor: 'rgba(245,158,11,0.7)', borderRadius: 4 }
            ]
        },
        options: {
            ...darkChartDefaults,
            scales: {
                ...darkChartDefaults.scales,
                x: { ...darkChartDefaults.scales.x, stacked: true, ticks: { color: '#64748b', font: { size: 10 } } },
                y: { ...darkChartDefaults.scales.y, stacked: true }
            }
        }
    });

    // --- Chart 2: Horizontal Bar ---
    const hbarLabels = @json($chartData['hbar']['labels']);
    const hbarKills  = @json($chartData['hbar']['kills']);

    new Chart(document.getElementById('chartTopKillers'), {
        type: 'bar',
        data: {
            labels: hbarLabels,
            datasets: [{
                label: 'Kills',
                data: hbarKills,
                backgroundColor: 'rgba(239,68,68,0.7)',
                borderRadius: 4
            }]
        },
        options: {
            ...darkChartDefaults,
            indexAxis: 'y',
            scales: {
                x: { ...darkChartDefaults.scales.x },
                y: { ticks: { color: '#64748b', font: { size: 10 } }, grid: { color: '#1e2a4a' } }
            }
        }
    });

    // --- Chart 3: Doughnut ---
    const doughnutPlace = @json($chartData['doughnut']['placePts']);
    const doughnutElim  = @json($chartData['doughnut']['elimPts']);

    new Chart(document.getElementById('chartDoughnut'), {
        type: 'doughnut',
        data: {
            labels: ['Place Points', 'Elim Points'],
            datasets: [{
                data: [doughnutPlace, doughnutElim],
                backgroundColor: ['rgba(124,58,237,0.8)', 'rgba(245,158,11,0.8)'],
                borderColor: ['#7c3aed', '#f59e0b'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { labels: { color: '#94a3b8', font: { size: 11 } }, position: 'bottom' },
                tooltip: { backgroundColor: '#1e2a4a', titleColor: '#f1f5f9', bodyColor: '#94a3b8' }
            }
        }
    });

    // --- Chart 4: Line ---
    const lineLabels   = @json($chartData['line']['labels']);
    const lineDatasets = @json($chartData['line']['datasets']);

    new Chart(document.getElementById('chartLine'), {
        type: 'line',
        data: { labels: lineLabels, datasets: lineDatasets },
        options: { ...darkChartDefaults }
    });
});

// ===================== QUICK INPUT PLAYER =====================
function loadTeamPlayers() {
    const teamId = parseInt(document.getElementById('teamSelect').value);
    const team   = teamsData.find(t => t.id === teamId);
    if (!team) return;
    for (let i = 0; i < 5; i++) {
        const p = team.players.find(p => p.slot === i);
        document.getElementById('player_' + i).value = p ? p.name : '';
    }
}

function savePlayerQuick() {
    const teamId = parseInt(document.getElementById('teamSelect').value);
    if (!teamId) { showToast('Pilih tim terlebih dahulu!', 'error'); return; }

    const players = {};
    for (let i = 0; i < 5; i++) {
        players[i] = document.getElementById('player_' + i).value.trim() || '-';
    }

    const url = `/admin/teams/${teamId}/players`;
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ players })
    })
    .then(async res => {
        if (res.ok || res.redirected) {
            showToast('Pemain berhasil disimpan!', 'success');
        } else {
            const data = await res.json().catch(() => ({}));
            showToast(data.message || 'Gagal menyimpan pemain!', 'error');
        }
    })
    .catch(() => showToast('Terjadi kesalahan jaringan!', 'error'));
}

// ===================== QUICK INPUT SCORE =====================
function calcScore() {
    const rank     = parseInt(document.getElementById('rankInput').value) || 18;
    const placePts = PMWC_POINTS[rank] || 0;
    let elim       = 0;
    for (let i = 0; i < 5; i++) {
        elim += parseInt(document.getElementById('kill_' + i).value) || 0;
    }
    document.getElementById('calcPlace').textContent = placePts;
    document.getElementById('calcElim').textContent  = elim;
    document.getElementById('calcTotal').textContent = placePts + elim;
}

function loadScoreData() {
    const matchId = document.getElementById('scoreMatchSelect').value;
    const teamId  = document.getElementById('scoreTeamSelect').value;
    if (!matchId || !teamId) return;

    fetch(`/admin/matches/${matchId}/results/${teamId}`, {
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('rankInput').value = data.rank || 18;
        for (let i = 0; i < 5; i++) {
            document.getElementById('kill_' + i).value = data['p' + i + '_kills'] || 0;
        }
        calcScore();
    })
    .catch(() => {});
}

function saveScoreQuick() {
    const matchId = document.getElementById('scoreMatchSelect').value;
    const teamId  = document.getElementById('scoreTeamSelect').value;
    if (!matchId || !teamId) { showToast('Pilih match dan tim terlebih dahulu!', 'error'); return; }

    const rank = parseInt(document.getElementById('rankInput').value) || 18;
    const results = {};
    results[teamId] = { rank };
    for (let i = 0; i < 5; i++) {
        results[teamId]['p' + i + '_kills'] = parseInt(document.getElementById('kill_' + i).value) || 0;
    }

    fetch(`/admin/matches/${matchId}/results`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ results })
    })
    .then(async res => {
        if (res.ok || res.redirected) {
            showToast('Score berhasil disimpan!', 'success');
        } else {
            const data = await res.json().catch(() => ({}));
            showToast(data.message || 'Gagal menyimpan score!', 'error');
        }
    })
    .catch(() => showToast('Terjadi kesalahan jaringan!', 'error'));
}

// Initial calc
calcScore();
</script>
@endpush
