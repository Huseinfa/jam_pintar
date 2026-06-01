@extends('layouts.backoffice')

@section('content')
<div class="container-fluid">

    {{-- =========================
        SECTION 1: LANDING PAGE
    ========================== --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">Manajemen Konten Landing Page</h2>
                <p class="text-muted mb-0">
                    Kelola konten yang ditampilkan pada landing page pengguna
                </p>
            </div>

            <a href="{{ route('backoffice.contents.create') }}" class="btn btn-primary">
                + Tambah Konten
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-5">
        <div class="card-body">

            {{-- FILTER --}}
            <div class="mb-3">
                <label class="form-label">Filter Type:</label>
                <select id="filterLanding" class="form-select" style="width:200px;">
                    <option value="">Semua</option>
                    <option value="carousel">Carousel</option>
                    <option value="intro">Intro</option>
                </select>
            </div>

            <div class="table-responsive">
                <table id="tableLanding" class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Text</th>
                            <th>Image</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contents as $content)
                            @if(in_array($content->type, ['carousel','intro']))
                            <tr>
                                <td class="text-center">{{ $content->id }}</td>
                                <td>{{ $content->title }}</td>
                                <td class="text-center">{{ $content->type }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($content->text, 50) }}</td>
                                <td class="text-center">
                                    @if ($content->image)
                                        <img src="{{ asset('storage/' . $content->image) }}" width="80" class="img-thumbnail">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('backoffice.contents.edit', $content->id) }}" class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('backoffice.contents.destroy', $content->id) }}" 
                                          method="POST" 
                                          style="display:inline;"
                                          onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>


    {{-- =========================
    SECTION 2: REKOMENDASI
    ========================= --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h2 class="fw-bold mb-1">Manajemen Rekomendasi Belajar</h2>
            <p class="text-muted mb-0">
                Kelola jadwal dan rekomendasi waktu belajar pengguna
            </p>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

        <div class="table-responsive">
            <table id="tableRekomendasi" class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Preferred Time</th>
                        <th class="text-center">Study Time</th>
                        <th class="text-center">Alternative</th>
                        <th class="text-center">Recommendation</th>
                        <th class="text-center" style="width: 150px;">Aksi</th> </tr>
                </thead>
                <tbody>
                    @foreach ($recommendations as $rec)
                    <tr>
                        <td class="text-center">{{ $rec->id }}</td> <td class="text-start">
                            {{ $rec->prefered_study_time }}
                        </td>

                        <td class="text-start">
                            {{ $rec->study_hour_start }} - {{ $rec->study_hour_end }}
                        </td>

                        <td class="text-start">
                            @if($rec->alt_study_hour_start && $rec->alt_study_hour_end)
                                {{ $rec->alt_study_hour_start }} - {{ $rec->alt_study_hour_end }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td class="text-start">
                            {{ \Illuminate\Support\Str::limit($rec->recomendation, 80) }}
                        </td>
                        
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-warning" title="Edit">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <button class="btn btn-sm btn-danger" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        </div>
    </div>

{{-- =========================
    DATATABLE SCRIPT
========================= --}}
@push('scripts')
<script>
$(document).ready(function() {

    // Landing Table
    let tableLanding = $('#tableLanding').DataTable({
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
    });

    // Filter Landing
    $('#filterLanding').on('change', function() {
        tableLanding.column(2).search(this.value).draw();
    });

    // Rekomendasi Table
    $('#tableRekomendasi').DataTable({
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
    });

});
</script>
@endpush

@endsection