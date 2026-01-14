@extends('layouts.member')

@section('title', 'Detail Buku')

@section('content')

<style>
    .book-card {
        border: none;
        border-radius: 16px;
    }

    .book-title {
        color: #0f5c55;
    }

    .book-table td:first-child {
        width: 120px;
        font-weight: 500;
        color: #555;
    }

    .badge-stock {
        background-color: #0f5c55;
    }

    .btn-primary-custom {
        background-color: #0f5c55;
        border: none;
    }

    .btn-primary-custom:hover {
        background-color: #0c4f49;
    }

    .btn-outline-custom {
        border-color: #0f5c55;
        color: #0f5c55;
    }

    .btn-outline-custom:hover {
        background-color: #0f5c55;
        color: white;
    }
</style>

<div class="card shadow-sm book-card">
    <div class="card-body p-4">
        <div class="row g-4">

            {{-- COVER --}}
            <div class="col-md-4 text-center">
                @if($book->image)
                    <img src="{{ asset('storage/'.$book->image) }}"
                         class="img-fluid rounded shadow-sm"
                         style="max-height: 360px;">
                @else
                    <div class="border rounded p-5 text-muted">
                        No Image
                    </div>
                @endif
            </div>

            {{-- DETAIL --}}
            <div class="col-md-8">
                <h3 class="fw-bold book-title mb-3">
                    {{ $book->title }}
                </h3>

                <table class="table table-borderless book-table">
                    <tr><td>Penulis</td><td>: {{ $book->author }}</td></tr>
                    <tr><td>Penerbit</td><td>: {{ $book->publisher }}</td></tr>
                    <tr><td>Tahun</td><td>: {{ $book->year }}</td></tr>
                    <tr><td>ISBN</td><td>: {{ $book->isbn }}</td></tr>
                    <tr>
                        <td>Stok</td>
                        <td>
                            :
                            @if($book->stock > 0)
                                <span class="badge badge-stock">
                                    {{ $book->stock }}
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    Habis
                                </span>
                            @endif
                        </td>
                    </tr>
                </table>

                {{-- BUTTON PINJAM --}}
                @if($book->stock > 0)
                    <!-- Trigger Modal -->
                    <button class="btn btn-primary-custom px-4"
                            data-bs-toggle="modal"
                            data-bs-target="#confirmPinjamModal">
                        <i class="bi bi-bookmark-plus"></i> Pinjam Buku
                    </button>
                @else
                    <span class="badge bg-danger px-3 py-2">
                        Stok habis
                    </span>
                @endif

                {{-- KEMBALI --}}
                <div class="mt-4">
                    <a href="{{ route('member.home') }}"
                       class="btn btn-outline-custom btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- ================= MODAL KONFIRMASI ================= --}}
<div class="modal fade" id="confirmPinjamModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    Konfirmasi Peminjaman
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p>
                    Apakah Anda yakin ingin meminjam buku:
                </p>
                <p class="fw-bold text-success">
                    "{{ $book->title }}"
                </p>
            </div>

            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    Batal
                </button>

                <form method="POST"
                      action="{{ route('member.transactions.store', $book) }}">
                    @csrf
                    <button type="submit"
                            class="btn btn-primary-custom">
                        Ya, Pinjam
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection
