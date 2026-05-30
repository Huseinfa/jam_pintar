@extends('layouts.backoffice')
@section('title', 'Edit Kota')
@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="fw-bold mb-4">Edit Kota</h4>
        <form action="{{ route('backoffice.cities.update', $city) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Nama Kota <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $city->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tipe</label>
                        <input type="text" name="type" class="form-control @error('type') is-invalid @enderror" value="{{ old('type', $city->type) }}" placeholder="e.g. Kota, Kabupaten">
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Provinsi</label>
                        <input type="text" name="province" class="form-control @error('province') is-invalid @enderror" value="{{ old('province', $city->province) }}">
                        @error('province')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Kode Kabupaten</label>
                <input type="text" name="regency_code" class="form-control @error('regency_code') is-invalid @enderror" value="{{ old('regency_code', $city->regency_code) }}">
                @error('regency_code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Perbarui
                </button>
                <a href="{{ route('backoffice.cities') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
