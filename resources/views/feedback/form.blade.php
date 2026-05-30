@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #FDC334;
    }
</style>
<div class="container py-5" style="padding-top: 120px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); color: white; padding: 40px 30px; text-align: center;">
                    <h2 class="mb-2 fw-bold">Berikan Feedback Anda</h2>
                    <p class="mb-0" style="opacity: 0.9;">Bantuan Anda sangat berarti untuk kami</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Ada kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <p class="text-muted mb-4">
                        Terima kasih telah menggunakan <strong>Jam Pintar</strong>. Jawab pertanyaan berikut ini untuk membantu kami terus berkembang.
                    </p>

                    <form method="POST" action="{{ route('feedback.submit', ['token' => $invitation->token]) }}" novalidate>
                        @csrf

                        @forelse ($questions as $index => $question)
                            <div class="mb-4">
                                <label for="answer_{{ $question->id }}" class="form-label fw-semibold">
                                    <span style="display: inline-block; background: #F5A623; color: white; width: 30px; height: 30px; border-radius: 50%; text-align: center; line-height: 30px; font-size: 0.9rem; margin-right: 10px;">{{ $index + 1 }}</span>
                                    {{ $question->question_text }}
                                    <span class="text-danger">*</span>
                                </label>
                                
                                @if ($question->answer_type === 'choice' && $question->option)
                                    <div class="option-container" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 12px;">
                                        @foreach ($question->option as $option)
                                            <label class="option-label" style="flex: 1; min-width: 120px;">
                                                <input type="radio" name="answer[{{ $question->id }}]" value="{{ $option }}" {{ old("answer.{$question->id}") === $option || (isset($savedInput["answer"][$question->id]) && $savedInput["answer"][$question->id] === $option) ? 'checked' : '' }} required>
                                                <span style="display: block; padding: 10px 12px; border: 2px solid #ddd; border-radius: 10px; text-align: center; cursor: pointer; transition: all 0.3s;">
                                                    {{ $option }}
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                @else
                                    <textarea
                                        class="form-control @error("answer.{$question->id}") is-invalid @enderror"
                                        id="answer_{{ $question->id }}"
                                        name="answer[{{ $question->id }}]"
                                        rows="4"
                                        placeholder="Tulis jawaban Anda di sini... (minimal 10 karakter)"
                                        required
                                        style="border-radius: 10px; border: 1.5px solid #ddd; font-size: 0.95rem; padding: 12px 15px;">{{ old("answer.{$question->id}") ?? (isset($savedInput["answer"][$question->id]) ? $savedInput["answer"][$question->id] : '') }}</textarea>
                                @endif

                                @error("answer.{$question->id}")
                                    <div class="invalid-feedback d-block mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        @empty
                            <div class="alert alert-info" role="alert">
                                <strong>Tidak ada pertanyaan feedback untuk saat ini.</strong>
                                <p class="mb-0">Admin akan menambahkan pertanyaan feedback segera.</p>
                            </div>
                        @endforelse

                        @if ($questions->count() > 0)
                            <!-- Submit Button -->
                            <div class="d-grid gap-2 mb-3 mt-5">
                                <button type="submit" class="btn btn-lg fw-semibold text-white" style="border-radius: 50px; background: #1a1a2e; font-size: 0.95rem; padding: 12px;">
                                    ✓ Kirim Feedback
                                </button>
                            </div>

                            <p class="text-center text-muted small mb-0">
                                Feedback Anda akan disimpan dengan aman dan membantu kami berkembang lebih baik.
                            </p>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .option-label input[type="radio"] {
        display: none;
    }

    .option-label input[type="radio"]:checked + span {
        background: #F5A623 !important;
        color: white !important;
        border-color: #F5A623 !important;
    }

    .option-label:hover span {
        border-color: #F5A623;
    }
</style>
@endsection
