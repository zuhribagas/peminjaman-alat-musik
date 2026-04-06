@extends('layouts.app')

@section('title', 'Detail Peminjaman')

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

@php
    $routePrefix = auth()->user()->role === 'petugas' ? 'petugas' : 'admin';
@endphp

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route($routePrefix . '.peminjaman.index') }}" class="btn btn-light rounded-circle shadow-sm" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h3 class="fw-bold mb-0">Detail Transaksi #{{ $peminjaman->id }}</h3>
                    <div class="small text-muted">{{ $peminjaman->created_at->format('l, d F Y • H:i') }}</div>
                </div>
            </div>

            <div class="card-premium mb-4">
                <div class="card-body p-4">
                    <div class="text-center py-4 border-bottom mb-4">
                        <div class="mb-2">Status Saat Ini</div>
                        @if($peminjaman->status == 'pending')
                            <div class="badge bg-warning fs-5 px-4 py-2 rounded-pill shadow-sm">Menunggu Persetujuan</div>
                        @elseif($peminjaman->status == 'approved')
                            <div class="badge bg-success fs-5 px-4 py-2 rounded-pill shadow-sm">Sedang Berlangsung</div>
                        @elseif($peminjaman->status == 'returned')
                            <div class="badge bg-info fs-5 px-4 py-2 rounded-pill shadow-sm">Selesai (Dikembalikan)</div>
                        @else
                            <div class="badge bg-danger fs-5 px-4 py-2 rounded-pill shadow-sm">Ditolak</div>
                        @endif
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6 border-end">
                            <h6 class="fw-bold text-uppercase text-muted small mb-3">Informasi Peminjam</h6>
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="avatar-circle bg-primary text-white" style="width: 48px; height: 48px; font-size: 1.2rem;">
                                    {{ strtoupper(substr($peminjaman->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold fs-5">{{ $peminjaman->user->name }}</div>
                                    <div class="text-muted">{{ $peminjaman->user->email }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 ps-md-4">
                            <h6 class="fw-bold text-uppercase text-muted small mb-3">Alat yang Dipinjam</h6>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded bg-light d-flex align-items-center justify-content-center border" style="width: 60px; height: 60px;">
                                    <i class="bi bi-box-seam text-secondary fs-3"></i>
                                </div>
                                <div>
                                    <div class="fw-bold fs-5">{{ $peminjaman->alat->nama_alat }}</div>
                                    <div class="text-muted">Jumlah: <strong>{{ $peminjaman->jumlah }} Unit</strong></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 border-light">

                    <h6 class="fw-bold text-uppercase text-muted small mb-3">Rincian Waktu</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-4">
                            <div class="p-3 bg-light rounded text-center">
                                <div class="small text-muted mb-1">Mulai Pinjam</div>
                                <div class="fw-bold">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 bg-light rounded text-center">
                                <div class="small text-muted mb-1">Rencana Kembali</div>
                                <div class="fw-bold">{{ $peminjaman->tanggal_kembali_rencana->format('d M Y') }}</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 bg-indigo-soft rounded text-center border border-primary border-opacity-25">
                                <div class="small text-primary mb-1">Durasi</div>
                                <div class="fw-bold text-primary">{{ $peminjaman->durasi_hari }} Hari</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold text-uppercase text-muted small mb-2">Keperluan</h6>
                        <p class="p-3 bg-light rounded fst-italic text-muted mb-0">
                            "{{ $peminjaman->keperluan }}"
                        </p>
                    </div>

                    @if($peminjaman->status === 'pending')
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end pt-3 border-top">
                             <form action="{{ route($routePrefix . '.peminjaman.reject', $peminjaman) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-light text-danger fw-bold px-4 py-2" onclick="return confirm('Tolak?')">
                                    <i class="bi bi-x-circle me-2"></i> Tolak Request
                                </button>
                            </form>
                            <form action="{{ route($routePrefix . '.peminjaman.approve', $peminjaman) }}" method="POST" class="approve-form">
                                @csrf
                                <button type="submit" class="btn btn-success fw-bold px-4 py-2 shadow-sm">
                                    <i class="bi bi-check-lg me-2"></i> Setujui Peminjaman
                                </button>
                            </form>
                        </div>
                    @elseif($peminjaman->status === 'approved')
                        <div class="d-grid pt-3 border-top">
                            <a href="{{ route($routePrefix . '.pengembalian.create', $peminjaman) }}" class="btn btn-warning fw-bold py-3 shadow-sm">
                                <i class="bi bi-arrow-return-left me-2"></i> Proses Pengembalian Barang
                            </a>
                        </div>
                    @elseif($peminjaman->status === 'returned' && $peminjaman->pengembalian)
                         <div class="d-grid pt-3 border-top">
                            <div class="alert alert-info d-flex justify-content-between align-items-center mb-0">
                                <div>
                                    <strong><i class="bi bi-check-circle-fill me-2"></i>Peminjaman Selesai</strong>
                                    <span class="d-block small mt-1">Lihat detail denda dan pembayaran di menu Pengembalian.</span>
                                </div>
                                <a href="{{ route($routePrefix . '.pengembalian.show', $peminjaman->pengembalian) }}" class="btn btn-primary btn-sm fw-bold">
                                    Lihat Detail Pengembalian
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
