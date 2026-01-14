@extends('layouts.admin')

@push('styles')
<style>
    /* ================= TABLE HIJAU MEMBER ================= */
    .perpus-table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .perpus-table thead th {
        background-color: var(--hijau-utama);
        color: #ffffff;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        border: 1px solid var(--hijau-utama);
        white-space: nowrap;
        text-align: center;
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
</style>
@endpush

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0" style="color: var(--hijau-utama)">
            👥 Kelola Member
        </h4>

        <a href="{{ route('admin.members.create') }}"
           class="btn btn-success btn-sm">
            + Tambah Member
        </a>
    </div>

    {{-- SEARCH --}}
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text"
                   name="search"
                   class="form-control form-control-sm"
                   placeholder="Cari nama / email..."
                   value="{{ request('search') }}">
        </div>

        <div class="col-md-auto">
            <button class="btn btn-success btn-sm">
                Cari
            </button>
        </div>

        @if(request('search'))
            <div class="col-md-auto">
                <a href="{{ route('admin.members.index') }}"
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
                        <th class="text-start">Nama</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th class="text-start">Alamat</th>
                        <th width="140">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @php
                    $no = ($members->currentPage() - 1) * $members->perPage();
                @endphp

                @forelse($members as $member)
                    <tr>
                        <td>{{ ++$no }}</td>
                        <td class="text-start fw-semibold">
                            {{ $member->name }}
                        </td>
                        <td>{{ $member->email }}</td>
                        <td>
                            @if($member->phone)
                                <span class="badge bg-info text-dark">
                                    {{ $member->phone }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-start">
                            {{ $member->address ?? '-' }}
                        </td>
                        <td>
                            <a href="{{ route('admin.members.edit', $member) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('admin.members.destroy', $member) }}"
                                  method="POST"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Hapus member ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-muted py-4">
                            Belum ada data member
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        </div>
    </div>

    {{-- PAGINATION --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $members->links('pagination::bootstrap-5') }}
    </div>

</div>
@endsection
