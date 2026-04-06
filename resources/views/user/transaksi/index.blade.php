@extends('layouts.app')

@section('sidebar')
    @include('user.components.sidebar')
@endsection

@section('navigation')
    @include('layouts.navigation')
@endsection

@section('page-title', 'Riwayat Transaksi Saya')

@section('content')
<div class="container-fluid px-6 py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">💰 Riwayat Transaksi Peminjaman</h5>
                </div>
                <div class="card-body">
                    @if($transaksi->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Alat Pancing</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Durasi</th>
                                        <th>Total Biaya</th>
                                        <th>Status</th>
                                        <th>Pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaksi as $item)
                                    <tr>
                                        <td><strong>#{{ $item->id }}</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-star-fill text-primary"></i>
                                                <div>
                                                    <div class="fw-semibold">{{ $item->alat->nama_alat }}</div>
                                                    <small class="text-muted">{{ $item->alat->kategori->nama_kategori }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $item->tanggal_pinjam->format('d/m/Y') }}</td>
                                        <td>{{ $item->tanggal_kembali_rencana->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $item->durasi_hari ?? 0 }} Hari</span>
                                        </td>
                                        <td>
                                            <strong class="text-success">Rp {{ number_format($item->total_biaya ?? 0, 0, ',', '.') }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $item->status_badge }}">
                                                {{ $item->status_text }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($item->payment_status === 'paid')
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle"></i> Lunas
                                                </span>
                                            @else
                                                <span class="badge bg-warning">
                                                    <i class="bi bi-clock"></i> Belum Bayar
                                                </span>
                                            @endif
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
                            <p class="text-muted mt-3">Belum ada transaksi peminjaman</p>
                            <a href="{{ route('user.peminjaman.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Ajukan Peminjaman
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-receipt display-4 text-primary mb-3"></i>
                    <h3 class="mb-1">{{ $totalTransaksi }}</h3>
                    <p class="text-muted mb-0">Total Transaksi</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-cash-stack display-4 text-success mb-3"></i>
                    <h3 class="mb-1">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</h3>
                    <p class="text-muted mb-0">Total Belanja</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-hourglass-split display-4 text-warning mb-3"></i>
                    <h3 class="mb-1">{{ $transaksiAktif }}</h3>
                    <p class="text-muted mb-0">Sedang Dipinjam</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
