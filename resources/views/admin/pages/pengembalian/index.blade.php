@extends('layouts.app')

@section('title', 'Daftar Pengembalian')

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

@section('page-title', 'Daftar Pengembalian')

@php
    $routePrefix = auth()->user()->role === 'petugas' ? 'petugas' : 'admin';
@endphp

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Riwayat Pengembalian Alat</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Peminjaman</th>
                        <th>Peminjam</th>
                        <th>Alat</th>
                        <th>Tanggal Kembali</th>
                        <th>Kondisi</th>
                        <th>Denda</th>
                        <th>Diproses oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengembalians as $p)
                        <tr>
                            <td>#{{ $p->id }}</td>
                            <td>#{{ $p->peminjaman_id }}</td>
                            <td>{{ $p->peminjaman->user->name }}</td>
                            <td>{{ $p->peminjaman->alat->nama_alat }}</td>
                            <td>{{ $p->tanggal_kembali_aktual->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $p->kondisi_badge }}">
                                    {{ ucfirst(str_replace('_', ' ', $p->kondisi_alat)) }}
                                </span>
                            </td>
                            <td>
                                <strong class="{{ $p->denda > 0 ? 'text-danger' : 'text-success' }}">
                                    {{ $p->denda_formatted }}
                                </strong>
                            </td>
                            <td>{{ $p->processor->name }}</td>
                            <td>
                                <a href="{{ route($routePrefix . '.pengembalian.show', $p) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Belum ada pengembalian</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $pengembalians->links() }}
    </div>
</div>
@endsection
