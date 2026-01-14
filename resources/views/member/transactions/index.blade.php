@extends('layouts.member')

@section('title', 'Riwayat Peminjaman')

@section('content')

<style>
    .history-card {
        border: none;
        border-radius: 16px;
    }

    .history-title {
        color: #0f5c55;
    }

    .table thead {
        background-color: #e9f5f3;
    }

    .table th {
        font-weight: 600;
        color: #0f5c55;
        text-align: center;
        vertical-align: middle;
    }

    .table td {
        vertical-align: middle;
    }

    .badge-status {
        padding: 6px 14px;
        border-radius: 12px;
        font-weight: 500;
    }

    .badge-reservasi {
        background-color: #fff3cd;
        color: #856404;
    }

    .badge-dipinjam {
        background-color: #0f5c55;
        color: white;
    }

    .badge-selesai {
        background-color: #e9f5f3;
        color: #0f5c55;
        border: 1px solid #0f5c55;
    }

    .fee-text {
        color: #dc3545;
        font-weight: 600;
    }
</style>

<div class="card shadow-sm history-card">
    <div class="card-body p-4">

        <h4 class="fw-bold mb-4 history-title">
            <i class="bi bi-clock-history me-2"></i>
            Riwayat Peminjaman Buku
        </h4>

        @if($transactions->isEmpty())
            <div class="alert alert-info text-center mb-0">
                Belum ada riwayat peminjaman buku.
            </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">

                <thead>
                    <tr>
                        <th>No</th>
                        <th class="text-start">Judul Buku</th>
                        <th>Reservasi</th>
                        <th>Dipinjam</th>
                        <th>Batas Kembali</th>
                        <th>Dikembalikan</th>
                        <th>Denda</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($transactions->sortByDesc('created_at') as $i => $t)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>

                        <td class="text-start fw-semibold">
                            {{ $t->book->title ?? '-' }}
                        </td>

                        <td class="text-center">
                            {{ $t->reservation_date?->format('d M Y') ?? '-' }}
                        </td>

                        <td class="text-center">
                            {{ $t->borrow_date?->format('d M Y') ?? '-' }}
                        </td>

                        <td class="text-center">
                            {{ $t->due_date?->format('d M Y') ?? '-' }}
                        </td>

                        <td class="text-center">
                            {{ $t->return_date?->format('d M Y') ?? '-' }}
                        </td>

                        <td class="text-center fee-text">
                            Rp {{ number_format($t->late_fee, 0, ',', '.') }}
                        </td>

                        <td class="text-center">
                            @if($t->status === 'reservasi')
                                <span class="badge badge-status badge-reservasi">
                                    Reservasi
                                </span>
                            @elseif($t->status === 'dipinjam')
                                <span class="badge badge-status badge-dipinjam">
                                    Dipinjam
                                </span>
                            @else
                                <span class="badge badge-status badge-selesai">
                                    Selesai
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
        @endif

    </div>
</div>

@endsection
