<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('questions')->insert([

            // ── Q1 → study_hours_weekly ──────────────────────────────────────
            [
                'question_text' => 'Berapa total jam kamu belajar dalam seminggu (di luar jam kuliah)?',
                'question_type' => 'kuisioner',
                'option'        => json_encode([
                    'Kurang dari 5 jam',
                    '5–10 jam',
                    '10–20 jam',
                    'Lebih dari 20 jam',
                ]),
                'answer_type'   => 'choice',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],

            // ── Q2 → organization_level ──────────────────────────────────────
            [
                'question_text' => 'Seberapa terorganisir cara kamu merencanakan jadwal belajar?',
                'question_type' => 'kuisioner',
                'option'        => json_encode([
                    'Tidak terorganisir sama sekali',
                    'Kurang terorganisir',
                    'Cukup terorganisir',
                    'Sangat terorganisir',
                ]),
                'answer_type'   => 'choice',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],

            // ── Q3 → procrastination_level ───────────────────────────────────
            [
                'question_text' => 'Seberapa sering kamu menunda-nunda tugas atau belajar?',
                'question_type' => 'kuisioner',
                'option'        => json_encode([
                    'Hampir tidak pernah',
                    'Jarang',
                    'Kadang-kadang',
                    'Sering',
                ]),
                'answer_type'   => 'choice',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],

            // ── Q4 → uses_study_aids ─────────────────────────────────────────
            [
                'question_text' => 'Apakah kamu menggunakan alat bantu belajar seperti flashcard, mind map, ringkasan, atau aplikasi belajar?',
                'question_type' => 'kuisioner',
                'option'        => json_encode([
                    'Tidak pernah',
                    'Jarang',
                    'Kadang-kadang',
                    'Selalu',
                ]),
                'answer_type'   => 'choice',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],

            // ── Q5 → study_location ──────────────────────────────────────────
            [
                'question_text' => 'Di mana kamu paling sering belajar?',
                'question_type' => 'kuisioner',
                'option'        => json_encode([
                    'Rumah/Kos',
                    'Perpustakaan',
                    'Kafe',
                    'Kampus (luar kelas)',
                ]),
                'answer_type'   => 'choice',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],

            // ── Q6 → study_method ────────────────────────────────────────────
            [
                'question_text' => 'Metode belajar mana yang paling cocok untukmu?',
                'question_type' => 'kuisioner',
                'option'        => json_encode([
                    'Visual (diagram, video, warna)',
                    'Auditori (rekaman, diskusi)',
                    'Kinestetik (praktik langsung)',
                    'Membaca/Menulis (catatan, buku)',
                ]),
                'answer_type'   => 'choice',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            
            // pretest question
            [
                'question_text' => 'Semester berapa kamu saat ini?',
                'question_type' => 'pretest',
                'option'        => json_encode(['Semester 1', 'Semester 2', 'Semester 3', 'Semester 4', 'Semester 5', 'Semester 6', 'Semester 7', 'Semester 8']),
                'answer_type'   => 'choice',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'question_text' => 'Aktivitas lain yang kamu lakukan seperti apa selain kuliah?',
                'question_type' => 'pretest',
                'option'        => json_encode(['Fokus kuliah', 'Kuliah sambil organisasi', 'Kuliah sambil kerja/freelance', 'Aktif lomba/proyek']),
                'answer_type'   => 'choice',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'question_text' => 'Hal apa yang paling sering membuat belajar terasa sulit?',
                'question_type' => 'pretest',
                'option'        => json_encode(['Sulit fokus', 'Mudah terdistraksi', 'Kurang konsisten', 'Cepat bosan', 'Sulit mengatur waktu']),
                'answer_type'   => 'choice',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'question_text' => 'Apa yang paling kamu harapkan dari aplikasi ini?',
                'question_type' => 'pretest',
                'option'        => json_encode(['Membantu lebih fokus', 'Membantu lebih disiplin', 'Membantu mengatur belajar', 'Membantu membangun kebiasaan belajar', 'Membantu meningkatkan produktivitas']),
                'answer_type'   => 'choice',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],

        ]);
    }
}