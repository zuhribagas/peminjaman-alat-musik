<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UKK Peminjaman Alat - Sistem Manajemen Inventaris</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
        body {
            font-family: 'Public Sans', sans-serif;
            background: linear-gradient(135deg, #f0fdf4 0%, #d1fae5 50%, #a7f3d0 100%);
            min-height: 100vh;
        }
        
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .logo-box {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #00a76f 0%, #00d68f 100%);
            border-radius: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 20px 60px rgba(0, 167, 111, 0.3);
        }
        
        .logo-box i {
            font-size: 2.5rem;
            color: white;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            color: #1c252e;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            color: #637381;
            font-weight: 500;
            margin-bottom: 2.5rem;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, #00a76f 0%, #00d68f 100%);
            border: none;
            padding: 1rem 2.5rem;
            font-size: 1.125rem;
            font-weight: 700;
            border-radius: 0.75rem;
            box-shadow: 0 8px 24px rgba(0, 167, 111, 0.3);
            transition: all 0.3s ease;
            color: white;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(0, 167, 111, 0.4);
        }
        
        .btn-outline-custom {
            border: 2px solid #00a76f;
            color: #00a76f;
            padding: 1rem 2.5rem;
            font-size: 1.125rem;
            font-weight: 700;
            border-radius: 0.75rem;
            background: white;
            transition: all 0.3s ease;
        }
        
        .btn-outline-custom:hover {
            background: #00a76f;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 167, 111, 0.2);
        }
        
        .feature-card {
            background: white;
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: 0 8px 24px rgba(145, 158, 171, 0.1);
            transition: all 0.3s ease;
            border: none;
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 48px rgba(145, 158, 171, 0.15);
        }
        
        .feature-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #f0fdf4 0%, #d1fae5 100%);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        
        .feature-icon i {
            font-size: 2rem;
            color: #00a76f;
        }
        
        .stats-box {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            text-align: center;
        }
        
        .stats-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: #00a76f;
        }
        
        .stats-label {
            color: #637381;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="logo-box">
                            <i class="bi bi-box-seam-fill"></i>
                        </div>
                        <h3 class="mb-0 fw-bold" style="color: #1c252e;">UKK Peminjaman</h3>
                    </div>
                    
                    <h1 class="hero-title">
                        Sistem Manajemen<br>
                        <span style="background: linear-gradient(135deg, #00a76f 0%, #00d68f 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Peminjaman Alat</span>
                    </h1>
                    
                    <p class="hero-subtitle">
                        Kelola inventaris dan peminjaman alat dengan mudah, cepat, dan efisien. 
                        Platform modern untuk optimasi workflow Anda.
                    </p>
                    
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('login') }}" class="btn btn-primary-custom">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-custom">
                            <i class="bi bi-person-plus me-2"></i>Daftar Gratis
                        </a>
                    </div>
                    
                    <div class="row mt-5 g-3">
                        <div class="col-4">
                            <div class="stats-box">
                                <div class="stats-number">{{ \App\Models\Alat::count() }}+</div>
                                <div class="stats-label">Alat</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stats-box">
                                <div class="stats-number">{{ \App\Models\User::count() }}+</div>
                                <div class="stats-label">Pengguna</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stats-box">
                                <div class="stats-number">{{ \App\Models\Peminjaman::count() }}+</div>
                                <div class="stats-label">Transaksi</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="bi bi-lightning-charge-fill"></i>
                                </div>
                                <h4 class="fw-bold mb-2">Proses Cepat</h4>
                                <p class="text-muted mb-0">
                                    Pengajuan dan approval peminjaman dalam hitungan detik. Sistem otomatis untuk efisiensi maksimal.
                                </p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                                <h4 class="fw-bold mb-2">Aman & Terpercaya</h4>
                                <p class="text-muted mb-0">
                                    Sistem keamanan berlapis dengan log aktivitas lengkap. Data Anda dijamin aman.
                                </p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="bi bi-graph-up"></i>
                                </div>
                                <h4 class="fw-bold mb-2">Laporan Real-time</h4>
                                <p class="text-muted mb-0">
                                    Dashboard analytics dan laporan lengkap untuk monitoring inventaris Anda.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>