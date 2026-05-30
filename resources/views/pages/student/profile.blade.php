@extends('layouts.app')

@section('title', 'SmartPeak')

@section('content')

<style>
    body {
        background-color: #FDC334;
    }

    .container {
        padding-top: 85px;
    }
    /* =========================
        PROFILE HEADER
    ========================== */

    .profile-card {
        border-radius: 30px;
        background-color: #f5f5f5;
        padding: 30px;
        margin-bottom: 30px;
    }

    .profile-wrapper {
        display: flex;
        align-items: center;
        gap: 30px;
    }

    .profile-icon {
        font-size: 120px;
        color: #212529;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-info {
        flex: 1;
    }

    .profile-name {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 10px;
        border-bottom: 1px solid #bdbdbd;
        padding-bottom: 10px;
    }

    .profile-email-label {
        font-size: 1rem;
        font-weight: 600;
        color: #6c757d;
        margin-bottom: 0;
    }

    .profile-email {
        font-size: 1.2rem;
        color: #343a40;
    }

    /* =========================
        DETAIL PROFILE
    ========================== */

    .profile-detail-card {
        border-radius: 35px;
        background-color: #f5f5f5;
        padding: 40px;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 10px;
        color: #212529;
    }

    .custom-input {
        border-radius: 50px;
        padding: 14px 20px;
        border: 1px solid #cfcfcf;
        background-color: #fff;
        color: #6c757d;
    }

    .gender-wrapper {
        display: flex;
        gap: 25px;
        margin-top: 10px;
    }

    .form-check-label {
        color: #6c757d;
    }

    @media (max-width: 768px) {

        .profile-wrapper {
            flex-direction: column;
            text-align: center;
        }

        .profile-name {
            border-bottom: none;
        }

        .profile-detail-card {
            padding: 25px;
        }
    }

    /* css untuk result card */
    .result-card {
    border-radius: 35px;
    background-color: #f5f5f5;
    padding: 35px;
}

.result-top {
    background-color: #2d3448;
    border-radius: 35px;
    padding: 35px;
    color: white;

    display: flex;
    align-items: center;
    gap: 30px;
}

.result-icon {
    font-size: 100px;
}

.chronotype-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 20px;
}

.chronotype-info {
    display: flex;
    align-items: center;
    gap: 10px;

    font-size: 1.3rem;
    font-weight: 600;

    margin-bottom: 15px;
}

.study-time {
    font-size: 2rem;
    font-weight: 500;
}

.result-note {
    margin-top: 35px;
}

.result-note h4 {
    font-weight: 700;
    margin-bottom: 10px;
}

.result-note p {
    color: #6c757d;
    font-size: 1.2rem;
}

.result-action {
    margin-top: 35px;

    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.btn-detail,
.btn-calendar {
    border-radius: 50px;
    padding: 15px 30px;
    font-weight: 600;
}

.btn-detail {
    border: 2px solid #2d3448;
    color: #2d3448;
}

.btn-calendar {
    border: 2px solid #f0b429;
    color: #2d3448;
}
</style>

<div class="container pb-3">

    {{-- PROFILE HEADER --}}
    <div class="card shadow-sm profile-card border-0">
        <div class="profile-wrapper">

            {{-- Foto Profile --}}
            <div class="profile-icon">
                <i class="bi bi-person-circle"></i>
            </div>

            {{-- Informasi User --}}
            <div class="profile-info">

                <div class="profile-name">
                    {{ $user->name }}
                </div>

                <div>
                    <p class="profile-email-label">
                        <i class="bi bi-envelope-fill me-2"></i>Email
                    </p>

                    <p class="profile-email">
                        {{ $user->email }}
                    </p>
                </div>

            </div>
        </div>
    </div>

    {{-- FEEDBACK REMINDER SECTION --}}
    @if($pendingFeedbacks > 0)
    <div class="card shadow-sm border-0 mt-4" style="border-radius: 20px; border-left: 5px solid #F5A623; overflow: hidden;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="fw-bold mb-2">
                        <i class="fas fa-envelope-circle-check" style="color: #F5A623;"></i>
                        Feedback Tertunda
                    </h5>
                    <p class="text-muted mb-0">
                        Anda memiliki <strong>{{ $pendingFeedbacks }}</strong> feedback yang belum diselesaikan. Feedback Anda sangat membantu kami untuk berkembang!
                    </p>
                </div>
                <a href="{{ route('student.feedback.reminders') }}" class="btn" style="background: #F5A623; color: white; border-radius: 50px; white-space: nowrap;">
                    Lihat Semua →
                </a>
            </div>
        </div>
    </div>
    @endif

    {{-- DETAIL PROFILE --}}
    <div class="card shadow-sm profile-detail-card border-0 mt-4">
        {{-- Nama --}}
        <div class="mb-4">
            <label class="form-label">Nama Lengkap</label>
            <input type="text"
                   class="form-control custom-input"
                   value="{{ $user->name }}"
                   readonly>
        </div>
        {{-- Kota --}}
        <div class="mb-4">
            <label class="form-label">Asal Kota</label>
            <input type="text"
                   class="form-control custom-input"
                   value="{{ $user->city->name ?? '-' }}"
                   readonly>
        </div>
        {{-- Tanggal Lahir --}}
        <div class="mb-4">
            <label class="form-label">Tanggal Lahir</label>
            <input type="text"
                   class="form-control custom-input"
                   value="{{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d/m/Y') : '-' }}"
                   readonly>
        </div>
        {{-- Gender --}}
        <div class="mb-2">
            <label class="form-label">Jenis Kelamin</label>
            <div class="gender-wrapper">
                <div class="form-check">
                    <input class="form-check-input"
                           type="radio"
                           disabled
                           {{ $user->gender == 'LakiLaki' ? 'checked' : '' }}>
                    <label class="form-check-label">
                        Laki-Laki
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input"
                           type="radio"
                           disabled
                           {{ $user->gender == 'Perempuan' ? 'checked' : '' }}>
                    <label class="form-check-label">
                        Perempuan
                    </label>
                </div>
            </div>
        </div>
    </div>

    {{-- data prefered study conclusion, resend and connect button to google calendar --}}
    {{-- RESULT CARD --}}
    @if($result && $result->recommendation)
    {{-- koneksikan icon dengan hasil rekomendasi --}}

    @php
        // $icon = $result->recommendation->prefered_study_time;
        $studyTime = $result->recommendation->prefered_study_time;
        $icon = match($studyTime) {
        'Morning' => 'img/time1.png',
        'Afternoon' => 'img/time2.png',
        'Evening' => 'img/time3.png',
        'Night' => 'img/time4.png',
        default => 'img/time1.png'
    };
    @endphp

    <div class="card shadow-sm border-0 result-card mt-4">
        <div class="result-top">
            {{-- Left --}}
            <div class="result-icon">
                <img src="{{ asset($icon) }}" alt="Chronotype" class="chronotype-img">
            </div>
            {{-- Right --}}
            <div class="result-content">
                <h3 class="chronotype-title">
                    {{ $result->recommendation->prefered_study_time }}
                </h3>
                <div class="chronotype-info">
                    <i class="bi bi-brain"></i>
                    <span>
                        Jam Pintar
                    </span> 
                </div>
                <div class="study-time">
                    {{ \Carbon\Carbon::parse($result->recommendation->study_hour_start)->format('H.i') }}
                    -
                    {{ \Carbon\Carbon::parse($result->recommendation->study_hour_end)->format('H.i') }}
                </div>
            </div>
        </div>
        {{-- NOTE --}}
        <div class="result-note">
            <h4>Catatan</h4>
            <p>
                {{-- {{ $result->recommendation->recomendation }} --}}
                Untuk mendapatkan hasil belajar maksimal coba hubungkan dengan google calendar kamu untuk pengalaman lebih baik.
            </p>
        </div>
        {{-- BUTTON --}}
        <div class="result-action">
            {{-- DETAIL --}}
            <a href="{{ route('result.pdf', $result->test_attempt_id) }}"
            class="btn btn-detail">
                <i class="bi bi-envelope-fill me-2"></i>
                Detail Hasil
            </a>
            {{-- GOOGLE CALENDAR --}}
            <a href="{{ route('student.calendar', $result->id) }}"
            class="btn btn-calendar">

                <i class="bi bi-calendar-event me-2"></i>
                Google Calendar
            </a>
        </div>
    </div>
    @endif

</div>

@endsection