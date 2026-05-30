<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: #f5f5f5;">

<div class="container min-vh-100 d-flex align-items-center justify-content-center">
    
    <div class="card border-0 shadow-sm p-4"
         style="max-width: 430px; width: 100%; border-radius: 32px;">

        {{-- Header --}}
        <div class="text-center mb-4">
            
            <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle"
                 style="width: 60px; height: 60px; background: #FDC334;">
            </div>

            <h3 class="fw-bold" style="color: #1a1a2e;">
                Lupa Password
            </h3>

            <p class="text-muted small mb-0">
                Masukkan email Anda untuk menerima link reset password
            </p>
        </div>

        {{-- Success Message --}}
        @if (session('status'))
            <div class="alert alert-success small">
                {{ session('status') }}
            </div>
        @endif

        {{-- Error --}}
        @if ($errors->any())
            <div class="alert alert-danger small">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
                <label class="form-label fw-semibold small">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    class="form-control py-3 px-3"
                    placeholder="Masukkan Email"
                    required
                    value="{{ old('email') }}"
                    style="border-radius: 50px; border: 1.5px solid #2A3141;"
                >
            </div>

            <div class="d-grid mb-3">
                <button type="submit"
                        class="btn text-white py-3 fw-semibold"
                        style="background: #1a1a2e; border-radius: 50px;">
                    Kirim Link Reset
                </button>
            </div>

            <div class="text-center">
                <a href="{{ route('dashboard') }}"
                   class="small text-decoration-none fw-semibold"
                   style="color: #F5A623;">
                    Kembali ke Login
                </a>
            </div>

        </form>
    </div>
</div>

</body>
</html>