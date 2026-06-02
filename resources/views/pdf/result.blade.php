

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Rekomendasi Belajar - SmartPeak</title>
<style>

    body {
        font-family: 'poppins', sans-serif;
        font-size: 12px;
        color: #2D3748;
        margin: 0;
        padding: 0;
    }

    .container {
        padding: 30px;
    }
    /* HEADER */
    .header {
        background: #F4B400;
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 20px;
    }

    .logo {
        font-size: 28px;
        font-weight: bold;
    }

    .header-title {
        font-size: 22px;
        font-weight: bold;
        margin-top: 10px;
    }

    .header-subtitle {
        font-size: 12px;
        margin-top: 8px;
        line-height: 1.8;
    }

    .report-info {
        margin-bottom: 20px;
        padding: 12px;
        border: 1px solid #E2E8F0;
        background: #F8FAFC;
    }

    /* CARD */
    .card {
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 18px;
        margin-bottom: 18px;
    }

    .section-title {
        font-size: 15px;
        font-weight: bold;
        color: #F59E0B;
        border-bottom: 1px solid #E5E7EB;
        padding-bottom: 8px;
        margin-bottom: 15px;
    }

    /* PROFILE */

    .profile-table {
        width: 100%;
    }

    .profile-table td {
        padding: 6px 0;
    }

    .label {
        width: 140px;
        font-weight: bold;
    }

    /* BADGE */

    .study-badge {
        display: inline-block;
        padding: 10px 20px;
        background: #FEF3C7;
        color: #92400E;
        font-size: 15px;
        font-weight: bold;
        border-radius: 20px;
    }

    /* RECOMMENDATION */

    .recommendation-text {
        text-align: justify;
        line-height: 1.8;
    }

    /* TIME */
    .time-table {
    width: 100%;
    border-collapse: collapse;
    }

    .time-table td {
        width: 50%;
        vertical-align: top;
        padding: 0 8px;
    }

    .time-box {
        border: 1px solid #E5E7EB;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        min-height: 70px;
    }

    .time-label {
        font-size: 11px;
        color: #6B7280;
        margin-bottom: 10px;
    }

    .time-value {
        font-size: 18px;
        font-weight: bold;
        color: #1F2937;
    }
    /* CONCLUSION */

    .conclusion {
        background: #FFF7ED;
        border-left: 5px solid #F59E0B;
        padding: 15px;
        line-height: 1.8;
    }

    /* FOOTER */

    .divider {
        border-top: 1px solid #E5E7EB;
        margin: 20px 0;
    }

    .footer {
        text-align: center;
        font-size: 11px;
        color: #718096;
        margin-top: 30px;
    }

</style>
</head>
<body>
<div class="container">
<!-- HEADER -->
<div class="header">
    <div class="logo">
        SMARTPEAK
    </div>
    <div class="header-title">
        Laporan Hasil Analisis Pola Belajar
    </div>
    <div class="header-subtitle">
        Dokumen ini berisi hasil analisis dan rekomendasi waktu belajar
        berdasarkan kebiasaan belajar pengguna pada sistem SmartPeak.
    </div>
</div>

<!-- INFORMASI LAPORAN -->

<div class="report-info">
    <strong>ID Hasil :</strong>
    SP-{{ str_pad($result->id, 5, '0', STR_PAD_LEFT) }}
    <br>
    <strong>Tanggal Analisis :</strong>
    {{ $result->created_at->format('d F Y') }}
</div>

<!-- PROFIL PENGGUNA -->

<div class="card">
    <div class="section-title">
        Profil Pengguna
    </div>
    <table class="profile-table">
        <tr>
            <td class="label">Nama</td>
            <td>: {{ $result->testAttempt->user->name }}</td>
        </tr>
        <tr>
            <td class="label">Email</td>
            <td>: {{ $result->testAttempt->user->email }}</td>
        </tr>
        <tr>
            <td class="label">Usia</td>
            <td>:
                {{ \Carbon\Carbon::parse($result->testAttempt->user->birth_date)->age }}
                Tahun
            </td>
        </tr>
        <tr>
            <td class="label">Jenis Kelamin</td>
            <td>:
                {{ $result->testAttempt->user->gender == 'LakiLaki'
                    ? 'Laki-Laki'
                    : 'Perempuan' }}
            </td>
        </tr>
    </table>
</div>

<!-- HASIL ANALISIS -->

<div class="card">
    <div class="section-title">
        Hasil Analisis Pola Belajar
    </div>
    <div class="study-badge">
        {{ strtoupper($result->recommendation->preferred_study_time ?? $result->recommendation->prefered_study_time) }}
    </div>
</div>

<!-- WAKTU BELAJAR -->
<div class="card">
    <div class="section-title">
        Waktu Belajar yang Direkomendasikan
    </div>
    <table class="time-table">
        <tr>
            <td>
                <div class="time-box">
                    <div class="time-label">
                        Jam Belajar Utama
                    </div>
                    <div class="time-value">
                        {{ \Carbon\Carbon::parse($result->recommendation->study_hour_start)->format('H:i') }}
                        -
                        {{ \Carbon\Carbon::parse($result->recommendation->study_hour_end)->format('H:i') }}
                    </div>
                </div>
            </td>
            <td>
                <div class="time-box">
                    <div class="time-label">
                        Jam Belajar Alternatif
                    </div>
                    <div class="time-value">
                        @if(
                            $result->recommendation->alt_study_hour_start &&
                            $result->recommendation->alt_study_hour_end
                        )
                            {{ \Carbon\Carbon::parse($result->recommendation->alt_study_hour_start)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::parse($result->recommendation->alt_study_hour_end)->format('H:i') }}

                        @else
                            -
                        @endif
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <div style="clear:both"></div>
</div>

<!-- REKOMENDASI -->
<div class="card">
    <div class="section-title">
        Rekomendasi Belajar Personal
    </div>
    <div class="recommendation-text">
        {{ $result->recommendation->recomendation }}
    </div>
</div>

<!-- KESIMPULAN -->
<div class="card">
    <div class="section-title">
        Kesimpulan Hasil Analisis
    </div>
    <div class="conclusion">
        Berdasarkan hasil analisis pola belajar yang dilakukan melalui
        SmartPeak, pengguna memiliki kecenderungan belajar paling optimal
        pada kategori
        <strong>
            {{ strtoupper($result->recommendation->preferred_study_time ?? $result->recommendation->prefered_study_time) }}
        </strong>
        Disarankan untuk memprioritaskan aktivitas belajar pada rentang
        waktu yang direkomendasikan agar konsentrasi, produktivitas,
        dan efektivitas belajar dapat meningkat secara maksimal.
    </div>
</div>

<!-- FOOTER -->
<div class="footer">
    <div class="divider"></div>
    <strong>SmartPeak Learning Recommendation System</strong>
    <br><br>
    Sistem rekomendasi waktu belajar berbasis analisis
    kebiasaan belajar mahasiswa Jurusan Teknologi Informasi.
    <br><br>
    © {{ date('Y') }} SmartPeak
</div>
</div>
</body>
</html>