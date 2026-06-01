<form method="POST" action="/rekomendasi">
    @csrf
        <!-- GitHub Username-->
    <div class="form-group">
        <label for="github_username">GitHub Username</label>
        <input 
            type="text" 
            name="github_username" 
            id="github_username" 
            class="form-control" 
            placeholder="contoh: husein-fadhlullah"
        >
        <small class="text-muted">
            Digunakan untuk mendeteksi jam produktif kamu secara otomatis dari aktivitas commit.
        </small>
    </div>

    <!-- Fallback: Manual study hour -->
    <div class="form-group" id="manual_hour_group">
        <label for="usual_study_hour">Jam Biasa Belajar (fallback jika tidak pakai GitHub)</label>
        <input 
            type="number" 
            name="usual_study_hour" 
            id="usual_study_hour" 
            class="form-control" 
            min="0" 
            max="23" 
            placeholder="contoh: 21 (untuk jam 9 malam)"
        >
        <small class="text-muted">Format 24 jam. Dipakai jika GitHub tidak tersedia atau datanya kurang.</small>
    </div>

    <label>Jam belajar per minggu</label>
    <input type="number" name="study_hours" min="1" max="40" required>

    <label>Lokasi belajar</label>
    <select name="study_location">
        <option>Home</option>
        <option>Library</option>
        <option>Cafe</option>
        <option>Campus</option>
        <option>Online</option>
    </select>

    <label>Metode belajar</label>
    <select name="study_method">
        <option>Membaca</option>
        <option>Mencatat</option>
        <option>Diskusi</option>
        <option>Latihan Soal</option>
        <option>Video/Tutorial</option>
    </select>

    <label>Tingkat prokrastinasi (1-5)</label>
    <input type="number" name="procrastination" min="1" max="5" required>

    <label>Tingkat organisasi (1-5)</label>
    <input type="number" name="organization" min="1" max="5" required>

    <label>Pakai alat bantu belajar?</label>
    <select name="uses_study_aids">
        <option value="1">Ya</option>
        <option value="0">Tidak</option>
    </select>

    <button type="submit">Dapatkan Rekomendasi</button>
</form>