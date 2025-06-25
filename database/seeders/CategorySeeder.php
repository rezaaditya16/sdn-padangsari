<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Bullying / Perundungan',
                'target_role' => 'guru_bk',
            ],
            [
                'name' => 'Masalah Akademik',
                'target_role' => 'guru_mapel',
            ],
            [
                'name' => 'Fasilitas Sekolah',
                'target_role' => 'tenaga_pendidik',
            ],
            [
                'name' => 'Administrasi',
                'target_role' => 'kepala_sekolah',
            ],
            [
                'name' => 'Konseling',
                'target_role' => 'guru_bk',
            ],
            [
                'name' => 'Lainnya',
                'target_role' => 'admin',
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate([
                'name' => $category['name'],
            ], $category);
        }
    }
}
