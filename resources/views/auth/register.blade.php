<div class="modal fade" id="modalRegister" tabindex="-1" aria-labelledby="modalRegisterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-100 my-4 px-3 px-sm-0" style="max-width: 550px;">
        <div class="modal-content border-0 shadow-sm" style="border-radius: 55px; overflow: hidden;">
            <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close" style="z-index: 10;"></button>
            <div class="modal-body p-4 p-sm-5" style="background: #fff; border-radius: 32px;">
                {{-- Header custom: judul + deskripsi --}}
                <div class="text-start mb-4">
                    <h3 class="fw-bold mb-1">Halo!</h3>
                    <p class="text-muted mb-2">Yuk, buat akunmu sekarang dan mulai jelajahi keseruan di dalamnya.</p>
                </div>

                {{-- Tampilkan error umum jika ada --}}
                @if ($errors->any() && !$errors->has('email') && !$errors->has('password') && !$errors->has('name'))
                    <div class="alert alert-danger py-2 small">
                        Ada kesalahan, silakan cek kembali data Anda.
                    </div>
                @endif

                <form method="POST" action="{{ route('auth.register') }}" novalidate>
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold small">Nama Lengkap</label>
                            <input
                                type="text"
                                class="form-control py-3 px-3 @error('name') is-invalid @enderror"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Masukkan Nama Lengkap"
                                required
                                autofocus
                                style="border-radius: 50px; border: 1.5px solid #2A3141; font-size: 0.95rem;"
                            >
                            @error('name')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="city_name" class="form-label fw-semibold small">Asal Kota</label>
                            <div class="position-relative">
                                <input
                                    type="text"
                                    class="form-control py-3 px-3"
                                    id="city_name"
                                    name="city_name"
                                    value="{{ old('city_name') }}"
                                    placeholder="Ketik 2-3 huruf untuk mencari kota"
                                    autocomplete="off"
                                    style="border-radius: 50px; border: 1.5px solid #2A3141; font-size: 0.95rem;"
                                >
                                <input type="hidden" name="city_id" id="city_id" value="{{ old('city_id') }}">
                                <div id="city_suggestions" class="list-group position-absolute" style="z-index: 2000; width: 100%; display: none;
                                    max-height: 240px; overflow:auto;
                                    top: calc(100% + .25rem); left: 0;">
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label fw-semibold small">Email</label>
                            <input
                                type="email"
                                class="form-control py-3 px-3 @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Masukkan Email"
                                required
                                style="border-radius: 50px; border: 1.5px solid #2A3141; font-size: 0.95rem;"
                            >
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="github_username" class="form-label fw-semibold small">Username GitHub</label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-radius: 50px 0 0 50px; border: 1.5px solid #2A3141; background: #f8f9fa;">
                                    <i class="fab fa-github"></i>
                                </span>
                                <input
                                    type="text"
                                    class="form-control py-3 px-3 @error('github_username') is-invalid @enderror"
                                    id="github_username"
                                    name="github_username"
                                    value="{{ old('github_username') }}"
                                    placeholder="username-github"
                                    required
                                    style="border-radius: 0 50px 50px 0; border: 1.5px solid #2A3141; border-left: none; font-size: 0.95rem;"
                                >
                            </div>
                            @error('github_username')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                            <small class="text-muted d-block mt-1">Masukkan username GitHub Anda (tanpa @)</small>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold small">Jenis Kelamin</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="gender_m" value="LakiLaki" {{ old('gender')=='LakiLaki' ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="gender_m">Laki-Laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="gender_f" value="Perempuan" {{ old('gender')=='Perempuan' ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="gender_f">Perempuan</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label fw-semibold small">
                                Password
                            </label>

                            <div class="password-input-wrapper">

                                <input
                                    type="password"
                                    class="form-control py-3 px-3 @error('password') is-invalid @enderror password-field"
                                    id="password"
                                    name="password"
                                    placeholder="Masukkan Password"
                                    required
                                    style="border-radius:50px;border:1.5px solid #2A3141;font-size:0.95rem;padding-right:50px;"
                                >

                            <button 
                                type="button"
                                class="toggle-password-btn"
                                tabindex="-1"
                                title="Tampilkan/Sembunyikan Password">
                                <i class="fa-regular fa-eye"></i>
                            </button>

                            </div>

                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror


                            {{-- Rules password --}}
                            <div id="passwordRules">

                                <div id="rule-length" class="rule-item">
                                    ❌ Minimal 8 karakter
                                </div>

                                <div id="rule-uppercase" class="rule-item">
                                    ❌ Huruf besar
                                </div>

                                <div id="rule-lowercase" class="rule-item">
                                    ❌ Huruf kecil
                                </div>

                                <div id="rule-number" class="rule-item">
                                    ❌ Angka
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <label for="password_confirmation"
                                class="form-label fw-semibold small">

                                Konfirmasi Password

                            </label>

                            <div class="password-input-wrapper">

                                <input
                                    type="password"
                                    class="form-control py-3 px-3 password-field"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Ulangi Password"
                                    required
                                    style="border-radius:50px;border:1.5px solid #2A3141;font-size:0.95rem;padding-right:50px;"
                                >

                            <button 
                                type="button"
                                class="toggle-password-btn"
                                tabindex="-1"
                                title="Tampilkan/Sembunyikan Konfirmasi Password">
                                <i class="fa-regular fa-eye"></i>
                            </button>

                            </div>

                            <small id="confirmMessage" class="match-indicator"></small>

                        </div>


                        <div class="col-12">
                            <label for="birth_date" class="form-label fw-semibold small">Tanggal Lahir</label>
                            <input
                                type="date"
                                class="form-control py-3 px-3"
                                id="birth_date"
                                name="birth_date"
                                value="{{ old('birth_date') }}"
                                placeholder="mm/dd/yyyy"
                                style="border-radius: 50px; border: 1.5px solid #2A3141; font-size: 0.95rem;"
                            >
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    id="allow_feedback_emails" 
                                    name="allow_feedback_emails" 
                                    value="1"
                                    {{ old('allow_feedback_emails', 1) ? 'checked' : '' }}
                                    style="cursor: pointer;">
                                <label class="form-check-label small" for="allow_feedback_emails" style="cursor: pointer;">
                                    Izinkan kami mengirimkan email feedback dan reminder untuk membantu kami meningkatkan aplikasi
                                    <i class="fas fa-info-circle text-muted" style="font-size: 0.8rem;" title="Kami akan mengirim email feedback setelah 7 hari setelah tes selesai"></i>
                                </label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-grid">
                                <button type="submit" class="btn py-3 fw-semibold text-white"
                                        style="border-radius: 50px; background: #1a1a2e; font-size: 0.95rem;">
                                    Daftar
                                </button>
                            </div>
                        </div>

                        <div class="col-12 text-center">
                            <p class="small mb-0">Sudah punya akun? <a href="#" class="text-decoration-none fw-semibold" style="color: #F5A623;" data-bs-toggle="modal" data-bs-target="#modalLogin" data-bs-dismiss="modal">Masuk</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Sukses Registrasi --}}
<div class="modal fade" id="modalRegisterSuccess" tabindex="-1" aria-labelledby="modalRegisterSuccessLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-body text-center py-5">
                <div class="mb-4">
                    <div style="width: 80px; height: 80px; margin: 0 auto; background: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                </div>
                <h4 class="fw-bold mb-2">Berhasil!</h4>
                <p class="text-muted mb-0">
                    Pendaftaran berhasil! Silakan verifikasi email Anda terlebih dahulu sebelum login.
                </p>
                <div class="d-grid mt-4">
                    <a href="#" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalLogin" data-bs-dismiss="modal">Masuk Sekarang</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Buka modal otomatis jika ada error validasi registrasi (gunakan old input sebagai indikator) --}}
@if ($errors->any() && old('name'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = new bootstrap.Modal(document.getElementById('modalRegister'));
        modal.show();
    });
</script>
@endif

<style>

input::-ms-reveal,
input::-ms-clear {
    display: none;
}
.password-input-wrapper {
    position: relative;
    width: 100%;
    display: flex;
    align-items: center;
}

.password-input-wrapper .form-control {
    width: 100%;
    padding-right: 50px !important;
    flex: 1;
}

.toggle-password-btn {
    position: absolute;
    right: 15px;
    border: none;
    background: none;
    padding: 8px;
    margin: 0;
    cursor: pointer;
    color: #999;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    pointer-events: auto !important;
    z-index: 1000 !important;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    transition: all 0.2s ease;
}

.toggle-password-btn:hover {
    color: #1a1a2e;
    background-color: rgba(0,0,0,0.05);
}

.toggle-password-btn:active {
    transform: scale(0.95);
}

.rule-success {
    color: #28a745;
}

.rule-fail {
    color: #dc3545;
}

#passwordRules {
    display: none !important;
    margin-top: 12px;
    padding: 12px 14px;
    background: #f8f9fa;
    border-radius: 10px;
    font-size: 0.85rem;
    border: 1.5px solid #e9ecef;
    opacity: 0;
    transition: opacity 0.2s ease;
}

#passwordRules.show {
    display: block !important;
    opacity: 1;
}

.rule-item {
    padding: 6px 0;
    font-weight: 500;
    line-height: 1.4;
}

/* Styling untuk password confirmation */
#password_confirmation.is-valid {
    border-color: #28a745 !important;
}

#password_confirmation.is-invalid {
    border-color: #dc3545 !important;
}

.match-indicator {
    font-size: 0.85rem;
    margin-top: 6px;
    display: none !important;
    font-weight: 600;
    line-height: 1.4;
}

.match-indicator.show {
    display: block !important;
}

.match-indicator.success {
    color: #28a745;
}

.match-indicator.error {
    color: #dc3545;
}

/* GitHub username input styling */
.input-group .input-group-text {
    border-top-right-radius: 0 !important;
    border-bottom-right-radius: 0 !important;
}

.input-group .form-control {
    border-top-left-radius: 0 !important;
    border-bottom-left-radius: 0 !important;
}

.input-group .form-control:focus {
    border-color: #2A3141 !important;
    box-shadow: none;
}

.input-group .input-group-text {
    font-size: 1rem;
    color: #666;
}

</style>

<script>
// Autocomplete for city_name using Nominatim (OpenStreetMap)
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
        }, 300);
    });

    // close when clicking outside
    document.addEventListener('click', function(e){
        if (!input.contains(e.target) && !list.contains(e.target)){
            clearList();
        }
    });
})();
</script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    // =========================
    // GET ELEMENTS - Query from form context for accuracy
    // =========================

    const form = document.querySelector('#modalRegister form');
    if (!form) {
        console.error('Register form not found!');
        return;
    }

    // Query elements from form context to ensure correct elements
    const passwordInput = form.querySelector('input[name="password"]');
    const confirmInput = form.querySelector('input[name="password_confirmation"]');
    const rulesBox = document.getElementById('passwordRules');
    const confirmMessage = document.getElementById('confirmMessage');

    if (!passwordInput || !confirmInput) {
        console.error('Password inputs not found!', { passwordInput, confirmInput });
        return;
    }

    console.log('✓ Password validation initialized', { 
        passwordId: passwordInput.id,
        confirmId: confirmInput.id,
        formFound: !!form
    });

    // =========================
    // PASSWORD VALIDATION RULES
    // =========================

    function checkPasswordRules(password) {
        const rules = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /[0-9]/.test(password)
        };
        return rules;
    }

    function updatePasswordRules(password) {
        // Query fresh every time
        const rulesBox = document.getElementById('passwordRules');
        
        if (!rulesBox) {
            console.warn('Password rules box not found');
            return;
        }
        
        const rules = checkPasswordRules(password);

        console.log('📋 Password rules check:', { password, rules });

        // Show rules box if password has content
        if (password.length > 0) {
            rulesBox.classList.add('show');
        } else {
            rulesBox.classList.remove('show');
        }

        // Update each rule indicator
        const ruleElements = {
            'rule-length': { valid: rules.length, text: 'Minimal 8 karakter' },
            'rule-uppercase': { valid: rules.uppercase, text: 'Huruf besar' },
            'rule-lowercase': { valid: rules.lowercase, text: 'Huruf kecil' },
            'rule-number': { valid: rules.number, text: 'Angka' }
        };

        Object.entries(ruleElements).forEach(([id, rule]) => {
            const element = document.getElementById(id);
            if (element) {
                element.innerHTML = (rule.valid ? '✔' : '❌') + ' ' + rule.text;
                element.classList.remove('rule-success', 'rule-fail');
                element.classList.add(rule.valid ? 'rule-success' : 'rule-fail');
            }
        });
    }

    // =========================
    // CONFIRM PASSWORD CHECK
    // =========================

    function checkConfirmPassword() {
        // Always query from form context to avoid stale references
        const pwd = form.querySelector('input[name="password"]');
        const confirm = form.querySelector('input[name="password_confirmation"]');
        const msg = document.getElementById('confirmMessage');
        
        if (!pwd || !confirm || !msg) {
            console.warn('Elements not found for password check');
            return;
        }
        
        const passwordValue = pwd.value;
        const confirmValue = confirm.value;

        console.log('🔐 Password match check:', { 
            password: passwordValue,
            confirm: confirmValue,
            match: passwordValue === confirmValue,
            passwordLen: passwordValue.length,
            confirmLen: confirmValue.length
        });

        // Reset classes and border - keep default gray
        confirm.classList.remove('is-valid', 'is-invalid');
        confirm.style.borderColor = '';

        // If confirm field is empty, clear message and keep gray border
        if (confirmValue === '') {
            msg.innerHTML = '';
            msg.classList.remove('show', 'success', 'error');
            return;
        }

        // Check if passwords match
        if (passwordValue === confirmValue && passwordValue.length > 0) {
            confirm.classList.add('is-valid');
            confirm.style.borderColor = '#28a745';
            msg.innerHTML = '✔ Password cocok!';
            msg.className = 'match-indicator show success';
        } else {
            confirm.classList.add('is-invalid');
            confirm.style.borderColor = '#dc3545';
            msg.innerHTML = '❌ Password tidak cocok';
            msg.className = 'match-indicator show error';
        }
    }

    // =========================
    // EVENT LISTENERS
    // =========================

    // Monitor password input
    passwordInput.addEventListener('input', function() {
        console.log('⌨️ Password input:', this.value);
        updatePasswordRules(this.value);
        checkConfirmPassword();
    });

    // Monitor confirm password input
    confirmInput.addEventListener('input', function() {
        console.log('⌨️ Confirm input:', this.value);
        checkConfirmPassword();
    });

    // Handle paste events
    passwordInput.addEventListener('paste', function() {
        setTimeout(() => {
            console.log('📋 Password paste:', this.value);
            updatePasswordRules(this.value);
            checkConfirmPassword();
        }, 0);
    });

    confirmInput.addEventListener('paste', function() {
        setTimeout(() => {
            console.log('📋 Confirm paste:', this.value);
            checkConfirmPassword();
        }, 0);
    });

    // Monitor form reset
    form.addEventListener('reset', function() {
        console.log('🔄 Form reset detected');
        setTimeout(() => {
            const msg = document.getElementById('confirmMessage');
            const rulesBox = document.getElementById('passwordRules');
            if (msg) {
                msg.innerHTML = '';
                msg.className = 'match-indicator';
            }
            if (rulesBox) {
                rulesBox.classList.remove('show');
            }
        }, 0);
    });

    // Monitor modal events for fresh element queries
    const modal = document.getElementById('modalRegister');
    if (modal) {
        modal.addEventListener('shown.bs.modal', function() {
            console.log('📱 Modal shown - elements refreshed');
            // Force re-query on modal show
            const newPwdInput = form.querySelector('input[name="password"]');
            const newConfirmInput = form.querySelector('input[name="password_confirmation"]');
            console.log('✓ Fresh element references after modal show', {
                pwd: newPwdInput ? newPwdInput.value : 'NOT FOUND',
                confirm: newConfirmInput ? newConfirmInput.value : 'NOT FOUND'
            });
        });
    }

    console.log('✅ Password validation script fully initialized');

});

</script>

</script>

<script>
// =========================
// TOGGLE PASSWORD - Main Handler
// =========================

document.addEventListener('DOMContentLoaded', function() {
    // Attach toggle password handlers to all buttons
    const toggleButtons = document.querySelectorAll('.toggle-password-btn');
    
    toggleButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const wrapper = this.closest('.password-input-wrapper');
            if (!wrapper) return;
            
            const input = wrapper.querySelector('input[type="password"], input[type="text"]');
            if (!input) return;
            
            const icon = this.querySelector('i');
            
            // Toggle type
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
            
            input.focus();
        });
    });
});

</script>

<script>
// Handle registration form submission
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#modalRegister form');
    if (!form) return;
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        
        // Get CSRF token
        const token = document.querySelector('meta[name="csrf-token"]')?.content || 
                      form.querySelector('input[name="_token"]')?.value;
        
        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': token,
                },
                body: formData
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                // Registration successful
                const registerModal = bootstrap.Modal.getInstance(document.getElementById('modalRegister'));
                if (registerModal) registerModal.hide();
                
                // Show success modal
                const successModal = new bootstrap.Modal(document.getElementById('modalRegisterSuccess'));
                successModal.show();
                
                // Reset form
                form.reset();
                // Clear any validation classes
                form.querySelectorAll('.form-control').forEach(input => {
                    input.classList.remove('is-invalid');
                });
            } else {
                // Server returned error
                if (data.errors) {
                    // Handle validation errors
                    Object.keys(data.errors).forEach(field => {
                        const input = form.querySelector(`[name="${field}"]`);
                        if (input) {
                            input.classList.add('is-invalid');
                        }
                    });
                }
            }
        } catch (error) {
            console.error('Registration error:', error);
        }
    });
});
</script>
