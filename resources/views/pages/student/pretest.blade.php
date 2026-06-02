```blade
@extends('layouts.app')

@section('title', 'PreTest - SmartPeak')

@section('content')

    {{-- Custom Modal --}}
    {{-- <div class="modal-overlay" id="customModal">
    <div class="modal-content">
        <div class="modal-icon">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </div>

        <h3 class="modal-title" id="modalTitle">
            Lanjutkan ke Tes
        </h3>

        <p class="modal-message" id="modalMessage">
            Jawaban kamu berhasil disimpan ✨
            Yuk masuk atau daftar terlebih dahulu untuk melanjutkan tes.
        </p>

        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="{{ route('login') }}" class="modal-auth-btn">
                Masuk
            </a>
            <a href="{{ route('auth.register.form') }}" class="modal-auth-btn register">
                Daftar
            </a>
        </div>
    </div>
</div> --}}

    <div class="quiz-wrapper">
        <div class="quiz-content">

            <div class="container">

                {{-- Header --}}
                <div class="text-center mb-4">
                    <h1 class="title-pretest fw-bold text-dark">
                        Yuk Kenali Pola Belajarmu ✨
                    </h1>

                    <p class="subtitle-pretest text-dark fw-medium">
                        Jawabanmu membantu kami memberikan rekomendasi waktu belajar yang lebih personal.
                    </p>
                </div>

                {{-- Question Card --}}
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">

                        <div class="question-card">

                            {{-- Question --}}
                            <h2 class="fw-bold fs-5 mb-4" id="questionText">
                                @if ($questions && count($questions) > 0)
                                    {{ $questions[0]->question_text }}
                                @else
                                    Tidak ada pertanyaan tersedia
                                @endif
                            </h2>
                            {{-- Answer --}}
                            <div id="answerContainer" class="mb-4">
                                {{-- Dynamic --}}
                            </div>
                            {{-- Progress --}}
                            <div class="progress-section mb-4">
                                <span class="progress-counter" id="questionCounter">
                                    1/{{ $totalQuestions }}
                                </span>
                                <div class="progress-bar-wrapper">
                                    <div class="progress-bar-filled" id="progressBarFilled" style="width: 0%">
                                    </div>
                                </div>
                            </div>
                            {{-- Navigation --}}
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn-back" id="prevBtn" onclick="previousQuestion()">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M3 10h10a4 4 0 0 1 4 4v2" />
                                        <polyline points="7 14 3 10 7 6" />
                                    </svg>
                                </button>
                                <button class="btn-next" id="nextBtn" onclick="nextQuestion()">
                                    <span id="nextBtnText">
                                        Selanjutnya
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .quiz-wrapper {
            background-color: #FDC334;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding-top: 85px;
        }

        .quiz-content {
            flex: 1;
            padding: 80px 0;
        }

        .quiz-content .container {
            margin-top: -60;
        }
        

        .title-pretest {
            font-size: 2rem;
        }
        .subtitle-pretest {
            font-size: 1rem;
            line-height:4;
        }
        .question-card {
            background-color: #FFFFFF;
            border-radius: 24px;
            padding: 32px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* OPTION BUTTON */

        .option-btn {
            display: block;
            width: 100%;
            padding: 16px 24px;
            margin-bottom: 12px;
            background-color: #fff;
            border: 2px solid #34d399;
            border-radius: 50px;
            color: #1f2937;
            font-weight: 500;
            font-size: 16px;
            text-align: left;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .option-btn:hover {
            background-color: #b2dfc8;            
        }

        .option-btn.active {
            background-color: #8ED8B5;
            border-color:#34d399;
        }

        /* PROGRESS */

        .progress-counter {
            font-size: 14px;
            color: #4b5563;
            font-weight: 500;
            display: block;
            margin-bottom: 8px;
        }

        .progress-bar-wrapper {
            width: 100%;
            height: 10px;
            background-color: #FA5B19;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar-filled {
            height: 100%;
            background-color: #8ED8B5;
            transition: width 0.3s ease;
        }

        /* NAVIGATION */

        .btn-back {
            background: transparent;
            border: none;
            cursor: pointer;
        }

        .btn-next {
            background-color: #1f2937;
            color: #fff;
            border: none;
            padding: 10px 24px;
            border-radius: 50px;
            font-weight: 500;
        }

        /* MODAL */

        .modal-overlay {
            display: none;
            position: fixed;
            z-index: 9999;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-content {
            background: #1f2937;
            border-radius: 24px;
            padding: 40px;
            width: 90%;
            max-width: 420px;
            text-align: center;
        }

        .modal-title {
            color: white;
            margin-top: 20px;
        }

        .modal-message {
            color: #cbd5e1;
            margin-top: 10px;
        }

        .modal-auth-btn {
            background: white;
            color: #111827;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
        }

        .modal-auth-btn.register {
            background: #10b981;
            color: white;
        }

        .modal-icon {
            width: 70px;
            height: 70px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
        }
    </style>

    <script>
        const questions = @json($questions);
        const totalQuestions = {{ $totalQuestions }};

        let currentQuestion = 0;
        let answers = {};

        document.addEventListener('DOMContentLoaded', () => {
            displayQuestion(0);
            updateNavigation();
        });

        function displayQuestion(index) {

            const question = questions[index];

            currentQuestion = index;

            document.getElementById('questionText').textContent =
                question.question_text;

            document.getElementById('questionCounter').textContent =
                `${index + 1}/${totalQuestions}`;

            renderAnswerOptions(question);

            updateProgressBar();

            updateNavigation();
        }

        function renderAnswerOptions(question) {

            const container = document.getElementById('answerContainer');

            container.innerHTML = '';

            question.option.forEach(option => {

                const button = document.createElement('button');

                button.type = 'button';

                button.className = 'option-btn';

                button.textContent = option;

                button.onclick = () => selectAnswer(question.id, option);

                if (answers[question.id] === option) {
                    button.classList.add('active');
                }

                container.appendChild(button);
            });
        }

        function selectAnswer(questionId, answer) {

            answers[questionId] = answer;

            renderAnswerOptions(
                questions.find(q => q.id === questionId)
            );

            updateProgressBar();

            updateNavigation();
        }

        function nextQuestion() {

            const currentQuestionId = questions[currentQuestion].id;

            if (!answers[currentQuestionId]) {
                alert('Mohon pilih jawaban terlebih dahulu');
                return;
            }

            if (currentQuestion < totalQuestions - 1) {

                displayQuestion(currentQuestion + 1);

            } else {

                submitPretest();
            }
        }

        function previousQuestion() {

            if (currentQuestion > 0) {
                displayQuestion(currentQuestion - 1);
            }
        }

        function updateNavigation() {

            const prevBtn = document.getElementById('prevBtn');

            const nextBtn = document.getElementById('nextBtn');

            const currentQuestionId = questions[currentQuestion].id;

            prevBtn.disabled = currentQuestion === 0;

            nextBtn.disabled = !answers[currentQuestionId];

            document.getElementById('nextBtnText').textContent =
                currentQuestion === totalQuestions - 1 ?
                'Mulai Tes' :
                'Selanjutnya';
        }

        function updateProgressBar() {

            const answeredCount = Object.keys(answers).length;

            const progressPercent =
                (answeredCount / totalQuestions) * 100;

            document.getElementById('progressBarFilled').style.width =
                progressPercent + '%';
        }

        function submitPretest() {

            fetch('/onboarding/submit', {

                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content'),
                        'Accept': 'application/json',
                    },

                    credentials: 'include',

                    body: JSON.stringify({
                        answers: answers
                    })
                })

                .then(response => response.json())

                .then(data => {

                    if (data.success) {

                        // document
                        //     .getElementById('customModal')
                        //     .classList.add('show');

                        window.location.href = data.redirect;

                    } else {

                        alert('Terjadi kesalahan');
                    }
                })

                .catch(error => {
                    console.error(error);
                });
        }
    </script>

@endsection
```
