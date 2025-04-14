<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Announcement;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $announcements = [
            [
                'title' => 'Pengumuman Libur Nasional',
                'content' => 'Sekolah akan diliburkan pada tanggal 17 Agustus 2025 untuk memperingati Hari Kemerdekaan.',
                'image' => 'libur-nasional.jpg',
                'publish_date' => '2025-08-10',
            ],
            [
                'title' => 'Kegiatan Donor Darah',
                'content' => 'Akan diadakan kegiatan donor darah pada tanggal 20 Mei 2025 di aula sekolah.',
                'image' => 'donor-darah.jpg',
                'publish_date' => '2025-05-15',
            ],
            [
                'title' => 'Pengumuman Ujian Akhir',
                'content' => 'Ujian akhir semester akan dilaksanakan mulai tanggal 1 Juni 2025.',
                'image' => 'ujian-akhir.jpg',
                'publish_date' => '2025-05-25',
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }
    }
}
