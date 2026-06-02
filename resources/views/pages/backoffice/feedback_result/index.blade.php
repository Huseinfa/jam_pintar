@extends('layouts.backoffice')

@section('title', 'Feedback Result')

@section('content')
    <div class="container-fluid py-3">

        {{-- Header --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">Feedback Result</h2>
                    <p class="text-muted mb-0">
                        Hasil evaluasi dan umpan balik pengguna SmartPeak
                    </p>
                </div>

                <a href="{{ route('backoffice.feedback_result.export') }}" class="btn btn-export">
                    <i class="bi bi-download"></i> Export Data
                </a>
            </div>
        </div>

        {{-- Alert --}}
        @foreach (['success' => 'success', 'error' => 'danger'] as $msg => $type)
            @if (session($msg))
                <div class="alert alert-{{ $type }} alert-dismissible fade show">
                    {{ session($msg) }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        @endforeach

        {{-- Card --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">

                {{-- Filter --}}
                <div class="row mb-3 align-items-center">

                    <div class="col-md-6 d-flex align-items-center gap-2">
                        <label class="mb-0">Show</label>

                        <select class="form-select form-select-sm" onchange="updatePerPage(this.value)" style="width:90px">
                            @foreach ([10, 25, 50, 100, 'all'] as $size)
                                <option value="{{ $size }}" {{ $perPage == $size ? 'selected' : '' }}>
                                    {{ strtoupper($size) }}
                                </option>
                            @endforeach
                        </select>

                        <label class="mb-0">entries</label>
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
                                <th>No</th>
                                <th>Nama User</th>
                                <th>Jam Pintar</th>
                                <th>Kategori</th>
                                <th>Tanggal</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($feedbacks as $feedback)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $feedback->user->name ?? '-' }}</td>

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
                                        <a href="{{ route('backoffice.feedback_result.show', $feedback) }}"
                                            class="btn btn-aksi btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
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
                            Menampilkan {{ $feedbacks->firstItem() }} - {{ $feedbacks->lastItem() }}
                            dari {{ $feedbacks->total() }}
                        </small>

                        {{ $feedbacks->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                @endif

            </div>
        </div>

    </div>

    {{-- STYLE --}}
    <style>
        .btn-aksi {
            background-color: #FDC334;
            color: #fff;
            border: none;
        }

        .btn-aksi:hover {
            background-color: #d49f18;
            color: #fff;
        }

        .btn-export {
            background-color: #74cca3;
            color: #fff;
            border: 1.5px solid #2fd487;
        }

        .btn-export:hover {
            background-color: #48a57a;
            color: #fff;
        }
    </style>

    {{-- SCRIPT --}}
    <script>
        function updatePerPage(value) {
            const url = new URL(window.location);
            url.searchParams.set('per_page', value);
            window.location.href = url;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchForm = document.getElementById('searchForm');

            let timer;

            searchInput.addEventListener('keyup', function() {
                clearTimeout(timer);
                timer = setTimeout(() => searchForm.submit(), 400);
            });
        });
    </script>

@endsection
