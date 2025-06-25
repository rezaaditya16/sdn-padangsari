<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\Category;
use App\Models\Classroom;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Categories first
        $categories = [
            ['name' => 'Pengumuman Sekolah', 'target_role' => 'all'],
            ['name' => 'Kegiatan', 'target_role' => 'all'],
            ['name' => 'Akademik', 'target_role' => 'all'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']], $category);
        }

        // Create Classrooms
        $classrooms = [
            ['name' => 'Kelas 1A'],
            ['name' => 'Kelas 1B'],
            ['name' => 'Kelas 2A'],
            ['name' => 'Kelas 2B'],
            ['name' => 'Kelas 3A'],
            ['name' => 'Kelas 3B'],
            ['name' => 'Kelas 4A'],
            ['name' => 'Kelas 4B'],
            ['name' => 'Kelas 5A'],
            ['name' => 'Kelas 5B'],
            ['name' => 'Kelas 6A'],
            ['name' => 'Kelas 6B'],
        ];

        foreach ($classrooms as $classroom) {
            Classroom::firstOrCreate(['name' => $classroom['name']], $classroom);
        }

        // Create sample teachers
        $teachers = [
            [
                'name' => 'Dra. Siti Nurhaida, M.Pd',
                'position' => 'Guru Bahasa Indonesia',
            ],
            [
                'name' => 'Ahmad Fauzi, S.Pd',
                'position' => 'Guru Matematika',
            ],
            [
                'name' => 'Maria Magdalena, S.Pd',
                'position' => 'Guru IPA',
            ],
            [
                'name' => 'Budi Santoso, S.Pd',
                'position' => 'Guru Pendidikan Jasmani',
            ],
        ];

        foreach ($teachers as $teacher) {
            Teacher::firstOrCreate(['name' => $teacher['name']], $teacher);
        }

        // Create sample students
        $students = [
            [
                'name' => 'Andi Pratama',
                'nisn' => '2015123001',
                'class' => 'Kelas 6A',
                'classroom_id' => Classroom::where('name', 'Kelas 6A')->first()->id,
                'birth_date' => '2015-05-15',
                'parent_email' => 'orangtua.andi@gmail.com',
            ],
            [
                'name' => 'Sari Dewi',
                'nisn' => '2015123002',
                'class' => 'Kelas 6A',
                'classroom_id' => Classroom::where('name', 'Kelas 6A')->first()->id,
                'birth_date' => '2015-03-20',
                'parent_email' => 'orangtua.sari@gmail.com',
            ],
            [
                'name' => 'Rizki Aditya',
                'nisn' => '2016123003',
                'class' => 'Kelas 5A',
                'classroom_id' => Classroom::where('name', 'Kelas 5A')->first()->id,
                'birth_date' => '2016-08-10',
                'parent_email' => 'orangtua.rizki@gmail.com',
            ],
            [
                'name' => 'Maya Sari',
                'nisn' => '2016123004',
                'class' => 'Kelas 5A',
                'classroom_id' => Classroom::where('name', 'Kelas 5A')->first()->id,
                'birth_date' => '2016-12-05',
                'parent_email' => 'orangtua.maya@gmail.com',
            ],
        ];

        foreach ($students as $student) {
            Student::firstOrCreate(['nisn' => $student['nisn']], $student);
        }

        // Create sample announcements
        $announcements = [
            [
                'title' => 'Libur Semester Ganjil 2024/2025',
                'content' => 'Pengumuman libur semester ganjil tahun ajaran 2024/2025 akan dimulai tanggal 23 Desember 2024 sampai dengan 6 Januari 2025. Siswa diharapkan tetap belajar di rumah.',
                'image' => 'uploads/announcements/libur.jpg',
                'publish_date' => now()->subDays(2),
            ],
            [
                'title' => 'Pendaftaran Ekstrakurikuler Semester Genap',
                'content' => 'Pendaftaran ekstrakurikuler untuk semester genap telah dibuka. Tersedia ekstrakurikuler Pramuka, Karate, Seni Tari, dan Komputer. Pendaftaran dibuka hingga 15 Januari 2025.',
                'image' => 'uploads/announcements/ekskul.jpg',
                'publish_date' => now()->subDays(1),
            ],
            [
                'title' => 'Ulangan Tengah Semester Genap',
                'content' => 'Ulangan Tengah Semester (UTS) Genap akan dilaksanakan pada tanggal 15-19 Maret 2025. Siswa diharapkan mempersiapkan diri dengan baik.',
                'image' => 'uploads/announcements/uts.jpg',
                'publish_date' => now()->addDays(30),
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::firstOrCreate(['title' => $announcement['title']], $announcement);
        }

        // Create sample gallery
        $galleries = [
            [
                'title' => 'Kegiatan Upacara Bendera',
                'description' => 'Dokumentasi kegiatan upacara bendera rutin setiap hari Senin',
                'images' => json_encode(['uploads/gallery/upacara1.jpg', 'uploads/gallery/upacara2.jpg']),
            ],
            [
                'title' => 'Lomba Merdeka 17 Agustus',
                'description' => 'Dokumentasi berbagai lomba dalam rangka memperingati Hari Kemerdekaan Indonesia',
                'images' => json_encode(['uploads/gallery/lomba1.jpg', 'uploads/gallery/lomba2.jpg', 'uploads/gallery/lomba3.jpg']),
            ],
            [
                'title' => 'Kunjungan Edukatif',
                'description' => 'Kegiatan kunjungan edukatif siswa kelas 5 ke museum dan taman edukasi',
                'images' => json_encode(['uploads/gallery/kunjungan1.jpg', 'uploads/gallery/kunjungan2.jpg']),
            ],
        ];

        foreach ($galleries as $gallery) {
            Gallery::firstOrCreate(['title' => $gallery['title']], $gallery);
        }

        $this->command->info('Sample data created successfully!');
        $this->command->info('Teachers: ' . Teacher::count());
        $this->command->info('Students: ' . Student::count());
        $this->command->info('Announcements: ' . Announcement::count());
        $this->command->info('Galleries: ' . Gallery::count());
        $this->command->info('Categories: ' . Category::count());
        $this->command->info('Classrooms: ' . Classroom::count());
    }
}
