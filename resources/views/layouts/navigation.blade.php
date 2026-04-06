<nav class="navbar navbar-glass mb-4">
    <div class="d-flex align-items-center justify-content-between w-100">
        <div>
            <h5 class="fw-bold text-dark mb-0">@yield('page-title')</h5>
            <small class="text-muted">{{ now()->format('l, d F Y') }}</small>
        </div>

        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-light rounded-circle shadow-sm position-relative" style="width: 40px; height: 40px;">
                <i class="bi bi-bell"></i>
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
            </button>

            <div class="dropdown">
                <button class="btn btn-light rounded-pill shadow-sm pe-3 ps-1 py-1 d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                    <div class="avatar-circle bg-primary text-white" style="width: 32px; height: 32px; font-size: 0.8rem;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <span class="fw-semibold small d-none d-md-block">{{ Auth::user()->name }}</span>
                    <i class="bi bi-chevron-down small text-muted"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-2 rounded-3 mt-2">
                    <li class="px-3 py-2 border-bottom mb-2">
                        <div class="fw-bold text-dark">{{ Auth::user()->name }}</div>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item rounded-2 text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
