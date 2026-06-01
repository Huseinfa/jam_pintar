<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #F5A623 0%, #e59a1e 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .content p {
            margin: 15px 0;
            font-size: 14px;
        }
        .reminder-box {
            background: #fff3cd;
            border-left: 4px solid #F5A623;
            padding: 20px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .reminder-box strong {
            color: #856404;
        }
        .cta-button {
            display: inline-block;
            background: #F5A623;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            margin: 20px 0;
            transition: background 0.3s;
        }
        .cta-button:hover {
            background: #e59a1e;
        }
        .footer {
            text-align: center;
            color: #999;
            font-size: 12px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⏰ Ingatkan: Feedback Anda Sangat Berarti!</h1>
        </div>
        
        <div class="content">
            <p>Halo <strong>{{ $user->name }}</strong>,</p>

            <div class="reminder-box">
                <p>🔔 <strong>Kami belum menerima feedback Anda</strong></p>
                <p>Sekitar satu minggu lalu, kami mengirimkan email meminta pendapat Anda tentang Jam Pintar. Tampaknya email tersebut belum Anda buka atau jawab.</p>
            </div>

            <p>Kami ingin sekali mendengar apa yang Anda pikirkan tentang aplikasi kami! Feedback Anda sangat membantu dalam:</p>
            <ul>
                <li>✨ Meningkatkan kualitas tes kepribadian</li>
                <li>📈 Membuat rekomendasi yang lebih akurat</li>
                <li>💪 Mengembangkan fitur-fitur baru</li>
                <li>🎯 Memberikan pengalaman yang lebih baik</li>
            </ul>

            <p><strong>Mengisi feedback hanya membutuhkan 2-3 menit saja!</strong></p>

            <div style="text-align: center;">
                <a href="{{ $feedbackUrl }}" class="cta-button">Isi Feedback Sekarang →</a>
            </div>

            <p style="color: #999; font-size: 12px;">
                <em>Jika Anda merasa feedback sudah tidak relevan atau tidak ingin berbagi feedback, Anda dapat mengabaikan email ini.</em>
            </p>

            <p>Terima kasih atas dukungan Anda! 🙏</p>
            <p>
                Salam hangat,<br>
                <strong>Tim Jam Pintar</strong>
            </p>
        </div>

        <div class="footer">
            <p>© {{ now()->year }} Jam Pintar. Semua hak dilindungi.</p>
            <p>Anda menerima email ini karena Anda mengizinkan kami mengirimkan feedback reminder.</p>
        </div>
    </div>
</body>
</html>
