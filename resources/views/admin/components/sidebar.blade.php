<nav class="sidebar">
    <div class="sidebar-header">
        
        <span>ADMIN</span>
    </div>

    <div class="sidebar-body">
        <div class="nav-section">Dashboard</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i>
            <span>Overview</span>
        </a>

        <div class="nav-section mt-4">Master Data</div>
        <a href="{{ route('admin.kategori.index') }}" class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i>
            <span>Kategori Alat</span>
        </a>
        <a href="{{ route('admin.alat.index') }}" class="nav-link {{ request()->routeIs('admin.alat.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i>
            <span>Inventaris</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            <span>Manajemen User</span>
        </a>

        <div class="nav-section mt-4">Transaksi</div>
        <a href="{{ route('admin.peminjaman.index') }}" class="nav-link {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">
            <i class="bi bi-arrow-left-right"></i>
            <span>Peminjaman</span>
        </a>
        <a href="{{ route('admin.pengembalian.index') }}" class="nav-link {{ request()->routeIs('admin.pengembalian.*') ? 'active' : '' }}">
            <i class="bi bi-arrow-counterclockwise"></i>
            <span>Pengembalian</span>
        </a>
        <a href="{{ route('admin.transaksi.index') }}" class="nav-link {{ request()->routeIs('admin.transaksi.*') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i>
            <span>Laporan</span>
        </a>
    </div>

    <div class="sidebar-footer">
        <div class="user-profile">
            <div class="avatar-circle bg-primary text-white" style="width: 36px; height: 36px;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div style="line-height: 1.2;">
                <div class="fw-bold small">{{ Auth::user()->name }}</div>
            </div>
        </div>
    </div>
</nav>
