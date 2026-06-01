@extends('layouts.backoffice')
@section('title', 'Detail Kota')
@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Detail Kota</h4>
            <div>
                <a href="{{ route('backoffice.cities.edit', $city) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('backoffice.cities') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label fw-bold">ID</label>
                    <p>{{ $city->id }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Kota</label>
                    <p>{{ $city->name }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Tipe</label>
                    <p>{{ $city->type ?? '-' }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Provinsi</label>
                    <p>{{ $city->province ?? '-' }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label fw-bold">Kode Kabupaten</label>
                    <p>{{ $city->regency_code ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Dibuat Pada</label>
                    <p>{{ $city->created_at->format('d-m-Y H:i') }}</p>
                </div>
            </div>
        </div>

        <hr>

        <div class="mt-3">
            <form action="{{ route('backoffice.cities.destroy', $city) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kota ini?')">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
