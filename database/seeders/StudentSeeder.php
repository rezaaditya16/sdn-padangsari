<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $students = [
            ['name' => 'Abigail', 'class' => 'Kelas 1', 'photo' => ''],
            ['name' => 'Agus', 'class' => 'Kelas 1', 'photo' => ''],
            ['name' => 'Cakra', 'class' => 'Kelas 1', 'photo' => ''],
            ['name' => 'David', 'class' => 'Kelas 1', 'photo' => ''],
            ['name' => 'Ega', 'class' => 'Kelas 1', 'photo' => ''],
            ['name' => 'Fajar', 'class' => 'Kelas 1', 'photo' => ''],

            ['name' => 'Agustina', 'class' => 'Kelas 2', 'photo' => ''],
            ['name' => 'Bagus', 'class' => 'Kelas 2', 'photo' => ''],
            ['name' => 'Cahya', 'class' => 'Kelas 2', 'photo' => ''],
            ['name' => 'Dafa', 'class' => 'Kelas 3', 'photo' => ''],
            ['name' => 'Naufa', 'class' => 'Kelas 3', 'photo' => ''],
            ['name' => 'Joni', 'class' => 'Kelas 3', 'photo' => ''],

            ['name' => 'Jono', 'class' => 'Kelas 4', 'photo' => ''],
        ];

        foreach ($students as $studentData) {
            Student::create($studentData);
        }
    }
}
