@extends('layouts.app')

@section('title', 'Proses Pengembalian')

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

@section('page-title', 'Proses Pengembalian')

@php
    $routePrefix = auth()->user()->role === 'petugas' ? 'petugas' : 'admin';
@endphp

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Form Pengembalian Alat</h5>
            </div>
            <div class="card-body">
                <form action="{{ route($routePrefix . '.pengembalian.store', $peminjaman) }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="tanggal_kembali_aktual" class="form-label">Tanggal Kembali Aktual *</label>
                        <input type="date" class="form-control @error('tanggal_kembali_aktual') is-invalid @enderror" 
                               id="tanggal_kembali_aktual" name="tanggal_kembali_aktual" 
                               value="{{ old('tanggal_kembali_aktual', date('Y-m-d')) }}" 
                               max="{{ date('Y-m-d') }}" required>
                        @error('tanggal_kembali_aktual')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            Tanggal seharusnya kembali: <strong>{{ $peminjaman->tanggal_kembali_rencana->format('d/m/Y') }}</strong>
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="kondisi_alat" class="form-label">Kondisi Alat Saat Dikembalikan *</label>
                        <select class="form-select @error('kondisi_alat') is-invalid @enderror" 
                                id="kondisi_alat" name="kondisi_alat" required>
                            <option value="">-- Pilih Kondisi --</option>
                            <option value="baik" {{ old('kondisi_alat') == 'baik' ? 'selected' : '' }}>Baik</option>
                            <option value="rusak_ringan" {{ old('kondisi_alat') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="rusak_berat" {{ old('kondisi_alat') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                        </select>
                        @error('kondisi_alat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                  id="keterangan" name="keterangan" rows="3" 
                                  placeholder="Catatan kondisi alat atau keterangan lainnya...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="alert alert-info">
                        <h6><i class="bi bi-info-circle"></i> Informasi Denda:</h6>
                        <ul class="mb-0">
                            <li>Denda keterlambatan: <strong>Rp 5.000 per hari</strong></li>
                            <li>Denda akan dihitung otomatis berdasarkan tanggal kembali aktual</li>
                            <li>Tidak ada denda jika dikembalikan tepat waktu atau lebih awal</li>
                        </ul>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Proses Pengembalian
                        </button>
                        <a href="{{ route($routePrefix . '.peminjaman.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Info Peminjaman</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <th>ID:</th>
                        <td>#{{ $peminjaman->id }}</td>
                    </tr>
                    <tr>
                        <th>Peminjam:</th>
                        <td>{{ $peminjaman->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Alat:</th>
                        <td>{{ $peminjaman->alat->nama_alat }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah:</th>
                        <td>{{ $peminjaman->jumlah }} unit</td>
                    </tr>
                    <tr>
                        <th>Tgl Pinjam:</th>
                        <td>{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Tgl Kembali:</th>
                        <td>{{ $peminjaman->tanggal_kembali_rencana->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td><span class="badge bg-{{ $peminjaman->status_badge }}">{{ $peminjaman->status_text }}</span></td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header bg-warning">
                <h5 class="mb-0">Perhitungan Denda</h5>
            </div>
            <div class="card-body">
                <p class="small mb-2">Tanggal rencana: <strong>{{ $peminjaman->tanggal_kembali_rencana->format('d/m/Y') }}</strong></p>
                <p class="small mb-2">Jika kembali hari ini:</p>
                @php
                    $today = \Carbon\Carbon::today();
                    $rencana = $peminjaman->tanggal_kembali_rencana;
                    $daysLate = $today->gt($rencana) ? $today->diffInDays($rencana) : 0;
                    $estimatedDenda = $daysLate * 5000;
                @endphp
                
                @if($daysLate > 0)
                    <div class="alert alert-danger mb-0">
                        <strong>Terlambat {{ $daysLate }} hari</strong><br>
                        Denda: <strong>Rp {{ number_format($estimatedDenda, 0, ',', '.') }}</strong>
                    </div>
                @else
                    <div class="alert alert-success mb-0">
                        <strong>Tepat Waktu</strong><br>
                        Denda: <strong>Rp 0</strong>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
