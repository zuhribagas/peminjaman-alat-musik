@extends('layouts.app')

@section('title', 'Detail Pengembalian')

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

@section('page-title', 'Detail Pengembalian #' . $pengembalian->id)

@php
    $routePrefix = auth()->user()->role === 'petugas' ? 'petugas' : 'admin';
@endphp

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Informasi Pengembalian</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">ID Pengembalian:</div>
                    <div class="col-md-8">#{{ $pengembalian->id }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">ID Peminjaman:</div>
                    <div class="col-md-8">
                        <a href="{{ route($routePrefix . '.peminjaman.show', $pengembalian->peminjaman) }}" class="text-decoration-none">
                            #{{ $pengembalian->peminjaman_id }}
                        </a>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Tanggal Kembali Rencana:</div>
                    <div class="col-md-8">{{ $pengembalian->peminjaman->tanggal_kembali_rencana->format('d F Y') }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Tanggal Kembali Aktual:</div>
                    <div class="col-md-8">
                        <strong>{{ $pengembalian->tanggal_kembali_aktual->format('d F Y') }}</strong>
                        @php
                            $daysLate = $pengembalian->tanggal_kembali_aktual->gt($pengembalian->peminjaman->tanggal_kembali_rencana) 
                                ? $pengembalian->tanggal_kembali_aktual->diffInDays($pengembalian->peminjaman->tanggal_kembali_rencana) 
                                : 0;
                        @endphp
                        @if($daysLate > 0)
                            <span class="badge bg-danger">Terlambat {{ $daysLate }} hari</span>
                        @else
                            <span class="badge bg-success">Tepat Waktu</span>
                        @endif
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Kondisi Alat:</div>
                    <div class="col-md-8">
                        <span class="badge bg-{{ $pengembalian->kondisi_badge }} fs-6">
                            {{ ucfirst(str_replace('_', ' ', $pengembalian->kondisi_alat)) }}
                        </span>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Rincian Biaya:</div>
                    <div class="col-md-8">
                         <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Sewa Alat
                                <span>Rp {{ number_format($pengembalian->peminjaman->total_biaya, 0, ',', '.') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center list-group-item-light">
                                Denda
                                <span class="{{ $pengembalian->denda > 0 ? 'text-danger fw-bold' : 'text-success' }}">
                                    Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center active">
                                <strong>TOTAL</strong>
                                <strong>Rp {{ number_format($pengembalian->peminjaman->total_biaya + $pengembalian->denda, 0, ',', '.') }}</strong>
                            </li>
                        </ul>
                        
                        <div class="mt-3">
                            @php
                                $isLunas = $pengembalian->status_denda === 'paid' && $pengembalian->peminjaman->payment_status === 'paid';
                            @endphp
                            
                            @if($isLunas)
                                <div class="alert alert-success d-flex align-items-center mb-0">
                                    <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                                    <div>
                                        <strong>LUNAS</strong><br>
                                        Semua tagihan telah dibayar.
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning d-flex align-items-center justify-content-between mb-0">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                                        <div>
                                            <strong>BELUM LUNAS</strong><br>
                                            Harap tagih pembayaran ke user.
                                        </div>
                                    </div>
                                    <form action="{{ route($routePrefix . '.pengembalian.markPaid', $pengembalian) }}" method="POST" class="payment-form">
                                        @csrf
                                        <button type="submit" class="btn btn-primary fw-bold">
                                            <i class="bi bi-wallet2 me-2"></i> Terima Pembayaran
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                @if($pengembalian->keterangan)
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Keterangan:</div>
                    <div class="col-md-8">{{ $pengembalian->keterangan }}</div>
                </div>
                @endif
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Diproses oleh:</div>
                    <div class="col-md-8">
                        {{ $pengembalian->processor->name }}<br>
                        <small class="text-muted">{{ $pengembalian->created_at->format('d F Y H:i') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Info Peminjaman</h5>
            </div>
            <div class="card-body">
                <p><strong>Peminjam:</strong><br>{{ $pengembalian->peminjaman->user->name }}</p>
                <p><strong>Alat:</strong><br>{{ $pengembalian->peminjaman->alat->nama_alat }}</p>
                <p><strong>Kategori:</strong><br>{{ $pengembalian->peminjaman->alat->kategori->nama_kategori }}</p>
                <p><strong>Jumlah:</strong><br>{{ $pengembalian->peminjaman->jumlah }} unit</p>
                <p><strong>Keperluan:</strong><br>{{ $pengembalian->peminjaman->keperluan }}</p>
            </div>
        </div>
        
        <div class="mt-3">
            <a href="{{ route($routePrefix . '.pengembalian.index') }}" class="btn btn-secondary w-100">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
