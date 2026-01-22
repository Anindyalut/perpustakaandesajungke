@extends('layouts.member')

@section('title', 'Home Member')

@section('content')

<style>
    /* ===== CARD GLOBAL ===== */
    .book-card {
        border: none;
        border-radius: 16px;
        transition: transform .2s ease, box-shadow .2s ease;
        height: 100%;
    }

    .book-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0,0,0,.08);
    }

    .book-img {
        height: 220px;
        object-fit: cover;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
    }

    /* ===== JUDUL: 2 BARIS + ... ===== */
    .book-title {
        min-height: 3em;              /* 2 baris */
        line-height: 1.5em;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* ===== PENULIS: 1 BARIS + ... ===== */
    .book-author {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
        max-width: 100%;
    }

    /* ===== BADGE ===== */
    .badge-recommend {
        background-color: #0f5c55;
    }

    .badge-stock {
        background-color: #e9f5f3;
        color: #0f5c55;
        border: 1px solid #0f5c55;
    }

    /* ===== BUTTON ===== */
    .btn-outline-custom {
        border-color: #0f5c55;
        color: #0f5c55;
    }

    .btn-outline-custom:hover {
        background-color: #0f5c55;
        color: white;
    }

    /* ===== HEADER ===== */
    .recommendation-header {
        background-color: #0f5c55;
        color: white;
        border-radius: 16px 16px 0 0;
    }

    .section-title {
        color: #0f5c55;
    }

    <style>
    /* ===== CARD GLOBAL ===== */
    .book-card {
        border: none;
        border-radius: 16px;
        transition: transform .2s ease, box-shadow .2s ease;
        height: 100%;
    }

    .book-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0,0,0,.08);
    }

    .book-img {
        height: 220px;
        object-fit: cover;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
    }

    /* ===== JUDUL: 2 BARIS + ... ===== */
    .book-title {
        min-height: 3em;              /* 2 baris */
        line-height: 1.5em;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* ===== PENULIS: 1 BARIS + ... ===== */
    .book-author {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
        max-width: 100%;
    }

    /* ===== BADGE ===== */
    .badge-recommend {
        background-color: #0f5c55;
    }

    .badge-stock {
        background-color: #e9f5f3;
        color: #0f5c55;
        border: 1px solid #0f5c55;
    }

    /* ===== BUTTON ===== */
    .btn-outline-custom {
        border-color: #0f5c55;
        color: #0f5c55;
    }

    .btn-outline-custom:hover {
        background-color: #0f5c55;
        color: white;
    }

        /* ===== SLIDE GRID REKOMENDASI ===== */
    .recommendation-slider {
        display: flex;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        gap: 24px;
        padding-bottom: 12px;
    }

    .recommendation-page {
        flex: 0 0 100%;
        scroll-snap-align: start;
    }

    .recommendation-page .row {
        margin: 0;
    }

    .recommendation-slider::-webkit-scrollbar {
        height: 8px;
    }

    .recommendation-slider::-webkit-scrollbar-thumb {
        background: #0f5c55;
        border-radius: 10px;
    }
</style>

{{-- ================= REKOMENDASI ================= --}}
@if($recommendations->isNotEmpty())
<div class="card mb-5 shadow-sm book-card">
    <div class="card-header recommendation-header fw-bold">
        📚 Rekomendasi Untuk Kamu
    </div>

    <div class="card-body">
        <div class="recommendation-slider">

            @foreach($recommendations->chunk(4) as $page)
            <div class="recommendation-page">
                <div class="row g-4">

                    @foreach($page as $book)
                    <div class="col-md-3">
                        <div class="card book-card h-100">

                            @if($book->image)
                                <img src="{{ asset('storage/'.$book->image) }}"
                                     class="book-img">
                            @else
                                <div class="text-center py-5 text-muted">
                                    No Image
                                </div>
                            @endif

                            <div class="card-body d-flex flex-column">
                                <h6 class="fw-bold book-title">
                                    {{ $book->title }}
                                </h6>

                                <small class="text-muted mb-1 book-author">
                                    {{ $book->author }}
                                </small>

                                <span class="badge badge-recommend mb-2">
                                    Direkomendasikan
                                </span>

                                <span class="badge badge-stock mb-3">
                                    Stok: {{ $book->stock }}
                                </span>

                                <div class="mt-auto d-grid">
                                    <a href="{{ route('member.books.show', $book) }}"
                                       class="btn btn-outline-custom btn-sm">
                                        Detail Buku
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
@endif




{{-- ================= DAFTAR BUKU ================= --}}
<h4 class="fw-bold mb-4 section-title">
    📖 Daftar Buku
</h4>

<div class="row g-4">

@forelse($books as $book)
    <div class="col-md-3">
        <div class="card book-card h-100">

            @if($book->image)
                <img src="{{ asset('storage/'.$book->image) }}"
                     class="book-img">
            @else
                <div class="text-center py-5 text-muted">
                    No Image
                </div>
            @endif

            <div class="card-body d-flex flex-column">

                <h6 class="fw-bold book-title"
                    title="{{ $book->title }}">
                    {{ $book->title }}
                </h6>

                <small class="text-muted mb-2 book-author"
                       title="{{ $book->author }}">
                    {{ $book->author }}
                </small>

                <span class="badge badge-stock mb-3">
                    Stok: {{ $book->stock }}
                </span>

                <div class="mt-auto d-grid">
                    <a href="{{ route('member.books.show', $book) }}"
                       class="btn btn-outline-custom btn-sm">
                        Detail Buku
                    </a>
                </div>

            </div>
        </div>
    </div>
@empty
    <div class="col-12 text-center text-muted">
        Tidak ada buku tersedia
    </div>
@endforelse

</div>

@endsection
