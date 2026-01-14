<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Perpustakaan Desa')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        /* HEADER ATAS */
        .header-top {
            background-color: #0f5c55;
            color: white;
            padding: 25px 15px;
            text-align: center;
        }

        .header-top h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .header-top p {
            margin: 0;
            font-size: 14px;
        }

        /* NAVBAR */
        .header-nav {
            background-color: #0f5c55;
            border-top: 1px solid rgba(255,255,255,.2);
            padding: 10px 20px;
        }

        .nav-link-custom {
            color: white;
            margin-left: 20px;
            text-decoration: none;
            font-weight: 500;
            white-space: nowrap;
        }

        .nav-link-custom:hover {
            text-decoration: underline;
        }

        .member-name {
            cursor: pointer;
        }

        .dropdown-menu {
            font-size: 14px;
        }

        /* SEARCH BAR */
        .search-form {
            flex: 1;
            max-width: 550px; /* panjang search */
        }

        .search-input {
            border-radius: 8px 0 0 8px;
        }

        .search-btn {
            border-radius: 0 8px 8px 0;
        }
    </style>
</head>
<body>

{{-- HEADER ATAS --}}
<div class="header-top">
    <h1>PERPUSTAKAAN DESA JUNGKE</h1>
    <p>Jl. Raya Glodok - Simo No.06 Desa Jungke, Karas, Magetan</p>
    <p>Kode Pos : 63396</p>
</div>

{{-- NAVBAR --}}
<div class="header-nav d-flex justify-content-between align-items-center gap-3 flex-wrap">

    {{-- SEARCH --}}
    <form method="GET"
          action="{{ route('member.home') }}"
          class="d-flex align-items-center search-form">

        <div class="input-group input-group-sm w-100">
            <input type="text"
                   name="search"
                   class="form-control search-input"
                   placeholder="Cari judul buku, penulis, atau kategori..."
                   value="{{ request('search') }}">

            <button class="btn btn-light search-btn">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </form>

    {{-- MENU --}}
    <div class="d-flex align-items-center">

        <a href="{{ route('member.home') }}" class="nav-link-custom">
            <i class="bi bi-house"></i> Home
        </a>

        <a href="{{ route('member.transactions.index') }}" class="nav-link-custom">
            <i class="bi bi-clock-history"></i> Riwayat
        </a>

        {{-- MEMBER DROPDOWN --}}
        <div class="dropdown ms-3">
            <a class="nav-link-custom dropdown-toggle member-name"
               href="#"
               role="button"
               data-bs-toggle="dropdown">
                <i class="bi bi-person-circle"></i>
                {{ auth()->user()->name }}
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item"
                       href="{{ route('member.profile') }}">
                        <i class="bi bi-person"></i> Biodata Saya
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>

    </div>
</div>

{{-- CONTENT --}}
<div class="container-fluid mt-4 px-4">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
