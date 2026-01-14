@extends('layouts.admin')

@section('title', 'Laporan Transaksi')

@section('content')

<h4 class="fw-bold mb-4">
    <i class="bi bi-file-earmark-text me-2"></i> Laporan Transaksi
</h4>

{{-- FILTER --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">

            <div class="col-md-3">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="from" class="form-control"
                       value="{{ request('from') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="to" class="form-control"
                       value="{{ request('to') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua</option>
                    <option value="reservasi" @selected(request('status')=='reservasi')>Reservasi</option>
                    <option value="dipinjam" @selected(request('status')=='dipinjam')>Dipinjam</option>
                    <option value="selesai" @selected(request('status')=='selesai')>Selesai</option>
                </select>
            </div>

            <div class="col-md-3">
                <button class="btn btn-primary w-100">
                    <i class="bi bi-filter"></i> Terapkan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- RINGKASAN --}}
<div class="row mb-4 text-center">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Total Transaksi</h6>
                <h3 class="fw-bold">{{ $totalTransactions }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Total Dipinjam</h6>
                <h3 class="fw-bold">{{ $totalBorrowed }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Total Denda</h6>
                <h3 class="fw-bold text-danger">
                    Rp {{ number_format($totalFine,0,',','.') }}
                </h3>
            </div>
        </div>
    </div>
</div>

{{-- EXPORT --}}
<a href="{{ route('admin.reports.pdf', request()->query()) }}"
   class="btn btn-danger mb-3">
    <i class="bi bi-file-earmark-pdf"></i> Export PDF
</a>

{{-- TABEL --}}
<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>No</th>
                    <th>Member</th>
                    <th>Buku</th>
                    <th>Status</th>
                    <th>Denda</th>
                    <th>Tanggal</th>
                </tr>
            </thead>

            <tbody class="text-center">
                @forelse($transactions as $i => $t)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $t->user->name }}</td>
                    <td class="text-start">{{ $t->book->title }}</td>

                    {{-- STATUS --}}
                    <td>
                        @if($t->status === 'reservasi')
                            <span class="badge bg-warning text-dark">
                                Reservasi
                            </span>
                        @elseif($t->status === 'dipinjam')
                            <span class="badge bg-primary">
                                Dipinjam
                            </span>
                        @elseif($t->status === 'selesai')
                            <span class="badge bg-success">
                                Selesai
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                -
                            </span>
                        @endif
                    </td>

                    {{-- DENDA --}}
                    <td class="fw-semibold text-danger">
                        @if($t->status === 'selesai')
                            Rp {{ number_format($t->fine,0,',','.') }}
                        @else
                            -
                        @endif
                    </td>

                    <td>{{ $t->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-muted">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
