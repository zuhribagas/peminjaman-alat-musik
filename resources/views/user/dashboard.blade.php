@extends('layouts.app')

@section('title', 'Dashboard User')

@section('sidebar')
    @include('user.components.sidebar')
@endsection

@section('navbar')
    @include('layouts.navigation')
@endsection

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="hero-welcome mb-5">
        <div class="row align-items-center position-relative" style="z-index: 1;">
            <div class="col-lg-8">
                <h1 class="hero-title">
                    Halo, {{ auth()->user()->name }}! <i class="bi bi-emoji-smile-fill"></i>
                </h1>
                <p class="hero-subtitle mb-3">Mau mancing apa hari ini? Alat terbaik siap menemanimu.</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('user.peminjaman.create') }}" class="btn btn-light text-primary fw-bold shadow-sm px-4 py-2">
                        <i class="bi bi-cart-plus me-2"></i> Sewa Alat Sekarang
                    </a>
                    <a href="{{ route('user.peminjaman.index') }}" class="btn btn-outline-light fw-bold px-4 py-2">
                        Peminjaman Saya
                    </a>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-center">
                <i class="bi bi-water text-white" style="font-size: 8rem; opacity: 0.2;"></i>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card-premium h-100">
                <div class="card-body stat-card">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-wrapper bg-indigo-soft mb-0 me-3">
                            <i class="bi bi-receipt"></i>
                        </div>
                        <div>
                            <div class="stat-label">Total Sewa</div>
                            <div class="stat-value">{{ $stats['total_peminjaman'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-premium h-100">
                <div class="card-body stat-card">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-wrapper bg-amber-soft mb-0 me-3">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div>
                            <div class="stat-label">Pending</div>
                            <div class="stat-value">{{ $stats['pending'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-premium h-100">
                <div class="card-body stat-card">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-wrapper bg-emerald-soft mb-0 me-3">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div>
                            <div class="stat-label">Disetujui</div>
                            <div class="stat-value">{{ $stats['approved'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-premium h-100">
                <div class="card-body stat-card">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-wrapper bg-rose-soft mb-0 me-3">
                            <i class="bi bi-arrow-return-left"></i>
                        </div>
                        <div>
                            <div class="stat-label">Dikembalikan</div>
                            <div class="stat-value">{{ $stats['returned'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-8">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold text-dark mb-0">Rekomendasi Alat</h4>
                <a href="{{ route('user.peminjaman.create') }}" class="text-decoration-none fw-semibold">Lihat Semua <i class="bi bi-arrow-right"></i></a>
            </div>
            
            <div class="row g-3">
                @forelse($alat_tersedia as $alat)
                    <div class="col-md-6 col-lg-4">
                        <div class="card-premium h-100 p-0">
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 140px; border-bottom: 1px solid var(--border-color);">
                                @if($alat->foto)
                                    <img src="{{ asset('storage/' . $alat->foto) }}" class="w-100 h-100 object-fit-cover" alt="{{ $alat->nama_alat }}">
                                @else
                                    <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                @endif
                            </div>
                            <div class="card-body p-3">
                                <div class="badge badge-soft-primary mb-2">{{ $alat->kategori->nama_kategori }}</div>
                                <h6 class="fw-bold mb-1 text-truncate">{{ $alat->nama_alat }}</h6>
                                <p class="text-success fw-bold small mb-2">
                                    <i class="bi bi-tag-fill"></i> Rp {{ number_format($alat->harga_sewa_per_hari, 0, ',', '.') }}/hari
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted"><i class="bi bi-box-seam"></i> Stok: {{ $alat->stok_tersedia }}</small>
                                    <a href="{{ route('user.peminjaman.create') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        Sewa
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info border-0 shadow-sm">
                            <i class="bi bi-info-circle me-2"></i> Belum ada alat yang tersedia saat ini.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card-premium h-100">
                <div class="card-header">
                    <h5 class="mb-0">Aktivitas Terakhir</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($recent_peminjaman as $p)
                            <li class="list-group-item p-3 border-bottom">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold text-dark">{{ $p->alat->nama_alat }}</div>
                                        <div class="small text-muted mb-1">
                                            {{ $p->tanggal_pinjam->format('d M') }} - {{ $p->tanggal_kembali_rencana->format('d M') }}
                                        </div>
                                        <div>
                                            @if($p->status == 'pending')
                                                <span class="badge badge-soft-warning">Menunggu</span>
                                            @elseif($p->status == 'approved')
                                                <span class="badge badge-soft-success">Disetujui</span>
                                            @elseif($p->status == 'returned')
                                                <span class="badge badge-soft-info">Selesai</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="small fw-bold text-success mb-1">
                                            Rp {{ number_format($p->total_biaya, 0, ',', '.') }}
                                        </div>
                                        <a href="{{ route('user.peminjaman.index') }}" class="btn btn-xs btn-light rounded-circle">
                                            <i class="bi bi-chevron-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item p-4 text-center">
                                <p class="text-muted mb-0">Belum ada riwayat peminjaman.</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
