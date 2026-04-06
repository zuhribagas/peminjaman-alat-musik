@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('sidebar')
    @include('petugas.components.sidebar')
@endsection

@section('navbar')
    @include('layouts.navigation')
@endsection

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="hero-welcome mb-5" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
        <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 1;">
            <div>
                <h1 class="hero-title">
                    Halo, Petugas! <i class="bi bi-shield-check"></i>
                </h1>
                <p class="hero-subtitle mb-0">Selamat bertugas hari ini, {{ now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card-premium h-100">
                <div class="card-body stat-card">
                    <div>
                        <div class="stat-icon-wrapper bg-amber-soft">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div class="stat-label mb-1">Perlu Persetujuan</div>
                        <div class="stat-value">{{ \App\Models\Peminjaman::where('status', 'pending')->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-premium h-100">
                <div class="card-body stat-card">
                    <div>
                        <div class="stat-icon-wrapper bg-emerald-soft">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="stat-label mb-1">Sedang Dipinjam</div>
                        <div class="stat-value">{{ \App\Models\Peminjaman::where('status', 'approved')->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-premium h-100">
                <div class="card-body stat-card">
                    <div>
                        <div class="stat-icon-wrapper bg-indigo-soft">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </div>
                        <div class="stat-label mb-1">Sudah Dikembalikan</div>
                        <div class="stat-value">{{ \App\Models\Peminjaman::where('status', 'returned')->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-premium">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Permintaan Peminjaman Terbaru</h5>
            <a href="{{ route('petugas.peminjaman.index') }}" class="btn btn-sm btn-outline-secondary">Kelola Semua</a>
        </div>
        <div class="table-responsive">
            <table class="table table-modern align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Peminjam</th>
                        <th>Alat</th>
                        <th>Tanggal Pinjam</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $pending = \App\Models\Peminjaman::with(['user', 'alat'])
                            ->where('status', 'pending')
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp
                    @forelse($pending as $p)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $p->user->name }}</div>
                            </td>
                            <td>{{ $p->alat->nama_alat }}</td>
                            <td>{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                            <td><span class="badge badge-soft-warning">Menunggu</span></td>
                            <td class="text-end pe-4">
                                <a href="{{ route('petugas.peminjaman.show', $p) }}" class="btn btn-sm btn-primary">
                                    Proses
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada permintaan baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
