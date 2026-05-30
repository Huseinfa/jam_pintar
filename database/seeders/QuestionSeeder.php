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
            [
                'question_text' => 'Jika kamu diberi tugas berat secara mendadak, apa yang kamu rasakan?',
                'question_type' => 'kuisioner',
                'option'        => json_encode(['Semangat', 'Lemas', 'Mengantuk', 'Biasa Saja']),
                'answer_type'   => 'choice',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'question_text' => 'Pilih gambar yang paling menggambarkan dirimu saat belajar:',
                'question_type' => 'kuisioner',
                'option'        => json_encode(['/img/question/OptionExmpl1.png', '/img/question/OptionExmpl2.png', '/img/question/OptionExmpl3.png', '/img/question/OptionExmpl4.png']),
                'answer_type'   => 'choice',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'question_text' => 'Bagaimana kamu menangani stres akademik?',
                'question_type' => 'kuisioner',
                'option'        => json_encode(['Istirahat cukup', 'Berolahraga', 'Curhat ke teman', 'Fokus pada tugas']),
                'answer_type'   => 'choice',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'question_text' => 'Bagaimana kamu menangani stres akademik?',
                'question_type' => 'kuisioner',
                'option'        => json_encode(['Istirahat cukup', 'Berolahraga', 'Curhat ke teman', 'Fokus pada tugas']),
                'answer_type'   => 'choice',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'question_text' => 'Pilih suasana yang paling mendukung produktivitasmu:',
                'question_type' => 'kuisioner',
                'option'        => json_encode(['/img/question/OptionExmpl1.png', '/img/question/OptionExmpl2.png', '/img/question/OptionExmpl3.png', '/img/question/OptionExmpl4.png']),
                'answer_type'   => 'choice',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'question_text' => 'Apa tipe pelajar yang kamu miliki?',
                'question_type' => 'kuisioner',
                'option'        => json_encode(['Visual', 'Auditori', 'Kinestik', 'Membaca/Menulis']),
                'answer_type'   => 'choice',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'question_text' => 'Pilih gaya belajar yang paling sesuai:',
                'question_type' => 'kuisioner',
                'option'        => json_encode(['/img/question/OptionExmpl1.png', '/img/question/OptionExmpl2.png', '/img/question/OptionExmpl3.png', '/img/question/OptionExmpl4.png']),
                'answer_type'   => 'choice',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'question_text' => 'Preferensi waktu belajar terbaikmu?',
                'question_type' => 'kuisioner',
                'option'        => json_encode(['Pagi', 'Siang', 'Malam', 'Tengah malam']),
                'answer_type'   => 'choice',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'question_text' => 'Pilih metode belajar yang paling efektif untukmu:',
                'question_type' => 'kuisioner',
                'option'        => json_encode(['/img/question/OptionExmpl1.png', '/img/question/OptionExmpl2.png', '/img/question/OptionExmpl3.png', '/img/question/OptionExmpl4.png']),
                'answer_type'   => 'choice',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'question_text' => 'Hambatan terbesarmu dalam belajar?',
                'question_type' => 'kuisioner',
                'option'        => json_encode(['Konsentrasi', 'Motivasi', 'Memahami materi', 'Manajemen waktu']),
                'answer_type'   => 'choice',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'question_text' => 'Pilih goals belajar yang ingin kamu capai:',
                'question_type' => 'kuisioner',
                'option'        => json_encode(['/img/question/OptionExmpl1.png', '/img/question/OptionExmpl2.png', '/img/question/OptionExmpl3.png', '/img/question/OptionExmpl4.png']),
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
