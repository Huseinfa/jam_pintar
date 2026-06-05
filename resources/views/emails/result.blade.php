<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hasil Analisis Pola Belajar SmartPeak</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333333; background-color: #f4f7f6; margin: 0; padding: 40px 20px;">
    
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        
        <div style="background-color: #FDC334; color: #ffffff; padding: 30px 20px; text-align: center;">
            <h1 style="margin: 0; font-size: 26px; letter-spacing: 1px;">SmartPeak</h1>
            <p style="margin: 5px 0 0 0; font-size: 14px; opacity: 0.9;">Learning Recommendation System</p>
        </div>

        <div style="padding: 40px 30px;">
            <h2 style="margin-top: 0; color: #2c3e50; font-size: 20px;">Selamat! Hasil Analisis Kamu Siap</h2>
            
            <p style="font-size: 16px;">Halo <strong>{{ $result->testAttempt->user->name }}</strong>,</p>
            
            <p style="color: #555555;">Kami senang memberitahu bahwa hasil tes pola belajar kamu telah selesai dianalisis oleh sistem kami dan kini siap untuk dilihat!</p>
            
            <div style="background-color: #f8f9fa; border-left: 4px solid #FA5B19; padding: 20px; margin: 25px 0; border-radius: 0 4px 4px 0;">
                <h3 style="margin-top: 0; font-size: 16px; color: #2c3e50; margin-bottom: 15px;">Ringkasan Tes Kamu:</h3>
                <ul style="list-style-type: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 10px;">
                        <strong style="color: #333;">Rekomendasi:</strong> 
                        <span style="color: #555;">{{ $result->recommendation->recommendation_text ?? 'Proses analisis selesai' }}</span>
                    </li>
                    <li style="margin-bottom: 10px;">
                        <strong style="color: #333;">Waktu Test:</strong> 
                        <span style="color: #555;">{{ $result->testAttempt->created_at->format('d M Y H:i') }}</span>
                    </li>
                    <li>
                        <strong style="color: #333;">Selesai:</strong> 
                        <span style="color: #555;">{{ $result->testAttempt->finished_at->format('d M Y H:i') }}</span>
                    </li>
                </ul>
            </div>
            
            @if(!empty($result->pdf_path))
            <p style="color: #555555;">File PDF <strong>Laporan Hasil Analisis Pola Belajar</strong> kamu sudah terlampir pada email ini.</p>
            <p style="color: #555555;">Kamu juga tetap bisa mengunduh laporan secara langsung melalui dashboard.</p>
            @else
            <p style="color: #555555;">Kamu dapat melihat laporan lengkap secara langsung melalui dashboard.</p>
            @endif
            
            <div style="margin: 35px 0; text-align: center;">
                <a href="{{ route('dashboard') }}" style="background-color: #FDC334; color: #ffffff; padding: 14px 28px; text-decoration: none; border-radius: 6px; display: inline-block; font-weight: bold; font-size: 16px; transition: background-color 0.3s;">
                    Lihat Hasil Lengkap
                </a>
            </div>
            
            <hr style="border: none; border-top: 1px solid #eeeeee; margin: 30px 0;">

            <h3 style="font-size: 16px; color: #2c3e50; margin-bottom: 10px;">Apa Selanjutnya?</h3>
            <p style="color: #555555; font-size: 14px;">Kami sangat ingin mendengar <em>feedback</em> kamu tentang pengalaman menggunakan SmartPeak. Masukan dari kamu akan membantu kami untuk terus berkembang dan memberikan layanan yang lebih baik.</p>
            
            <p style="color: #555555; font-size: 14px; margin-top: 30px;">
                Salam Hangat,<br>
                <strong>Tim SmartPeak</strong>
            </p>
        </div>
        
        <div style="background-color: #f8f9fa; padding: 20px; text-align: center; border-top: 1px solid #eeeeee;">
            <p style="margin: 0; font-size: 12px; color: #999999;">&copy; {{ date('Y') }} SmartPeak. All rights reserved.</p>
        </div>

    </div>
</body>
</html>