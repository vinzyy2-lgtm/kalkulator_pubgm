@extends('layouts.admin')
@section('page-title', 'Tambah Tim')

@section('content')

<div class="d-flex align-items-center mb-4">
    <a href="{{ route('admin.teams.index') }}" class="btn btn-sm me-3" style="background:#161b2e;border:1px solid #1e2a4a;color:#94a3b8">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card-dark p-4">
            <h6 class="mb-4" style="color:#f1f5f9;font-weight:700;font-size:15px">
                <i class="bi bi-people-fill me-2" style="color:#7c3aed"></i>Tambah Tim Baru
            </h6>

            <form action="{{ route('admin.teams.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label" style="font-size:11px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.5px">Nama Tim *</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="form-control form-control-dark"
                        placeholder="Contoh: Team Liquid, PUBG Mobile ID..." required
                        style="font-size:14px">
                    @error('name')
                        <div style="font-size:11px;color:#ef4444;margin-top:4px"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label" style="font-size:11px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.5px">Urutan (opsional)</label>
                    <input type="number" name="order" value="{{ old('order', 0) }}"
                        class="form-control form-control-dark"
                        placeholder="0" min="0"
                        style="font-size:14px;width:120px">
                    <div style="font-size:11px;color:#4a5568;margin-top:4px">Angka lebih kecil = tampil lebih awal</div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-pubg">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Tim
                    </button>
                    <a href="{{ route('admin.teams.index') }}" class="btn" style="background:#0d1117;border:1px solid #1e2a4a;color:#94a3b8">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
