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
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
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
        .highlight {
            background: #fff;
            padding: 20px;
            border-left: 4px solid #F5A623;
            margin: 20px 0;
            border-radius: 4px;
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
        .questions {
            background: white;
            padding: 20px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .question-item {
            margin: 15px 0;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        .question-item:last-child {
            border-bottom: none;
        }
        .question-item strong {
            color: #1a1a2e;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🌟 Kami Ingin Tahu Pendapatmu!</h1>
        </div>
        
        <div class="content">
            <p>Halo <strong>{{ $user->name }}</strong>,</p>

            <p>Terima kasih telah menggunakan <strong>Jam Pintar</strong>! Kami senang Anda telah menyelesaikan tes kepribadian kami.</p>

            <div class="highlight">
                <p><strong>📋 Kami ingin mendengar feedback Anda</strong></p>
                <p>Untuk membantu kami meningkatkan aplikasi, kami sangat menghargai pendapat Anda tentang pengalaman menggunakan Jam Pintar. Feedback Anda akan membantu kami membuat aplikasi yang lebih baik!</p>
            </div>

            <p><strong>Kami akan menanyakan 4 pertanyaan sederhana:</strong></p>
            <div class="questions">
                <div class="question-item">
                    <strong>1. Seberapa cocok hasil tes dengan kepribadian Anda?</strong>
                    <p>Kami ingin tahu apakah rekomendasi yang kami berikan sesuai dengan karakter Anda.</p>
                </div>
                <div class="question-item">
                    <strong>2. Seberapa berguna aplikasi ini untuk Anda?</strong>
                    <p>Bagaimana pengalaman Anda menggunakan Jam Pintar secara keseluruhan?</p>
                </div>
                <div class="question-item">
                    <strong>3. Berapa rating kepuasan Anda?</strong>
                    <p>Rating dari Sangat Puas hingga Sangat Tidak Puas.</p>
                </div>
                <div class="question-item">
                    <strong>4. Ada saran atau masukan untuk kami?</strong>
                    <p>Apa yang bisa kami tingkatkan lebih lanjut?</p>
                </div>
            </div>

            <div style="text-align: center;">
                <a href="{{ $feedbackUrl }}" class="cta-button">Berikan Feedback Saya →</a>
            </div>

            <p style="color: #999; font-size: 12px; margin-top: 30px;">
                <em>Link ini hanya berlaku untuk Anda. Jangan bagikan dengan orang lain.</em>
            </p>

            <p>Terima kasih atas waktu dan feedback Anda! 🙏</p>
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
