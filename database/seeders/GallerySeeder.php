<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galleries = [
            [
                'title' => 'Kegiatan Sekolah',
                'description' => 'Dokumentasi kegiatan sekolah selama bulan April.',
                'images' => ['kegiatan1.jpg', 'kegiatan2.jpg', 'kegiatan3.jpg'],
            ],
            [
                'title' => 'Lomba Olahraga',
                'description' => 'Foto-foto dari lomba olahraga antar kelas.',
                'images' => ['lomba1.jpg', 'lomba2.jpg', 'lomba3.jpg'],
            ],
            [
                'title' => 'Pentas Seni',
                'description' => 'Galeri foto dari pentas seni tahunan.',
                'images' => ['pentas1.jpg', 'pentas2.jpg', 'pentas3.jpg'],
            ],
        ];

        foreach ($galleries as $gallery) {
            Gallery::create($gallery);
        }
    }
}
