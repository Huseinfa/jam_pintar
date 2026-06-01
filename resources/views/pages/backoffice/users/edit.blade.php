@extends('layouts.backoffice')

@section('title', 'Edit User')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="fw-bold mb-4">Edit User</h4>

        <form action="{{ route('backoffice.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Gender</label>
                        <input type="text" name="gender" class="form-control" value="{{ old('gender', $user->gender) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Github Username</label>
                        <input type="text" name="github_username" class="form-control" value="{{ old('github_username', $user->github_username) }}">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Asal Kota</label>
                <div class="position-relative">
                    <input
                        type="text"
                        class="form-control"
                        id="city_name"
                        name="city_name"
                        value="{{ old('city_name', $user->city?->name ?? (is_string($user->city) ? $user->city : '')) }}"
                        placeholder="Ketik 2-3 huruf untuk mencari kota"
                        autocomplete="off"
                    >
                    <input type="hidden" name="city_id" id="city_id" value="{{ old('city_id', $user->city_id ?? '') }}">
                    <div id="city_suggestions" class="list-group position-absolute" style="z-index: 2000; width: 100%; display: none; max-height: 240px; overflow:auto; top: calc(100% + .25rem); left: 0;"></div>
                </div>
            </div>

            @push('scripts')
            <script>
            ;(function (){
                const input = document.getElementById('city_name');
                const list = document.getElementById('city_suggestions');
                if (!input) return;

                let timer = null;

                function clearList(){ list.innerHTML = ''; list.style.display = 'none'; }

                function renderSuggestions(items){
                    clearList();
                    if (!items.length) return;
                    items.forEach(i=>{
                        const a = document.createElement('button');
                        a.type = 'button';
                        a.className = 'list-group-item list-group-item-action';
                        a.innerHTML = '<div class="fw-semibold">' + (i.name || i.city_name || i.display_name || '') + '</div>' +
                                      '<div class="small text-muted">' + (i.province ? i.province : '') + '</div>';
                        a.addEventListener('click', function(){
                            input.value = i.name || i.city_name || i.display_name || '';
                            const hid = document.getElementById('city_id');
                            if (hid) hid.value = i.id || '';
                            clearList();
                        });
                        list.appendChild(a);
                    });
                    list.style.display = 'block';
                }

                async function fetchPlaces(q){
                    const url = '/api/cities/search?q=' + encodeURIComponent(q);
                    try{
                        const res = await fetch(url, {headers:{'Accept':'application/json'}});
                        if (!res.ok) {
                            console.error('City API error', res.status, res.statusText);
                            return [];
                        }
                        const data = await res.json();
                        return data || [];
                    }catch(e){ console.error('City API fetch failed', e); return []; }
                }

                input.addEventListener('input', function(e){
                    const q = e.target.value.trim();
                    clearTimeout(timer);
                    // clear selected city_id if user edits text
                    const hid = document.getElementById('city_id'); if (hid) hid.value = '';
                    if (q.length < 2) { clearList(); return; }
                    timer = setTimeout(async ()=>{
                        const items = await fetchPlaces(q);
                        renderSuggestions(items);
                    }, 250);
                });

                // close when clicking outside
                document.addEventListener('click', function(e){
                    if (!input.contains(e.target) && !list.contains(e.target)){
                        clearList();
                    }
                });
            })();
            </script>
            @endpush

            <div class="mb-3">
                <label class="form-label">Birth Date</label>
                <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', optional($user->birth_date)->format('Y-m-d')) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select">
                    <option value="user" {{ $user->role==='user' ? 'selected' : '' }}>user</option>
                    <option value="admin" {{ $user->role==='admin' ? 'selected' : '' }}>admin</option>
                </select>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Simpan</button>
                <a href="{{ route('backoffice.users') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
