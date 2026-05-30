<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Backoffice')</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    {{-- font options --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        #sidebar-admin {
            width: 250px;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            background-color: #0d6efd;
        }

        #main-wrapper {
            margin-left: 250px;
            min-height: 100vh;
        }

        #content {
            padding: 24px;
        }

        /* link */
        /* Sidebar link default */
        .sidebar-link {
            transition: all 0.2s ease;
            font-weight: 400;
        }

        /* Hover effect */
        .sidebar-link:hover {
            font-weight: 700;
            transform: translateX(2px);
        }

        /* Hover icon */
        .sidebar-link:hover i {
            font-weight: 700;
        }

        /* Active menu */
        .active-sidebar {
            font-weight: 700;
            background-color: rgba(255, 255, 255, 0.12);
            border-radius: 10px;
        }

        /* Active icon */
        .active-sidebar i {
            font-weight: 700;
        }

        /* Prevent unexpectedly large icon rendering (diagnostic quick-fix) */
        .bi {
            font-size: 1rem !important;
            line-height: 1;
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- Sidebar Admin --}}
    <nav id="sidebar-admin" class="d-flex flex-column p-3">
        <div class="text-white fw-bold fs-5 mb-4 px-2">
            <i class="bi bi-grid-fill me-2"></i> Backoffice
        </div>
        <ul class="nav flex-column gap-1">
            {{-- Dashboard --}}
            <li class="nav-item">
                <a href="{{ route('backoffice.index') }}"
                    class="nav-link sidebar-link text-white {{ request()->routeIs('backoffice.index') ? 'active-sidebar' : '' }}">

                    <i class="bi bi-house me-2"></i>
                    Dashboard
                </a>
            </li>

            {{-- CRUD Question --}}
            <li class="nav-item">
                <a href="{{ route('backoffice.question') }}"
                    class="nav-link sidebar-link text-white {{ request()->routeIs('backoffice.question') ? 'active-sidebar' : '' }}">

                    <i class="bi bi-question-circle me-2"></i>
                    Pertanyaan
                </a>
            </li>

            {{-- CRUD Cities --}}
            <li class="nav-item">
                <a href="{{ route('backoffice.cities') }}"
                    class="nav-link sidebar-link text-white {{ request()->routeIs('backoffice.cities*') ? 'active-sidebar' : '' }}">

                    <i class="bi bi-geo-alt me-2"></i>
                    Kota
                </a>
            </li>

            {{-- RESULT Feedback --}}
            <li class="nav-item">
                <a href="{{ route('backoffice.feedback_result') }}"
                    class="nav-link sidebar-link text-white {{ request()->routeIs('backoffice.feedback_result*') ? 'active-sidebar' : '' }}">

                    <i class="bi bi-chat-left-text me-2"></i> {{-- Menambahkan ikon chat --}}
                    Feedback Result
                </a>
            </li>

        </ul>

        <div class="mt-auto">
            <form method="POST" action="{{ route('auth.logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light w-100">
                    <i class="bi bi-box-arrow-left me-2"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    {{-- Konten --}}
    <div id="main-wrapper">
        <div id="content">
            @yield('content')
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- sweetalert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#0d6efd',
                timer: 2500,
                showConfirmButton: false
            });
        </script>
    @endif

    {{-- sweet alert delete --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => {

                button.addEventListener('click', function(e) {

                    e.preventDefault();

                    const form = this.closest('form');
                    const question = this.dataset.question;

                    Swal.fire({
                        title: 'Hapus Pertanyaan?',
                        text: `Question "${question}" akan dihapus.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {

                        if (result.isConfirmed) {
                            form.submit();
                        }

                    });

                });

            });

        });
    </script>
    {{-- Sweet Alert Delete City --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const cityButtons =
                document.querySelectorAll('.btn-delete-city');

            cityButtons.forEach(button => {

                button.addEventListener('click', function(e) {

                    e.preventDefault();

                    const form =
                        this.closest('form');

                    const cityName =
                        this.dataset.city;

                    Swal.fire({

                        title: 'Hapus Kota?',
                        text: `Kota "${cityName}" akan dihapus.`,
                        icon: 'warning',

                        showCancelButton: true,

                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',

                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'

                    }).then((result) => {

                        if (result.isConfirmed) {

                            form.submit();

                        }

                    });

                });

            });

        });
    </script>

    @stack('scripts')
</body>

</html>
