@extends('layouts.app')

@section('title', 'Manajemen User')

@section('sidebar')
    @include('admin.components.sidebar')
@endsection

@section('navbar')
    @include('layouts.navigation')
@endsection

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-1">Manajemen User</h2>
            <p class="text-muted mb-0">Kelola pengguna dan hak akses sistem</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-premium d-flex align-items-center">
            <i class="bi bi-plus-lg me-2"></i> Tambah User
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-premium">
                <div class="table-responsive">
                    <table class="table table-modern align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4" style="width: 5%;">No</th>
                                <th>Nama & Email</th>
                                <th style="width: 15%;">Role</th>
                                <th style="width: 15%;">Tanggal Registrasi</th>
                                <th class="text-end pe-4" style="width: 20%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $user)
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">{{ $users->firstItem() + $index }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-circle 
                                                @if($user->role === 'admin') bg-danger-subtle text-danger
                                                @elseif($user->role === 'petugas') bg-primary-subtle text-primary
                                                @else bg-success-subtle text-success
                                                @endif 
                                                border" style="width: 40px; height: 40px;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                                                <div class="text-muted small">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($user->role === 'admin')
                                            <span class="badge badge-soft-danger fs-6">
                                                <i class="bi bi-shield-fill-check me-1"></i> Admin
                                            </span>
                                        @elseif($user->role === 'petugas')
                                            <span class="badge badge-soft-primary fs-6">
                                                <i class="bi bi-person-badge me-1"></i> Petugas
                                            </span>
                                        @else
                                            <span class="badge badge-soft-success fs-6">
                                                <i class="bi bi-person me-1"></i> User
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-muted small">{{ $user->created_at->format('d M Y') }}</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-light border" title="Edit">
                                                <i class="bi bi-pencil me-1"></i> Edit
                                            </a>
                                            @if($user->id !== auth()->id())
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-light border text-danger" title="Hapus">
                                                        <i class="bi bi-trash me-1"></i> Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="bi bi-people text-muted mb-3" style="font-size: 3rem; opacity: 0.5;"></i>
                                            <p class="text-muted mb-0">Belum ada user ditambahkan</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($users->hasPages())
                    <div class="card-footer bg-white border-top py-3">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
                this.submit();
            }
        });
    });
</script>
@endpush
@endsection
