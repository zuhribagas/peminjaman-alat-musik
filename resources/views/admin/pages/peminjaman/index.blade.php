@extends('layouts.app')

@section('title', 'Admin Peminjaman')

@php
    $routePrefix = auth()->user()->role === 'petugas' ? 'petugas.' : 'admin.';
@endphp

@section('sidebar')
    @if(auth()->user()->role === 'petugas')
        @include('petugas.components.sidebar')
    @else
        @include('admin.components.sidebar')
    @endif
@endsection

@section('navbar')
    @include('layouts.navigation')
@endsection

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-1">Peminjaman</h2>
            <p class="text-muted mb-0">Monitor dan kelola status peminjaman pengguna</p>
        </div>
        
        <div class="bg-white p-1 rounded-pill border shadow-sm d-inline-flex">
            <a href="{{ route($routePrefix . 'peminjaman.index') }}" 
               class="px-4 py-2 rounded-pill text-decoration-none fw-bold small {{ !request('status') ? 'bg-primary text-white shadow-sm' : 'text-muted' }}">
               Semua
            </a>
            <a href="{{ route($routePrefix . 'peminjaman.index', ['status' => 'pending']) }}" 
               class="px-4 py-2 rounded-pill text-decoration-none fw-bold small {{ request('status') == 'pending' ? 'bg-warning text-dark shadow-sm' : 'text-muted' }}">
               Pending
            </a>
            <a href="{{ route($routePrefix . 'peminjaman.index', ['status' => 'approved']) }}" 
               class="px-4 py-2 rounded-pill text-decoration-none fw-bold small {{ request('status') == 'approved' ? 'bg-success text-white shadow-sm' : 'text-muted' }}">
               Active
            </a>
            <a href="{{ route($routePrefix . 'peminjaman.index', ['status' => 'returned']) }}" 
               class="px-4 py-2 rounded-pill text-decoration-none fw-bold small {{ request('status') == 'returned' ? 'bg-info text-white shadow-sm' : 'text-muted' }}">
               Done
            </a>
        </div>
    </div>

    <div class="card-premium">
        <div class="table-responsive">
            <table class="table table-modern align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">ID Transaksi</th>
                        <th>User</th>
                        <th>Alat & Durasi</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $p)
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold text-dark">#{{ $p->id }}</span>
                                <div class="small text-muted">{{ $p->created_at->diffForHumans() }}</div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3 bg-gradient-primary">
                                        {{ strtoupper(substr($p->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $p->user->name }}</div>
                                        <div class="small text-muted">{{ $p->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="bi bi-box-seam me-2 text-muted"></i>
                                    <span class="fw-medium">{{ $p->alat->nama_alat }}</span>
                                </div>
                                <div class="badge bg-light text-dark border">
                                    <i class="bi bi-clock me-1"></i> {{ $p->durasi_hari }} Hari
                                </div>
                            </td>
                            <td>
                                <div class="small fw-semibold">{{ $p->tanggal_pinjam->format('d M') }}</div>
                                <i class="bi bi-arrow-down-short text-muted"></i>
                                <div class="small">{{ $p->tanggal_kembali_rencana->format('d M') }}</div>
                            </td>
                            <td>
                                @if($p->status == 'pending')
                                    <span class="badge badge-soft-warning">Menunggu Approval</span>
                                @elseif($p->status == 'approved')
                                    <span class="badge badge-soft-success">Sedang Dipinjam</span>
                                @elseif($p->status == 'returned')
                                    <span class="badge badge-soft-info">Dikembalikan</span>
                                @else
                                    <span class="badge badge-soft-danger">Ditolak</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-2 rounded-3">
                                        <li>
                                            <a class="dropdown-item rounded-2 mb-1" href="{{ route($routePrefix . 'peminjaman.show', $p) }}">
                                                <i class="bi bi-eye me-2 text-primary"></i> Detail
                                            </a>
                                        </li>
                                        @if($p->status == 'pending')
                                            <li>
                                                <form action="{{ route($routePrefix . 'peminjaman.approve', $p) }}" method="POST" class="approve-form">
                                                    @csrf
                                                    <button class="dropdown-item rounded-2 mb-1 text-success fw-medium">
                                                        <i class="bi bi-check-lg me-2"></i> Approve
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route($routePrefix . 'peminjaman.reject', $p) }}" method="POST" class="reject-form">
                                                    @csrf
                                                    <button class="dropdown-item rounded-2 text-danger fw-medium">
                                                        <i class="bi bi-x-lg me-2"></i> Reject
                                                    </button>
                                                </form>
                                            </li>
                                        @elseif($p->status == 'approved')
                                            @if(auth()->user()->role === 'admin')
                                            <li>
                                                <a class="dropdown-item rounded-2 text-warning fw-medium" href="{{ route('admin.pengembalian.create', $p) }}">
                                                    <i class="bi bi-arrow-return-left me-2"></i> Return
                                                </a>
                                            </li>
                                            @endif
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-inbox text-muted mb-3" style="font-size: 3rem; opacity: 0.5;"></i>
                                    <h5 class="text-muted">Tidak ada data peminjaman</h5>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($peminjamans->hasPages())
            <div class="card-footer bg-white border-top py-3">
                {{ $peminjamans->links() }}
            </div>
        @endif
    </div>
</div>

<style>
.avatar-circle {
    width: 40px; height: 40px; border-radius: 50%; 
    display: flex; align-items: center; justify-content: center; 
    color: white; font-weight: bold; background: #6366f1;
}
.bg-gradient-primary { background: linear-gradient(135deg, #6366f1, #818cf8); }
</style>
@endsectionA
