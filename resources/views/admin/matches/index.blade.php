@extends('layouts.admin')
@section('page-title', 'Input Match')

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

{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p style="color:#64748b;font-size:13px;margin:0">Kelola semua match. Klik <strong style="color:#f59e0b">Input Hasil</strong> untuk memasukkan skor.</p>
    </div>
    <form action="{{ route('admin.matches.store') }}" method="POST" class="d-inline">
        @csrf
        <input type="hidden" name="match_number" value="{{ (($matches->max('match_number') ?? 0) + 1) }}">
        <button type="submit" class="btn btn-sm btn-pubg" onclick="return confirm('Buat Match #{{ (($matches->max('match_number') ?? 0) + 1) }}?')">
            <i class="bi bi-plus-circle me-1"></i>Match Baru
        </button>
    </form>
</div>

{{-- Match Grid --}}
@if($matches->isEmpty())
    <div class="card-dark p-5 text-center">
        <i class="bi bi-controller" style="font-size:48px;color:#2a3050"></i>
        <p class="mt-3 mb-4" style="color:#4a5568;font-size:15px">Belum ada match. Buat match pertama!</p>
        <form action="{{ route('admin.matches.store') }}" method="POST">
            @csrf
            <input type="hidden" name="match_number" value="1">
            <button type="submit" class="btn btn-pubg">
                <i class="bi bi-plus-circle me-2"></i>Buat Match #1
            </button>
        </form>
    </div>
@else
    <div class="row g-3">
        @foreach($matches as $match)
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card-dark p-4" style="position:relative;overflow:hidden">
                    {{-- Background number --}}
                    <div style="position:absolute;top:-5px;right:10px;font-size:60px;font-weight:900;color:rgba(255,255,255,0.03);line-height:1;pointer-events:none">
                        #{{ $match->match_number }}
                    </div>

                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div>
                            <div style="font-size:11px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.5px">Match</div>
                            <div style="font-size:28px;font-weight:900;color:#f59e0b;line-height:1">#{{ $match->match_number }}</div>
                        </div>
                        <div class="text-end">
                            @php $resultCount = $match->match_results_count ?? 0; @endphp
                            <span class="badge" style="background:{{ $resultCount > 0 ? 'rgba(16,185,129,0.15)' : 'rgba(100,116,139,0.15)' }};color:{{ $resultCount > 0 ? '#10b981' : '#64748b' }};border:1px solid {{ $resultCount > 0 ? 'rgba(16,185,129,0.3)' : 'rgba(100,116,139,0.2)' }};font-size:11px">
                                {{ $resultCount > 0 ? $resultCount . ' Tim Input' : 'Belum Ada Data' }}
                            </span>
                        </div>
                    </div>

                    <div style="font-size:11px;color:#4a5568;margin-bottom:12px">
                        <i class="bi bi-calendar3 me-1"></i>{{ $match->created_at->format('d M Y, H:i') }}
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.matches.show', $match) }}" class="btn btn-sm flex-fill btn-pubg" style="font-size:12px">
                            <i class="bi bi-pencil-square me-1"></i>Input Hasil
                        </a>
                        <form action="{{ route('admin.matches.destroy', $match) }}" method="POST"
                            onsubmit="return confirm('Hapus Match #{{ $match->match_number }}? Semua hasil akan terhapus!')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#ef4444;font-size:12px">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection
