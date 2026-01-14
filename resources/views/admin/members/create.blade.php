@extends('layouts.admin')

@section('content')
<h4 class="fw-bold mb-3">➕ Tambah Member</h4>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.members.store') }}">
            @csrf

            <label>Nama</label>
            <input name="name" class="form-control mb-2" required>

            <label>Email</label>
            <input name="email" type="email" class="form-control mb-2" required>

            <label>Password</label>
            <input name="password" type="password" class="form-control mb-2" required>

            <label>No HP</label>
            <input name="phone" class="form-control mb-2">

            <label>Alamat</label>
            <textarea name="address" class="form-control mb-3"></textarea>

            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.members.index') }}"
               class="btn btn-secondary">
               Kembali
            </a>
        </form>
    </div>
</div>
@endsection
