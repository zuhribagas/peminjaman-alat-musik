@extends('layouts.app')

@section('title', 'Kelola Kategori')

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
            <h2 class="fw-bold text-dark mb-1">Kategori Alat</h2>
            <p class="text-muted mb-0">Kelola kategori untuk pengelompokan inventaris</p>
        </div>
        <a href="{{ route($routePrefix . '.kategori.create') }}" class="btn btn-premium d-flex align-items-center">
            <i class="bi bi-plus-lg me-2"></i> Tambah Kategori
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-premium">
                <div class="table-responsive">
                    <table class="table table-modern align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4" style="width: 5%;">No</th>
                                <th>Nama Kategori</th>
                                <th style="width: 20%;">Jumlah Alat</th>
                                <th class="text-end pe-4" style="width: 20%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kategoris as $index => $kategori)
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">{{ $kategoris->firstItem() + $index }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-circle bg-primary-subtle text-primary border" style="width: 40px; height: 40px;">
                                                <i class="bi bi-tag-fill"></i>
                                            </div>
                                            <span class="fw-bold text-dark">{{ $kategori->nama_kategori }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-info fs-6">
                                            {{ $kategori->alat_count }} Item
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route($routePrefix . '.kategori.edit', $kategori) }}" class="btn btn-sm btn-light border" title="Edit">
                                                <i class="bi bi-pencil me-1"></i> Edit
                                            </a>
                                            <form action="{{ route($routePrefix . '.kategori.destroy', $kategori) }}" method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light border text-danger" title="Hapus">
                                                    <i class="bi bi-trash me-1"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="bi bi-tags text-muted mb-3" style="font-size: 3rem; opacity: 0.5;"></i>
                                            <p class="text-muted mb-0">Belum ada kategori ditambahkan</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($kategoris->hasPages())
                    <div class="card-footer bg-white border-top py-3">
                        {{ $kategoris->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
