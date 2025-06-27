<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Classroom;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $students = [
            // Kelas 1A
            [
                'nisn' => '1234567890',
                'name' => 'Ahmad Rizki Pratama',
                'birth_date' => '2015-03-15',
                'classroom_id' => 1, // Kelas 1
                'photo' => '',
                'parent_email' => 'rizkipratama@gmail.com'
            ],
            [
                'nisn' => '1234567891',
                'name' => 'Siti Nurhaliza',
                'birth_date' => '2015-05-20',
                'classroom_id' => 1, // Kelas 1
                'photo' => '',
                'parent_email' => 'nurhaliza.parent@gmail.com'
            ],
            [
                'nisn' => '1234567892',
                'name' => 'Cakra Wirawan',
                'birth_date' => '2015-02-10',
                'classroom_id' => 1, // Kelas 1
                'photo' => '',
                'parent_email' => 'cakra.parent@gmail.com'
            ],
            [
                'nisn' => '1234567893',
                'name' => 'David Saputra',
                'birth_date' => '2015-04-25',
                'classroom_id' => 1, // Kelas 1
                'photo' => '',
                'parent_email' => 'david.parent@gmail.com'
            ],
            [
                'nisn' => '1234567894',
                'name' => 'Eka Putri',
                'birth_date' => '2015-01-18',
                'classroom_id' => 1, // Kelas 1
                'photo' => '',
                'parent_email' => 'eka.parent@gmail.com'
            ],

            // Kelas 2A
            [
                'nisn' => '1234567895',
                'name' => 'Fajar Maulana',
                'birth_date' => '2014-08-10',
                'classroom_id' => 2, // Kelas 2
                'photo' => '',
                'parent_email' => 'fajar.parent@gmail.com'
            ],
            [
                'nisn' => '1234567896',
                'name' => 'Gilang Rahman',
                'birth_date' => '2014-12-05',
                'classroom_id' => 2, // Kelas 2
                'photo' => '',
                'parent_email' => 'gilang.parent@gmail.com'
            ],
            [
                'nisn' => '1234567897',
                'name' => 'Hana Permata',
                'birth_date' => '2014-07-22',
                'classroom_id' => 2, // Kelas 2
                'photo' => '',
                'parent_email' => 'hana.parent@gmail.com'
            ],
            [
                'nisn' => '1234567898',
                'name' => 'Irfan Hidayat',
                'birth_date' => '2014-11-18',
                'classroom_id' => 2, // Kelas 2
                'photo' => '',
                'parent_email' => 'irfan.parent@gmail.com'
            ],
            [
                'nisn' => '1234567899',
                'name' => 'Joko Susilo',
                'birth_date' => '2014-04-30',
                'classroom_id' => 2, // Kelas 2
                'photo' => '',
                'parent_email' => 'joko.parent@gmail.com'
            ],

            // Kelas 3A
            [
                'nisn' => '1234567800',
                'name' => 'Kirana Sari',
                'birth_date' => '2013-09-14',
                'classroom_id' => 3, // Kelas 3
                'photo' => '',
                'parent_email' => 'kirana.parent@gmail.com'
            ],
            [
                'nisn' => '1234567801',
                'name' => 'Lutfi Hakim',
                'birth_date' => '2013-01-25',
                'classroom_id' => 3, // Kelas 3
                'photo' => '',
                'parent_email' => 'lutfi.parent@gmail.com'
            ],
            [
                'nisn' => '1234567802',
                'name' => 'Maya Dewi',
                'birth_date' => '2013-06-08',
                'classroom_id' => 3, // Kelas 3
                'photo' => '',
                'parent_email' => 'maya.parent@gmail.com'
            ],
            [
                'nisn' => '1234567803',
                'name' => 'Nanda Pratama',
                'birth_date' => '2013-10-12',
                'classroom_id' => 3, // Kelas 3
                'photo' => '',
                'parent_email' => 'nanda.parent@gmail.com'
            ],
            [
                'nisn' => '1234567804',
                'name' => 'Omar Malik',
                'birth_date' => '2013-03-28',
                'classroom_id' => 3, // Kelas 3
                'photo' => '',
                'parent_email' => 'omar.parent@gmail.com'
            ],

            // Kelas 4A
            [
                'nisn' => '1234567805',
                'name' => 'Putri Anggraini',
                'birth_date' => '2012-02-14',
                'classroom_id' => 4, // Kelas 4
                'photo' => '',
                'parent_email' => 'putri.parent@gmail.com'
            ],
            [
                'nisn' => '1234567806',
                'name' => 'Rama Wijaya',
                'birth_date' => '2012-07-19',
                'classroom_id' => 4, // Kelas 4
                'photo' => '',
                'parent_email' => 'rama.parent@gmail.com'
            ],
            [
                'nisn' => '1234567807',
                'name' => 'Sinta Maharani',
                'birth_date' => '2012-09-03',
                'classroom_id' => 4, // Kelas 4
                'photo' => '',
                'parent_email' => 'sinta.parent@gmail.com'
            ],
            [
                'nisn' => '1234567808',
                'name' => 'Tari Lestari',
                'birth_date' => '2012-11-26',
                'classroom_id' => 4, // Kelas 4
                'photo' => '',
                'parent_email' => 'tari.parent@gmail.com'
            ],
            [
                'nisn' => '1234567809',
                'name' => 'Umar Faruq',
                'birth_date' => '2012-04-17',
                'classroom_id' => 4, // Kelas 4
                'photo' => '',
                'parent_email' => 'umar.parent@gmail.com'
            ],

            // Kelas 5A
            [
                'nisn' => '1234567810',
                'name' => 'Vina Amelia',
                'birth_date' => '2011-08-09',
                'classroom_id' => 5, // Kelas 5
                'photo' => '',
                'parent_email' => 'vina.parent@gmail.com'
            ],
            [
                'nisn' => '1234567811',
                'name' => 'Wawan Setiawan',
                'birth_date' => '2011-01-22',
                'classroom_id' => 5, // Kelas 5
                'photo' => '',
                'parent_email' => 'wawan.parent@gmail.com'
            ],
            [
                'nisn' => '1234567812',
                'name' => 'Xena Safira',
                'birth_date' => '2011-05-15',
                'classroom_id' => 5, // Kelas 5
                'photo' => '',
                'parent_email' => 'xena.parent@gmail.com'
            ],
            [
                'nisn' => '1234567813',
                'name' => 'Yusuf Rahman',
                'birth_date' => '2011-12-30',
                'classroom_id' => 5, // Kelas 5
                'photo' => '',
                'parent_email' => 'yusuf.parent@gmail.com'
            ],
            [
                'nisn' => '1234567814',
                'name' => 'Zahra Putri',
                'birth_date' => '2011-09-18',
                'classroom_id' => 5, // Kelas 5
                'photo' => '',
                'parent_email' => 'zahra.parent@gmail.com'
            ],

            // Kelas 6A
            [
                'nisn' => '1234567815',
                'name' => 'Alya Azzahra',
                'birth_date' => '2010-03-05',
                'classroom_id' => 6, // Kelas 6
                'photo' => '',
                'parent_email' => 'alya.parent@gmail.com'
            ],
            [
                'nisn' => '1234567816',
                'name' => 'Bima Sakti',
                'birth_date' => '2010-06-20',
                'classroom_id' => 6, // Kelas 6
                'photo' => '',
                'parent_email' => 'bima.parent@gmail.com'
            ],
            [
                'nisn' => '1234567817',
                'name' => 'Citra Kencana',
                'birth_date' => '2010-11-12',
                'classroom_id' => 6, // Kelas 6
                'photo' => '',
                'parent_email' => 'citra.parent@gmail.com'
            ],
            [
                'nisn' => '1234567818',
                'name' => 'Dewi Sartika',
                'birth_date' => '2010-08-28',
                'classroom_id' => 6, // Kelas 6
                'photo' => '',
                'parent_email' => 'dewi.parent@gmail.com'
            ],
            [
                'nisn' => '1234567819',
                'name' => 'Eko Prasetyo',
                'birth_date' => '2010-02-10',
                'classroom_id' => 6, // Kelas 6
                'photo' => '',
                'parent_email' => 'eko.parent@gmail.com'
            ],

            // Data testing yang mudah diingat
            [
                'nisn' => '1111111111',
                'name' => 'Test Student 1',
                'birth_date' => '2015-01-01',
                'classroom_id' => 1, // Kelas 1
                'photo' => '',
                'parent_email' => 'test1@gmail.com'
            ],
            [
                'nisn' => '2222222222',
                'name' => 'Test Student 2',
                'birth_date' => '2014-02-02',
                'classroom_id' => 2, // Kelas 2
                'photo' => '',
                'parent_email' => 'test2@gmail.com'
            ],
            [
                'nisn' => '3333333333',
                'name' => 'Test Student 3',
                'birth_date' => '2013-03-03',
                'classroom_id' => 3, // Kelas 3
                'photo' => '',
                'parent_email' => 'test3@gmail.com'
            ]
        ];

        foreach ($students as $studentData) {
            // Verifikasi bahwa classroom_id yang direferensikan ada
            if (Classroom::find($studentData['classroom_id'])) {
                Student::create($studentData);
            }
        }

        // Tampilkan informasi untuk testing
        $this->command->info('Student seeder completed! Created ' . count($students) . ' students.');
        $this->command->info('');
        $this->command->info('=== SAMPLE LOGIN CREDENTIALS FOR TESTING ===');
        $this->command->info('NISN: 1234567890, Birth Date: 2015-03-15 (Ahmad Rizki Pratama - Kelas 1)');
        $this->command->info('NISN: 1111111111, Birth Date: 2015-01-01 (Test Student 1 - Kelas 1)');
        $this->command->info('NISN: 2222222222, Birth Date: 2014-02-02 (Test Student 2 - Kelas 2)');
        $this->command->info('NISN: 3333333333, Birth Date: 2013-03-03 (Test Student 3 - Kelas 3)');
        $this->command->info('===========================================');
    }
}
