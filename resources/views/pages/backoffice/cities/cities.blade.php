@extends('layouts.backoffice')
@section('title', 'Manajemen Kota')

@section('content')

<div class="container-fluid py-3">

    {{-- Header --}}
{{-- Header Card --}}
<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center">

            <div>
                <h2 class="fw-bold mb-1">
                    Manajemen Kota
                </h2>

                <p class="text-muted mb-0">
                    Kelola data kota dan informasi lokasi
                </p>
            </div>

            <a href="{{ route('backoffice.cities.create') }}"
                class="btn btn-primary">

                <i class="bi bi-plus-circle"></i>
                Tambah Kota

            </a>

        </div>

    </div>

</div>


    {{-- Alert --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button class="btn-close"
            data-bs-dismiss="alert"></button>
    </div>
    @endif


    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button class="btn-close"
            data-bs-dismiss="alert"></button>
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

                        <select
                            class="form-select form-select-sm"
                            onchange="updatePerPage(this.value)"
                            style="width:90px"
                        >
                            <option value="10" {{ $perPage==10?'selected':'' }}>10</option>
                            <option value="25" {{ $perPage==25?'selected':'' }}>25</option>
                            <option value="50" {{ $perPage==50?'selected':'' }}>50</option>
                            <option value="100" {{ $perPage==100?'selected':'' }}>100</option>
                            <option value="all" {{ $perPage=='all'?'selected':'' }}>All</option>
                        </select>

                    </form>

                    <label>entries</label>

                </div>

                <div class="col-md-6 text-end">

                <form method="GET" id="searchForm">

                    <input
                        type="hidden"
                        name="per_page"
                        value="{{ $perPage }}"
                    >

                    <input
                        type="text"
                        class="form-control form-control-sm d-inline"
                        id="searchInput"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari kota..."
                        style="max-width:250px"
                        autocomplete="off"
                    >

                </form>

                </div>

            </div>


            {{-- Tabel --}}
            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                    <tr>
                        <th>ID</th>
                        <th>Nama Kota</th>
                        <th>Tipe</th>
                        <th>Provinsi</th>
                        <th>Kode Kabupaten</th>
                        <th width="150">Aksi</th>
                    </tr>

                    </thead>

                    <tbody>

                    @forelse($cities as $city)

                    <tr class="city-row">

                        <td>{{ $city->id }}</td>
                        <td>{{ $city->name }}</td>
                        <td>{{ $city->type ?? '-' }}</td>
                        <td>{{ $city->province ?? '-' }}</td>
                        <td>{{ $city->regency_code ?? '-' }}</td>

                        <td>

                            <div class="d-flex gap-1">

                                <button
                                    type="button"
                                    class="btn btn-info btn-sm btn-show-city"

                                    data-name="{{ $city->name }}"
                                    data-type="{{ $city->type }}"
                                    data-province="{{ $city->province }}"
                                    data-regency="{{ $city->regency_code }}">

                                    <i class="bi bi-eye"></i>

                                </button>

                                <a href="{{ route('backoffice.cities.edit',$city) }}"
                                    class="btn btn-warning btn-sm">

                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('backoffice.cities.destroy', $city) }}"
                                    method="POST"
                                    style="display:inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm btn-delete-city"
                                        data-city="{{ $city->name }}">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8"
                            class="text-center py-4">

                            Tidak ada data

                        </td>

                    </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if($perPage!='all')

            <div class="d-flex justify-content-between align-items-center mt-3">

                <small class="text-muted">

                    Menampilkan
                    {{ $cities->firstItem() }}
                    -
                    {{ $cities->lastItem() }}
                    dari
                    {{ $cities->total() }}

                </small>

                {{ $cities->appends(request()->query())->links('pagination::bootstrap-5') }}

            </div>

            @endif

        </div>

    </div>

</div>
<div class="modal fade"
    id="cityModal"
    tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <div class="modal-header">

                <h5 class="modal-title">

                    Detail Kota

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <table class="table">

                    <tr>
                        <th width="40%">Nama Kota</th>
                        <td id="modalName"></td>
                    </tr>

                    <tr>
                        <th>Tipe</th>
                        <td id="modalType"></td>
                    </tr>

                    <tr>
                        <th>Provinsi</th>
                        <td id="modalProvince"></td>
                    </tr>

                    <tr>
                        <th>Kode Kabupaten</th>
                        <td id="modalRegency"></td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

</div>

<script>

function updatePerPage(value){

let url=new URL(window.location);

url.searchParams.set('per_page',value);

window.location.href=url;

}

</script>
<script>

document.addEventListener('DOMContentLoaded', function(){

    const buttons =
        document.querySelectorAll('.btn-delete-city');

    buttons.forEach(button=>{

        button.addEventListener('click',function(e){

            e.preventDefault();

            const form =
                this.closest('form');

            const city =
                this.dataset.city;

            Swal.fire({

                title:'Hapus Kota?',
                text:`"${city}" akan dihapus.`,

                icon:'warning',

                showCancelButton:true,

                confirmButtonColor:'#dc3545',
                cancelButtonColor:'#6c757d',

                confirmButtonText:'Ya, Hapus!',
                cancelButtonText:'Batal'

            }).then((result)=>{

                if(result.isConfirmed){

                    form.submit();

                }

            });

        });

    });

});

</script>
<script>

document.addEventListener('DOMContentLoaded', function(){

    const showButtons =
        document.querySelectorAll('.btn-show-city');

    const modal =
        new bootstrap.Modal(
            document.getElementById('cityModal')
        );

    showButtons.forEach(button=>{

        button.addEventListener('click',function(){

            document.getElementById('modalName')
                .innerText=this.dataset.name || '-';

            document.getElementById('modalType')
                .innerText=this.dataset.type || '-';

            document.getElementById('modalProvince')
                .innerText=this.dataset.province || '-';

            document.getElementById('modalRegency')
                .innerText=this.dataset.regency || '-';

            modal.show();

        });

    });

});

</script>
<script>

document.addEventListener('DOMContentLoaded', function(){

    const searchInput =
        document.getElementById('searchInput');

    const searchForm =
        document.getElementById('searchForm');

    let timer;

    searchInput.addEventListener('keyup', function(){

        clearTimeout(timer);

        timer = setTimeout(()=>{

            searchForm.submit();

        },400);

    });

});

</script>
@endsection