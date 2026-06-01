@extends('layouts.app')

@section('title', 'Quiz - SmartPeak')

@section('content')
{{-- Custom Modal --}}
<div class="modal-overlay" id="customModal">
    <div class="modal-content">
        <div class="modal-icon">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </div>
        <h3 class="modal-title" id="modalTitle">Berhasil</h3>
        <p class="modal-message" id="modalMessage">Test berhasil diserahkan! Terima kasih.</p>
        <button class="modal-btn" id="modalBtn" onclick="closeModal()">OK</button>
    </div>
</div>

{{-- Main Content dengan Background Kuning Full --}}
<div class="quiz-wrapper">
    <div class="quiz-content">
        <div class="container">
            {{-- Header --}}
            <h1 class="text-center text-dark fw-bold fs-4 mb-4">
                Silakan jawab pertanyaan di bawah ini ya!
            </h1>

            {{-- Question Card --}}
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="question-card">
                        {{-- Question Text --}}
                        <h2 class="fw-bold fs-5 mb-4" id="questionText">
                            @if($questions && count($questions) > 0)
                                {{ $questions[0]->question_text }}
                            @else
                                Tidak ada pertanyaan tersedia
                            @endif
                        </h2>

                        {{-- Answer Options --}}
                        <div id="answerContainer" class="mb-4">
                            {{-- Diisi oleh JavaScript --}}
                        </div>

                        {{-- Progress Section --}}
                        <div class="progress-section mb-4">
                            <span class="progress-counter" id="questionCounter">1/{{ $totalQuestions }}</span>
                            <div class="progress-bar-wrapper">
                                <div class="progress-bar-filled" id="progressBarFilled" style="width: 0%;"></div>
                            </div>
                        </div>

                        {{-- Navigation --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn-back" id="prevBtn" onclick="previousQuestion()">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 10h10a4 4 0 0 1 4 4v2"/>
                                    <polyline points="7 14 3 10 7 6"/>
                                </svg>
                            </button>

                            <button class="btn-next" id="nextBtn" onclick="nextQuestion()">
                                <span id="nextBtnText">Selanjutnya</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Reset untuk memastikan background kuning full */
    html, body {
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
        background-color: #FDC334;
    }

    .question-card {
        background-color: #FFFFFF;
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Custom Modal Styles */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal-content {
        background-color: #1e293b;
        border-radius: 20px;
        padding: 40px 50px;
        text-align: center;
        max-width: 400px;
        width: 90%;
        animation: modalFadeIn 0.3s ease;
    }

    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .modal-icon {
        width: 70px;
        height: 70px;
        background-color: #ffffff;
        border: 3px solid #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .modal-icon svg {
        color: #000000;
    }

    .modal-title {
        color: #ffffff;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .modal-message {
        color: #94a3b8;
        font-size: 14px;
        margin-bottom: 28px;
        line-height: 1.5;
    }

    .modal-btn {
        background-color: #ffffff;
        color: #1e293b;
        border: none;
        padding: 12px 50px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .modal-btn:hover {
        background-color: #f1f5f9;
        transform: scale(1.02);
    }

    /* Option Button Styles - Text */
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
        background-color: #d1fae5;
    }

    .option-btn.active {
        background-color: #d1fae5;
        border-color: #059669;
    }

    /* Image Choice Styles - Grid 2x2 */
    .image-choice-container {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }

    .image-choice {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        cursor: pointer;
    }

    .image-choice .radio-circle {
        width: 20px;
        height: 20px;
        min-width: 20px;
        border: 2px solid #d1d5db;
        border-radius: 50%;
        margin-top: 8px;
        transition: all 0.2s ease;
        position: relative;
    }

    .image-choice.active .radio-circle {
        border-color: #10b981;
    }

    .image-choice.active .radio-circle::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 10px;
        height: 10px;
        background-color: #10b981;
        border-radius: 50%;
    }

    .image-choice .image-wrapper {
        flex: 1;
        border-radius: 12px;
        overflow: hidden;
        border: 3px solid transparent;
        transition: all 0.3s ease;
    }

    .image-choice:hover .image-wrapper {
        border-color: #d1d5db;
    }

    .image-choice.active .image-wrapper {
        border-color: #10b981;
    }

    .image-choice img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        display: block;
    }

    /* Progress Section */
    .progress-section {
        margin-top: 24px;
    }

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
        border-radius: 4px;
    }

    /* Navigation Buttons */
    .btn-back {
        background: transparent;
        border: none;
        color: #374151;
        cursor: pointer;
        padding: 8px;
        transition: color 0.2s ease;
    }

    .btn-back:hover {
        color: #111827;
    }

    .btn-back:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }

    .btn-next {
        background-color: #1f2937;
        color: #fff;
        border: none;
        padding: 10px 24px;
        border-radius: 50px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .btn-next:hover {
        background-color: #374151;
    }

    .btn-next:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Responsive */
    @media (max-width: 576px) {
        .image-choice-container {
            grid-template-columns: 1fr;
        }
        
        .image-choice img {
            height: 140px;
        }

        .modal-content {
            padding: 30px 25px;
        }
    }
</style>

<script>
    const questions = @json($questions);
    const totalQuestions = {{ $totalQuestions }};
    const userId = {{ Auth::check() ? Auth::user()->id : 'null' }};  // ← User ID dari Blade
    let currentQuestion = 0;
    let answers = {};
    let modalCallback = null;

    document.addEventListener('DOMContentLoaded', function() {
        displayQuestion(0);
        updateNavigation();
    });

    // Custom Modal Functions
    function showModal(title, message, buttonText = 'OK', callback = null) {
        document.getElementById('modalTitle').textContent = title;
        document.getElementById('modalMessage').textContent = message;
        document.getElementById('modalBtn').textContent = buttonText;
        document.getElementById('customModal').classList.add('show');
        modalCallback = callback;
    }

    function closeModal() {
        document.getElementById('customModal').classList.remove('show');
        if (modalCallback) {
            modalCallback();
            modalCallback = null;
        }
    }

    function displayQuestion(index) {
        const question = questions[index];
        currentQuestion = index;

        document.getElementById('questionText').textContent = question.question_text;
        document.getElementById('questionCounter').textContent = `${index + 1}/${totalQuestions}`;

        renderAnswerOptions(question);
        updateProgressBar();
        updateNavigation();

        if (answers[question.id]) {
            selectAnswer(question.id, answers[question.id]);
        }
    }

    function renderAnswerOptions(question) {
        const container = document.getElementById('answerContainer');
        container.innerHTML = '';

        if (!question.option || question.option.length === 0) {
            container.innerHTML = '<p class="text-danger">Opsi jawaban tidak tersedia</p>';
            return;
        }

        const isImageUrl = (str) => {
            if (typeof str !== 'string') return false;
            return /\.(jpg|jpeg|png|gif|webp)$/i.test(str) || str.startsWith('/img/') || str.includes('unsplash.com') || str.startsWith('http');
        };

        const isImageQuestion = question.answer_type === 'image' || question.option.every(opt => isImageUrl(opt));

        if (!isImageQuestion) {
            question.option.forEach((option) => {
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
        } else {
            const imageContainer = document.createElement('div');
            imageContainer.className = 'image-choice-container';

            question.option.forEach((imageUrl, index) => {
                const choiceDiv = document.createElement('div');
                choiceDiv.className = 'image-choice';
                choiceDiv.setAttribute('data-value', imageUrl);
                choiceDiv.onclick = () => selectAnswer(question.id, imageUrl);

                const radioCircle = document.createElement('div');
                radioCircle.className = 'radio-circle';

                const imageWrapper = document.createElement('div');
                imageWrapper.className = 'image-wrapper';

                const img = document.createElement('img');
                img.src = imageUrl;
                img.alt = `Option ${index + 1}`;
                img.onerror = function() {
                    this.src = '/img/placeholder.png';
                };

                imageWrapper.appendChild(img);
                choiceDiv.appendChild(radioCircle);
                choiceDiv.appendChild(imageWrapper);

                if (answers[question.id] === imageUrl) {
                    choiceDiv.classList.add('active');
                }
                imageContainer.appendChild(choiceDiv);
            });
            container.appendChild(imageContainer);
        }
    }

    function updateProgressBar() {
        const answeredCount = Object.keys(answers).length;
        const progressPercent = (answeredCount / totalQuestions) * 100;
        document.getElementById('progressBarFilled').style.width = progressPercent + '%';
    }

    function selectAnswer(questionId, answer) {
        answers[questionId] = answer;
        renderAnswerOptions(questions.find(q => q.id === questionId));
        updateProgressBar();
        updateNavigation();
    }

    function nextQuestion() {
        const currentQuestionId = questions[currentQuestion].id;
        if (!answers[currentQuestionId]) {
            showModal('Peringatan', 'Mohon pilih jawaban untuk pertanyaan ini', 'OK');
            return;
        }

        if (currentQuestion < totalQuestions - 1) {
            displayQuestion(currentQuestion + 1);
        } else {
            submitTest();
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
            currentQuestion === totalQuestions - 1 ? 'Selesai' : 'Selanjutnya';
    }

    function submitTest() {
        if (Object.keys(answers).length < totalQuestions) {
            showModal('Peringatan', 'Mohon jawab semua pertanyaan sebelum submit', 'OK');
            return;
        }

        // Ubah format jawaban dari {question_id: answer} ke API format
        const formattedAnswers = {};
        Object.keys(answers).forEach(questionId => {
            formattedAnswers[questionId] = answers[questionId];
        });

        // Debug log
        console.log('Submitting test with:', {
            userId: userId,
            answerCount: Object.keys(formattedAnswers).length,
            csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ? '✓' : '✗'
        });

        // Kirim ke web route dengan CSRF protection
        fetch('/student/test/submit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            credentials: 'include',  // ← PENTING: Kirim session cookies
            body: JSON.stringify({
                user_id: userId,  // ← Kirim user_id dari Blade
                answers: formattedAnswers
            })
        })
        .then(response => {
            console.log('API Response status:', response.status);
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || `HTTP error! status: ${response.status}`);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('API Success:', data);
            if (data.success) {
                // showModal('Berhasil', 'Test berhasil diserahkan! Terima kasih.', 'OK', function() {
                    // Redirect setelah modal ditutup
                    // window.location.href = '{{ route("dashboard") }}';
                    // redirect ke halaman hasil rekomendasi untuk test attempt yang baru saja dibuat
                    
                // });
                showModal(
                    'Berhasil',
                    'Test berhasil diserahkan! Terima kasih.',
                    'OK',
                    function() {

                        window.location.href = `/result/${data.attempt_id}`;

                    }
                );
            } else {
                showModal('Error', data.message || 'Terjadi kesalahan saat submit test', 'OK');
            }
        })
        .catch(error => {
            console.error('Fetch Error:', error);
            showModal('Error', 'Terjadi kesalahan: ' + error.message, 'OK');
        });
    }
</script>
@endsection