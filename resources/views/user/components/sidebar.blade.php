<nav class="sidebar">
    <div class="sidebar-header">
        
        <span>USER</span>
    </div>

    <div class="sidebar-body">
        <div class="nav-section">Utama</div>
        <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i>
            <span>Dashboard</span>
        </a>

        <div class="nav-section mt-4">Aktivitas</div>
        <a href="{{ route('user.peminjaman.create') }}" class="nav-link {{ request()->routeIs('user.peminjaman.create') ? 'active' : '' }}">
            <i class="bi bi-cart-plus"></i>
            <span>Sewa Alat</span>
        </a>
        <a href="{{ route('user.peminjaman.index') }}" class="nav-link {{ request()->routeIs('user.peminjaman.index') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i>
            <span>Riwayat Saya</span>
        </a>
    </div>

    <div class="sidebar-footer">
        <div class="user-profile">
            <div class="avatar-circle bg-success text-white" style="width: 36px; height: 36px;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div style="line-height: 1.2;">
                <div class="fw-bold small">{{ Auth::user()->name }}</div>
            </div>
        </div>
    </div>
</nav>
