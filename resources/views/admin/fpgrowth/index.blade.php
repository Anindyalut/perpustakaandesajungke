@extends('layouts.admin')

@section('title', 'Rekomendasi Buku (FP-Growth)')

@push('styles')
<style>
    /* ================= IJO PERPUS TABLE ================= */
    .perpus-table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .perpus-table thead th {
        background-color: #1f7a63;
        color: #ffffff;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        border: 1px solid #1f7a63;
        white-space: nowrap;
        text-align: center;
        vertical-align: middle;
    }

    .perpus-table tbody td {
        border: 1px solid #d6e4df;
        font-size: 14px;
        vertical-align: middle;
    }

    .perpus-table tbody tr:nth-child(even) {
        background-color: #f3f8f6;
    }

    .perpus-table tbody tr:hover {
        background-color: #e1f1ec;
    }

    /* ================= CARD ================= */
    .card {
        border-radius: 12px;
        border: none;
    }

    /* ================= BADGE ================= */
    .badge {
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 6px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="mb-3">
        <h4 class="fw-bold mb-1 text-dark">
            📊 Hasil Rekomendasi Buku (FP-Growth)
        </h4>
        <p class="text-muted mb-1">
            Rekomendasi dihasilkan berdasarkan pola peminjaman buku secara bersamaan.
        </p>
        <p class="mb-0">
            Nilai <strong>Minimum Support</strong>: {{ $minSupport }}%
        </p>
    </div>

    {{-- GRAFIK TOP BUKU FP-GROWTH --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">
                📚 Grafik Buku yang Sering Dipinjam Bersamaan (FP-Growth)
            </h5>

            @if(empty($topBooks))
                <div class="text-center text-muted py-4">
                    Data grafik belum tersedia.
                </div>
            @else
                <canvas id="topBooksChart" height="110"></canvas>
            @endif
        </div>
    </div>

    {{-- TABEL ATURAN ASOSIASI --}}
    <div class="card shadow-sm">
        <div class="card-body table-responsive p-0">

            @if(empty($rules))
                <div class="text-center text-muted py-4">
                    Belum ditemukan aturan asosiasi buku.
                </div>
            @else
                <table class="table perpus-table text-center mb-0">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th class="text-start">Jika Meminjam</th>
                            <th class="text-start">Maka Juga Meminjam</th>
                            <th width="120">Support (%)</th>
                            <th width="140">Confidence (%)</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($rules as $i => $r)
                        <tr>
                            <td>{{ $i + 1 }}</td>

                            <td class="text-start fw-semibold">
                                {{ $r['from'] }}
                            </td>

                            <td class="text-start">
                                {{ $r['to'] }}
                            </td>

                            <td>
                                {{ number_format($r['support'], 2) }}%
                            </td>

                            <td>
                                <span class="badge bg-success">
                                    {{ number_format($r['confidence'], 2) }}%
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@if(!empty($topBooks))
<script>
    const ctx = document.getElementById('topBooksChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_column($topBooks, 'title')) !!},
            datasets: [{
                label: 'Frekuensi Kemunculan',
                data: {!! json_encode(array_column($topBooks, 'count')) !!},
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });
</script>
@endif
@endpush
