@extends('layouts.app')

@section('title', 'SmartPeak')

@section('content')

    <section id="home" class="hero-section d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6 hero-left-content">
                    <div class="hero-badge mb-2">
                        <span class="badge-animated">
                            <span class="typingtext">✨ Temukan Ritme Belajarmu</span>
                        </span>
                    </div>
                    <h1 class="hero-title mb-3">
                        Kenali <span class="highlight-text">Jam Pintarmu</span>
                    </h1>
                    <h2 class="hero-subtitle mb-4">
                        Tingkatkan Fokus Belajarmu
                    </h2>
                    <p class="hero-desc mb-4">
                        Temukan jam terbaik otakmu untuk belajar lebih fokus,
                        santai, dan efektif. Lewat kuis seru, kami bantu kamu
                        kenali ritme belajarmu.
                    </p>
                    <div class="hero-buttons">
                        <a href="{{ route('student.index') }}" class="btn btn-hero-primary px-4 py-3 rounded-pill me-3">
                            ✨ Cari Jam Pintarku
                        </a>
                        {{-- <a href="#problem" class="btn btn-hero-secondary px-4 py-3 rounded-pill">
                            Pelajari Lebih Lanjut
                        </a> --}}
                    </div>

                </div>

                <div class="col-lg-6 text-center">
                    <div class="hero-illustration">
                        <img src="{{ asset('img/ilustrasi.png') }}" class="img-fluid floating-illustration">
                        <div class="floating-card card-1">
                            🧠 Fokus Maksimal
                        </div>
                        <div class="floating-card card-2">
                            ⏰ Jam Optimal
                        </div>
                        <div class="floating-card card-3">
                            📚 Belajar Efektif
                        </div>

                        <div class="scroll-indicator">
                            <span class="scroll-badge">
                                Explore More
                                <span class="arrow">↓</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <div class="hero-wave">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120">
            <path fill="#f8f9fa" fill-opacity="1"
                d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z">
            </path>
        </svg>
    </div>

    {{-- PROBLEM --}}
    <section id="problem" class="problem-section py-5">
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

                <div class="hero-buttons">
                    <a href="#home" class="btn btn-hero-primary px-4 py-3 rounded-pill me-3">
                        Mulai Perjalanan
                    </a>
                </div>

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
            display: flex;
            min-height: 95vh;
            padding-top: 50px;
            padding-bottom: 0;
            background: linear-gradient(135deg, #FFC83D 0%, #FFB800 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-wave {
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            line-height: 0;
        }

        .hero-wave svg {
            display: block;
            width: 100%;
            height: 140px;
        }
        

        .hero-stats {
            display: flex;
            gap: 40px;
        }


        .hero-section .container {
            position: relative;
            /* padding: 0; */
            z-index: 2;
        }

        .container {
            width: min(1200px, 90%);
            margin: 0 auto;
        }

        .hero-left-content {
            z-index: 2;
        }

        .hero-title {
            font-size: 2.7rem;
            font-weight: 800;
            color: #2A3141;
            padding-top: 2rem;
        }

        .hero-subtitle {
            font-size: 1.8rem;
            color: #2A3141;
            font-weight: 700;
        }

        .hero-desc {
            font-size: 1rem;
            line-height: 1.7;
            color: #2A3141;
        }

        .hero-buttons .btn {
            font-weight: 570;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .badge-animated {
            background: rgba(255, 255, 255, .3);
            padding: 8px 20px;
            border-radius: 999px;
            font-weight: 600;
            display: inline-block;
        }

        .typing-text {
            display: inline-block;
            overflow: hidden;
            white-space: nowrap;
            border-right: 2px solid #2A3141;
            width: 0;
            animation:
                typing 5s steps(25, end) infinite,
                blink .8s infinite;
        }

        @keyframes typing {
            0% {
                width: 0;
            }

            40%,
            60% {
                width: 100%;
            }

            100% {
                width: 0;
            }
        }

        @keyframes blink {

            0%,
            50% {
                border-color: #474747;
            }

            51%,
            100% {
                border-color: transparent;
            }
        }

        .highlight-text {
            color: #1c2434;
        }

        .btn-hero-primary {
            background: #2A3141;
            color: white;
            border: none;
            transition: all .3s ease;
        }

        .btn-hero-primary:hover {
            background: #8ED8B5;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(255, 138, 61, .25);
        }

        .btn-hero-secondary {
            /* border: 2px solid #2A3141; */
            background: #FF8A3D;
            color: #ffffff;
            transition: all .3s ease;
        }

        .btn-hero-secondary:hover {
            background: #8ED8B5;
            color: white;
            transform: translateY(-2px);
        }

        /*  Elements Container */
        .stat-number {
            font-size: 1.8rem;
            font-weight: 800;
            color: #2A3141;
        }

        .stat-label {
            font-size: .85rem;
        }

        .hero-illustration {
            position: relative;
            display: inline-block;
        }

        .scroll-indicator {
            position: absolute;
            bottom: -50px;
            left: 50%;
            transform: translateX(-50%);
        }

        .floating-illustration {
            width: 100%;
            max-width: 560px;
            height: auto;
        }

        .floating-card {
            position: absolute;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);

            padding: 8px 14px;
            border-radius: 40px;

            font-size: 0.70rem;
            font-weight: 600;
            color: #2A3141;

            box-shadow:
                0 8px 20px rgba(0, 0, 0, .08),
                0 2px 8px rgba(0, 0, 0, .05);

            border: 1px solid rgba(255, 255, 255, .4);

            transition: all .3s ease;
        }

        .card-1 {
            top: 15%;
            left: 5%;
        }

        .card-2 {
            top: 45%;
            right: 5%;
        }

        .card-3 {
            bottom: 15%;
            left: 12%;
        }

        .scroll-indicator {
            position: absolute;
            bottom: -80px;
            left: 50%;
            transform: translateX(-50%);
        }

        .scroll-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;

            background: rgba(255, 255, 255, .25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, .3);
            border-radius: 999px;

            font-size: .9rem;
            font-weight: 600;
            color: #2A3141;

            animation: floatExplore 2.5s ease-in-out infinite;
        }

        .arrow {
            display: inline-block;
            animation: arrowBounce 1.2s ease-in-out infinite;
        }

        @keyframes floatExplore {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .mouse {
            width: 28px;
            height: 45px;
            border: 2px solid #2A3141;
            border-radius: 20px;
            margin: auto;
            position: relative;
        }

        .wheel {
            width: 4px;
            height: 8px;
            background: #2A3141;
            border-radius: 2px;
            position: absolute;
            top: 8px;
            left: 50%;
            transform: translateX(-50%);
            animation: scroll 2s infinite;
        }

        @keyframes scroll {
            from {
                opacity: 1;
                top: 8px;
            }

            to {
                opacity: 0;
                top: 22px;
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        /* PROBLEM CARDS */

        .problem-section {
            /* margin-top: rem; */
            /* margin-bottom: 5rem; */
            padding-top: 5rem;
        }

        .problem-title {
            margin-top: 2rem;
            font-size: 1.75rem !important;
            color: #2A3141 !important;
            font-weight: 800 !important;
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
            border-radius: 90px;
            margin-top: 1rem;

        }

        .time-wrapper {
            position : relativer;
            margin-top: 3rem;
            margin-bottom: 3.5rem;
        }

        .time-title {
            font-size: 1.75rem !important;
            color: #2A3141 !important;
            font-weight: 800 !important;
            /* margin-top: 1rem !important; */
            padding-bottom: 2rem;
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
            border-radius: 70px;
            padding: 0;
            margin-top: 30px;
        }

        .call-subtitle {
            /* margin-top: 2rem; */
            font-size: 1.75rem !important;
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

            font-size: 0.85rem;
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

@endsection
