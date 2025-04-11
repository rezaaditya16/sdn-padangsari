<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Classroom;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teachers = [
            ['name' => 'Anam', 'position' => 'Guru Kelas 1', 'classroom_id' => 1, 'photo' => ''],
            ['name' => 'Burhan', 'position' => 'Guru Kelas 2', 'classroom_id' => 2, 'photo' => ''],
            ['name' => 'Catur', 'position' => 'Guru Kelas 3', 'classroom_id' => 3, 'photo' => ''],
            ['name' => 'Doni', 'position' => 'Guru Kelas 4', 'classroom_id' => 4, 'photo' => ''],
            ['name' => 'Arga', 'position' => 'Guru Kelas 5', 'classroom_id' => 5, 'photo' => ''],
            ['name' => 'Lala', 'position' => 'Guru Kelas 6', 'classroom_id' => 6, 'photo' => ''],
            ['name' => 'michella', 'position' => 'Guru Bahasa Inggris', 'classroom_id' => null, 'photo' => ''],
            ['name' => 'kitty', 'position' => 'Guru seni Rupa', 'classroom_id' => null, 'photo' => ''],
            ['name' => 'Denis', 'position' => 'Guru Pendidikan Jasmani', 'classroom_id' => null, 'photo' => ''],
        ];

        foreach ($teachers as $teacherData) {
            if ($teacherData['classroom_id'] === null || Classroom::find($teacherData['classroom_id'])) {
                Teacher::create([
                    'name' => $teacherData['name'],
                    'position' => $teacherData['position'],
                    'classroom_id' => $teacherData['classroom_id'],
                    'photo' => $teacherData['photo'],
                ]);
            }
        }
    }
}