<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $students = [
            // Kelas 1
            ['name' => 'Abigail', 'class' => 'Kelas 1', 'photo' => ''],
            ['name' => 'Agus', 'class' => 'Kelas 1', 'photo' => ''],
            ['name' => 'Cakra', 'class' => 'Kelas 1', 'photo' => ''],
            ['name' => 'David', 'class' => 'Kelas 1', 'photo' => ''],
            ['name' => 'Ega', 'class' => 'Kelas 1', 'photo' => ''],
            ['name' => 'Fajar', 'class' => 'Kelas 1', 'photo' => ''],
            ['name' => 'Gilang', 'class' => 'Kelas 1', 'photo' => ''],
            ['name' => 'Hana', 'class' => 'Kelas 1', 'photo' => ''],
            ['name' => 'Irfan', 'class' => 'Kelas 1', 'photo' => ''],
            ['name' => 'Joko', 'class' => 'Kelas 1', 'photo' => ''],

            // Kelas 2
            ['name' => 'Agustina', 'class' => 'Kelas 2', 'photo' => ''],
            ['name' => 'Bagus', 'class' => 'Kelas 2', 'photo' => ''],
            ['name' => 'Cahya', 'class' => 'Kelas 2', 'photo' => ''],
            ['name' => 'Dina', 'class' => 'Kelas 2', 'photo' => ''],
            ['name' => 'Erlangga', 'class' => 'Kelas 2', 'photo' => ''],
            ['name' => 'Farah', 'class' => 'Kelas 2', 'photo' => ''],
            ['name' => 'Gita', 'class' => 'Kelas 2', 'photo' => ''],
            ['name' => 'Hendra', 'class' => 'Kelas 2', 'photo' => ''],
            ['name' => 'Indah', 'class' => 'Kelas 2', 'photo' => ''],
            ['name' => 'Jamal', 'class' => 'Kelas 2', 'photo' => ''],

            // Kelas 3
            ['name' => 'Dafa', 'class' => 'Kelas 3', 'photo' => ''],
            ['name' => 'Naufa', 'class' => 'Kelas 3', 'photo' => ''],
            ['name' => 'Joni', 'class' => 'Kelas 3', 'photo' => ''],
            ['name' => 'Kirana', 'class' => 'Kelas 3', 'photo' => ''],
            ['name' => 'Lutfi', 'class' => 'Kelas 3', 'photo' => ''],
            ['name' => 'Maya', 'class' => 'Kelas 3', 'photo' => ''],
            ['name' => 'Nanda', 'class' => 'Kelas 3', 'photo' => ''],
            ['name' => 'Omar', 'class' => 'Kelas 3', 'photo' => ''],
            ['name' => 'Putri', 'class' => 'Kelas 3', 'photo' => ''],
            ['name' => 'Qori', 'class' => 'Kelas 3', 'photo' => ''],

            // Kelas 4
            ['name' => 'Jono', 'class' => 'Kelas 4', 'photo' => ''],
            ['name' => 'Rama', 'class' => 'Kelas 4', 'photo' => ''],
            ['name' => 'Sinta', 'class' => 'Kelas 4', 'photo' => ''],
            ['name' => 'Tari', 'class' => 'Kelas 4', 'photo' => ''],
            ['name' => 'Umar', 'class' => 'Kelas 4', 'photo' => ''],
            ['name' => 'Vina', 'class' => 'Kelas 4', 'photo' => ''],
            ['name' => 'Wawan', 'class' => 'Kelas 4', 'photo' => ''],
            ['name' => 'Xena', 'class' => 'Kelas 4', 'photo' => ''],
            ['name' => 'Yusuf', 'class' => 'Kelas 4', 'photo' => ''],
            ['name' => 'Zahra', 'class' => 'Kelas 4', 'photo' => ''],

            // Kelas 5
            ['name' => 'Alya', 'class' => 'Kelas 5', 'photo' => ''],
            ['name' => 'Bima', 'class' => 'Kelas 5', 'photo' => ''],
            ['name' => 'Citra', 'class' => 'Kelas 5', 'photo' => ''],
            ['name' => 'Dewi', 'class' => 'Kelas 5', 'photo' => ''],
            ['name' => 'Eko', 'class' => 'Kelas 5', 'photo' => ''],
            ['name' => 'Fani', 'class' => 'Kelas 5', 'photo' => ''],
            ['name' => 'Gilang', 'class' => 'Kelas 5', 'photo' => ''],
            ['name' => 'Hani', 'class' => 'Kelas 5', 'photo' => ''],
            ['name' => 'Irfan', 'class' => 'Kelas 5', 'photo' => ''],
            ['name' => 'Joko', 'class' => 'Kelas 5', 'photo' => ''],

            // Kelas 6
            ['name' => 'Andi', 'class' => 'Kelas 6', 'photo' => ''],
            ['name' => 'Budi', 'class' => 'Kelas 6', 'photo' => ''],
            ['name' => 'Cindy', 'class' => 'Kelas 6', 'photo' => ''],
            ['name' => 'Doni', 'class' => 'Kelas 6', 'photo' => ''],
            ['name' => 'Eka', 'class' => 'Kelas 6', 'photo' => ''],
            ['name' => 'Fajar', 'class' => 'Kelas 6', 'photo' => ''],
            ['name' => 'Gita', 'class' => 'Kelas 6', 'photo' => ''],
            ['name' => 'Hadi', 'class' => 'Kelas 6', 'photo' => ''],
            ['name' => 'Indra', 'class' => 'Kelas 6', 'photo' => ''],
            ['name' => 'Jaya', 'class' => 'Kelas 6', 'photo' => ''],
        ];

        foreach ($students as $studentData) {
            Student::create($studentData);
        }
    }
}
