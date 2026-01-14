@extends('layouts.admin')

@section('title', 'Data Transaksi')

@section('content')

<style>
    .page-title {
        font-weight: 700;
        color: #333;
    }

    .table thead th {
        vertical-align: middle;
        font-size: 14px;
    }

    .table tbody td {
        font-size: 14px;
    }

    .badge-status {
        padding: 6px 12px;
        font-size: 12px;
    }

    .action-btn form {
        display: inline-block;
    }
</style>

<div class="container-fluid">

    <h4 class="page-title mb-3">
        📑 Data Transaksi
    </h4>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle me-1"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- Total Denda --}}
    @if($totalFine > 0)
        <div class="alert alert-info">
            💰 Total Denda Keseluruhan:
            <strong>Rp {{ number_format($totalFine, 0, ',', '.') }}</strong>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">

            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th class="text-start">Judul Buku</th>
                        <th>Penulis</th>
                        <th>Peminjam</th>
                        <th>Status</th>
                        <th>Reservasi</th>
                        <th>Dipinjam</th>
                        <th>Batas Kembali</th>
                        <th>Dikembalikan</th>
                        <th>Denda</th>
                        <th width="170">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($transactions as $t)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td class="text-start fw-semibold">
                            {{ $t->book->title ?? '-' }}
                        </td>

                        <td>{{ $t->book->author ?? '-' }}</td>
                        <td>{{ $t->user->name ?? '-' }}</td>

                        <td>
                            @if($t->status == 'reservasi')
                                <span class="badge bg-warning text-dark badge-status">
                                    Reservasi
                                </span>
                            @elseif($t->status == 'dipinjam')
                                <span class="badge bg-primary badge-status">
                                    Dipinjam
                                </span>
                            @elseif($t->status == 'selesai')
                                <span class="badge bg-success badge-status">
                                    Selesai
                                </span>
                            @else
                                <span class="badge bg-secondary badge-status">
                                    -
                                </span>
                            @endif
                        </td>

                        <td>{{ optional($t->reservation_date)->format('d M Y') ?? '-' }}</td>
                        <td>{{ optional($t->borrow_date)->format('d M Y') ?? '-' }}</td>
                        <td>{{ optional($t->max_return_date)->format('d M Y') ?? '-' }}</td>
                        <td>{{ optional($t->return_date)->format('d M Y') ?? '-' }}</td>

                        {{-- Denda --}}
                        <td>
                            @if($t->fine > 0)
                                <span class="text-danger fw-bold">
                                    Rp {{ number_format($t->fine, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="action-btn">
                            @if($t->status == 'reservasi')
                                <form method="POST"
                                      action="{{ route('admin.transactions.borrow', $t) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-primary"
                                            onclick="return confirm('Ubah status menjadi Dipinjam?')">
                                        Set Dipinjam
                                    </button>
                                </form>

                            @elseif($t->status == 'dipinjam')
                                <form method="POST"
                                      action="{{ route('admin.transactions.return', $t) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-success"
                                            onclick="return confirm('Selesaikan transaksi ini?')">
                                        Set Selesai
                                    </button>
                                </form>
                            @else
                                <span class="text-muted fst-italic">
                                    Tidak ada aksi
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-muted py-4">
                            Belum ada transaksi
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection
