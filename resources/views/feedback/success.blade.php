@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #FDC334;
    }
</style>
<div class="container py-5" style="padding-top: 300px; padding-bottom: 200px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm text-center" style="border-radius: 20px; overflow: hidden;">
                <div class="card-body p-5">
                    <div style="margin: 30px 0;">
                        <div style="width: 100px; height: 100px; margin: 0 auto; background: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                    </div>

                    <h3 class="fw-bold mb-3">Terima Kasih! 🎉</h3>

                    <p class="text-muted mb-4">
                        Feedback Anda telah kami terima dengan baik. Masukan Anda sangat berharga dan akan membantu kami terus meningkatkan Jam Pintar.
                    </p>

                    <div class="alert alert-info mb-4" role="alert">
                        <strong>📧 Apa selanjutnya?</strong>
                        <p class="mb-0 mt-2" style="font-size: 0.9rem;">
                            Tim kami akan meninjau feedback Anda dan menggunakannya untuk pengembangan fitur-fitur baru.
                        </p>
                    </div>

                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg fw-semibold" style="border-radius: 50px; background: #1a1a2e; border: none; padding: 12px 40px;">
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
