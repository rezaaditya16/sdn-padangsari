<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
            ['name' => 'Michella', 'position' => 'Guru Bahasa Inggris', 'classroom_id' => 7, 'photo' => ''],
            ['name' => 'Kitty', 'position' => 'Guru Seni Rupa', 'classroom_id' => 8, 'photo' => ''],
            ['name' => 'Denis', 'position' => 'Guru Pendidikan Jasmani', 'classroom_id' => 9, 'photo' => ''],
        ];

        foreach ($teachers as $teacherData) {
            if ($teacherData['classroom_id'] === null || Classroom::find($teacherData['classroom_id'])) {
                // Buat data teacher
                $teacher = Teacher::firstOrCreate(
                    ['name' => $teacherData['name']],
                    $teacherData
                );

                // Buat user account untuk login ke admin dashboard
                $firstName = strtolower(explode(' ', $teacherData['name'])[0]);
                $email = $firstName . '@sdn-padangsari.sch.id';
                $password = $firstName . '123';

                User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name' => $teacherData['name'],
                        'email' => $email,
                        'password' => Hash::make($password),
                        'role' => 'guru',
                        'teacher_id' => $teacher->id,
                    ]
                );
            }
        }
    }
}
