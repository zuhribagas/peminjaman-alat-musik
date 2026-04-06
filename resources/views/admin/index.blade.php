@extends('layouts.app')

@section('title', 'Peminjaman Alat Musik')

@section('sidebar')
    @include('admin.components.sidebar')
@endsection

@section('navbar')
    @include('layouts.navigation')
@endsection

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Manajemen Peminjaman Alat Musik</h2>
            <p class="text-muted mb-0">Kelola semua data peminjaman alat musik di sini.</p>
        </div>
        <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-premium">
            <i class="bi bi-plus-lg me-2"></i> Tambah Peminjaman
        </a>
    </div>

    {{-- Filter --}}
    <div class="card-premium mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.peminjaman.index') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="form-control" placeholder="Cari nama peminjam / alat...">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="tanggal" value="{{ request('tanggal') }}" 
                               class="form-control">
                    </div>
                    <div class="col-md-2 d-grid">
                        <button class="btn btn-outline-primary">
                            <i class="bi bi-search me-1"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card-premium">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Peminjaman</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-modern align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Peminjam</th>
                        <th>Alat Musik</th>
                        <th>Tanggal Pinjam</th>
                        <th>Durasi</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $index => $p)
                        <tr>
                            <td>{{ $peminjaman->firstItem() + $index }}</td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3 bg-primary text-white rounded-circle 
                                                d-flex align-items-center justify-content-center"
                                         style="width:35px;height:35px;font-size:0.8rem;">
                                        {{ strtoupper(substr($p->user->name,0,1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $p->user->name }}</div>
                                        <div class="small text-muted">{{ $p->user->email }}</div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="fw-medium">{{ $p->alat->nama_alat }}</span>
                                <div class="small text-muted">
                                    Kategori: {{ $p->alat->kategori->nama_kategori ?? '-' }}
                                </div>
                            </td>

                            <td>
                                {{ $p->tanggal_pinjam->format('d M Y') }}
                                <div class="small text-muted">
                                    s/d {{ $p->tanggal_kembali_rencana->format('d M Y') }}
                                </div>
                            </td>

                            <td>
                                <span class="fw-bold text-primary">
                                    {{ $p->durasi_hari }} Hari
                                </span>
                            </td>

                            <td>
                                @if($p->status == 'pending')
                                    <span class="badge badge-soft-warning">Menunggu</span>
                                @elseif($p->status == 'approved')
                                    <span class="badge badge-soft-success">Disetujui</span>
                                @elseif($p->status == 'returned')
                                    <span class="badge badge-soft-info">Dikembalikan</span>
                                @else
                                    <span class="badge badge-soft-danger">Ditolak</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <a href="{{ route('admin.peminjaman.show', $p->id) }}" 
                                   class="btn btn-sm btn-light text-primary">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('admin.peminjaman.edit', $p->id) }}" 
                                   class="btn btn-sm btn-light text-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('admin.peminjaman.destroy', $p->id) }}" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-light text-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <p class="text-muted mb-0">Belum ada data peminjaman.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="card-footer">
            {{ $peminjaman->links() }}
        </div>
    </div>
</div>
@endsection