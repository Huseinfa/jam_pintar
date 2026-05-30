@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #FDC334;
    }
</style>
<div class="container" style="padding-top: 120px; padding-bottom: 60px;">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-sm" style="border-radius: 25px; overflow: hidden;">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); color: white; padding: 30px;">
                    <h2 class="fw-bold mb-0">⏰ Feedback Tertunda</h2>
                </div>
                <div class="card-body p-4">
                    @if ($pendingFeedbacks->isEmpty())
                        <div class="text-center py-4">
                            <div style="font-size: 3rem; margin-bottom: 20px;">✨</div>
                            <h5 class="fw-bold mb-2">Tidak Ada Feedback Tertunda</h5>
                            <p class="text-muted mb-0">Anda sudah menyelesaikan semua feedback! Terima kasih atas kontribusi Anda.</p>
                        </div>
                    @else
                        <p class="text-muted mb-4">
                            Anda memiliki <strong>{{ $pendingFeedbacks->count() }}</strong> feedback yang belum diselesaikan. Klik salah satu di bawah untuk mengisinya sekarang.
                        </p>

                        @foreach ($pendingFeedbacks as $feedback)
                            <div class="card border-0 shadow-sm mb-3" style="border-radius: 15px; border-left: 5px solid #F5A623;">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h5 class="fw-bold mb-2">Test selesai pada {{ $feedback->email_sent_at->format('d M Y') }}</h5>
                                            <p class="text-muted mb-2 small">
                                                📧 Email undangan dikirim {{ $feedback->email_sent_at->diffForHumans() }}
                                            </p>
                                            
                                            @if ($feedback->reminder_sent_at)
                                                <p class="text-muted small mb-0">
                                                    🔔 Email reminder dikirim {{ $feedback->reminder_sent_at->diffForHumans() }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="col-auto">
                                            <a href="{{ route('feedback.form', ['token' => $feedback->token]) }}" class="btn btn-warning fw-semibold" style="border-radius: 50px;">
                                                Isi Feedback →
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
