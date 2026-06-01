@extends('layouts.backoffice')

@section('title', 'Kelola Users')

@section('content')

    <div class="container-fluid py-3">

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h2 class="fw-bold mb-1">Kelola Pengguna</h2>
                        <p class="text-muted mb-0">Kelola data mahasiswa dan hasil tes. Klik "Lihat" untuk membuka detail.</p>
                    </div>

                </div>

            </div>

        </div>

        {{-- Alerts --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="card shadow-sm border-0">

            <div class="card-body">

                {{-- Filter Row --}}
                <div class="row mb-3">

                    <div class="col-md-6 d-flex align-items-center gap-2">

                        <label>Show</label>

                        <select class="form-select form-select-sm" onchange="updatePerPage(this.value)" style="width:90px">
                            <option value="10" {{ $perPage==10? 'selected':'' }}>10</option>
                            <option value="20" {{ $perPage==20? 'selected':'' }}>20</option>
                            <option value="50" {{ $perPage==50? 'selected':'' }}>50</option>
                            <option value="100" {{ $perPage==100? 'selected':'' }}>100</option>
                            <option value="all" {{ $perPage=='all'? 'selected':'' }}>All</option>
                        </select>

                        <label>entries</label>

                    </div>

                    <div class="col-md-6 text-end">

                        <div class="mb-2 text-end">
                            <a href="{{ route('backoffice.users.export') }}" class="btn btn-success btn-sm">
                                <i class="bi bi-download me-1"></i> Export Semua (CSV)
                            </a>
                            <a href="{{ route('backoffice.users.export.pdf') }}" class="btn btn-primary btn-sm ms-2">
                                <i class="bi bi-file-earmark-pdf me-1"></i> Export Semua (PDF)
                            </a>
                        </div>

                        <form method="GET" id="searchForm" class="d-inline">
                            <input type="hidden" name="perPage" id="perPageInput" value="{{ $perPage }}">
                            <input type="text" class="form-control form-control-sm d-inline" id="searchInput" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama atau email..." style="max-width:300px" autocomplete="off">
                        </form>

                    </div>

                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Jenis Kelamin</th>
                                <th>Github</th>
                                <th>Percobaan</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>
                                    @if(method_exists($users, 'firstItem') && $users->firstItem())
                                        {{ $users->firstItem() + $loop->index }}
                                    @else
                                        {{ $loop->iteration }}
                                    @endif
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->gender ?? '-' }}</td>
                                <td>{{ $user->github_username ?? '-' }}</td>
                                <td>{{ $user->test_attempts_count }}</td>
                                <td>
                                <div class="d-flex gap-1">
                                    <button type="button" data-user-id="{{ $user->id }}" class="btn btn-info btn-sm btn-show-user" title="Lihat">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    <a href="{{ route('backoffice.users.edit', $user->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    @if($user->role !== 'admin')
                                    <form action="{{ route('backoffice.users.destroy', $user->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-delete-user" data-user="{{ $user->name }}" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($perPage!='all')
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted">
                        Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }}
                    </small>

                    {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
                @endif

            </div>

        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="userModal" tabindex="-1">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Detail User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body" id="userModalBody"></div>
        </div>
      </div>
    </div>

    @endsection

    @push('scripts')
    <script>
    function updatePerPage(value){
        let url = new URL(window.location);
        url.searchParams.set('perPage', value);
        window.location.href = url;
    }

    document.addEventListener('DOMContentLoaded', function(){

        // debounce search
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        let timer;
        if (searchInput) {
            searchInput.addEventListener('keyup', function(){
                clearTimeout(timer);
                timer = setTimeout(()=>{ searchForm.submit(); }, 300);
            });
        }

        const userModalEl = document.getElementById('userModal');
        const userModal = new bootstrap.Modal(userModalEl);

        document.querySelectorAll('.btn-show-user').forEach(btn => {
            btn.addEventListener('click', async function(){
                const id = this.dataset.userId;
                const url = `{{ url('backoffice/users') }}/${id}`;
                const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                if (!res.ok) {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal memuat data user' });
                    return;
                }
                const html = await res.text();
                document.getElementById('userModalBody').innerHTML = html;
                userModal.show();
            });
        });

        // delete confirmation for users
        document.querySelectorAll('.btn-delete-user').forEach(button => {
            button.addEventListener('click', function(e){
                e.preventDefault();
                const form = this.closest('form');
                const name = this.dataset.user;
                Swal.fire({
                    title: 'Hapus User?',
                    text: `User "${name}" akan dihapus.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result)=>{
                    if(result.isConfirmed) form.submit();
                });
            });
        });

    });
    </script>
    @endpush
