@extends('layouts.guest')

@section('content')
<div class="auth-split-screen">
    <div class="auth-left">
        <div class="auth-card">
            <div class="mb-5">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="bg-indigo-soft p-2 rounded">
                        <i class="bi bi-box-seam-fill text-primary fs-4"></i>
                    </div>
                    <span class="fw-bold fs-4 text-dark">gentpng.id</span>
                </div>
                <h2 class="fw-bold mb-2">Buat Akun Baru</h2>
                <p class="text-muted">Mulai perjalanan memancing Anda hari ini</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <label class="form-label fw-semibold small text-muted text-uppercase">Informasi Pribadi</label>
                    <div class="mb-3">
                        <input type="text" class="form-control form-control-premium @error('name') is-invalid @enderror" 
                               name="name" value="{{ old('name') }}" placeholder="Nama Lengkap" required autofocus>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control form-control-premium @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" placeholder="Email Address" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold small text-muted text-uppercase">Keamanan</label>
                    <div class="mb-3">
                        <input type="password" class="form-control form-control-premium @error('password') is-invalid @enderror" 
                               name="password" placeholder="Password (Min. 8 karakter)" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control form-control-premium" 
                               name="password_confirmation" placeholder="Ulangi Password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-premium w-100 py-3 mb-4">
                    Daftar Sekarang
                </button>

                <p class="text-center text-muted">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Masuk</a>
                </p>
            </form>
        </div>
    </div>

    <div class="auth-right d-none d-lg-flex">
        <div class="text-center position-relative" style="z-index: 2;">
            <img src="https://cdni.iconscout.com/illustration/premium/thumb/fisherman-catching-fish-2974950-2477383.png" 
                 alt="Fishing Illustration" class="img-fluid mb-4" style="max-width: 400px; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.2));">
            <h2 class="fw-bold mb-3">Sewa Alat Pancing Terbaik</h2>
            <p class="lead opacity-75">Akses ratusan alat pancing premium dengan harga terjangkau.<br>Mudah, Cepat, dan Terpercaya.</p>
        </div>
    </div>
</div>
@endsection
