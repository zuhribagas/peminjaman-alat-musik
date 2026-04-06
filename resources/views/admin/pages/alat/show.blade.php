@extends('layouts.app')

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

@section('page-title', 'Detail Alat')

@php
    $routePrefix = auth()->user()->role === 'petugas' ? 'petugas' : 'admin';
@endphp

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route($routePrefix . '.alat.index') }}" class="btn btn-light rounded-circle shadow-sm" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h3 class="fw-bold mb-0">Detail Produk</h3>
            </div>

            <div class="row g-4">
                <div class="col-md-5">
                    <div class="card-premium h-100 p-2">
                        <div class="rounded-4 overflow-hidden position-relative bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                            @if($alat->foto)
                                <img src="{{ asset('storage/' . $alat->foto) }}" alt="{{ $alat->nama_alat }}" class="w-100 h-100 object-fit-cover">
                            @else
                                <i class="bi bi-image text-muted" style="font-size: 5rem; opacity: 0.3;"></i>
                            @endif
                            
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-white text-dark shadow-sm px-3 py-2 fw-bold border">
                                    {{ $alat->kategori->nama_kategori }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="card-premium h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h2 class="fw-bold mb-1">{{ $alat->nama_alat }}</h2>
                                    <p class="text-muted mb-0">Kode: {{ $alat->kode_alat }}</p>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-light" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                        <li><a class="dropdown-item" href="{{ route($routePrefix . '.alat.edit', $alat) }}">Edit Data</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route($routePrefix . '.alat.destroy', $alat) }}" method="POST" class="delete-form">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">Hapus</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-3 mb-4">
                                <span class="fs-4 fw-bold text-primary">Rp {{ number_format($alat->harga_sewa_per_hari, 0, ',', '.') }}</span>
                                <span class="text-muted">/ hari</span>
                            </div>

                            <hr class="border-light mb-4">

                            <div class="row g-4 mb-4">
                                <div class="col-6">
                                    <div class="p-3 bg-light rounded-3">
                                        <div class="small text-muted text-uppercase mb-1">Stok Tersedia</div>
                                        <div class="fs-5 fw-bold {{ $alat->stok_tersedia > 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $alat->stok_tersedia }} / {{ $alat->stok_total }} Unit
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 bg-light rounded-3">
                                        <div class="small text-muted text-uppercase mb-1">Kondisi</div>
                                        <div class="fs-5 fw-bold">
                                            @if($alat->kondisi == 'baik') <span class="text-success">Sangat Baik</span>
                                            @else <span class="text-warning">Perlu Perbaikan</span> @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="fw-bold">Deskripsi</h6>
                                <p class="text-muted" style="line-height: 1.6;">
                                    {{ $alat->deskripsi ?? 'Tidak ada deskripsi untuk alat ini.' }}
                                </p>
                            </div>

                            <div class="alert alert-light border d-flex gap-3 align-items-center">
                                <i class="bi bi-info-circle text-info fs-4"></i>
                                <div>
                                    <div class="small fw-bold">Info Denda</div>
                                    <div class="small text-muted">Keterlambatan dikenakan denda Rp {{ number_format($alat->denda_keterlambatan_per_hari, 0) }}/hari</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
