@extends('layouts.app')

@section('title', 'Tambah Kategori')

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

@section('page-title', 'Tambah Kategori')

@php
    $routePrefix = auth()->user()->role === 'petugas' ? 'petugas' : 'admin';
@endphp

@section('content')
<div class="container-fluid px-6 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route($routePrefix . '.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route($routePrefix . '.kategori.index') }}">Kategori</a></li>
                    <li class="breadcrumb-item active">Tambah Kategori</li>
                </ol>
            </nav>

            <div class="card card-lg">
                <div class="card-header border-bottom-0">
                    <h4 class="mb-0">Form Tambah Kategori</h4>
                    <p class="text-muted mb-0 mt-2">Isi form di bawah untuk menambah kategori baru</p>
                </div>
                <div class="card-body">
                    <form action="{{ route($routePrefix . '.kategori.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="nama_kategori" class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nama_kategori') is-invalid @enderror" 
                                   id="nama_kategori" 
                                   name="nama_kategori" 
                                   value="{{ old('nama_kategori') }}"
                                   placeholder="Contoh: Elektronik, Olahraga, dll"
                                   required>
                            @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Masukkan nama kategori yang jelas dan deskriptif</small>
                        </div>

                        <div class="d-flex gap-2 justify-content-end border-top pt-4">
                            <a href="{{ route($routePrefix . '.kategori.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Simpan Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
