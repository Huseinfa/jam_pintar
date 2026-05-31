@extends('layouts.app')

@section('title', 'Hasil Rekomendasi - SmartPeak')

@section('content')
<div style="background-color: #FDC334; min-height: 100vh; padding-top: 100px; padding-bottom: 60px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9">

                {{-- Card Hasil --}}
                <div style="background: #fff; border-radius: 24px; padding: 40px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center;">

                    {{-- Icon --}}
                    <div style="width: 80px; height: 80px; background: #8ED8B5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>

                    <h1 class="fw-bold mb-2" style="font-size: 1.4rem; color: #2A3141;">
                        Quiz Selesai! 🎉
                    </h1>
                    <p class="text-muted mb-4">Berikut adalah rekomendasi waktu belajar terbaikmu</p>

                    {{-- Rekomendasi --}}
                    <div style="background: #FDC334; border-radius: 16px; padding: 24px; margin-bottom: 32px;">
                        <p class="mb-1" style="font-size: 0.9rem; color: #2A3141;">Waktu Belajar Optimal Kamu</p>
                        <h2 class="fw-bold mb-1" style="font-size: 2rem; color: #2A3141;">
                                {{ $result->recommendation->prefered_study_time ?? '-' }}
                        </h2>
                        <p style="color: #2A3141; font-size: 0.95rem;">
                            {{ $result->recommendation->study_hour_start ?? '' }} –
                            {{ $result->recommendation->study_hour_end ?? '' }}
                        </p>
                    </div>

                    {{-- Deskripsi --}}
                    @if($result->recommendation->recomendation ?? false)
                    <p class="text-muted mb-4" style="font-size: 0.95rem; line-height: 1.7;">
                        {{ $result->recommendation->recomendation }}
                    </p>
                    @endif

                    {{-- Tombol aksi --}}
                    <div class="d-flex flex-column gap-3">
                        <a href="{{ url('/result/' . $attemptId . '/download') }}"
                           style="background: #2A3141; color: #fff; padding: 14px 32px; border-radius: 50px; text-decoration: none; font-weight: 600; display: block;">
                            📄 Download PDF
                        </a>
                        <a href="{{ route('student.calendar', $result->id) }}"
                           style="background: #fff; color: #2A3141; padding: 14px 32px; border-radius: 50px; text-decoration: none; font-weight: 600; border: 2px solid #2A3141; display: block;">
                            📅 Tambah ke Google Calendar
                        </a>
                        <a href="{{ route('dashboard') }}"
                           style="color: #6b7280; text-decoration: none; font-size: 0.9rem;">
                            Kembali ke Dashboard
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection