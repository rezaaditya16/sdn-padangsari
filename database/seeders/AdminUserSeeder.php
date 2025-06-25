<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'name' => 'Admin Kepala Sekolah',
                'email' => 'kepsek@sdnpadangsari.sch.id',
                'password' => Hash::make('kepsek123'),
                'role' => 'kepala_sekolah',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Admin Guru BK',
                'email' => 'bk@sdnpadangsari.sch.id',
                'password' => Hash::make('gurubk123'),
                'role' => 'guru_bk',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Admin Wali Kelas',
                'email' => 'walikelas@sdnpadangsari.sch.id',
                'password' => Hash::make('walikelas123'),
                'role' => 'wali_kelas',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Admin Guru Mapel',
                'email' => 'gurumapel@sdnpadangsari.sch.id',
                'password' => Hash::make('gurumapel123'),
                'role' => 'guru_mapel',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Admin Tenaga Pendidik',
                'email' => 'tendik@sdnpadangsari.sch.id',
                'password' => Hash::make('tendik123'),
                'role' => 'tenaga_pendidik',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Super Admin',
                'email' => 'admin@sdnpadangsari.sch.id',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now()
            ]
        ];

        foreach ($adminUsers as $user) {
            User::create($user);
        }

        $this->command->info('Admin users created successfully!');
        $this->command->info('');
        $this->command->info('=== ADMIN LOGIN CREDENTIALS ===');
        $this->command->info('Super Admin:');
        $this->command->info('Email: admin@sdnpadangsari.sch.id | Password: admin123');
        $this->command->info('');
        $this->command->info('Kepala Sekolah:');
        $this->command->info('Email: kepsek@sdnpadangsari.sch.id | Password: kepsek123');
        $this->command->info('');
        $this->command->info('Guru BK:');
        $this->command->info('Email: bk@sdnpadangsari.sch.id | Password: gurubk123');
        $this->command->info('');
        $this->command->info('Wali Kelas:');
        $this->command->info('Email: walikelas@sdnpadangsari.sch.id | Password: walikelas123');
        $this->command->info('');
        $this->command->info('Guru Mapel:');
        $this->command->info('Email: gurumapel@sdnpadangsari.sch.id | Password: gurumapel123');
        $this->command->info('');
        $this->command->info('Tenaga Pendidik:');
        $this->command->info('Email: tendik@sdnpadangsari.sch.id | Password: tendik123');
        $this->command->info('=================================');
    }
}
