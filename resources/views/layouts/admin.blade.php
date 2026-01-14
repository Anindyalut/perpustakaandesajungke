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
            transition: margin-left .3s ease;
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
            z-index: 1050;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar h4 {
            font-size: 18px;
            text-align: center;
            padding: 1.5rem 0;
            font-weight: bold;
            color: #fff;
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

        /* ================= CONTENT ================= */
        .content {
            margin-left: 260px;
            padding: 30px;
            transition: margin-left .3s ease;
            max-width: 100%;
            overflow-x: auto;
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

        /* ================= MOBILE OVERLAY ================= */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.4);
            z-index: 1040;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 240px;
                transform: translateX(-100%);
                box-shadow: 2px 0 8px rgba(0,0,0,0.2);
            }

            .content {
                margin-left: 0;
                padding: 15px;
            }

            .sidebar-toggle {
                left: 10px;
                top: 10px;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                font-size: 20px;
                padding: 0;
            }

            .sidebar-open .sidebar {
                transform: translateX(0);
            }

            .sidebar-open .sidebar-overlay {
                display: block;
            }
        }

        /* ================= DESKTOP COLLAPSE ================= */
        @media (min-width: 769px) {
            .sidebar-collapsed .sidebar {
                transform: translateX(-100%);
            }

            .sidebar-collapsed .content {
                margin-left: 0;
            }

            .sidebar-collapsed .sidebar-toggle {
                left: 10px;
            }

            .sidebar-collapsed .sidebar-toggle i {
                transform: rotate(180deg);
            }
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- MOBILE OVERLAY --}}
<div class="sidebar-overlay"></div>

{{-- TOGGLE --}}
<button id="toggleSidebar" class="sidebar-toggle">
    <i class="bi bi-list"></i>
</button>

{{-- SIDEBAR --}}
<div class="sidebar d-flex flex-column justify-content-between">
    <div>
        <h4 class="fw-bold">ADMIN<br>PERPUSTAKAAN</h4>

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
    const body = document.body;
    const overlay = document.querySelector('.sidebar-overlay');

    function isMobile() {
        return window.innerWidth <= 768;
    }

    // Toggle sidebar
    toggleBtn.addEventListener('click', () => {
        if(isMobile()){
            body.classList.toggle('sidebar-open'); // overlay mobile
        } else {
            body.classList.toggle('sidebar-collapsed'); // desktop push
            localStorage.setItem(
                'sidebar',
                body.classList.contains('sidebar-collapsed') ? 'collapsed' : 'open'
            );
        }
    });

    // Click overlay to close sidebar (mobile)
    overlay.addEventListener('click', () => {
        if(isMobile()) body.classList.remove('sidebar-open');
    });

    // Close sidebar when link clicked
    document.querySelectorAll('.sidebar a').forEach(link => {
        link.addEventListener('click', () => {
            if(isMobile()){
                body.classList.remove('sidebar-open');
            }
        });
    });

    // Load sidebar state desktop
    if(localStorage.getItem('sidebar') === 'collapsed'){
        body.classList.add('sidebar-collapsed');
    }

    // Resize listener
    window.addEventListener('resize', () => {
        if(isMobile()){
            body.classList.remove('sidebar-collapsed'); // desktop collapse di-reset
        } else {
            body.classList.remove('sidebar-open'); // overlay mobile ditutup
        }
    });
</script>

@stack('scripts')

</body>
</html>
