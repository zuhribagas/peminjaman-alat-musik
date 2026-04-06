@extends('layouts.app')

@section('title', 'Edit Alat')

@section('sidebar')
    @include('admin.components.sidebar')
@endsection

@section('navbar')
    @include('layouts.navigation')
@endsection

@section('page-title', 'Edit Alat')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.alat.update', $alat) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="kode_alat" class="form-label">Kode Alat *</label>
                    <input type="text" class="form-control @error('kode_alat') is-invalid @enderror" 
                           id="kode_alat" name="kode_alat" value="{{ old('kode_alat', $alat->kode_alat) }}" required>
                    @error('kode_alat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="kategori_id" class="form-label">Kategori *</label>
                    <select class="form-select @error('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id" required>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id', $alat->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="nama_alat" class="form-label">Nama Alat *</label>
                <input type="text" class="form-control @error('nama_alat') is-invalid @enderror" 
                       id="nama_alat" name="nama_alat" value="{{ old('nama_alat', $alat->nama_alat) }}" required>
                @error('nama_alat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                          id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $alat->deskripsi) }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="harga_sewa_per_hari" class="form-label">Harga Sewa Per Hari (Rp) *</label>
                <input type="number" min="0" step="1000" class="form-control @error('harga_sewa_per_hari') is-invalid @enderror" 
                       id="harga_sewa_per_hari" name="harga_sewa_per_hari" value="{{ old('harga_sewa_per_hari', $alat->harga_sewa_per_hari) }}" required>
                <small class="text-muted">Contoh: 25000 untuk Rp 25,000/hari</small>
                @error('harga_sewa_per_hari')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="stok_total" class="form-label">Stok Total *</label>
                    <input type="number" min="0" class="form-control @error('stok_total') is-invalid @enderror" 
                           id="stok_total" name="stok_total" value="{{ old('stok_total', $alat->stok_total) }}" required>
                    @error('stok_total')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="stok_tersedia" class="form-label">Stok Tersedia *</label>
                    <input type="number" min="0" class="form-control @error('stok_tersedia') is-invalid @enderror" 
                           id="stok_tersedia" name="stok_tersedia" value="{{ old('stok_tersedia', $alat->stok_tersedia) }}" required>
                    @error('stok_tersedia')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="kondisi" class="form-label">Kondisi *</label>
                    <select class="form-select @error('kondisi') is-invalid @enderror" id="kondisi" name="kondisi" required>
                        <option value="baik" {{ old('kondisi', $alat->kondisi) == 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="rusak_ringan" {{ old('kondisi', $alat->kondisi) == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="rusak_berat" {{ old('kondisi', $alat->kondisi) == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                    @error('kondisi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                @if($alat->foto)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $alat->foto) }}" alt="Foto Alat" style="max-width: 200px;" class="img-thumbnail">
                    </div>
                @endif
                <label for="foto" class="form-label">Foto (Kosongkan jika tidak ingin mengubah)</label>
                <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                       id="foto" name="foto" accept="image/*">
                <small class="text-muted">Max: 2MB</small>
                @error('foto')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.alat.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
