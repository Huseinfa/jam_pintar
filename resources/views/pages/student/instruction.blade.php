@extends('layouts.app')

@section('title', 'SmartPeak')

@section('content')

    <section class="instruction-section d-flex align-items-center justify-content-center">
        <div class="container instruction-wrapper text-center">
            <div class="instruction-content mx-auto">

                <h4 class="fw-bold instruction-title mb-4">
                    Intruksi Pengerjaan Tes
                </h4>

                <p class="instruction-subtitle mb-4">
                    Tes ini bertujuan untuk mengetahui waktu terbaik kamu dalam belajar berdasarkan pola fokus dan ritme
                    alami tubuhmu.
                </p>

                {{-- CARD --}}
                <div class="card-instruction-content mx-auto">
                    <div class="d-flex justify-content-center gap-4 flex-wrap">
                        <div class="card instruction-card card-1">
                            <img src="{{ asset('img/instruction1.png') }}" class="card-img-top instruction-img">
                            <div class="card-body">
                                <p class="card-text">
                                    Siapkan diri dalam kondisi santai, rileks, fokus, dan bebas gangguan biar ngerjainnya
                                    nyaman.
                                </p>
                            </div>
                        </div>
                        <div class="card instruction-card card-2">
                            <img src="{{ asset('img/instruction2.png') }}" class="card-img-top instruction-img">
                            <div class="card-body">
                                <p class="card-text ">
                                    Baca setiap pertanyaan dengan teliti, karena tidak bisa diulang jadi pastikan sebelum
                                    lanjut.
                                </p>
                            </div>
                        </div>
                        <div class="card instruction-card card-3">
                            <img src="{{ asset('img/instruction3.png') }}" class="card-img-top instruction-img">
                            <div class="card-body">
                                <p class="card-text">
                                    Jawab dengan jujur dan apa adanya, pilih jawaban yang paling menggambarkan dirimu.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="instruction-footer mb-4">
                    Jika sudah siap, Klik Mulai Tes dibawah ini ya!
                </p>

                <button type="button" class="btn btn-mulai rounded-pill px-4"
                    onclick="window.location='{{ route('student.test') }}'">
                    Mulai Tes
                </button>

            </div>
    </section>


    <style>
        .instruction-section {
            min-height: 100vh;
            background-color: #FFF8E8;
            margin-top: 60px;
        }

        .instruction-section {}

        .instruction-title {}

        .instruction-subtitle {
            padding-bottom: 2rem;
            font-size: 1rem;
        }

        .instruction-card {
            width: 19rem;
            border-radius: 12%;
            transition: all 0.3s ease;
            transform: scale(1);
        }

        
        .instruction-card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        .instruction-img {
            width: 40%;
            margin: 1rem auto 0 auto
        }

        .instruction-card p {
            font-size: 0.8rem;
            font-weight: 500;
        }

        .card-1 {
            background-color: #FDC334;
            border: 1.5px solid #2A3141;
        }

        .card-2 {
            background-color: #F14803;
            border: 1.5px solid #2A3141;
        }

        .card-3 {
            background-color: #8ED8B5;
            border: 1.5px solid #2A3141;
        }

        .instruction-footer {
            padding-top: 3rem;
            font-size: 1rem;
        }
        
        /* Button */
        .btn-mulai {
            background-color: #2A3141;
            color: #fff;
            font-weight: 500;
            font-size: 14px !important;
            transition: all 0.25s ease;
            margin-top: 1rem;
            padding: 12px 28px;
        }

        .btn-mulai:hover {
            background-color: #ffffff !important;
            color: #1f2a3e !important;
            border: 1.5px solid #1f2a3e !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
        }

        .btn-mulai:hover {
            background-color: #1b2230;
            transform: translateY(-2px);
            color: #fff;
        }

    </style>

@endsection
