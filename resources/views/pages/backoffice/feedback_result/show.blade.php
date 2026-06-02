@extends('layouts.backoffice')

@section('title', 'Detail Feedback')

@section('content')

    <div class="container-fluid py-3">
        {{-- Header --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold mb-1">
                            Detail Feedback
                        </h2>
                        <p class="text-muted mb-0">
                            Informasi lengkap hasil feedback pengguna
                        </p>
                    </div>
                    <a href="{{ route('backoffice.feedback_result.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        {{-- Informasi User --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    Informasi Pengguna
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <th width="250">Nama User</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Tes</th>
                        <td>{{ $testDate }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Feedback</th>
                        <td>{{ $feedbackDate }}</td>
                    </tr>

                    <tr>
                        <th>Jam Pintar</th>
                        <td>{{ $jamPintar }}</td>
                    </tr>

                    <tr>
                        <th>Kategori</th>
                        <td>
                            <span class="badge bg-success">
                                {{ $kategori }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        {{-- Jawaban Feedback --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    Jawaban Feedback
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="70">No</th>
                                <th>Pertanyaan</th>
                                <th>Jawaban</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($answers as $index => $answer)
                                <tr>
                                    <td>
                                        {{ $index + 1 }}
                                    </td>

                                    <td>
                                        {{ $answer->question->question_text }}
                                    </td>

                                    <td>
                                        {{ $answer->answer }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="3" class="text-center py-4">

                                        Tidak ada data feedback

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
