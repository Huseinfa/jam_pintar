<nav class="navbar navbar-expand-lg px-3" style="background-color:#ffffff; box-shadow:0 2px 10px rgba(0,0,0,0.05);">

    <div class="container-fluid">

        <!-- Brand -->
        <a class="navbar-brand fw-bold" href="#" style="color:#2A3141;">
            <i class="bi bi-moon-stars-fill me-2"></i> SmartPeak
        </a>

        <!-- Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">

            <!-- NAV MENU -->
            <ul class="navbar-nav align-items-center me-5 mx-2">

                <!-- Home -->
                <li class="nav-item">
                    <a class="nav-link mx-2 nav-link-custom active" href="{{ route('dashboard') }}#home">
                        Home
                    </a>
                </li>

                <!-- How It Works -->
                <li class="nav-item">
                    <a class="nav-link mx-2 nav-link-custom" href="{{ route('dashboard') }}#method">
                        Steps
                    </a>
                </li>

                <!-- About -->
                <li class="nav-item">
                    <a class="nav-link mx-2 nav-link-custom" href="{{ route('dashboard') }}#about">
                        About
                    </a>
                </li>

            </ul>

            <!-- LOGIN BUTTON / USER PROFILE -->
            @auth
                <div class="dropdown">
                    <button class="btn btn-login-custom rounded-pill px-4 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-2"></i>{{ auth()->user()->name ?? auth()->user()->email }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        {{-- <li>
                            <span class="dropdown-item-text small text-muted">
                                {{ auth()->user()->email }}
                            </span>
                        </li> --}}
                        {{-- bagian untuk menuju profil --}}
                        <li>
                            <a class="dropdown-item" href="{{ route('student.profile') }}">
                                <i class="bi bi-person me-2"></i>Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('auth.logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <button type="button" class="btn btn-login-custom rounded-pill px-4" data-bs-toggle="modal"
                    data-bs-target="#modalLogin">
                    Login
                </button>
            @endauth

        </div>

    </div>
</nav>

<style>
    /* Login Button - hover jadi putih dengan outline gelap */
    .btn-login-custom {
        background-color: #212529;
        color: #ffffff;
        border: 1.5px solid #212529;
        font-weight: 500;
        transition: all 0.25s ease;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
        font-size: 1rem;
        padding: 0.7rem 1.5rem;
    }

    .btn-login-custom:hover {
        background-color: #ffffff !important;
        color: #1f2a3e !important;
        border: 1.5px solid #1f2a3e !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
    }

    .btn-login-custom:focus {
        box-shadow: 0 0 0 3px rgba(33, 37, 41, 0.25);
        outline: none;
    }

    .navbar {
        position: fixed;
        top: 0;
        z-index: 999;
        width: 100%;
    }

    .nav-link-custom {
        color: #2A3141;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .nav-link-custom.active {
        font-weight: 500;
        /* bukan bold */
    }

    .nav-link-custom:hover {
        opacity: 0.7;
    }

    /* Responsive adjustment */
    @media (max-width: 992px) {
        .btn-login-custom {
            margin-top: 0.5rem;
            width: 100%;
        }
    }
</style>
