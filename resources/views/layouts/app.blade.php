<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/modern-dashboard.css') }}">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Stack Styles (Untuk halaman spesifik) -->
    @stack('styles')
</head>

<body class="bg-light">
    <div id="app-content" class="d-flex">
        
        <!-- SIDEBAR -->
        <div id="sidebar-wrapper">
            @yield('sidebar')
        </div>

        <!-- MAIN CONTENT WRAPPER -->
        <div id="page-content-wrapper" class="flex-grow-1">
            
            <!-- NAVBAR -->
            <div id="navbar-wrapper">
                @yield('navbar')
            </div>

            <!-- MAIN CONTENT -->
            <main class="container-fluid py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- JS Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.all.min.js"></script>
    
    <!-- Stack Scripts (Untuk halaman spesifik) -->
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // ===============================
            // 1. GENERIC CONFIRMATION FUNCTION
            // ===============================
            function confirmAction(form, options) {
                Swal.fire({
                    title: options.title,
                    text: options.text,
                    icon: options.icon || 'warning',
                    showCancelButton: true,
                    confirmButtonColor: options.confirmColor,
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: options.confirmText,
                    cancelButtonText: 'Batal',
                    background: '#ffffff',
                    customClass: {
                        popup: 'rounded-4 shadow-lg border-0',
                        confirmButton: options.confirmClass,
                        cancelButton: 'btn btn-secondary px-4 py-2 rounded-3 ms-2'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Add loading state to submit button
                        const submitBtn = form.querySelector('button[type="submit"]');
                        if(submitBtn) {
                            submitBtn.disabled = true;
                            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';
                        }
                        form.submit();
                    }
                });
            }

            // ===============================
            // 2. FORM SUBMIT LISTENER
            // ===============================
            document.body.addEventListener('submit', function (e) {
                const form = e.target;

                // Handle Delete Form
                if (form.classList.contains('delete-form')) {
                    e.preventDefault();
                    confirmAction(form, {
                        title: 'Hapus Data?',
                        text: 'Data yang dihapus tidak bisa dikembalikan!',
                        confirmColor: '#ef4444',
                        confirmText: 'Ya, Hapus!',
                        confirmClass: 'btn btn-danger px-4 py-2 rounded-3'
                    });
                    return;
                }

                // Handle Approve Form
                if (form.classList.contains('approve-form')) {
                    e.preventDefault();
                    confirmAction(form, {
                        title: 'Setujui Peminjaman?',
                        text: 'Status akan berubah menjadi Active/Sedang Dipinjam.',
                        icon: 'question',
                        confirmColor: '#10b981',
                        confirmText: 'Ya, Setuju!',
                        confirmClass: 'btn btn-success px-4 py-2 rounded-3'
                    });
                    return;
                }

                // Handle Reject Form
                if (form.classList.contains('reject-form')) {
                    e.preventDefault();
                    confirmAction(form, {
                        title: 'Tolak Peminjaman?',
                        text: 'Peminjaman akan dibatalkan permanen.',
                        confirmColor: '#ef4444',
                        confirmText: 'Ya, Tolak!',
                        confirmClass: 'btn btn-danger px-4 py-2 rounded-3'
                    });
                    return;
                }
            });

            // ===============================
            // 3. FLASH MESSAGE TOAST (Success/Error)
            // ===============================
            if(session('success'))
              @  const ToastSuccess = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
                ToastSuccess.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{!! addslashes(session('success')) !!}",
                    background: '#fff',
                    color: '#000'
                });
            @endif

            @if(session('error'))
                const ToastError = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
                ToastError.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{!! addslashes(session('error')) !!}",
                    background: '#fff',
                    color: '#000'
                });
            @endif

            // ===============================
            // 4. VALIDATION ERROR ALERT
            // ===============================
            @if($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    html: `<div class="text-start">
                            <ul class="list-unstyled mb-0">
                                @foreach($errors->all() as $error)
                                    <li class="mb-1"><i class="bi bi-exclamation-triangle-fill text-warning me-2"></i> {{ e($error) }}</li>
                                @endforeach
                            </ul>
                           </div>`,
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#d33',
                    customClass: {
                        popup: 'rounded-4 shadow-lg border-0'
                    }
                });
            @endif
        });
    </script>
</body>
</html>