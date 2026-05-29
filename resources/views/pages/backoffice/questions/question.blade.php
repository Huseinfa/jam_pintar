@extends('layouts.backoffice')
@section('title', 'Backoffice')
@section('content')
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h2 class="fw-bold mb-1">
                Manajemen Question
            </h2>
            <p class="text-muted mb-0">
                Kelola data pertanyaan kuisioner dan feedback
            </p>
        </div>
    </div>

    {{-- Card Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-end mb-4">
                <a href="{{ route('backoffice.question.create') }}" class="btn btn-primary shadow-sm">
                    <i class="bi bi-plus-circle me-1"></i>
                    Tambah Pertanyaan
                </a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">ID</th>
                            <th>Pertanyaan</th>
                            <th width="180">Question Type</th>
                            <th width="180">Answer Type</th>
                            <th width="180">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($questions as $question)
                            <tr>
                                <td>
                                    {{ $question->id }}
                                </td>
                                <td>
                                    <div class="fw-semibold">
                                        {{ $question->question_text }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                        {{ ucfirst($question->question_type) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-success-subtle text-success px-3 py-2">
                                        {{ ucfirst($question->answer_type) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        {{-- show  --}}
                                        <a href="{{ route('backoffice.question.show', $question->id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        {{-- Edit --}}
                                        <a href="{{ route('backoffice.question.edit', $question->id) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        {{-- Delete --}}
                                        <form action="{{ route('backoffice.question.destroy', $question->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-delete"
                                                data-question="{{ $question->question_text }}"><i
                                                    class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    Belum ada data question
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-4">
                <small class="text-muted">
                    Menampilkan
                    {{ $questions->firstItem() }}
                    -
                    {{ $questions->lastItem() }}
                    dari
                    {{ $questions->total() }}
                    data question
                </small>
                {{ $questions->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
