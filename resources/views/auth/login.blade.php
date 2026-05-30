<style>
    @media (max-width: 575.98px) {
        #modalLogin {
            /* margin: auto; */
        }
        #modalLogin .modal-dialog {
            max-width: 25px;
        }
        #modalLogin .modal-content {
            /* border-radius: 24px !important; */
        }
        #modalLogin .modal-body {
            padding: 1.75rem !important;
        }
    }
</style>


<div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-100 my-4 px-3 px-sm-0" style="max-width: 420px;"> {{-- mx-3 untuk jarak horizontal pada layar kecil, mx-sm-auto untuk auto margin pada layar medium ke atas --}}
        <div class="modal-content border-0 shadow-sm" style="border-radius: 55px; overflow: hidden;">
        {{-- border 0 shadow-sm agar tidak ada border dan shadow --}}
            {{-- button close untuk popup --}}
            <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close" style="z-index: 10;"></button>
            <div class="modal-body p-4 p-sm-5" style="background: #fff; border-radius: 32px;">
                    <div class="text-center mb-4">
                        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 56px; height: 56px; background: #FDC334;">
                        </div>
                        <h5 class="fw-bold mb-1" style="font-size: 1.4rem;">Masuk ke Akun</h5>
                        <p class="text-muted small mb-0">Masuk dengan email dan password</p>
                    </div>
                {{-- Tampilkan alert error jika ada --}}
                @if ($errors->any())
                    <div class="alert alert-danger py-2 small">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- Tampilkan success message (setelah register) --}}
                @if (session('success'))
                    <div class="alert alert-success py-2 small">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('auth.login') }}">
                    @csrf

                    {{-- email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold small">Email</label>
                        <input
                            type="email"
                            class="form-control py-3 px-3"
                            id="email"
                            name="email"
                            placeholder="Masukkan Email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            style="border-radius: 50px; border: 1.5px solid #2A3141; font-size: 0.95rem;"
                        >
                    </div>
                    {{-- password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold small">Password</label>
                        <input
                            type="password"
                            class="form-control py-3 px-3"
                            id="password"
                            name="password"
                            placeholder="Masukkan Password"
                            required
                            style="border-radius: 50px; border: 1.5px solid #2A3141; font-size: 0.95rem;"
                        >
                    </div>
                    {{-- remember me dan lupa password --}}
                    <div class="d-flex justify-content-between aligh-items-center mb-4">
                        <div class="form-check mb-0">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember" style="border: 1.5px solid #2A3141;">
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                        {{-- lupa password --}}
                        <a href="{{ route('password.request') }}" 
                           class="small text-decoration-none fw-semibold" 
                           style="color: #F5A623;">
                            Lupa Password
                        </a>
                    </div>

                    {{-- Tombol Masuk --}}
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn py-3 fw-semibold text-white"
                                style="border-radius: 50px; background: #1a1a2e; font-size: 0.95rem;">
                            Masuk
                        </button>
                    </div>

                    {{-- Daftar akun --}}
                    <p class="text-center small mb-0">
                        Belum punya akun?
                        
                        <a href="#"
                        data-bs-toggle="modal"
                        data-bs-target="#modalRegister"
                        data-bs-dismiss="modal"
                        class="text-decoration-none fw-semibold"
                        style="color: #F5A623;">
                            Daftar
                        </a>
                    </p>
                </form>
            </div>

        </div>
    </div>
</div>

{{-- Buka modal otomatis jika ada error atau success message (setelah redirect) --}}
@if ($errors->any() || session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = new bootstrap.Modal(document.getElementById('modalLogin'));
        modal.show();
    });
</script>
@endif