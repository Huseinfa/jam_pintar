# Panduan Setup Fitur Feedback Reminder

## Overview
Fitur ini memungkinkan sistem untuk mengumpulkan feedback dari pengguna setelah mereka menyelesaikan test. Jawaban feedback disimpan di tabel `answers` yang sudah ada, dengan `question_type = 'feedback'`.

Alurnya adalah:

1. Admin membuat questions dengan `question_type = 'feedback'`
2. User menyelesaikan tes
3. Hasil tes dikirim ke email
4. Setelah 7 hari, email undangan feedback dikirim
5. User dapat mengisi feedback melalui link yang dikirim
6. Jawaban disimpan di tabel `answers` (terhubung dengan questions dan test_attempt)
7. Jika user tidak mengisi feedback dalam 7 hari setelah email undangan, reminder akan dikirim
8. Feedback reminder juga ditampilkan di halaman profil user

## Komponen yang Dibuat

### Database Migrations
- `2026_05_23_000001_add_feedback_consent_to_users_table.php` - Menambah kolom `allow_feedback_emails` di tabel users
- `2026_05_23_000002_create_feedback_tables.php` - Membuat tabel `feedback_invitations` (hanya untuk tracking email)

### Models
- `App\Models\FeedbackInvitation` - Model untuk tracking undangan feedback (email sent, reminder sent)
- **Note:** Jawaban feedback disimpan di model `Answer` yang sudah ada, dengan `question.question_type = 'feedback'`

### Controllers
- `App\Http\Controllers\FeedbackController` - Handle form feedback dan submission

### Jobs
- `App\Jobs\SendFeedbackInvitationEmail` - Job untuk mengirim email feedback invitation
- `App\Jobs\SendFeedbackReminderEmail` - Job untuk mengirim email reminder

### Mailables
- `App\Mail\FeedbackInvitationMail` - Email template untuk feedback invitation
- `App\Mail\FeedbackReminderMail` - Email template untuk feedback reminder

### Console Commands
- `App\Console\Commands\SendFeedbackInvitations` - Command untuk mengirim invitations
- `App\Console\Commands\SendFeedbackReminders` - Command untuk mengirim reminders

### Views
- `resources/views/feedback/form.blade.php` - Form pengisian feedback (dynamic dari questions)
- `resources/views/feedback/success.blade.php` - Halaman sukses setelah submit feedback
- `resources/views/feedback/pending-reminders.blade.php` - Halaman list feedback yang tertunda
- `resources/views/emails/feedback-invitation.blade.php` - Email template invitation
- `resources/views/emails/feedback-reminder.blade.php` - Email template reminder

### Routes
```php
// Public routes untuk feedback
Route::get('/feedback/{token}', [FeedbackController::class, 'showForm'])->name('feedback.form');
Route::post('/feedback/{token}', [FeedbackController::class, 'submitFeedback'])->name('feedback.submit');
Route::get('/feedback/success', [FeedbackController::class, 'successPage'])->name('feedback.success');

// Student routes
Route::get('/feedback/reminders', [FeedbackController::class, 'listPendingReminders'])->name('student.feedback.reminders');
```

## Setup Instructions

### 1. Jalankan Migration
```bash
php artisan migrate
```

Ini akan membuat:
- Kolom `allow_feedback_emails` di tabel `users` (default: true)
- Tabel `feedback_invitations` untuk tracking undangan

### 2. Buat Feedback Questions
Admin harus membuat questions dengan `question_type = 'feedback'` di database atau melalui admin panel:

```php
// Contoh: Create questions via Tinker
php artisan tinker

App\Models\Question::create([
    'question_text' => 'Seberapa cocok hasil tes dengan kepribadian Anda?',
    'question_type' => 'feedback',
    'answer_type' => 'essay',
    'option' => null,
]);

App\Models\Question::create([
    'question_text' => 'Seberapa berguna aplikasi ini untuk Anda?',
    'question_type' => 'feedback',
    'answer_type' => 'essay',
    'option' => null,
]);

App\Models\Question::create([
    'question_text' => 'Rating kepuasan Anda terhadap Jam Pintar?',
    'question_type' => 'feedback',
    'answer_type' => 'choice',
    'option' => json_encode(['Sangat Puas', 'Puas', 'Biasa Saja', 'Tidak Puas', 'Sangat Tidak Puas']),
]);

// dst...
```

### 3. Setup Queue (Opsional tapi Recommended)
Untuk production, gunakan queue system (Redis, SQS, dll). Update `.env`:
```env
QUEUE_CONNECTION=redis  # atau driver lainnya
```

Kemudian jalankan queue worker:
```bash
php artisan queue:work
```

Untuk development, bisa menggunakan `sync` driver:
```env
QUEUE_CONNECTION=sync
```

### 4. Setup Scheduler (Untuk Auto-Send Reminders)
Edit `app/Console/Kernel.php` dan tambahkan schedule di method `schedule()`:

```php
$schedule->command('feedback:send-invitations')->daily()->at('02:00');
$schedule->command('feedback:send-reminders')->daily()->at('03:00');
```

Atau jalankan manual kapan saja:
```bash
php artisan feedback:send-invitations
php artisan feedback:send-reminders
```

### 5. Setup Mail Configuration
Update `.env` dengan mail driver:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io  # atau provider lainnya
MAIL_PORT=465
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@jampintar.com
MAIL_FROM_NAME="Jam Pintar"
```

## Alur Kerja

### Saat User Register/Login
- Checkbox untuk mengizinkan email feedback tersedia di form register
- Default: checked (izin diberikan)
- Dapat diubah di settings profil nanti

### Saat User Menyelesaikan Test
- `TestAttempt` model akan secara otomatis schedule job `SendFeedbackInvitationEmail`
- Job akan dijalankan setelah 7 hari via queue

### Email Invitation Dikirim (Hari ke-7)
- User menerima email dengan link feedback
- Email berisi preview pertanyaan feedback yang ada
- Link unique per user (token-based)

### User Mengisi Feedback
- Buka link dari email
- Form ditampilkan secara dinamis berdasarkan questions dengan `question_type = 'feedback'`
- Jawaban disimpan ke tabel `answers` dengan `question_id` dan `test_attempt_id`

### Jika User Belum Submit (7 hari setelah invitation)
- Reminder email dikirim otomatis
- Ditampilkan notif di profile page
- Link untuk mengisi feedback masih berlaku

## Customization

### Mengubah Delay Email Invitation
Di `app/Models/TestAttempt.php`, ubah angka hari:
```php
SendFeedbackInvitationEmail::dispatch($model)->delay(now()->addDays(7));  // 7 -> ubah ke angka lain
```

### Mengubah Feedback Questions
Ganti atau tambah questions di database dengan `question_type = 'feedback'`. Form akan otomatis tampil dengan questions yang ada.

### Mengubah Template Email
Edit file di:
- `resources/views/emails/feedback-invitation.blade.php`
- `resources/views/emails/feedback-reminder.blade.php`

## Database Schema

### feedback_invitations table
```
id (primary key)
user_id (foreign key to users)
test_attempt_id (foreign key to test_attempts)
token (unique string - for link verification)
email_sent_at (timestamp - when invitation was sent)
reminder_sent_at (timestamp - when reminder was sent)
created_at, updated_at
```

### answers table (existing)
Digunakan untuk menyimpan jawaban feedback:
```
id (primary key)
question_id (foreign key to questions - where question_type = 'feedback')
test_attempt_id (foreign key to test_attempts)
answer (text - jawaban user)
created_at, updated_at
```

## Testing

### Manual Testing di Development
1. Buat test attempt baru
2. Ubah `finished_at` di database ke 7 hari lalu
3. Jalankan command:
   ```bash
   php artisan feedback:send-invitations
   ```
4. Cek email di Mailtrap atau log

### Testing Dengan Tinker
```bash
php artisan tinker

# Buat test attempt
$attempt = App\Models\TestAttempt::find(1);
$attempt->update(['finished_at' => now()->subDays(7)]);

# Dispatch job
App\Jobs\SendFeedbackInvitationEmail::dispatch($attempt);
```

### Check Apakah Feedback Sudah Diisi
```bash
php artisan tinker

$invitation = App\Models\FeedbackInvitation::find(1);
$invitation->isFeedbackSubmitted();  // true/false
```

## Troubleshooting

### Email tidak terkirim
- Cek `.env` MAIL configuration
- Cek `storage/logs/` untuk error messages
- Pastikan queue worker berjalan (jika menggunakan queue)

### Job tidak dijalankan
- Untuk development, pastikan `QUEUE_CONNECTION=sync` di `.env`
- Untuk production, pastikan queue worker berjalan

### Form feedback tidak menampilkan pertanyaan
- Pastikan sudah ada questions dengan `question_type = 'feedback'` di database
- Cek di table `questions`: `SELECT * FROM questions WHERE question_type = 'feedback'`

### Migration error
```bash
php artisan migrate:rollback
php artisan migrate
```

## Important Notes

- Jawaban feedback disimpan di tabel `answers` yang sudah ada
- Setiap questions dengan `question_type = 'feedback'` akan ditampilkan di form
- `answer_type` bisa 'choice' (radio button) atau 'essay' (textarea)
- Jika `answer_type = 'choice'`, gunakan `option` JSON untuk list pilihan
- Token-based feedback link (unik per user, can't reuse)

## Future Enhancements
- [ ] Buat feedback analytics dashboard
- [ ] Export feedback ke CSV/Excel
- [ ] Sentiment analysis pada feedback
- [ ] Allow user untuk mengubah consent preferences
- [ ] Batch email sending dengan rate limiting
