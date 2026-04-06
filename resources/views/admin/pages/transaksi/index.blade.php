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

@section('page-title', 'Transaksi Peminjaman')

@php
    $routePrefix = auth()->user()->role === 'petugas' ? 'petugas' : 'admin';
@endphp

@section('content')
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi bi-receipt display-4 text-primary"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Total Transaksi</h6>
                        <h3 class="mb-0">{{ $totalTransaksi }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi bi-cash-stack display-4 text-success"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Total Pendapatan</h6>
                        <h3 class="mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi bi-clock-history display-4 text-warning"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Menunggu Bayar</h6>
                        <h3 class="mb-0">{{ $menungguPembayaran }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">Daftar Transaksi</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label">Filter User</label>
                <select name="user_id" class="form-select">
                    <option value="">Semua User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Status Pembayaran</label>
                <select name="payment_status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Sudah Bayar</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary d-block w-100">Filter</button>
            </div>
        </form>

        @if($transaksi->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Alat</th>
                            <th>Tgl Pinjam</th>
                            <th>Durasi</th>
                            <th>Total Biaya</th>
                            <th>Pembayaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi as $item)
                        <tr>
                            <td><strong>#{{ $item->id }}</strong></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar avatar-sm rounded-circle bg-primary text-white">
                                        {{ strtoupper(substr($item->user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $item->user->name }}</div>
                                        <small class="text-muted">{{ $item->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>{{ $item->alat->nama_alat }}</div>
                                <small class="text-muted">{{ $item->alat->kategori->nama_kategori }}</small>
                            </td>
                            <td>{{ $item->tanggal_pinjam->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-info">{{ $item->durasi_hari ?? 0 }} Hari</span>
                            </td>
                            <td>
                                <strong class="text-success">Rp {{ number_format($item->total_biaya ?? 0, 0, ',', '.') }}</strong>
                            </td>
                            <td>
                                @if($item->payment_status === 'paid')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Lunas
                                    </span>
                                    @if($item->paid_at)
                                        <br><small class="text-muted">{{ $item->paid_at->format('d/m/Y H:i') }}</small>
                                    @endif
                                @else
                                    <span class="badge bg-warning">
                                        <i class="bi bi-clock"></i> Belum Bayar
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $item->status_badge }}">
                                    {{ $item->status_text }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route($routePrefix . '.peminjaman.show', $item) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $transaksi->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <p class="text-muted mt-3">Belum ada transaksi</p>
            </div>
        @endif
    </div>
</div>
@endsection
