@extends('layouts.app')

@section('title', 'Dashboard – Admin')

@push('styles')
<style>
    .stat-card { border-left: 4px solid #e94560; }
    .stat-number { font-size: 2.5rem; font-weight: 700; color: #e94560; }
</style>
@endpush

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2 class="text-white">
            <i class="bi bi-speedometer2 me-2" style="color:#e94560;"></i>
            Admin Dashboard
        </h2>
    </div>
</div>

{{-- Stats Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body text-center">
                <div class="stat-number">{{ $totalTeams }}</div>
                <div class="text-muted">Teams</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body text-center">
                <div class="stat-number">{{ $totalMatches }}</div>
                <div class="text-muted">Matches Played</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body text-center">
                <div class="stat-number">{{ $standingsData->sum('total_kills') }}</div>
                <div class="text-muted">Total Kills</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body text-center">
                <div class="stat-number">{{ $standingsData->sum('total_points') }}</div>
                <div class="text-muted">Total Points</div>
            </div>
        </div>
    </div>
</div>

{{-- Charts --}}
<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-bar-chart-fill me-2"></i>Points per Team
            </div>
            <div class="card-body">
                <canvas id="pointsChart" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-pie-chart-fill me-2"></i>Kills Distribution (Top 5)
            </div>
            <div class="card-body d-flex align-items-center">
                <canvas id="killsChart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-lightning-fill me-2"></i>Quick Actions
            </div>
            <div class="card-body">
                <a href="{{ route('admin.teams.index') }}" class="btn btn-primary me-2 mb-2">
                    <i class="bi bi-people-fill me-1"></i>Manage Teams
                </a>
                <a href="{{ route('admin.matches.index') }}" class="btn btn-primary mb-2">
                    <i class="bi bi-controller me-1"></i>Manage Matches
                </a>
                <a href="{{ route('admin.matches.create') }}" class="btn btn-outline-success mb-2">
                    <i class="bi bi-plus-circle me-1"></i>Add New Match
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-trophy me-2"></i>Top 3 Teams
            </div>
            <div class="card-body">
                @forelse($standingsData->take(3) as $i => $entry)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>
                            @if($i === 0) 🥇 @elseif($i === 1) 🥈 @else 🥉 @endif
                            <strong>{{ $entry['team']->name }}</strong>
                        </span>
                        <span class="badge bg-warning text-dark">{{ $entry['total_points'] }} pts</span>
                    </div>
                @empty
                    <p class="text-muted">Belum ada data.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const chartLabels = @json($chartLabels);
const chartPoints = @json($chartPoints);
const chartKills  = @json($chartKills);

// Bar chart: points per team
const ctx1 = document.getElementById('pointsChart').getContext('2d');
new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: chartLabels,
        datasets: [
            {
                label: 'Placement Points',
                data: chartPoints.map((p, i) => p - chartKills[i]),
                backgroundColor: 'rgba(233, 69, 96, 0.7)',
                borderColor: '#e94560',
                borderWidth: 1,
            },
            {
                label: 'Kill Points',
                data: chartKills,
                backgroundColor: 'rgba(0, 180, 216, 0.7)',
                borderColor: '#00b4d8',
                borderWidth: 1,
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { labels: { color: '#ccc' } }
        },
        scales: {
            x: {
                stacked: true,
                ticks: { color: '#aaa', maxRotation: 45 },
                grid: { color: 'rgba(255,255,255,0.05)' }
            },
            y: {
                stacked: true,
                ticks: { color: '#aaa' },
                grid: { color: 'rgba(255,255,255,0.05)' }
            }
        }
    }
});

// Pie chart: top 5 kills
const top5Labels = chartLabels.slice(0, 5);
const top5Kills  = chartKills.slice(0, 5);
const ctx2 = document.getElementById('killsChart').getContext('2d');
new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: top5Labels,
        datasets: [{
            data: top5Kills,
            backgroundColor: [
                '#e94560', '#00b4d8', '#ffd700', '#48cae4', '#90e0ef'
            ],
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom', labels: { color: '#ccc', boxWidth: 12 } }
        }
    }
});
</script>
@endpush
