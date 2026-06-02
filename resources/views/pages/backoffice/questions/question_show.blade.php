@extends('layouts.backoffice')
@section('title', 'Edit Pertanyaan')
@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <h4 class="fw-bold mb-4">
            Detail Pertanyaan
        </h4>

        <div class="mb-3">
            <label class="form-label">Pertanyaan</label>
            <textarea class="form-control" rows="3" readonly>{{ $question->question_text }}</textarea>
        </div>  
        <div class="mb-3">
            <label class="form-label">Question Type</label>
            <input type="text" class="form-control" value="{{ ucfirst($question->question_type) }}" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Answer Type</label>
            <input type="text" class="form-control" value="{{ ucfirst($question->answer_type) }}" readonly>
        </div>  
        @if ($question->option)
            <div class="mb-3">
                <label class="form-label">Options</label>
                <input type="text" class="form-control" value="{{ is_array($question->option) ? implode(', ', $question->option) : '' }}" readonly>
            </div>
        @endif
        <a href="{{ route('backoffice.question') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>
</div>
@endsection