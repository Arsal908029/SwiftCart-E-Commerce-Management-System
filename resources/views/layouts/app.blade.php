<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SwiftCart — @yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@400;500;600;700&family=Bricolage+Grotesque:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --void: #080b14;
            --deep: #0f1623;
            --panel: #151d2e;
            --border: rgba(255,255,255,0.07);
            --cyan: #00e5ff;
            --lime: #b8ff57;
            --violet: #8b5cf6;
            --rose: #ff4d6d;
            --text: #e2e8f4;
            --muted: #64748b;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Bricolage Grotesque', sans-serif;
            background: var(--void);
            color: var(--text);
            margin: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        .nav-bar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem 2rem;
            background: rgba(8,11,20,0.9);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
        }
        .brand {
            font-family: 'Clash Display', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            letter-spacing: -0.02em;
            color: var(--text);
        }
        .brand-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--cyan), var(--violet));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
        }
        .brand-text span { color: var(--cyan); }

        .nav-pill {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: 4px;
        }
        .nav-link-custom {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.55rem 1.1rem;
            border-radius: 999px;
            text-decoration: none;
            color: var(--muted);
            transition: all 0.2s ease;
        }
        .nav-link-custom:hover { color: var(--text); background: rgba(255,255,255,0.1); }
        .nav-link-custom.active {
            background: var(--cyan);
            color: var(--void);
            font-weight: 600;
        }

        .nav-right-group {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .user-profile-nav {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border);
            padding: 5px 12px 5px 6px;
            border-radius: 999px;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .user-profile-nav:hover {
            background: rgba(255,255,255,0.06);
            border-color: rgba(255,255,255,0.12);
        }
        .user-profile-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--cyan), var(--violet));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Clash Display', sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--void);
        }
        .user-profile-info {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
            text-align: left;
        }
        .user-profile-name {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text);
        }
        .user-profile-role {
            font-size: 0.65rem;
            opacity: 0.65;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--muted);
        }

        .main-content {
            padding: 8.5rem 2rem 2rem;
            min-height: 100vh;
            position: relative;
            z-index: 1;
            max-width: 1400px;
            margin: 0 auto;
        }

        .top-bar {
            background: rgba(8,11,20,0.86);
            border: 1px solid rgba(255,255,255,0.08);
            padding: 1.1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-radius: 26px;
            backdrop-filter: blur(20px);
            margin-bottom: 1.5rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.16);
        }
        .top-bar h2 {
            font-family: 'Clash Display', sans-serif;
            font-size: 1.35rem;
            font-weight: 700;
            margin: 0;
            color: var(--text);
        }
        .top-bar-right { display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap; }
        .top-bar-badge { font-size: 0.82rem; padding: 0.45rem 0.85rem; border-radius: 999px; font-weight: 700; letter-spacing: 0.04em; }
        .top-bar-badge.admin { background: rgba(255,255,255,0.08); color: #c7d2fe; }
        .top-bar-badge.buyer { background: rgba(255,255,255,0.08); color: #a5b4fc; }

        .page-body { padding: 0; }

        .nav-spacer { height: 7rem; }

        /* Dark theme table overrides */
        .table {
            background: transparent !important;
            color: var(--text) !important;
            border-collapse: separate;
        }
        .table thead {
            background: rgba(255,255,255,0.02) !important;
            color: var(--text) !important;
        }
        .table thead th {
            color: var(--text) !important;
            border-bottom: 1px solid rgba(255,255,255,0.06) !important;
            font-weight: 700;
            background-color: transparent !important;
        }
        .table tbody tr {
            background: rgba(255,255,255,0.01) !important;
        }
        .table.table-striped tbody tr:nth-of-type(odd) td {
            background-color: rgba(255, 255, 255, 0.02) !important;
            color: var(--text) !important;
        }
        .table.table-striped tbody tr:nth-of-type(even) td {
            background-color: transparent !important;
            color: var(--text) !important;
        }
        .table-hover tbody tr:hover td {
            background-color: rgba(255, 255, 255, 0.04) !important;
            color: var(--text) !important;
        }
        .table td, .table th {
            border-color: rgba(255,255,255,0.06) !important;
            vertical-align: middle;
            color: var(--text) !important;
            background-color: transparent !important;
        }
        .table-responsive { background: transparent !important; }

        /* List groups inside tables */
        .list-group-item {
            background: transparent !important;
            border: 1px solid rgba(255,255,255,0.04) !important;
            color: var(--text) !important;
        }
        .badge.bg-primary {
            background: linear-gradient(135deg, var(--cyan), var(--violet)) !important;
            color: var(--void) !important;
            box-shadow: 0 0 10px rgba(0, 229, 255, 0.2) !important;
        }
        .badge.bg-secondary {
            background: rgba(255,255,255,0.06) !important;
            color: var(--text) !important;
        }
        .badge.bg-info {
            background: rgba(0, 229, 255, 0.15) !important;
            color: var(--cyan) !important;
            border: 1px solid rgba(0, 229, 255, 0.3) !important;
        }
        .badge.bg-success {
            background: rgba(184, 255, 87, 0.15) !important;
            color: var(--lime) !important;
            border: 1px solid rgba(184, 255, 87, 0.3) !important;
        }
        .badge.bg-danger {
            background: rgba(255, 77, 109, 0.15) !important;
            color: var(--rose) !important;
            border: 1px solid rgba(255, 77, 109, 0.3) !important;
        }

        /* Dark theme card overrides */
        .card {
            background: var(--panel) !important;
            color: var(--text) !important;
            border: 1px solid rgba(255,255,255,0.08) !important;
            border-radius: 20px !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25) !important;
        }
        .card .text-muted {
            color: var(--muted) !important;
        }
        .card h4, .card h5 {
            color: var(--text) !important;
            font-family: 'Clash Display', sans-serif;
            font-weight: 600;
        }
        .card .btn-outline-primary {
            color: var(--cyan) !important;
            border-color: var(--cyan) !important;
        }
        .card .btn-outline-primary:hover {
            background: var(--cyan) !important;
            color: var(--void) !important;
        }
        .card .btn-outline-success {
            color: var(--lime) !important;
            border-color: var(--lime) !important;
        }
        .card .btn-outline-success:hover {
            background: var(--lime) !important;
            color: var(--void) !important;
        }
        .card .btn-outline-warning {
            color: #fbbf24 !important;
            border-color: #fbbf24 !important;
        }
        .card .btn-outline-warning:hover {
            background: #fbbf24 !important;
            color: var(--void) !important;
        }
        .card .btn-outline-danger {
            color: var(--rose) !important;
            border-color: var(--rose) !important;
        }
        .card .btn-outline-danger:hover {
            background: var(--rose) !important;
            color: var(--void) !important;
        }
        /* Specific border colors for cards */
        .card.border-primary { border: 1px solid var(--cyan) !important; }
        .card.border-success { border: 1px solid var(--lime) !important; }
        .card.border-warning { border: 1px solid #fbbf24 !important; }
        .card.border-danger { border: 1px solid var(--rose) !important; }

        /* Dark theme alerts overrides */
        .alert {
            background: var(--panel) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: var(--text) !important;
            border-radius: 16px !important;
        }
        .alert-success {
            border-color: rgba(184, 255, 87, 0.3) !important;
            color: var(--lime) !important;
        }
        .alert-danger {
            border-color: rgba(255, 77, 109, 0.3) !important;
            color: var(--rose) !important;
        }
        .alert-info {
            border-color: rgba(0, 229, 255, 0.3) !important;
            color: var(--cyan) !important;
        }

        @media (max-width: 1024px) {
            .main-content { padding-top: 8.5rem; }
            .nav-bar { padding: 1rem 1.25rem; }
        }
        @media (max-width: 768px) {
            .nav-bar { flex-direction: column; align-items: center; gap: 0.75rem; }
            .nav-right-group { flex-direction: column; width: 100%; gap: 0.5rem; }
            .nav-pill { justify-content: center; width: 100%; }
            .main-content { padding-top: 12rem; }
        }
    </style>
    @yield('styles')
</head>
<body>

<nav class="nav-bar">
    <a href="/" class="brand">
        <div class="brand-icon">⚡</div>
        <span class="brand-text">Swift<span>Cart</span></span>
    </a>
    <div class="nav-right-group">
        <div class="nav-pill">
            <a href="{{ route('home') }}" class="nav-link-custom {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            @if(Auth::user() && Auth::user()->isAdmin())
                <a href="{{ url('/admin/dashboard') }}" class="nav-link-custom {{ request()->is('admin/dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ url('/admin/products') }}" class="nav-link-custom {{ request()->is('admin/products*') ? 'active' : '' }}">Products</a>
                <a href="{{ url('/admin/orders') }}" class="nav-link-custom {{ request()->is('admin/orders') ? 'active' : '' }}">Orders</a>
                <a href="{{ url('/admin/payments') }}" class="nav-link-custom {{ request()->is('admin/payments') ? 'active' : '' }}">Payments</a>
                <a href="{{ url('/admin/sales') }}" class="nav-link-custom {{ request()->is('admin/sales') ? 'active' : '' }}">Sales</a>
                <a href="{{ route('admin.feedbacks') }}" class="nav-link-custom {{ request()->is('admin/feedbacks') ? 'active' : '' }}">Feedbacks</a>
                <a href="{{ route('logout') }}" class="nav-link-custom" onclick="event.preventDefault(); document.getElementById('logout-nav-form').submit();">Sign Out</a>
            @elseif(Auth::user() && Auth::user()->isBuyer())
                <a href="{{ url('/buyer/dashboard') }}" class="nav-link-custom {{ request()->is('buyer/dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ url('/buyer/products') }}" class="nav-link-custom {{ request()->is('buyer/products*') ? 'active' : '' }}">Products</a>
                <a href="{{ url('/buyer/cart') }}" class="nav-link-custom {{ request()->is('buyer/cart') ? 'active' : '' }}">Cart</a>
                <a href="{{ url('/buyer/orders') }}" class="nav-link-custom {{ request()->is('buyer/orders') ? 'active' : '' }}">Orders</a>
                <a href="{{ route('buyer.feedback') }}" class="nav-link-custom {{ request()->is('buyer/feedback') ? 'active' : '' }}">Feedback</a>
                <a href="{{ route('buyer.profile') }}" class="nav-link-custom {{ request()->is('buyer/profile') ? 'active' : '' }}">Profile</a>
                <a href="{{ route('logout') }}" class="nav-link-custom" onclick="event.preventDefault(); document.getElementById('logout-nav-form').submit();">Sign Out</a>
            @else
                <a href="{{ route('login') }}" class="nav-link-custom {{ request()->routeIs('login') ? 'active' : '' }}">Sign In</a>
                <a href="{{ route('register') }}" class="nav-link-custom {{ request()->routeIs('register') ? 'active' : '' }}">Register</a>
            @endif
        </div>
        @if(Auth::check())
            <div class="user-profile-nav">
                <div class="user-profile-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div class="user-profile-info d-none d-md-flex">
                    <span class="user-profile-name">{{ Auth::user()->name }}</span>
                    <span class="user-profile-role">{{ ucfirst(Auth::user()->role) }}</span>
                </div>
            </div>
        @endif
    </div>
</nav>
<form id="logout-nav-form" method="POST" action="{{ route('logout') }}" style="display:none;">
    @csrf
</form>

<!-- SIDEBAR REMOVED -->

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="top-bar">
        <h2>@yield('page-title', 'Dashboard')</h2>
        <div class="top-bar-right">
            @if(Auth::user() && Auth::user()->isAdmin())
                <span class="top-bar-badge admin">
                    <i class="fas fa-shield-halved me-1"></i> Admin
                </span>
            @else
                <span class="top-bar-badge buyer">
                    <i class="fas fa-bag-shopping me-1"></i> Buyer
                </span>
            @endif
        </div>
    </div>

    <div class="page-body">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 mb-4" role="alert">
            <i class="fas fa-circle-exclamation me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
