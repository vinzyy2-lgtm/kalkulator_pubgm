@extends('layouts.admin')
@section('page-title', 'Edit Tim: {{ $team->name }}')

@section('content')

<div class="d-flex align-items-center mb-4">
    <a href="{{ route('admin.teams.index') }}" class="btn btn-sm me-3" style="background:#161b2e;border:1px solid #1e2a4a;color:#94a3b8">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

@if(session('success'))
    <div class="alert mb-4" style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.3);color:#6ee7b7;border-radius:10px;font-size:13px;padding:12px 16px">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    </div>
@endif

<div class="row g-4">
    {{-- Edit Tim --}}
    <div class="col-12 col-lg-5">
        <div class="card-dark p-4">
            <h6 class="mb-4" style="color:#f1f5f9;font-weight:700;font-size:15px">
                <i class="bi bi-people-fill me-2" style="color:#7c3aed"></i>Info Tim
            </h6>

            <form action="{{ route('admin.teams.update', $team) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label" style="font-size:11px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.5px">Nama Tim *</label>
                    <input type="text" name="name" value="{{ old('name', $team->name) }}"
                        class="form-control form-control-dark"
                        required style="font-size:14px">
                    @error('name')
                        <div style="font-size:11px;color:#ef4444;margin-top:4px">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label" style="font-size:11px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.5px">Urutan</label>
                    <input type="number" name="order" value="{{ old('order', $team->order) }}"
                        class="form-control form-control-dark"
                        min="0" style="font-size:14px;width:120px">
                </div>

                <button type="submit" class="btn btn-pubg">
                    <i class="bi bi-check-circle me-2"></i>Update Tim
                </button>
            </form>
        </div>
    </div>

    {{-- Edit Players --}}
    <div class="col-12 col-lg-7">
        <div class="card-dark p-4">
            <h6 class="mb-4" style="color:#f1f5f9;font-weight:700;font-size:15px">
                <i class="bi bi-person-gear me-2" style="color:#f59e0b"></i>Pemain Tim
            </h6>

            <form action="{{ route('admin.teams.players.update', $team) }}" method="POST">
                @csrf
                <div class="row g-3">
                    @foreach($team->players as $player)
                        <div class="col-12">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge" style="background:{{ $player->slot === 4 ? 'rgba(239,68,68,0.15)' : 'rgba(124,58,237,0.15)' }};color:{{ $player->slot === 4 ? '#ef4444' : '#a78bfa' }};font-size:10px;min-width:44px;text-align:center">
                                    {{ $player->getSlotLabel() }}
                                </span>
                                <input type="text" name="players[{{ $player->slot }}]"
                                    value="{{ old('players.' . $player->slot, $player->name) }}"
                                    class="form-control form-control-dark flex-fill"
                                    placeholder="{{ $player->slot === 4 ? 'Reserve' : 'Player ' . ($player->slot + 1) }}..."
                                    style="font-size:13px" required>
                            </div>
                        </div>
                    @endforeach

                    {{-- Add missing slots if any --}}
                    @for($slot = $team->players->count(); $slot < 5; $slot++)
                        <div class="col-12">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge" style="background:rgba(100,116,139,0.15);color:#64748b;font-size:10px;min-width:44px;text-align:center">
                                    {{ $slot === 4 ? 'RES' : 'P' . ($slot + 1) }}
                                </span>
                                <input type="text" name="players[{{ $slot }}]"
                                    value="{{ old('players.' . $slot) }}"
                                    class="form-control form-control-dark flex-fill"
                                    placeholder="{{ $slot === 4 ? 'Reserve' : 'Player ' . ($slot + 1) }}..."
                                    style="font-size:13px" required>
                            </div>
                        </div>
                    @endfor
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-pubg">
                        <i class="bi bi-person-check me-2"></i>Simpan Pemain
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
