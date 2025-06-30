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
                'target_role' => 'wali_kelas',
            ],
            [
                'name' => 'Fasilitas Sekolah',
                'target_role' => 'staff_tu',
            ],
            [
                'name' => 'Keamanan Sekolah',
                'target_role' => 'guru_piket',
            ],
            [
                'name' => 'Administrasi',
                'target_role' => 'staff_tu',
            ],
            [
                'name' => 'Konseling',
                'target_role' => 'guru_bk',
            ],
            [
                'name' => 'Keuangan / SPP',
                'target_role' => 'staff_tu',
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
