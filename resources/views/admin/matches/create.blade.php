@extends('layouts.admin')
@section('page-title', 'Buat Match Baru')

@section('content')

<div class="d-flex align-items-center mb-4">
    <a href="{{ route('admin.matches.index') }}" class="btn btn-sm me-3" style="background:#161b2e;border:1px solid #1e2a4a;color:#94a3b8">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card-dark p-4">
            <h6 class="mb-4" style="color:#f1f5f9;font-weight:700;font-size:15px">
                <i class="bi bi-controller me-2" style="color:#f59e0b"></i>Buat Match Baru
            </h6>

            <form action="{{ route('admin.matches.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label" style="font-size:11px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.5px">Nomor Match *</label>
                    <input type="number" name="match_number" value="{{ old('match_number', $nextNumber) }}"
                        class="form-control form-control-dark"
                        min="1" required
                        style="font-size:20px;font-weight:800;text-align:center;width:120px">
                    @error('match_number')
                        <div style="font-size:11px;color:#ef4444;margin-top:4px">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-pubg">
                        <i class="bi bi-plus-circle me-2"></i>Buat Match
                    </button>
                    <a href="{{ route('admin.matches.index') }}" class="btn" style="background:#0d1117;border:1px solid #1e2a4a;color:#94a3b8">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
