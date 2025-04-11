<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classroom;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = [
            'Kelas 1',
            'Kelas 2',
            'Kelas 3',
            'Kelas 4',
            'Kelas 5',
            'Kelas 6',
        ];

        foreach ($classes as $class) {
            Classroom::create(['name' => $class]);
        }
    }
}
