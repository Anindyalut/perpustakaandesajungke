@extends('layouts.admin')

@push('styles')
<style>
    /* ================= THEME MEMBER HIJAU ================= */
    :root {
        --hijau-utama: #0f5c55;
        --hijau-hover: #198754;
        --hijau-soft: #f1f8f6;
        --border-soft: #d1e7dd;
    }

    /* ================= TABLE ================= */
    .perpus-table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .perpus-table thead th {
        background-color: var(--hijau-utama);
        color: #fff;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        border: 1px solid var(--hijau-utama);
        white-space: nowrap;
    }

    .perpus-table tbody td {
        border: 1px solid var(--border-soft);
        font-size: 14px;
        vertical-align: middle;
    }

    .perpus-table tbody tr:nth-child(even) {
        background-color: var(--hijau-soft);
    }

    .perpus-table tbody tr:hover {
        background-color: #e3f2ee;
    }

    /* ================= CARD ================= */
    .card {
        border-radius: 14px;
        border: none;
    }

    /* ================= IMAGE ================= */
    .book-img {
        width: 55px;
        height: 75px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid var(--border-soft);
    }

    /* ================= BADGE ================= */
    .badge {
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 8px;
    }

    /* ================= BUTTON ================= */
    .btn-sm {
        padding: 5px 12px;
        font-size: 12px;
        border-radius: 8px;
    }

    .btn-success {
        background-color: var(--hijau-utama);
        border-color: var(--hijau-utama);
    }

    .btn-success:hover {
        background-color: var(--hijau-hover);
        border-color: var(--hijau-hover);
    }

    .btn-primary {
        background-color: #157347;
        border-color: #157347;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0" style="color: var(--hijau-utama)">
            📚 Kelola Buku
        </h4>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.books.pdf') }}"
               class="btn btn-success btn-sm">
                <i class="bi bi-file-earmark-pdf"></i> PDF
            </a>

            <a href="{{ route('admin.books.create') }}"
               class="btn btn-primary btn-sm">
                + Tambah Buku
            </a>
        </div>
    </div>

    {{-- SEARCH --}}
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text"
                   name="search"
                   class="form-control form-control-sm"
                   placeholder="Cari judul / penulis / penerbit..."
                   value="{{ request('search') }}">
        </div>

        <div class="col-md-auto">
            <button class="btn btn-success btn-sm">
                Cari
            </button>
        </div>

        @if(request('search'))
            <div class="col-md-auto">
                <a href="{{ route('admin.books.index') }}"
                   class="btn btn-secondary btn-sm">
                    Reset
                </a>
            </div>
        @endif
    </form>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success py-2">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="card shadow-sm">
        <div class="card-body table-responsive p-0">

            <table class="table perpus-table text-center mb-0">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Foto</th>
                        <th class="text-start">Nama Buku</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun</th>
                        <th>ISBN</th>
                        <th>Ukuran</th>
                        <th>Jml Hal</th>
                        <th>Warna</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @php
                    $no = ($books->currentPage() - 1) * $books->perPage();
                @endphp

                @forelse($books as $book)
                    <tr>
                        <td>{{ ++$no }}</td>

                        <td>
                            @if($book->image)
                                <img src="{{ asset('storage/'.$book->image) }}"
                                     class="book-img">
                            @else
                                <span class="text-muted small">No Image</span>
                            @endif
                        </td>

                        <td class="text-start fw-semibold">
                            {{ $book->title }}
                        </td>

                        <td>{{ $book->author }}</td>
                        <td>{{ $book->publisher }}</td>
                        <td>{{ $book->year }}</td>
                        <td>{{ $book->isbn }}</td>
                        <td>{{ $book->ukuran ?? '-' }}</td>
                        <td>{{ $book->jumlah_halaman ?? '-' }}</td>

                        <td>
                            <span class="badge bg-info text-dark">
                                {{ strtoupper($book->color) }}
                            </span>
                        </td>

                        <td>
                            @if($book->stock > 0)
                                <span class="badge bg-success">
                                    {{ $book->stock }}
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    Habis
                                </span>
                            @endif
                        </td>

                        <td>
                            Rp {{ number_format($book->price, 0, ',', '.') }}
                        </td>

                        <td class="fw-bold">
                            Rp {{ number_format($book->stock * $book->price, 0, ',', '.') }}
                        </td>

                        <td>
                            <a href="{{ route('admin.books.edit', $book) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('admin.books.destroy', $book) }}"
                                  method="POST"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus buku ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="14" class="text-muted py-4">
                            Belum ada data buku
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        </div>
    </div>

    {{-- PAGINATION --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $books->links('pagination::bootstrap-5') }}
    </div>

</div>
@endsection
