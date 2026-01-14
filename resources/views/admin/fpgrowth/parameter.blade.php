@extends('layouts.admin')

@section('title','Parameter Rekomendasi')

@push('styles')
<style>
    /* ================= CARD ================= */
    .card {
        border-radius: 12px;
        border: none;
    }

    /* ================= FORM ================= */
    .form-label {
        font-weight: 600;
        font-size: 14px;
    }

    .form-control {
        border-radius: 8px;
        font-size: 14px;
    }

    .btn {
        border-radius: 8px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="mb-3">
        <h4 class="fw-bold mb-0 text-dark">
            ⚙️ Parameter Rekomendasi (FP-Growth)
        </h4>
        <p class="text-muted mb-0">
            Atur nilai minimum support untuk proses rekomendasi buku.
        </p>
    </div>

    {{-- FORM --}}
    <div class="card shadow-sm" style="max-width: 500px">
        <div class="card-body">

            <h6 class="fw-bold mb-3 text-success">
                Parameter FP-Growth
            </h6>

            <form method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">
                        Minimum Support (%)
                    </label>

                    <input type="number"
                           name="min_support"
                           class="form-control"
                           value="{{ $setting->min_support }}"
                           min="1" max="100"
                           required>

                    <small class="text-muted">
                        Nilai 1–100 (%). Semakin kecil, rekomendasi semakin banyak.
                    </small>
                </div>

                <div class="d-flex justify-content-end">
                    <button class="btn btn-success">
                        Simpan Parameter
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection
