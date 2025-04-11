<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Support\Facades\Storage;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = [
            ['name' => 'Abigail', 'classroom_id' => 1, 'photo' => ''],
            ['name' => 'Agus', 'classroom_id' => 1, 'photo' => ''],
            ['name' => 'Cakra', 'classroom_id' => 1, 'photo' => ''],
            ['name' => 'David', 'classroom_id' => 1, 'photo' => ''],
            ['name' => 'Ega', 'classroom_id' => 1, 'photo' => ''],
            ['name' => 'Fajar', 'classroom_id' => 1, 'photo' => ''],

            ['name' => 'Agustina', 'classroom_id' => 2, 'photo' => ''],
            ['name' => 'Bagus', 'classroom_id' => 2, 'photo' => ''],
            ['name' => 'Cahya', 'classroom_id' => 2, 'photo' => ''],
            ['name' => 'Dafa', 'classroom_id' => 3, 'photo' => ''],
            ['name' => 'Naufa', 'classroom_id' => 3, 'photo' => ''],
            ['name' => 'Joni', 'classroom_id' => 3, 'photo' => ''],

            ['name' => 'Jono', 'classroom_id' => 4, 'photo' => ''],
            ['name' => 'Alex', 'classroom_id' => 4, 'photo' => ''],
            ['name' => 'Pasha', 'classroom_id' => 4, 'photo' => ''],
            ['name' => 'Wardi', 'classroom_id' => 5, 'photo' => ''],
            ['name' => 'Eko', 'classroom_id' => 5, 'photo' => ''],
            ['name' => 'Gery', 'classroom_id' => 6, 'photo' => ''],

        ];

        foreach ($students as $studentData) {
            $classroom = Classroom::find($studentData['classroom_id']);
            
            if ($classroom) {
                Student::create([
                    'name' => $studentData['name'],
                    'classroom_id' => $studentData['classroom_id'],
                    'class' => $classroom->name,
                    'photo' => $studentData['photo'],
                ]);
            }
        }
    }
}
