@extends('layouts.backoffice')

@section('title', 'Detail User')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-semibold">Detail User - {{ $user->name }}</h4>
        <div>
            <a href="{{ route('backoffice.users.export.user', $user->id) }}" class="btn btn-sm btn-success">Export User (CSV)</a>
            <a href="{{ route('backoffice.users.export.user.pdf', $user->id) }}" class="btn btn-sm btn-primary ms-2">Export PDF</a>
            <a href="{{ route('backoffice.users') }}" class="btn btn-sm btn-secondary ms-2">Kembali</a>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
                <p><strong>Nama:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Jenis Kelamin:</strong> {{ $user->gender ?? '-' }}</p>
                <p><strong>Github:</strong> {{ $user->github_username ?? '-' }}</p>
                @php
                    $cityName = '-';
                    // prefer explicit name stored in JSON or related city record
                    if (!empty($user->city) && is_string($user->city)) {
                        $decoded = json_decode($user->city);
                        if ($decoded && isset($decoded->name)) {
                            $cityName = trim($decoded->name);
                        } elseif ($decoded && isset($decoded->type)) {
                            $cityName = trim($decoded->type);
                        } else {
                            $cityName = $user->city;
                        }
                    }

                    if (method_exists($user, 'city')) {
                        try {
                            $cityModel = $user->city()->first();
                            if ($cityModel && !empty($cityModel->name)) {
                                $cityName = trim($cityModel->name);
                            }
                        } catch (\Throwable $e) {
                            // ignore
                        }
                    }
                @endphp
                <p><strong>Kota:</strong> {{ $cityName }}</p>
            </div>
    </div>

    <h5>Test Attempts</h5>
    <div class="table-responsive">
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th>Attempt ID</th>
                    <th>Started</th>
                    <th>Finished</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                @forelse($user->testAttempts as $attempt)
                    <tr>
                        <td>{{ $attempt->id }}</td>
                        <td>{{ optional($attempt->started_at)->toDateTimeString() }}</td>
                        <td>{{ optional($attempt->finished_at)->toDateTimeString() }}</td>
                        <td>
                            @if($attempt->result && $attempt->result->recommendation)
                                @php $rec = $attempt->result->recommendation; @endphp
                                <div class="mb-1">
                                    <span class="badge bg-light text-dark">{{ strtoupper($rec->preferred_study_time ?? $rec->prefered_study_time ?? '-') }}</span>
                                </div>
                                <div class="small text-muted">
                                    Jam: {{ $rec->study_hour_start ? \Carbon\Carbon::parse($rec->study_hour_start)->format('H:i') : '-' }} - {{ $rec->study_hour_end ? \Carbon\Carbon::parse($rec->study_hour_end)->format('H:i') : '-' }}
                                </div>
                                <div class="small text-muted">
                                    Alternatif: @if($rec->alt_study_hour_start && $rec->alt_study_hour_end) {{ \Carbon\Carbon::parse($rec->alt_study_hour_start)->format('H:i') }} - {{ \Carbon\Carbon::parse($rec->alt_study_hour_end)->format('H:i') }} @else - @endif
                                </div>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Tidak ada test attempts</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
