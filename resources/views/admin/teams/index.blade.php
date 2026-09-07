@extends('layouts.admin')
@section('page-title', 'Edit Teams')

@section('content')

{{-- Flash Messages --}}
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

{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p style="color:#64748b;font-size:13px;margin:0">Edit nama tim. Perubahan akan langsung diterapkan pada semua data.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.teams.create') }}" class="btn btn-sm btn-pubg">
            <i class="bi bi-plus-circle me-1"></i>Tambah Tim
        </a>
    </div>
</div>

{{-- Teams Grid --}}
<div class="row g-3">
    @forelse($teams as $idx => $team)
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card-dark p-3">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div style="width:28px;height:28px;background:rgba(124,58,237,0.15);border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;color:#7c3aed;flex-shrink:0">
                        {{ $idx + 1 }}
                    </div>
                    <span style="font-size:12px;color:#64748b;font-weight:600">TIM #{{ $idx + 1 }}</span>
                    <span class="ms-auto" style="font-size:11px;color:#4a5568">{{ $team->players_count ?? 0 }} pemain</span>
                </div>

                <form action="{{ route('admin.teams.update', $team) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="input-group mb-2">
                        <input type="text" name="name" value="{{ $team->name }}"
                            class="form-control form-control-dark"
                            placeholder="Nama tim..." required
                            style="font-size:13px;font-weight:600">
                        <button type="submit" class="btn btn-sm" style="background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.3);color:#10b981;font-size:12px;font-weight:600">
                            <i class="bi bi-check-lg"></i>
                        </button>
                    </div>
                    <input type="hidden" name="order" value="{{ $team->order }}">
                </form>

                <div class="d-flex gap-1 mt-2">
                    <a href="{{ route('admin.teams.show', $team) }}" class="btn btn-sm flex-fill" style="background:#0d1117;border:1px solid #1e2a4a;color:#94a3b8;font-size:11px">
                        <i class="bi bi-eye me-1"></i>Detail
                    </a>
                    <form action="{{ route('admin.teams.destroy', $team) }}" method="POST" class="flex-fill"
                        onsubmit="return confirm('Hapus tim {{ $team->name }}? Semua data terkait akan ikut terhapus.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm w-100" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#ef4444;font-size:11px">
                            <i class="bi bi-trash me-1"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card-dark p-5 text-center">
                <i class="bi bi-people" style="font-size:40px;color:#2a3050"></i>
                <p class="mt-3 mb-3" style="color:#4a5568;font-size:14px">Belum ada tim. Tambahkan tim terlebih dahulu.</p>
                <a href="{{ route('admin.teams.create') }}" class="btn btn-pubg">
                    <i class="bi bi-plus-circle me-1"></i>Tambah Tim Pertama
                </a>
            </div>
        </div>
    @endforelse
</div>

@endsection
