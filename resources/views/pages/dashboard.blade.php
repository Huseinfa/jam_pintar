@extends('layouts.app')

@section('title', 'SmartPeak')

@section('content')

    <section class="hero-section d-flex align-items-center justify-content-center">

        <div id="home" class="container hero-wrapper text-center">
            <div class="hero-content mx-auto">

                <!-- Title -->
                <h1 class="fw-bold hero-title mb-2">
                    Kenali Jam Pintarmu
                </h1>

                <h2 class="fw-semibold hero-subtitle mb-4">
                    Tingkatkan Fokus Belajarmu
                </h2>

                <!-- Description -->
                <p class="hero-desc mb-4 fw-medium">
                    Temukan jam terbaik otakmu untuk belajar lebih fokus, santai, dan efektif.
                    Lewat kuis seru, kami bantu kamu kenali ritme belajarmu!
                </p>

                {{-- button --}}
                {{-- <a href="{{ route('student.index') }}" class="btn btn-hero px-4 py-3 rounded-pill">
                    Cari Jam Pintarku
                </a> --}}

                <a href="{{ route('onboarding') }}" class="btn btn-hero px-4 py-3 rounded-pill">
                    Cari Jam Pintarku
                </a>

            </div>
        </div>

    </section>

    {{-- PROBLEM --}}
    <section class="problem-section py-5">
        <div class="container text-center">

            <h2 class="fw-semibold problem-title mb-5">
                Pernah merasa seperti ini ?
            </h2>

            <div class="d-flex justify-content-center gap-4 flex-wrap">

                {{-- CARD 1 --}}
                <div class="card problem-card">
                    <img src="{{ asset('img/pict1.png') }}" class="card-img-top problem-img">
                    <div class="card-body">
                        <h6 class="fw-bold">Belajar lama tapi zonk</h6>
                        <p class="card-text">
                            Udah lama baca, pas ditanya blank total.
                        </p>
                    </div>
                </div>

                {{-- CARD 2 --}}
                <div class="card problem-card">
                    <img src="{{ asset('img/pict2.png') }}" class="card-img-top problem-img">
                    <div class="card-body">
                        <h6 class="fw-bold">Belajar lama tapi zonk</h6>
                        <p class="card-text">
                            Baru buka buku, mata langsung auto shutdown.
                        </p>
                    </div>
                </div>

                {{-- CARD 3 --}}
                <div class="card problem-card">
                    <img src="{{ asset('img/pict3.png') }}" class="card-img-top problem-img">
                    <div class="card-body">
                        <h6 class="fw-bold">Belajar lama tapi zonk</h6>
                        <p class="card-text">
                            Pagi semangat, siang drop, malam galau.
                        </p>
                    </div>
                </div>

                {{-- CARD 4 --}}
                <div class="card problem-card">
                    <img src="{{ asset('img/pict4.png') }}" class="card-img-top problem-img"">
                    <div class="card-body">
                        <h6 class="fw-bold">Belajar lama tapi zonk</h6>
                        <p class="card-text">
                            Niat belajar, ujungnya scroll hingga tugas menumpuk
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <section class="time-section d-flex align-items-center justify-content-center">

        <div class="container time-wrapper text-center">
            <div class="time-content mx-auto">
                <h2 class="fw-bold time-title mb-5">
                    Setiap orang punya waktu fokus yang berbeda
                </h2>
                <div class="d-flex justify-content-center gap-4 flex-wrap">
                    <div class="card time-card">
                        <img src="{{ asset('img/time1.png') }}" class="card-img-top time-img"">
                        <div class="card-body">
                            <h6 class="fw-bold">Jam Pagi</h6>
                            <p class="card-text fw-medium">
                                Fokus tinggi di awal hari, pikiran masih segar dan minim distraksi.
                            </p>
                        </div>
                    </div>
                    <div class="card time-card">
                        <img src="{{ asset('img/time2.png') }}" class="card-img-top time-img"">
                        <div class="card-body">
                            <h6 class="fw-bold">Jam Siang</h6>
                            <p class="card-text fw-medium">
                                Rajin dan konsisten, kerja pelan tapi pasti sepanjang siang.
                            </p>
                        </div>
                    </div>
                    <div class="card time-card">
                        <img src="{{ asset('img/time3.png') }}" class="card-img-top time-img"">
                        <div class="card-body">
                            <h6 class="fw-bold">Jam Sore</h6>
                            <p class="card-text fw-medium">
                                Mulai aktif saat sore, fokus datang pas suasana makin tenang.
                            </p>
                        </div>
                    </div>
                    <div class="card time-card">
                        <img src="{{ asset('img/time4.png') }}" class="card-img-top time-img">
                        <div class="card-body">
                            <h6 class="fw-bold">Jam Malam</h6>
                            <p class="card-text fw-medium">
                                Aktif di malam hari, ide-ide cemerlang muncul pas sunyi.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- METHOD --}}
    <section id="method" class="method-section py-5">
        <div class="container text-center">

            <h2 class="fw-semibold problem-title mb-5">
                Gimana cara kerjanya ?
            </h2>
            <div class="step-wrapper d-flex flex-column align-items-center gap-4">
                {{-- step 1 --}}
                <div class="card-step step-1 d-flex align-items-center">
                    <div class="circle-number">1</div>
                    <p class="mb-0 fw-bold">
                        Jawab 10 pertanyaan asyik
                    </p>
                </div>

                <div class="card-step step-2 d-flex align-items-center">
                    <div class="circle-number">2</div>
                    <p class="mb-0 fw-bold">
                        Sistem menganalisa pola kamu
                    </p>
                </div>

                <div class="card-step step-3 d-flex align-items-center">
                    <div class="circle-number">3</div>
                    <p class="mb-0 fw-bold">
                        Dapakan jam pintar dan rekomendasi belajar
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- REACHOUT --}}
    <section class="call-section d-flex align-items-center justify-content-center">

        <div class="container call-wrapper text-center">
            <div class="call-content mx-auto">

                <!-- Title -->
                <h2 class="fw-semibold call-subtitle mb-4">
                    Sudah siap belajar lebih fokus ?
                </h2>

                <!-- Description -->
                <p class="call-desc mb-4 fw-medium">
                    Temukan jam fokus terbaikmu dalam beberapa langkah sederhana.
                </p>

                <!-- Button -->
                {{-- @auth --}}

                <a class="btn btn-hero px-4 py-3 rounded-pill" href="#home">
                    Mulai Perjalanan
                </a>
                {{-- @else --}}
                {{-- <button type="button" class="btn btn-hero px-4 py-3 rounded-pill"  href="#home">
                        Mulai Perjalanan
                    </button> --}}
                {{-- @endauth --}}
            </div>
        </div>
    </section>

    <section id=about class="about-section py-5">
        <div class="container text-center">
            <h5 class="about-title fw-bold">Tentang SmartPeak</h5>
            <p>SmartPeak adalah platform berbasis tes untuk menemukan waktu otak paling optimal. Dengan Smartpeak, kamu
                mendapat rekomendasi waktu belajar yang tepat. Temukan Waktumu, Maksimalkan Belajarmu.</p>
        </div>
    </section>

    <style>
        .hero-section {
            min-height: 85vh;
            width: 100%;
            background: linear-gradient(180deg, #FFC83D 0%, #FFB800 100%);
            border-bottom-left-radius: 120px;
            border-bottom-right-radius: 120px;
            padding: 0;
        }

        .hero-wrapper {
            max-width: 1000px;
            width: 100%;
        }

        /* isi konten center */
        .hero-content {
            text-align: center;
        }

        .hero-title {
            font-size: 2.4rem !important;
            color: #111 !important;
            font-weight: 800 !important;
        }

        .hero-subtitle {
            font-size: 2.4rem !important;
            color: #2A3141 !important;
            font-weight: 800 !important;
        }

        .hero-desc {
            font-size: 1rem;
            color: #2A3141;
            line-height: 1.6;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Button */
        .btn-hero {
            background-color: #2A3141;
            color: #fff;
            font-weight: 600;
            transition: all 0.25s ease;
            margin-top: 1rem;
        }

        .btn-hero:hover {
            background-color: #ffffff !important;
            color: #1f2a3e !important;
            border: 1.5px solid #1f2a3e !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
        }

        .btn-hero:hover {
            background-color: #1b2230;
            transform: translateY(-2px);
            color: #fff;
        }

        /* Desktop scaling */
        @media (min-width: 1200px) {
            .hero-title {
                font-size: 3.5rem;
            }

            .hero-subtitle {
                font-size: 1.7rem;
            }
        }

        /* PROBLEM CARDS */

        .problem-section {
            /* margin-top: rem; */
            /* margin-bottom: 5rem; */
            padding-top: 5rem;
        }

        .problem-title {
            font-size: 2rem !important;
            color: #2A3141 !important;
            font-weight: 800 !important;
            margin-top: 2rem;
        }

        .problem-card {
            width: 14rem;
            background: transparent;
            border: none;
            transition: all 0.3s ease;
            transform: translateY(0);
            will-change: transform;
            border-radius: 40px;
            padding-top: 40px;
        }

        .problem-img {
            display: block;
            margin: 0 auto;
            width: 60%;
            height: 120px;
            object-fit: cover;
            border-radius: 12px;
        }

        .problem-card:hover {
            background-color: #8ED8B5;
            /* tosca */
            transform: translateY(-8px) scale(1.03);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .problem-card:hover h6,
        .problem-card:hover p {
            color: #1f2a3e;
        }

        .problem-card img {
            transition: all 0.3s ease;
        }

        .problem-card:hover img {
            transform: scale(1.05);
        }

        .problem-card h6 {
            font-weight: 800;
            color: #2A3141;
        }

        .problem-card p {
            font-size: 0.9rem;
            color: #2A3141;
        }

        /* TIME SECTION */
        .time-section {
            min-height: 80vh;
            width: 100%;
            /* FIX */
            background: linear-gradient(180deg, #8ED8B5 0%, #76bb9b 100%);
            border-radius: 120px;
            margin-top: 2rem;

        }

        .time-title {
            font-size: 2rem !important;
            color: #2A3141 !important;
            font-weight: 800 !important;
            margin-top: 2rem;
        }

        /* isi konten center */
        .time-content {
            text-align: center;
            padding: 0;
            margin: 0;
        }

        .time-card {
            width: 15rem;
            background-color: #ffffff;
            border: none;
            border-radius: 20px;
            transition: all 0.3s ease;
            transform: scale(1);
        }

        .time-card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .time-img {
            display: block;
            margin: 0 auto;
            /* padding-top: 0px; */
            margin-top: 25px;
            width: 33%;
            height: 80px;
            object-fit: cover;
            border-radius: 12px;
        }

        .time-card:hover .time-img {
            transform: scale(1.1);
        }

        .time-card:hover h6,
        .time-card:hover p {
            transform: scale(1.03);
        }

        .time-card p {
            font-size: 0.9rem;
            color: #2A3141;
        }

        /* STEP */
        .card-step {
            background-color: #FA5B19;
            border-radius: 999px;
            /* full rounded / pill */
            padding: 12px 18px;
            display: flex;
            align-items: center;
            gap: 12px;

            width: 500px;
            height: 70px;
        }

        /* lingkaran angka */
        .circle-number {
            width: 40px;
            height: 40px;
            background-color: #ffffff;
            color: #2A3141;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;
            font-weight: 700;
            font-size: 20px;
        }

        /* teks */
        .step-wrapper {
            text-align: center;
        }


        /* teks */
        .step-wrapper {
            text-align: center;
            /* padding-bottom: 4rem; */
        }

        .card-step {
            border-radius: 999px;
            padding: 12px 18px;

            display: flex;
            align-items: center;
            gap: 12px;

            width: 500px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        }

        .step-1 {
            background-color: #FA5B19;
        }

        .step-2 {
            background-color: #FDC334;
        }

        .step-3 {
            background-color: #8ED8B5;
        }

        /* call section */
        .call-section {
            min-height: 52vh;
            width: 100%;
            background: linear-gradient(180deg, #FFC83D 0%, #FFB800 100%);
            border-radius: 80px;
            padding: 0;
            margin-top: 30px;
        }

        .call-subtitle {
            font-size: 1.8rem !important;
            color: #2A3141 !important;
            font-weight: 800 !important;
        }

        .about-section {
            margin-top: 3rem;
            background-color: #f8f9fa;
            /* padding: 10rem 0; */
            border-top: 1px solid rgba(42, 49, 65, 0.);
        }

        .about title {
            margin-bottom: 5px;
        }

        .about-section p {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 16px;
        }
    </style>

    @if (request()->query('showLogin'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var modal = new bootstrap.Modal(document.getElementById('modalLogin'));
                modal.show();
            });
        </script>
    @endif

    @if (request()->query('showLogin')) 
        <script>
            document.addEventListener('DOMContentLoaded', function() { 
                var modal = new bootstrap.Modal( document.getElementById('modalLogin') ); modal.show(); // Hapus query parameter setelah modal muncul 
                window.history.replaceState({}, document.title, window.location.pathname); 
            }); 
        </script>
    @endif
@endsection
