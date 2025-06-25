<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengaduan;
use App\Models\Student;
use App\Models\Category;

class PengaduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some students and categories
        $students = Student::limit(3)->get();
        $categories = Category::all();

        if ($students->isEmpty() || $categories->isEmpty()) {
            $this->command->info('No students or categories found. Run StudentSeeder and CategorySeeder first.');
            return;
        }

        $pengaduanData = [
            [
                'title' => 'Anak saya dibully oleh teman sekelas',
                'message' => 'Mohon bantuan, anak saya Ahmad Rizki sering dibully oleh teman sekelasnya. Dia sudah tidak mau berangkat sekolah. Tolong ditindaklanjuti segera.',
                'status' => 'Diajukan',
                'category_name' => 'Bullying / Perundungan'
            ],
            [
                'title' => 'Nilai matematika anak saya turun drastis',
                'message' => 'Saya khawatir dengan nilai matematika anak saya yang terus menurun. Apakah ada masalah dengan metode pengajaran atau anak saya yang kurang memahami?',
                'status' => 'Diproses',
                'category_name' => 'Masalah Akademik'
            ],
            [
                'title' => 'Fasilitas toilet sekolah rusak',
                'message' => 'Toilet di lantai 2 sudah rusak dari minggu lalu. Anak-anak jadi tidak nyaman. Mohon diperbaiki segera.',
                'status' => 'Diajukan',
                'category_name' => 'Fasilitas Sekolah'
            ],
            [
                'title' => 'Kesalahan dalam administrasi nilai rapor',
                'message' => 'Ada kesalahan dalam penulisan nilai rapor anak saya. Nilai bahasa Indonesia seharusnya 85 bukan 75. Mohon koreksi.',
                'status' => 'Selesai',
                'category_name' => 'Administrasi'
            ],
            [
                'title' => 'Anak saya butuh konseling',
                'message' => 'Anak saya terlihat stress dan sering menangis di rumah. Saya rasa dia butuh konseling dari guru BK.',
                'status' => 'Diajukan',
                'category_name' => 'Konseling'
            ],
            [
                'title' => 'Permintaan informasi kegiatan ekstrakurikuler',
                'message' => 'Saya ingin mengetahui jadwal dan jenis ekstrakurikuler yang tersedia untuk anak saya. Apakah ada ekstrakurikuler olahraga?',
                'status' => 'Diajukan',
                'category_name' => 'Lainnya'
            ]
        ];

        foreach ($pengaduanData as $index => $data) {
            $category = $categories->where('name', $data['category_name'])->first();
            $student = $students->get($index % $students->count());

            if ($category && $student) {
                Pengaduan::create([
                    'student_id' => $student->id,
                    'category_id' => $category->id,
                    'title' => $data['title'],
                    'message' => $data['message'],
                    'status' => $data['status'],
                    'responded_at' => $data['status'] === 'Diproses' ? now()->subDays(1) : null,
                    'completed_at' => $data['status'] === 'Selesai' ? now() : null,
                ]);
            }
        }

        $this->command->info('Sample pengaduan records created successfully.');
    }
}
