<nav class="sidebar">
    <div class="sidebar-header">
        
        <span>PETUGAS</span>
    </div>

    <div class="sidebar-body">
        <div class="nav-section">Utama</div>
        <a href="{{ route('petugas.dashboard') }}" class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i>
            <span>Dashboard</span>
        </a>

        <div class="nav-section mt-4">Master Data</div>
        <a href="{{ route('petugas.kategori.index') }}" class="nav-link {{ request()->routeIs('petugas.kategori.*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i>
            <span>Kategori Alat</span>
        </a>
        <a href="{{ route('petugas.alat.index') }}" class="nav-link {{ request()->routeIs('petugas.alat.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i>
            <span>Inventaris</span>
        </a>

        <div class="nav-section mt-4">Operasional</div>
        <a href="{{ route('petugas.peminjaman.index') }}" class="nav-link {{ request()->routeIs('petugas.peminjaman.*') ? 'active' : '' }}">
            <i class="bi bi-arrow-left-right"></i>
            <span>Peminjaman</span>
        </a>
        <a href="{{ route('petugas.pengembalian.index') }}" class="nav-link {{ request()->routeIs('petugas.pengembalian.*') ? 'active' : '' }}">
            <i class="bi bi-arrow-return-left"></i>
            <span>Pengembalian</span>
        </a>
        <a href="{{ route('petugas.transaksi.index') }}" class="nav-link {{ request()->routeIs('petugas.transaksi.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i>
            <span>Laporan</span>
        </a>
    </div>

    <div class="sidebar-footer">
        <div class="user-profile">
            <div class="avatar-circle bg-warning text-white" style="width: 36px; height: 36px;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div style="line-height: 1.2;">
                <div class="fw-bold small">{{ Auth::user()->name }}</div>
                <div class="text-muted" style="font-size: 0.7rem;">Petugas</div>
            </div>
        </div>
    </div>
</nav>
