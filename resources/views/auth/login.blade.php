@extends('layouts.guest')

@section('content')
<style>
/* ===== BACKGROUND MUSIC CAMPUS THEME ===== */
.auth-split-screen {
    min-height: 100vh;
    display: flex;
}

.auth-left {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0f172a, #1e293b, #312e81);
    background-size: 200% 200%;
    animation: gradientMove 10s ease infinite;
    position: relative;
    overflow: hidden;
}

/* Floating music notes */
.auth-left::before {
    content: "♪ ♫ ♬ ♩";
    position: absolute;
    font-size: 120px;
    color: rgba(255,255,255,0.05);
    top: 10%;
    left: 5%;
    animation: float 8s ease-in-out infinite;
}

.auth-left::after {
    content: "♫ ♬";
    position: absolute;
    font-size: 100px;
    color: rgba(255,255,255,0.05);
    bottom: 10%;
    right: 10%;
    animation: float 10s ease-in-out infinite;
}

/* Gradient animation */
@keyframes gradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Floating animation */
@keyframes float {
    0%,100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

/* Fade In Animation */
.auth-card {
    animation: fadeInUp 1s ease forwards;
    opacity: 0;
    transform: translateY(20px);
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Glassmorphism Card */
.auth-card {
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(15px);
    padding: 40px;
    border-radius: 20px;
    width: 100%;
    max-width: 420px;
    color: white;
    box-shadow: 0 10px 40px rgba(0,0,0,0.4);
}

/* Form Styling */
.form-control-premium {
    background: rgba(255,255,255,0.1);
    border: none;
    color: white;
}

.form-control-premium::placeholder {
    color: rgba(255,255,255,0.6);
}

.form-control-premium:focus {
    background: rgba(255,255,255,0.15);
    color: white;
    box-shadow: 0 0 0 2px #6366f1;
}

/* Button */
.btn-premium {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border: none;
    color: white;
    font-weight: 600;
    transition: 0.3s ease;
}

.btn-premium:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(99,102,241,0.4);
}

/* Right Side Campus Info */
.auth-right {
    flex: 1;
    background: #f8fafc;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px;
}
</style>

<div class="auth-split-screen">

    <!-- LEFT LOGIN -->
    <div class="auth-left">
        <div class="auth-card text-white">

            <div class="mb-4 text-center">
                <i class="bi bi-mortarboard-fill fs-2 mb-3"></i>
                <h3 class="fw-bold">Sistem Peminjaman Alat Musik</h3>
                <p class="opacity-75 small">Platform Inventaris Musik Kampus</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           class="form-control form-control-premium @error('email') is-invalid @enderror"
                           placeholder="Email Kampus"
                           required autofocus>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <input type="password"
                           name="password"
                           class="form-control form-control-premium @error('password') is-invalid @enderror"
                           placeholder="Password"
                           required>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4 small">
                    <div class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input">
                        <label class="form-check-label text-white-50">
                            Ingat Saya
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-decoration-none text-info">
                            Lupa Password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn btn-premium w-100 py-3">
                    Masuk ke Sistem
                </button>

                <p class="text-center mt-4 small opacity-75">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-info text-decoration-none fw-bold">
                        Daftar
                    </a>
                </p>
            </form>
        </div>
    </div>

    <!-- RIGHT INFO -->
    <div class="auth-right d-none d-lg-flex">
        <div class="text-center">
            <h2 class="fw-bold mb-3">Kelola Inventaris Musik Kampus 🎼</h2>
            <p class="text-muted mb-4">
                Sistem digital untuk peminjaman gitar, piano, drum,<br>
                dan alat musik lainnya secara efisien & transparan.
            </p>
            <i class="bi bi-music-note-list" style="font-size: 80px; color:#6366f1;"></i>
        </div>
    </div>

</div>
@endsection