@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('sidebar')
    @include('admin.components.sidebar')
@endsection

@section('navbar')
    @include('layouts.navigation')
@endsection

@section('page-title', 'Edit Kategori')

@section('content')
<div class="container-fluid px-6 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.kategori.index') }}">Kategori</a></li>
                    <li class="breadcrumb-item active">Edit Kategori</li>
                </ol>
            </nav>

            <div class="card card-lg">
                <div class="card-header border-bottom-0">
                    <h4 class="mb-0">Form Edit Kategori</h4>
                    <p class="text-muted mb-0 mt-2">Perbarui informasi kategori</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kategori.update', $kategori) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="nama_kategori" class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nama_kategori') is-invalid @enderror" 
                                   id="nama_kategori" 
                                   name="nama_kategori" 
                                   value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                                   placeholder="Contoh: Elektronik, Olahraga, dll"
                                   required>
                            @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Masukkan nama kategori yang jelas dan deskriptif</small>
                        </div>

                        <div class="alert alert-info d-flex align-items-center mb-4">
                            <i class="bi bi-info-circle me-2"></i>
                            <div>
                                Kategori ini memiliki <strong>{{ $kategori->alat_count }}</strong> alat terkait
                            </div>
                        </div>

                        <div class="d-flex gap-2 justify-content-end border-top pt-4">
                            <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Update Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
