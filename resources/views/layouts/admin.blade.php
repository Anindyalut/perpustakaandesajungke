<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Admin') | Admin Perpustakaan</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --hijau-utama: #0f5c55;
            --hijau-hover: #0d4f49;
            --hijau-soft: #f1f8f6;
            --border-soft: #d1e7dd;
        }

        body {
            background: #f8f9fa;
            overflow-x: hidden;
        }

        /* ================= SIDEBAR ================= */
        .sidebar {
            width: 260px;
            background: var(--hijau-utama);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            transition: transform .3s ease;
            z-index: 1000;
        }

        .sidebar h4 {
            font-size: 18px;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            margin: 4px 10px;
            border-radius: 8px;
            transition: .2s;
            font-size: 14px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: var(--hijau-hover);
        }

        /* ================= CONTENT ================= */
        .content {
            margin-left: 260px;
            padding: 30px;
            transition: margin-left .3s ease;
        }

        /* ================= TOGGLE BUTTON ================= */
        .sidebar-toggle {
            position: fixed;
            left: 260px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--hijau-utama);
            border: none;
            color: white;
            width: 28px;
            height: 70px;
            border-radius: 0 10px 10px 0;
            cursor: pointer;
            z-index: 1100;
            transition: all .3s ease;
        }

        .sidebar-toggle i {
            font-size: 18px;
        }

        /* ================= COLLAPSED ================= */
        .sidebar-collapsed .sidebar {
            transform: translateX(-100%);
        }

        .sidebar-collapsed .content {
            margin-left: 0;
        }

        .sidebar-collapsed .sidebar-toggle {
            left: 0;
        }

        .sidebar-collapsed .sidebar-toggle i {
            transform: rotate(180deg);
        }

        /* ================= MOBILE ================= */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .content {
                margin-left: 0;
                padding: 15px;
            }

            .sidebar-toggle {
                left: 0;
            }

            body:not(.sidebar-collapsed) .sidebar {
                transform: translateX(0);
            }
        }

        /* ================= LOGOUT ================= */
        .logout-btn {
            background: #e05656;
            border: none;
            color: white;
            padding: 10px;
            width: 80%;
            border-radius: 8px;
            margin: 20px auto;
            font-size: 14px;
        }

        .logout-btn:hover {
            background: #c94b4b;
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- TOGGLE --}}
<button id="toggleSidebar" class="sidebar-toggle">
    <i class="bi bi-chevron-left"></i>
</button>

{{-- SIDEBAR --}}
<div class="sidebar d-flex flex-column justify-content-between">
    <div>
        <h4 class="text-center text-white py-4 fw-bold">
            ADMIN<br>PERPUSTAKAAN
        </h4>

        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <a href="{{ route('admin.books.index') }}" class="{{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
            <i class="bi bi-book"></i> Kelola Buku
        </a>

        <a href="{{ route('admin.members.index') }}" class="{{ request()->routeIs('admin.members.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Kelola Member
        </a>

        <a href="{{ route('admin.transactions.index') }}" class="{{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
            <i class="bi bi-arrow-left-right"></i> Transaksi
        </a>

        <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i> Laporan
        </a>

        <a href="{{ route('admin.fpgrowth.parameter') }}" class="{{ request()->routeIs('admin.fpgrowth.parameter') ? 'active' : '' }}">
            <i class="bi bi-sliders"></i> Parameter Rekomendasi
        </a>

        <a href="{{ route('admin.fpgrowth.index') }}" class="{{ request()->routeIs('admin.fpgrowth.index') ? 'active' : '' }}">
            <i class="bi bi-stars"></i> Rekomendasi Buku
        </a>
    </div>

    <form method="POST" action="{{ route('logout') }}" class="text-center">
        @csrf
        <button class="logout-btn">Logout</button>
    </form>
</div>

{{-- CONTENT --}}
<div class="content">
    @yield('content')
</div>

<script>
    const toggleBtn = document.getElementById('toggleSidebar');

    if (localStorage.getItem('sidebar') === 'collapsed') {
        document.body.classList.add('sidebar-collapsed');
    }

    toggleBtn.addEventListener('click', () => {
        document.body.classList.toggle('sidebar-collapsed');

        localStorage.setItem(
            'sidebar',
            document.body.classList.contains('sidebar-collapsed')
                ? 'collapsed'
                : 'open'
        );
    });
</script>

@stack('scripts')

</body>
</html>
