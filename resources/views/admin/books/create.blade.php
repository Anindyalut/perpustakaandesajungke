@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h4 class="fw-bold mb-3">➕ Tambah Buku</h4>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.books.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <label>Nama Buku</label>
                <input type="text" name="title" class="form-control mb-2">

                <label>Penulis</label>
                <input type="text" name="author" class="form-control mb-2">

                <label>Penerbit</label>
                <input type="text" name="publisher" class="form-control mb-2">

                <label>Tahun Terbit</label>
                <input type="number" name="year" class="form-control mb-2">

                <label>ISBN</label>
                <input type="text" name="isbn" class="form-control mb-2">

                <label>Ukuran Buku</label>
                <input type="text"
                    name="ukuran"
                    class="form-control mb-2"
                    placeholder="Contoh: 14 x 21 cm"
                    value="{{ old('ukuran') }}">

                <label>Jumlah Halaman</label>
                <input type="number"
                    name="jumlah_halaman"
                    class="form-control mb-2"
                    placeholder="Contoh: 320"
                    value="{{ old('jumlah_halaman') }}">


                <label>Warna Buku</label>
                <select name="color" class="form-control mb-2">
                    <option value="">-- Pilih --</option>
                    <option value="color">Berwarna</option>
                    <option value="bw">Hitam Putih</option>
                </select>

                <label>Jumlah Buku</label>
                <input type="number" name="stock" class="form-control mb-2">

                <label>Harga Buku</label>
                <input type="number" name="price" class="form-control mb-2">

                <label>Total</label>
                <input type="text" id="total" class="form-control mb-2" readonly>

                <label>Foto Buku</label>
                <input type="file" name="image" class="form-control mb-3">

                <button class="btn btn-success">Simpan</button>
                <a href="{{ route('admin.books.index') }}"
                   class="btn btn-secondary">Kembali</a>
            </form>

        </div>
    </div>
</div>

<script>
    const stockInput = document.querySelector('input[name="stock"]');
    const priceInput = document.querySelector('input[name="price"]');
    const totalInput = document.getElementById('total');

    function calculateTotal() {
        const stock = parseInt(stockInput.value) || 0;
        const price = parseInt(priceInput.value) || 0;
        totalInput.value = 'Rp ' + (stock * price).toLocaleString('id-ID');
    }

    stockInput.addEventListener('input', calculateTotal);
    priceInput.addEventListener('input', calculateTotal);
</script>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection
