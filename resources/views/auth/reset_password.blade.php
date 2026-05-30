<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>

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
                Reset Password
            </h3>

            <p class="text-muted small mb-0">
                Masukkan password baru Anda
            </p>
        </div>

        {{-- Error --}}
        @if ($errors->any())
            <div class="alert alert-danger small">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            {{-- Email --}}
            <div class="mb-3">
                <input
                    type="email"
                    name="email"
                    value="{{ $email ?? old('email') }}"
                    class="form-control py-3 px-3"
                    placeholder="Masukkan Email"
                    required
                    style="border-radius: 50px; border: 1.5px solid #2A3141;"
                >
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <input
                    type="password"
                    name="password"
                    class="form-control py-3 px-3"
                    placeholder="Password Baru"
                    required
                    style="border-radius: 50px; border: 1.5px solid #2A3141;"
                >
            </div>

            {{-- Confirm Password --}}
            <div class="mb-4">
                <input
                    type="password"
                    name="password_confirmation"
                    class="form-control py-3 px-3"
                    placeholder="Konfirmasi Password"
                    required
                    style="border-radius: 50px; border: 1.5px solid #2A3141;"
                >
            </div>

            {{-- Button --}}
            <div class="d-grid">
                <button type="submit"
                        class="btn text-white py-3 fw-semibold"
                        style="background: #1a1a2e; border-radius: 50px;">
                    Reset Password
                </button>
            </div>

        </form>
    </div>
</div>

</body>
</html>