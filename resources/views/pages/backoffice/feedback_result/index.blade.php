@extends('layouts.backoffice')
@section('title', 'Feedback Result')

@section('content')

    <div class="container-fluid py-3">

        {{-- Header --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold mb-1">
                            Feedback Result
                        </h2>
                        <p class="text-muted mb-0">
                            Hasil evaluasi dan umpan balik pengguna SmartPeak
                        </p>
                    </div>

                    <a href="{{ route('backoffice.feedback_result.export') }}" class="btn btn-success">
                        <i class="bi bi-download"></i>
                        Export Data

                    </a>

                </div>

            </div>

        </div>

        {{-- Alert --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">

                {{ session('success') }}

                <button class="btn-close" data-bs-dismiss="alert">
                </button>

            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button class="btn-close" data-bs-dismiss="alert">
                </button>

            </div>
        @endif

        {{-- Card --}}
        <div class="card shadow-sm border-0">

            <div class="card-body">

                {{-- Filter --}}
                <div class="row mb-3">
                    <div class="col-md-6 d-flex align-items-center gap-2">
                        <label>Show</label>
                        <form method="GET">
                            <select class="form-select form-select-sm" onchange="updatePerPage(this.value)"
                                style="width:90px">

                                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>
                                    10
                                </option>

                                <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>
                                    25
                                </option>

                                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>
                                    50
                                </option>

                                <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>
                                    100
                                </option>

                                <option value="all" {{ $perPage == 'all' ? 'selected' : '' }}>
                                    All
                                </option>

                            </select>
                        </form>
                        <label>entries</label>
                    </div>
                    <div class="col-md-6 text-end">
                        <form method="GET" id="searchForm">
                            <input type="hidden" name="per_page" value="{{ $perPage }}">
                            <input type="text" class="form-control form-control-sm d-inline" id="searchInput"
                                name="search" value="{{ $search }}" placeholder="Cari nama pengguna..."
                                style="max-width:250px" autocomplete="off">

                        </form>

                    </div>

                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nama User</th>
                                <th>Jam Pintar</th>
                                <th>Kategori</th>
                                <th>Tanggal Feedback</th>
                                <th>Status</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($feedbacks as $feedback)
                                @php

                                    $feedbackAnswers = $feedback->answers->filter(
                                        fn($answer) => $answer->question &&
                                            $answer->question->question_type === 'feedback',
                                    );

                                    $scores = $feedbackAnswers
                                        ->pluck('answer')
                                        ->filter(fn($value) => is_numeric($value));

                                    $average = $scores->count() ? round($scores->avg(), 1) : null;

                                @endphp

                                <tr>

                                    <td>
                                        {{ $feedback->id }}
                                    </td>
                                    <td>
                                        {{ $feedback->user->name ?? '-' }}
                                    </td>
                                    <td>
                                        @if ($feedback->result && $feedback->result->recommendation)
                                            {{ \Carbon\Carbon::parse($feedback->result->recommendation->study_hour_start)->format('H:i') }}
                                            -
                                            {{ \Carbon\Carbon::parse($feedback->result->recommendation->study_hour_end)->format('H:i') }}
                                        @else
                                            -
                                        @endif

                                    </td>

                                    <td>
                                        {{ $feedback->result->recommendation->prefered_study_time ?? '-' }}
                                    </td>
                                    <td>

                                        {{ $feedback->updated_at->format('d M Y') }}

                                    </td>

                                    <td>

                                        @if (is_null($average))
                                            <span class="badge bg-secondary">
                                                Belum Dinilai
                                            </span>
                                        @elseif($average >= 4)
                                            <span class="badge bg-success">
                                                Efektif
                                            </span>
                                        @elseif($average >= 3)
                                            <span class="badge bg-warning text-dark">
                                                Cukup Efektif
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                Kurang Efektif
                                            </span>
                                        @endif

                                    </td>

                                    <td>

                                        <a href="{{ route('backoffice.feedback_result.show', $feedback->test_attempt_id) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        Belum ada data feedback
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- Pagination --}}
                @if ($perPage != 'all' && method_exists($feedbacks, 'links'))
                    <div class="d-flex justify-content-between align-items-center mt-3">

                        <small class="text-muted">
                            Menampilkan
                            {{ $feedbacks->firstItem() }}
                            -
                            {{ $feedbacks->lastItem() }}
                            dari
                            {{ $feedbacks->total() }}
                        </small>

                        {{ $feedbacks->appends(request()->query())->links('pagination::bootstrap-5') }}

                    </div>
                @endif

            </div>

        </div>

    </div>

    <script>
        function updatePerPage(value) {
            let url =
                new URL(window.location);

            url.searchParams.set(
                'per_page',
                value
            );

            window.location.href =
                url;
        }
    </script>

    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function() {
                const searchInput =
                    document.getElementById(
                        'searchInput'
                    );
                const searchForm =
                    document.getElementById(
                        'searchForm'
                    );
                let timer;
                searchInput.addEventListener(
                    'keyup',
                    function() {
                        clearTimeout(timer);
                        timer =
                            setTimeout(() => {
                                searchForm.submit();
                            }, 400);
                    });
            });
    </script>

@endsection
