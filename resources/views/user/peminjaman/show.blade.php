@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('sidebar')
    @include('user.components.sidebar')
@endsection

@section('navbar')
    @include('layouts.navigation')
@endsection

@section('page-title', 'Detail Peminjaman #' . $peminjaman->id)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Peminjaman</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Status:</div>
                    <div class="col-md-8">
                        <span class="badge bg-{{ $peminjaman->status_badge }} fs-6">{{ $peminjaman->status_text }}</span>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Alat:</div>
                    <div class="col-md-8">
                        {{ $peminjaman->alat->nama_alat }}<br>
                        <small class="text-muted">{{ $peminjaman->alat->kategori->nama_kategori }}</small>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Jumlah:</div>
                    <div class="col-md-8">{{ $peminjaman->jumlah }} unit</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Tanggal Pinjam:</div>
                    <div class="col-md-8">{{ $peminjaman->tanggal_pinjam->format('d F Y') }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Tanggal Kembali:</div>
                    <div class="col-md-8">{{ $peminjaman->tanggal_kembali_rencana->format('d F Y') }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Keperluan:</div>
                    <div class="col-md-8">{{ $peminjaman->keperluan }}</div>
                </div>
                
                @if($peminjaman->approved_by)
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Disetujui oleh:</div>
                    <div class="col-md-8">
                        {{ $peminjaman->approver->name }}<br>
                        <small class="text-muted">{{ $peminjaman->approved_at->format('d F Y H:i') }}</small>
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        @if($peminjaman->pengembalian)
        <div class="card mt-3">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Informasi Pengembalian</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Tanggal Dikembalikan:</div>
                    <div class="col-md-8">{{ $peminjaman->pengembalian->tanggal_kembali_aktual->format('d F Y') }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Kondisi Alat:</div>
                    <div class="col-md-8">
                        <span class="badge bg-{{ $peminjaman->pengembalian->kondisi_badge }}">
                            {{ ucfirst(str_replace('_', ' ', $peminjaman->pengembalian->kondisi_alat)) }}
                        </span>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Denda:</div>
                    <div class="col-md-8">
                        <strong class="text-danger fs-5">{{ $peminjaman->pengembalian->denda_formatted }}</strong>
                    </div>
                </div>
                
                @if($peminjaman->pengembalian->keterangan)
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Keterangan:</div>
                    <div class="col-md-8">{{ $peminjaman->pengembalian->keterangan }}</div>
                </div>
                @endif
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Diproses oleh:</div>
                    <div class="col-md-8">{{ $peminjaman->pengembalian->processor->name }}</div>
                </div>
            </div>
        </div>
        @endif
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Timeline</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Diajukan</strong><br>
                    <small>{{ $peminjaman->created_at->format('d F Y H:i') }}</small>
                </div>
                
                @if($peminjaman->approved_at)
                <div class="mb-3">
                    <strong>{{ $peminjaman->status === 'approved' || $peminjaman->status === 'returned' ? 'Disetujui' : 'Ditolak' }}</strong><br>
                    <small>{{ $peminjaman->approved_at->format('d F Y H:i') }}</small>
                </div>
                @endif
                
                @if($peminjaman->pengembalian)
                <div class="mb-3">
                    <strong>Dikembalikan</strong><br>
                    <small>{{ $peminjaman->pengembalian->created_at->format('d F Y H:i') }}</small>
                </div>
                @endif
            </div>
        </div>
        
        <div class="mt-3">
            <a href="{{ route('user.peminjaman.index') }}" class="btn btn-secondary w-100">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
