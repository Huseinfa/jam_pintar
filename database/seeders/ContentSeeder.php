<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('contents')->insert([
            [
                'type'       => 'Hero Section',
                'title'      => 'Selamat Datang',
                'text'       => 'Kenali waktu belajar terbaikmu',
                'image'      => 'carousel1.jpg',
                'order'      => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type'       => 'Hero Section',
                'title'      => 'Tentang Tes',
                'text'       => 'Tes ini membantu menentukan chronotype kamu',
                'image'      => 'intro.jpg',
                'order'      => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
