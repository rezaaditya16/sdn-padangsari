<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Tips Belajar Efektif',
                'content' => 'Berikut adalah beberapa tips untuk belajar lebih efektif...',
                'image' => 'tips-belajar.jpg',
                'link' => 'https://example.com/tips-belajar',
                'published_at' => '2025-04-15',
            ],
            [
                'title' => 'Kegiatan Sekolah Minggu Ini',
                'content' => 'Jangan lewatkan kegiatan seru di sekolah minggu ini...',
                'image' => 'kegiatan-sekolah.jpg',
                'link' => 'https://example.com/kegiatan-sekolah',
                'published_at' => '2025-04-16',
            ],
            [
                'title' => 'Pengumuman Lomba Menulis',
                'content' => 'Ayo ikuti lomba menulis yang akan diadakan bulan depan...',
                'image' => 'lomba-menulis.jpg',
                'link' => 'https://example.com/lomba-menulis',
                'published_at' => '2025-04-17',
            ],
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}
