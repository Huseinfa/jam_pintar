<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class FeedbackQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $feedbackQuestions = [
            [
                'question_text' => 'Seberapa mudah Anda memahami instruksi dan cara menjawab soal pada aplikasi Jam Pintar?',
                'question_type' => 'feedback',
                'answer_type'   => 'choice',
                'option' => json_encode([
                    'Sangat Sulit',
                    'Sulit',
                    'Cukup Mudah',
                    'Mudah',
                    'Sangat Mudah'
                ]),
            ],
            [
                'question_text' => 'Bagaimana penilaian Anda mengenai tampilan antarmuka (UI) aplikasi Jam Pintar?',
                'question_type' => 'feedback',
                'answer_type'   => 'choice',
                'option' => json_encode([
                    'Sangat Buruk',
                    'Buruk',
                    'Cukup',
                    'Baik',
                    'Sangat Baik'
                ]),
            ],
            [
                'question_text' => 'Apakah durasi waktu tes sudah cukup untuk menyelesaikan seluruh pertanyaan?',
                'question_type' => 'feedback',
                'answer_type'   => 'choice',
                'option' => json_encode([
                    'Sangat Tidak Cukup',
                    'Tidak Cukup',
                    'Cukup',
                    'Cukup Lama',
                    'Sangat Cukup'
                ]),
            ],
            [
                'question_text' => 'Seberapa relevan hasil rekomendasi yang Anda dapatkan setelah tes?',
                'question_type' => 'feedback',
                'answer_type'   => 'choice',
                'option' => json_encode([
                    'Sangat Tidak Relevan',
                    'Tidak Relevan',
                    'Cukup Relevan',
                    'Relevan',
                    'Sangat Relevan'
                ]),
            ],
            [
                'question_text' => 'Seberapa puas Anda terhadap keseluruhan pengalaman menggunakan Jam Pintar?',
                'question_type' => 'feedback',
                'answer_type'   => 'choice',
                'option' => json_encode([
                    'Sangat Tidak Puas',
                    'Tidak Puas',
                    'Netral',
                    'Puas',
                    'Sangat Puas'
                ]),
            ],
        ];

        foreach ($feedbackQuestions as $q) {
            Question::firstOrCreate(
                [
                    'question_text' => $q['question_text'],
                    'question_type' => 'feedback',
                ],
                $q
            );
        }
    }
}