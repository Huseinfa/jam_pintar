<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard')</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* Ensure the page fills viewport so footer can stick to bottom */
        html, body {
            height: 100%;
        }

        body {
            min-height: 100%;
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
        }

        h1,h2,h3,h4,h5 {
            font-family: 'Poppins', sans-serif;
            letter-spacing: -0.5px;
        }

        /* navbar */
        #navbar {
            width: 250px;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            background-color: #212529;
        }

        /* Main content wrapper: make full height so footer stays at bottom */
        #main-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* ensures wrapper spans viewport */
        }

        /* content grows to fill available space */
        #content {
            flex: 1;
            padding: 0px;
        }

    

    </style>

    @stack('styles')
</head>

<body>

    {{-- navbar --}}
    @include('components.navbar')

    <div id="main-wrapper">
        {{-- Header --}}
        @include('components.header')

        {{-- Konten Halaman --}}
        <main id="content">
            @yield('content')
        </main>

        {{-- Footer --}}
        @include('components.footer')
    </div>

    {{-- Modal Login & Register (hidden when success modal shows) --}}
    @if (!session('success'))
        @include('auth.login')
        {{-- Modal Register --}}
        @include('auth.register')
    @endif

    {{-- Success Modal for Feedback --}}
    @if (session('success'))
        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                    <div class="modal-body text-center p-5">
                        <div style="margin: 20px 0;">
                            <div style="width: 100px; height: 100px; margin: 0 auto; background: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                        </div>
                        <h4 class="fw-bold mt-3 mb-2">Terima Kasih! 🎉</h4>
                        <p class="text-muted mb-0">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = new bootstrap.Modal(document.getElementById('successModal'), {
                    backdrop: 'static',
                    keyboard: false
                });
                modal.show();
                
                // Close modal and redirect after 2 seconds
                setTimeout(function() {
                    modal.hide();
                    window.location.href = "{{ route('dashboard') }}";
                }, 2000);
            });
        </script>
    @endif

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>
