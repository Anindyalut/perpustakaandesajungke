@extends('layouts.member')

@section('title', 'Profil Saya')

@section('content')

<style>
    .profile-card {
        border: none;
        border-radius: 16px;
    }

    .profile-header {
        background-color: #0f5c55;
        color: white;
        border-radius: 16px 16px 0 0;
    }

    .form-label {
        font-weight: 500;
        color: #555;
    }

    .form-control:focus {
        border-color: #0f5c55;
        box-shadow: 0 0 0 0.2rem rgba(15, 92, 85, 0.15);
    }

    .btn-primary-custom {
        background-color: #0f5c55;
        border: none;
        padding: 8px 20px;
    }

    .btn-primary-custom:hover {
        background-color: #0c4f49;
    }
</style>

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow-sm profile-card">

            <div class="card-header profile-header fw-bold">
                <i class="bi bi-person me-2"></i>
                Biodata Member
            </div>

            <div class="card-body p-4">

                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle me-1"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST"
                      action="{{ route('member.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name', $user->name) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ old('email', $user->email) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No HP</label>
                        <input type="text"
                               name="phone"
                               class="form-control"
                               value="{{ old('phone', $user->phone ?? '') }}">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Alamat</label>
                        <textarea name="address"
                                  class="form-control"
                                  rows="3">{{ old('address', $user->address ?? '') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary-custom">
                            <i class="bi bi-save me-1"></i>
                            Simpan Perubahan
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection
