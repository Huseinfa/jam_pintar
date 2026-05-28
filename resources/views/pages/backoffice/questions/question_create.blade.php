@extends('layouts.backoffice')
@section('title', 'Tambah Pertanyaan')
@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="fw-bold mb-4">Tambah Pertanyaan</h4>
        <form action="{{ route('backoffice.questions.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Pertanyaan</label>
                <textarea name="question_text" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Question Type</label>
                <select name="question_type" class="form-select">
                    <option value="kuisioner">Kuisioner</option>
                    <option value="feedback">Feedback</option>
                    <option value="pretest">PreTest</option>
                    {{-- <option value="test">Test</option>
                    <option value="rating">Rating</option>
                    <option value="post_test">Post Test</option> --}}
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Answer Type</label>
                <select name="answer_type" class="form-select">
                    <option value="choice">Choice</option>
                    <option value="essay">Essay</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Options</label>
                <input type="text" name="option" class="form-control" placeholder="Pisahkan dengan koma">
            </div>
            <button class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection