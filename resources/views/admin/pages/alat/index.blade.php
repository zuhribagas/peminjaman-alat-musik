@extends('layouts.app')

@section('title', 'Alat Pancing')

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
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-1">Inventaris Alat</h2>
            <p class="text-muted mb-0">Kelola {{ $alats->total() }} unit alat pancing dalam database</p>
        </div>
        <a href="{{ route($routePrefix . '.alat.create') }}" class="btn btn-premium d-flex align-items-center">
            <i class="bi bi-plus-lg me-2"></i> Tambah Alat
        </a>
    </div>

    <div class="row g-4">
        @forelse($alats as $alat)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="product-grid-card h-100 d-flex flex-column">
                    <div class="product-image-wrapper">
                        @if($alat->foto)
                            <img src="{{ asset('storage/' . $alat->foto) }}" class="w-100 h-100 object-fit-cover" alt="{{ $alat->nama_alat }}">
                        @else
                            <i class="bi bi-image text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                        @endif
                        
                        <div class="position-absolute top-0 end-0 p-3">
                            @if($alat->stok_tersedia > 0)
                                <span class="badge bg-success shadow-sm">Available</span>
                            @else
                                <span class="badge bg-danger shadow-sm">Out of Stock</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="p-4 flex-grow-1 d-flex flex-column">
                        <div class="mb-2">
                            <span class="badge badge-soft-primary">{{ $alat->kategori->nama_kategori }}</span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1 text-truncate" title="{{ $alat->nama_alat }}">{{ $alat->nama_alat }}</h5>
                        <p class="text-muted small mb-3">{{ $alat->kode_alat }}</p>
                        
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <span class="text-muted small d-block">Harga Sewa</span>
                                    <span class="fw-bold text-success">Rp {{ number_format($alat->harga_sewa_per_hari, 0, ',', '.') }}</span>
                                </div>
                                <div class="text-end">
                                    <span class="text-muted small d-block">Stok</span>
                                    <span class="fw-bold text-dark">{{ $alat->stok_tersedia }}/{{ $alat->stok_total }}</span>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2 pt-3 border-top border-light">
                                <a href="{{ route($routePrefix . '.alat.show', $alat) }}" class="btn btn-light btn-sm flex-grow-1 text-primary">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <a href="{{ route($routePrefix . '.alat.edit', $alat) }}" class="btn btn-light btn-sm text-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route($routePrefix . '.alat.destroy', $alat) }}" method="POST" class="d-inline delete-form">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-light btn-sm text-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-box-4085812-3385481.png" alt="Empty" style="width: 200px; opacity: 0.8;">
                <h4 class="mt-3 text-muted">Belum ada alat</h4>
                <a href="{{ route($routePrefix . '.alat.create') }}" class="btn btn-outline-primary mt-2">Tambah Alat Pertama</a>
            </div>
        @endforelse
    </div>

    <div class="mt-5 d-flex justify-content-end">
        {{ $alats->links() }}
    </div>
</div>
@endsection
