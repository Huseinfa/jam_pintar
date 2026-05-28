@extends('layouts.backoffice')

@section('title', 'Edit Pertanyaan')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <h4 class="fw-bold mb-4">
            Edit Pertanyaan
        </h4>

        <form action="{{ route('backoffice.questions.update', $question->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Pertanyaan</label>

                <textarea name="question_text"
                          class="form-control"
                          rows="3">{{ $question->question_text }}</textarea>
            </div>
            {{-- question type --}}
            <div class="mb-3">
                <label class="form-label">
                    Question Type
                </label>

                <select name="question_type"
                        class="form-select">

                    <option value="kuisioner"
                        {{ $question->question_type == 'kuisioner' ? 'selected' : '' }}>
                        Kuisioner
                    </option>

                    <option value="feedback"
                        {{ $question->question_type == 'feedback' ? 'selected' : '' }}>
                        Feedback
                    </option>

                    <option value="pretest"
                        {{ $question->question_type == 'pretest' ? 'selected' : '' }}>
                        PreTest
                    </option>

                    {{-- <option value="test"
                        {{ $question->question_type == 'test' ? 'selected' : '' }}>
                        Test
                    </option>

                    <option value="rating"
                        {{ $question->question_type == 'rating' ? 'selected' : '' }}>
                        Rating
                    </option>

                    <option value="post_test"
                        {{ $question->question_type == 'post_test' ? 'selected' : '' }}>
                        Post Test
                    </option> --}}
                </select>
            </div>

            {{-- answer type --}}
            <div class="mb-3">
                <label class="form-label">
                    Answer Type
                </label>

                <select name="answer_type"
                        class="form-select">

                    <option value="choice"
                        {{ $question->answer_type == 'choice' ? 'selected' : '' }}>
                        Choice
                    </option>

                    <option value="essay"
                        {{ $question->answer_type == 'essay' ? 'selected' : '' }}>
                        Essay
                    </option>

                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Options</label>

                <input type="text"
                       name="option"
                       class="form-control"
                       value="{{ is_array($question->option) ? implode(',', $question->option) : '' }}">
            </div>

            <button class="btn btn-primary">
                Update
            </button>

        </form>

    </div>
</div>

@endsection