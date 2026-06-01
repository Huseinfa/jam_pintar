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
                'question_text' => 'Seberapa cocok hasil tes kepribadian dengan Anda?',
                'question_type' => 'feedback',
                'answer_type'   => 'choice',
                'option' => [
                    'Sangat Cocok',
                    'Cocok',
                    'Kurang Cocok',
                    'Tidak Cocok'
                ],
            ],
            [
                'question_text' => 'Seberapa puas Anda dengan rekomendasi yang diberikan?',
                'question_type' => 'feedback',
                'answer_type'   => 'choice',
                'option' => [
                    'Sangat Puas',
                    'Puas',
                    'Biasa Saja',
                    'Tidak Puas'
                ],
            ],
            [
                'question_text' => 'Apakah instruksi dan penjelasan hasil mudah dipahami?',
                'question_type' => 'feedback',
                'answer_type'   => 'choice',
                'option' => [
                    'Sangat Mudah',
                    'Mudah',
                    'Cukup',
                    'Sulit'
                ],
            ],
            [
                'question_text' => 'Bagaimana penilaian Anda terhadap pengalaman/tampilan aplikasi saat mengikuti tes?',
                'question_type' => 'feedback',
                'answer_type'   => 'choice',
                'option' => [
                    'Sangat Baik',
                    'Baik',
                    'Cukup',
                    'Kurang Baik'
                ],
            ],
            [
                'question_text' => 'Apakah Anda akan merekomendasikan fitur tes ini kepada teman atau kerabat?',
                'question_type' => 'feedback',
                'answer_type'   => 'choice',
                'option' => [
                    'Pasti Merekomendasikan',
                    'Mungkin',
                    'Ragu-ragu',
                    'Tidak Akan'
                ],
            ],
            [
                'question_text' => 'Apa saran, kritik, atau fitur baru yang ingin Anda sampaikan untuk pengembangan Jam Pintar ke depannya?',
                'question_type' => 'feedback',
                'answer_type'   => 'essay',
                'option' => [],
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