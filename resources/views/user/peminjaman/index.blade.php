@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('sidebar')
    @include('user.components.sidebar')
@endsection

@section('navbar')
    @include('layouts.navigation')
@endsection

@section('page-title', 'Riwayat Peminjaman Saya')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Peminjaman</h5>
        <a href="{{ route('user.peminjaman.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i> Ajukan Peminjaman Baru
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Alat</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $p)
                        <tr>
                            <td>#{{ $p->id }}</td>
                            <td>
                                {{ $p->alat->nama_alat }}<br>
                                <small class="text-muted">{{ $p->alat->kategori->nama_kategori }}</small>
                            </td>
                            <td>{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                            <td>{{ $p->tanggal_kembali_rencana->format('d/m/Y') }}</td>
                            <td>{{ $p->jumlah }}</td>
                            <td>
                                <span class="badge bg-{{ $p->status_badge }}">{{ $p->status_text }}</span>
                            </td>
                            <td>
                                @if($p->pengembalian)
                                    <strong class="text-danger">{{ $p->pengembalian->denda_formatted }}</strong>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('user.peminjaman.show', $p) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada peminjaman</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $peminjamans->links() }}
    </div>
</div>
@endsection
