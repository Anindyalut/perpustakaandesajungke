@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <h4 class="fw-bold mb-3">✏️ Edit Buku</h4>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.books.update', $book) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- JUDUL --}}
                    <div class="col-md-6 mb-3">
                        <label>Judul Buku</label>
                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ old('title', $book->title) }}">
                    </div>

                    {{-- PENULIS --}}
                    <div class="col-md-6 mb-3">
                        <label>Penulis</label>
                        <input type="text"
                               name="author"
                               class="form-control"
                               value="{{ old('author', $book->author) }}">
                    </div>

                    {{-- PENERBIT --}}
                    <div class="col-md-6 mb-3">
                        <label>Penerbit</label>
                        <input type="text"
                               name="publisher"
                               class="form-control"
                               value="{{ old('publisher', $book->publisher) }}">
                    </div>

                    {{-- TAHUN --}}
                    <div class="col-md-3 mb-3">
                        <label>Tahun</label>
                        <input type="number"
                               name="year"
                               class="form-control"
                               value="{{ old('year', $book->year) }}">
                    </div>

                    {{-- ISBN --}}
                    <div class="col-md-3 mb-3">
                        <label>ISBN</label>
                        <input type="text"
                               name="isbn"
                               class="form-control"
                               value="{{ old('isbn', $book->isbn) }}">
                    </div>

                    {{-- UKURAN --}}
                    <div class="col-md-3 mb-3">
                        <label>Ukuran</label>
                        <input type="text"
                            name="ukuran"
                            class="form-control"
                            placeholder="Contoh: 14 x 21 cm"
                            value="{{ old('ukuran', $book->ukuran) }}">
                    </div>

                    {{-- JUMLAH HALAMAN --}}
                    <div class="col-md-3 mb-3">
                        <label>Jumlah Halaman</label>
                        <input type="number"
                            name="jumlah_halaman"
                            min="1"
                            class="form-control"
                            placeholder="Contoh: 320"
                            value="{{ old('jumlah_halaman', $book->jumlah_halaman) }}">
                    </div>


                    {{-- WARNA --}}
                    <div class="col-md-3 mb-3">
                        <label>Warna</label>
                        <select name="color" class="form-control">
                            <option value="color" {{ $book->color == 'color' ? 'selected' : '' }}>
                                Color
                            </option>
                            <option value="bw" {{ $book->color == 'bw' ? 'selected' : '' }}>
                                B/W
                            </option>
                        </select>
                    </div>

                    {{-- STOK --}}
                    <div class="col-md-3 mb-3">
                        <label>Stok</label>
                        <input type="number"
                               name="stock"
                               class="form-control"
                               value="{{ old('stock', $book->stock) }}">
                    </div>

                    {{-- HARGA --}}
                    <div class="col-md-3 mb-3">
                        <label>Harga</label>
                        <input type="number"
                               name="price"
                               class="form-control"
                               value="{{ old('price', $book->price) }}">
                    </div>

                    {{-- TOTAL --}}
                    <div class="col-md-3 mb-3">
                        <label>Total</label>
                        <input type="text"
                               id="total"
                               class="form-control"
                               readonly>
                    </div>

                    {{-- FOTO --}}
                    <div class="col-md-6 mb-3">
                        <label>Foto Buku</label>
                        <input type="file" name="image" class="form-control">

                        @if($book->image)
                            <img src="{{ asset('storage/'.$book->image) }}"
                                 class="mt-2"
                                 width="100">
                        @endif
                    </div>

                </div>

                <div class="text-end">
                    <a href="{{ route('admin.books.index') }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>
                    <button class="btn btn-primary">
                        Update
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

{{-- AUTO HITUNG TOTAL --}}
<script>
    const stock = document.querySelector('input[name="stock"]');
    const price = document.querySelector('input[name="price"]');
    const total = document.getElementById('total');

    function hitungTotal() {
        const s = parseInt(stock.value) || 0;
        const p = parseInt(price.value) || 0;
        total.value = 'Rp ' + (s * p).toLocaleString('id-ID');
    }

    stock.addEventListener('input', hitungTotal);
    price.addEventListener('input', hitungTotal);

    // hitung saat halaman dibuka
    hitungTotal();
</script>
@endsection
