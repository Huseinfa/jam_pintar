<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hasil Test Kamu</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2>Selamat! Hasil Test Kamu Siap</h2>
        
        <p>Halo <strong>{{ $result->testAttempt->user->name }}</strong>,</p>
        
        <p>Kami senang memberitahu bahwa hasil tes kamu sudah dianalisis dan siap untuk dilihat!</p>
        
        <h3>Hasil Tes Kamu</h3>
        <ul>
            <li><strong>Rekomendasi:</strong> {{ $result->recommendation->recommendation_text ?? 'Proses analisis selesai' }}</li>
            <li><strong>Waktu Test:</strong> {{ $result->testAttempt->created_at->format('d M Y H:i') }}</li>
            <li><strong>Selesai:</strong> {{ $result->testAttempt->finished_at->format('d M Y H:i') }}</li>
        </ul>
        
        @isset($result->pdf_path)
        <p>Kamu dapat mendownload laporan lengkapmu melalui dashboard.</p>
        @endisset
        
        <div style="margin: 30px 0;">
            <a href="{{ route('dashboard') }}" style="background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; display: inline-block;">
                Lihat Hasil Lengkap
            </a>
        </div>
        
        <h3>Apa Selanjutnya?</h3>
        <p>Kami sangat ingin mendengar feedback kamu tentang pengalaman menggunakan Jam Pintar. Feedback kamu membantu kami untuk terus berkembang dan memberikan layanan yang lebih baik.</p>
        
        <p>Terima kasih telah menggunakan Jam Pintar!</p>
        
        <p>Salam,<br>
        Tim Jam Pintar</p>
    </div>
</body>
</html>
