# Feedback System - Final Architecture

## ✅ Struktur Database yang Dibutuhkan

### Tabel yang Ada (Existing)
```
questions
├── id
├── question_text
├── question_type: ENUM ['kuisioner', 'feedback']
├── answer_type: ENUM ['choice', 'essay']
├── option: JSON (for choice type)
└── timestamps

answers
├── id
├── question_id (FK → questions)
├── test_attempt_id (FK → test_attempts)
├── answer (text)
└── timestamps
```

### Tabel Baru (Created by Migration)
```
feedback_invitations
├── id
├── user_id (FK → users)
├── test_attempt_id (FK → test_attempts)
├── token (UNIQUE - untuk link verification)
├── email_sent_at (timestamp - kapan invitation dikirim)
├── reminder_sent_at (timestamp - kapan reminder dikirim)
└── timestamps
```

**CATATAN:** Jawaban feedback disimpan di tabel `answers` yang sudah ada, BUKAN di tabel terpisah.

---

## 📁 Files yang Dibutuhkan

### Models (3 files)
✅ `app/Models/FeedbackInvitation.php` - Track email invitations
✅ `app/Models/Answer.php` - Already exists, no changes
✅ `app/Models/Question.php` - Already exists, no changes

❌ `app/Models/Feedback.php` - **DIHAPUS** (tidak terpakai lagi)

### Controllers (1 file)
✅ `app/Http/Controllers/FeedbackController.php`
- `showForm($token)` - Tampilkan form dengan dynamic questions
- `submitFeedback($token)` - Save ke tabel `answers`
- `successPage()` - Success page
- `listPendingReminders()` - List feedback yang belum diisi

### Jobs (2 files)
✅ `app/Jobs/SendFeedbackInvitationEmail.php` - Kirim email invitation (delay 7 hari)
✅ `app/Jobs/SendFeedbackReminderEmail.php` - Kirim email reminder (7 hari setelah invitation)

### Mailables (2 files)
✅ `app/Mail/FeedbackInvitationMail.php` - Template email invitation
✅ `app/Mail/FeedbackReminderMail.php` - Template email reminder

### Commands (2 files)
✅ `app/Console/Commands/SendFeedbackInvitations.php` - CLI command
✅ `app/Console/Commands/SendFeedbackReminders.php` - CLI command

### Views (4 files)
✅ `resources/views/feedback/form.blade.php` - Dynamic form (loop questions)
✅ `resources/views/feedback/success.blade.php` - Success page
✅ `resources/views/feedback/pending-reminders.blade.php` - List pending
✅ `resources/views/emails/feedback-invitation.blade.php` - Email template
✅ `resources/views/emails/feedback-reminder.blade.php` - Email template

### Migrations (2 files)
✅ `database/migrations/2026_05_23_000001_add_feedback_consent_to_users_table.php`
- Tambah kolom `allow_feedback_emails` di tabel `users`

✅ `database/migrations/2026_05_23_000002_create_feedback_tables.php`
- Create tabel `feedback_invitations` SAJA

### Routes (web.php)
✅ Sudah ada di `routes/web.php`:
```php
Route::get('/feedback/{token}', [FeedbackController::class, 'showForm'])->name('feedback.form');
Route::post('/feedback/{token}', [FeedbackController::class, 'submitFeedback'])->name('feedback.submit');
Route::get('/feedback/success', [FeedbackController::class, 'successPage'])->name('feedback.success');
Route::get('/feedback/reminders', [FeedbackController::class, 'listPendingReminders'])->name('student.feedback.reminders');
```

---

## 🔄 Data Flow

```
1. Admin buat Questions
   Question::create([
       'question_text' => 'Pertanyaan feedback?',
       'question_type' => 'feedback',
       'answer_type' => 'essay',
   ])

2. User selesai test
   TestAttempt::update(['finished_at' => now()])
   → Auto-dispatch job (7 hari delay)

3. Email invitation dikirim
   FeedbackInvitation::create([
       'user_id' => $user->id,
       'test_attempt_id' => $attempt->id,
       'token' => unique_token,
       'email_sent_at' => now(),
   ])

4. User buka link `/feedback/{token}`
   → FeedbackController::showForm($token)
   → Query questions WHERE question_type='feedback'
   → Render form dinamis

5. User submit jawaban
   → FeedbackController::submitFeedback($token)
   → Loop questions dan save ke answers table:
   Answer::create([
       'question_id' => $question->id,
       'test_attempt_id' => $attempt->id,
       'answer' => user_answer,
   ])

6. Check apakah feedback diisi?
   → FeedbackInvitation::isFeedbackSubmitted()
   → Query answers WHERE question.question_type='feedback'
       AND test_attempt_id=$attempt->id

7. Jika belum diisi (7 hari setelah email)
   → Email reminder dikirim
   → reminder_sent_at updated
```

---

## 🛠️ Setup Steps

### 1. Jalankan Migration
```bash
php artisan migrate
```

### 2. Buat Feedback Questions (Admin)
```bash
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
    'question_text' => 'Rating kepuasan Anda?',
    'question_type' => 'feedback',
    'answer_type' => 'choice',
    'option' => json_encode(['Sangat Puas', 'Puas', 'Biasa', 'Tidak Puas']),
]);
```

### 3. Setup Queue Worker
```bash
# Development (.env: QUEUE_CONNECTION=sync)
# Production (.env: QUEUE_CONNECTION=redis atau lainnya)
php artisan queue:work
```

### 4. Setup Scheduler
Di `app/Console/Kernel.php`:
```php
$schedule->command('feedback:send-invitations')->daily()->at('02:00');
$schedule->command('feedback:send-reminders')->daily()->at('03:00');
```

### 5. Setup Mail
Di `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=...
MAIL_PORT=...
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_FROM_ADDRESS=no-reply@jampintar.com
MAIL_FROM_NAME=Jam Pintar
```

---

## 📊 Checklist Files

### ✅ KEEP (Sudah ada & benar)
- [x] `FeedbackInvitation.php` model
- [x] `FeedbackController.php` controller
- [x] `SendFeedbackInvitationEmail.php` job
- [x] `SendFeedbackReminderEmail.php` job
- [x] `FeedbackInvitationMail.php` mailable
- [x] `FeedbackReminderMail.php` mailable
- [x] `SendFeedbackInvitations.php` command
- [x] `SendFeedbackReminders.php` command
- [x] `feedback/form.blade.php` view
- [x] `feedback/success.blade.php` view
- [x] `feedback/pending-reminders.blade.php` view
- [x] `emails/feedback-invitation.blade.php` view
- [x] `emails/feedback-reminder.blade.php` view
- [x] Migration untuk `feedback_consent`
- [x] Migration untuk `feedback_invitations`

### ❌ DELETE (Tidak terpakai)
- [x] `Feedback.php` model - **SUDAH DIHAPUS**
- [x] `Migration create_feedbacks table` - **TIDAK DIPERLUKAN** (sudah di migration #2)

---

## 🔍 Error Checking

Setiap file sudah:
- ✅ Tidak ada import `Feedback` yang error
- ✅ Import hanya `FeedbackInvitation`
- ✅ Semua class dan method terdefenisi
- ✅ Jawaban disimpan ke `answers` table

**Jika masih ada error, jalankan:**
```bash
php artisan config:clear
php artisan cache:clear
composer dump-autoload
```

---

## 🎯 Key Points

1. **Jawaban feedback = Jawaban kuisioner**
   - Keduanya disimpan di tabel `answers`
   - Dibedakan by `question.question_type`

2. **Form dinamis**
   - Admin bisa add/edit feedback questions kapan saja
   - Form otomatis update tanpa perlu code change

3. **Token-based link**
   - Setiap user punya token unik
   - Tidak bisa akses feedback orang lain
   - Link dapat reuse (jika belum submit)

4. **Email history tracking**
   - `feedback_invitations.email_sent_at` - kapan invitation dikirim
   - `feedback_invitations.reminder_sent_at` - kapan reminder dikirim
   - Bukan untuk menyimpan jawaban

5. **No separate table for feedback answers**
   - Semua jawaban di `answers` table
   - Filter by `question.question_type = 'feedback'`
   - Lebih fleksibel dan DRY
