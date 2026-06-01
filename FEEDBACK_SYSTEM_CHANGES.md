# Update Feedback System - Menggunakan Existing Questions & Answers Tables

## Perubahan Utama

Sistem feedback sekarang **memanfaatkan struktur yang sudah ada** di tabel `questions` dan `answers`, bukan membuat struktur terpisah.

### Sebelum (Initial Design)
```
Feedback Flow:
User Input → Tabel `feedbacks` (terpisah) → Database
```

### Sesudah (Updated Design)
```
Feedback Flow:
User Input → Tabel `answers` (existing) → Database
           ↓
       Tracking Email → Tabel `feedback_invitations` (for email history only)
```

## Files Yang Berubah

### 1. FeedbackInvitation Model
**Sebelum:** Track `feedback_submitted`, `feedback_submitted_at`
**Sesudah:** Hanya track `email_sent_at`, `reminder_sent_at`
- Pengecekan feedback submit sekarang dilakukan dengan method `isFeedbackSubmitted()`
- Query jawaban dari tabel `answers` WHERE question_type = 'feedback'

```php
// Sebelum
if ($invitation->feedback_submitted) { }

// Sesudah
if ($invitation->isFeedbackSubmitted()) { }
```

### 2. Migration feedback_tables
**Sebelum:** Membuat 2 tabel (`feedback_invitations` + `feedbacks`)
**Sesudah:** Hanya membuat 1 tabel (`feedback_invitations`)
- Jawaban disimpan di tabel `answers` yang sudah ada
- Hanya perlu tracking email history di `feedback_invitations`

### 3. FeedbackController
**Sebelum:** Validasi hardcoded 4 pertanyaan, save ke tabel `feedbacks`
**Sesudah:** Validasi dinamis, query questions dari database, save ke tabel `answers`

```php
// Sebelum
$validated = $request->validate([
    'how_suitable' => 'required|string|min:10',
    'usefulness' => 'required|string|min:10',
    'overall_rating' => 'required|in:very_satisfied,...',
    'suggestions' => 'nullable|string',
]);
Feedback::create([...]);

// Sesudah
$feedbackQuestions = Question::where('question_type', 'feedback')->get();
foreach ($feedbackQuestions as $question) {
    Answer::create([
        'question_id' => $question->id,
        'test_attempt_id' => $invitation->test_attempt_id,
        'answer' => $request->input("answer.{$question->id}"),
    ]);
}
```

### 4. Feedback Form View
**Sebelum:** Hardcoded 4 pertanyaan
**Sesudah:** Dynamic loop dari questions yang ada di database

```blade
{{-- Sebelum --}}
<input name="how_suitable" />
<input name="usefulness" />
<input name="overall_rating" />

{{-- Sesudah --}}
@foreach ($questions as $question)
    <input name="answer[{{ $question->id }}]" />
@endforeach
```

## Keuntungan

✅ **Fleksibilitas:** Admin bisa tambah/edit pertanyaan tanpa ubah code
✅ **Reusable:** Satu struktur untuk kuisioner dan feedback
✅ **DRY:** Tidak ada duplikasi tabel & logic
✅ **Scalable:** Support choice dan essay type questions
✅ **Consistency:** Semua jawaban user tersimpan di tabel yang sama

## Admin Panel Integration

Admin bisa membuat feedback questions langsung di admin panel dengan:
- `question_text`: "Pertanyaan feedback"
- `question_type`: "feedback" (enum)
- `answer_type`: "essay" atau "choice"
- `option`: JSON untuk pilihan (jika choice type)

```php
// Contoh Question:
{
    "id": 1,
    "question_text": "Seberapa cocok hasil tes?",
    "question_type": "feedback",
    "answer_type": "essay",
    "option": null
}

{
    "id": 2,
    "question_text": "Rating kepuasan?",
    "question_type": "feedback",
    "answer_type": "choice",
    "option": ["Sangat Puas", "Puas", "Biasa", "Tidak Puas"]
}
```

## Data Flow

```
1. User selesai test
   ↓
2. TestAttempt.finished_at diupdate
   ↓
3. Job SendFeedbackInvitationEmail di-dispatch (delay 7 hari)
   ↓
4. Email dikirim, FeedbackInvitation created dengan token
   ↓
5. User buka link dengan token
   ↓
6. Form ditampilkan dengan queries questions (question_type='feedback')
   ↓
7. User submit jawaban
   ↓
8. Jawaban disimpan ke tabel answers (question_id, test_attempt_id, answer)
   ↓
9. FeedbackInvitation tidak perlu update (sudah bisa detect dari answers)
   ↓
10. Jika belum submit setelah 7 hari: reminder email dikirim
```

## No Breaking Changes

- Model `Feedback` masih ada tapi tidak digunakan (bisa di-delete nanti)
- Semua routes tetap sama
- Email templates tetap sama
- Consent checkbox tetap ada di register form

## Testing

Untuk testing, buat feedback questions di database:

```bash
php artisan tinker

App\Models\Question::create([
    'question_text' => 'Seberapa cocok hasil tes?',
    'question_type' => 'feedback',
    'answer_type' => 'essay',
]);

App\Models\Question::create([
    'question_text' => 'Rating kepuasan?',
    'question_type' => 'feedback',
    'answer_type' => 'choice',
    'option' => json_encode(['Sangat Puas', 'Puas', 'Biasa']),
]);
```

Kemudian test form feedback akan menampilkan pertanyaan-pertanyaan tersebut secara dinamis.
