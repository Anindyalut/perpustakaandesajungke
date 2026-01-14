@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold">Dashboard</h3>
    <p class="text-muted">Ringkasan data perpustakaan</p>
</div>

<div class="row g-4">

    {{-- Total Judul Buku --}}
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="fs-1 text-primary me-3">
                    <i class="bi bi-book"></i>
                </div>
                <div>
                    <small class="text-muted">Total Judul Buku</small>
                    <h3 class="fw-bold">{{ $totalBuku }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Stok Buku --}}
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="fs-1 text-success me-3">
                    <i class="bi bi-stack"></i>
                </div>
                <div>
                    <small class="text-muted">Total Stok Buku</small>
                    <h3 class="fw-bold text-success">{{ $totalStokBuku }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Reservasi --}}
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="fs-1 text-warning me-3">
                    <i class="bi bi-clock-fill"></i>
                </div>
                <div>
                    <small class="text-muted">Reservasi</small>
                    <h3 class="fw-bold text-warning">{{ $reservasi }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Dipinjam --}}
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="fs-1 text-danger me-3">
                    <i class="bi bi-x-circle-fill"></i>
                </div>
                <div>
                    <small class="text-muted">Dipinjam</small>
                    <h3 class="fw-bold text-danger">{{ $dipinjam }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Member --}}
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="fs-1 text-info me-3">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <small class="text-muted">Total Member</small>
                    <h3 class="fw-bold">{{ $totalMember }}</h3>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
