<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUsers = [
            [
                'name' => 'Admin SDN Padangsari',
                'email' => 'admin@sdn-padangsari.sch.id',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Kepala Sekolah',
                'email' => 'kepala@sdn-padangsari.sch.id',
                'password' => Hash::make('kepala123'),
                'role' => 'kepala_sekolah',
            ],
            [
                'name' => 'Guru BK',
                'email' => 'bk@sdn-padangsari.sch.id',
                'password' => Hash::make('gurubk123'),
                'role' => 'guru_bk',
            ],
            [
                'name' => 'Guru Mata Pelajaran',
                'email' => 'guru@sdn-padangsari.sch.id',
                'password' => Hash::make('guru123'),
                'role' => 'guru_mapel',
            ],
            [
                'name' => 'Tenaga Pendidik',
                'email' => 'tenaga@sdn-padangsari.sch.id',
                'password' => Hash::make('tenaga123'),
                'role' => 'tenaga_pendidik',
            ],
        ];

        foreach ($adminUsers as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->command->info('Admin users created successfully.');
    }
}
