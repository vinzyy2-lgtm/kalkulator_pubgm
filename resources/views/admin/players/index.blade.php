@extends('layouts.admin')
@section('page-title', 'Input Player')

@section('content')

@if(session('success'))
    <div class="alert mb-4" style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.3);color:#6ee7b7;border-radius:10px;font-size:13px;padding:12px 16px">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert mb-4" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#fca5a5;border-radius:10px;font-size:13px;padding:12px 16px">
        <i class="bi bi-x-circle-fill me-2"></i>{{ session('error') }}
    </div>
@endif

<div class="mb-4">
    <p style="color:#64748b;font-size:13px;margin:0">Input dan edit nama pemain untuk setiap tim. Klik <strong style="color:#f59e0b">Simpan</strong> per tim.</p>
</div>

<div class="row g-3">
    @forelse($teams as $team)
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card-dark p-0 overflow-hidden">
                {{-- Header --}}
                <div class="px-3 py-2 d-flex align-items-center gap-2" style="background:rgba(245,158,11,0.08);border-bottom:1px solid #1e2a4a">
                    <div style="width:28px;height:28px;background:rgba(245,158,11,0.15);border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;color:#f59e0b;flex-shrink:0">
                        {{ $loop->iteration }}
                    </div>
                    <span style="font-size:13px;font-weight:700;color:#f59e0b">{{ $team->name }}</span>
                </div>

                {{-- Form --}}
                <div class="p-3">
                    <form action="{{ route('admin.teams.players.update', $team) }}" method="POST">
                        @csrf
                        <div class="d-flex flex-column gap-2">
                            @foreach([0 => 'Player 1', 1 => 'Player 2', 2 => 'Player 3', 3 => 'Player 4', 4 => 'Reserve'] as $slot => $label)
                                @php $player = $team->players->firstWhere('slot', $slot); @endphp
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge" style="background:{{ $slot === 4 ? 'rgba(239,68,68,0.15)' : 'rgba(124,58,237,0.15)' }};color:{{ $slot === 4 ? '#ef4444' : '#a78bfa' }};font-size:10px;min-width:36px;text-align:center;flex-shrink:0">
                                        {{ $slot === 4 ? 'RES' : 'P'.($slot+1) }}
                                    </span>
                                    <input type="text"
                                        name="players[{{ $slot }}]"
                                        value="{{ old('players.' . $slot, $player ? $player->name : '') }}"
                                        class="form-control form-control-dark flex-fill"
                                        placeholder="{{ $label }}..."
                                        required
                                        style="font-size:12px;padding:5px 10px">
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-sm btn-pubg w-100 mt-3" style="font-size:12px">
                            <i class="bi bi-check-circle me-1"></i>Simpan {{ $team->name }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card-dark p-5 text-center">
                <i class="bi bi-person-x" style="font-size:40px;color:#2a3050"></i>
                <p class="mt-3 mb-3" style="color:#4a5568;font-size:14px">Belum ada tim. Tambahkan tim terlebih dahulu.</p>
                <a href="{{ route('admin.teams.create') }}" class="btn btn-pubg">
                    <i class="bi bi-plus-circle me-1"></i>Tambah Tim
                </a>
            </div>
        </div>
    @endforelse
</div>

@endsection
