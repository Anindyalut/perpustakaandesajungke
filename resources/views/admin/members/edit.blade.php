@extends('layouts.admin')

@section('content')
<h4 class="fw-bold mb-3">✏️ Edit Member</h4>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST"
              action="{{ route('admin.members.update', $member) }}">
            @csrf
            @method('PUT')

            <label>Nama</label>
            <input name="name"
                   value="{{ $member->name }}"
                   class="form-control mb-2" required>

            <label>Email</label>
            <input name="email"
                   type="email"
                   value="{{ $member->email }}"
                   class="form-control mb-2" required>

            <label>No HP</label>
            <input name="phone"
                   value="{{ $member->phone }}"
                   class="form-control mb-2">

            <label>Alamat</label>
            <textarea name="address"
                      class="form-control mb-3">{{ $member->address }}</textarea>

            <button class="btn btn-warning">Update</button>
            <a href="{{ route('admin.members.index') }}"
               class="btn btn-secondary">
               Kembali
            </a>
        </form>
    </div>
</div>
@endsection
