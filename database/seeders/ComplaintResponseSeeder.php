<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ComplaintResponse;
use App\Models\Pengaduan;
use App\Models\User;

class ComplaintResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get sample pengaduan and users
        $pengaduans = Pengaduan::take(3)->get();
        $admin = User::where('role', 'admin')->first();
        $guru = User::where('role', 'guru')->first();

        if (!$admin || $pengaduans->isEmpty()) {
            $this->command->info('No admin user or pengaduan found. Skipping response seeder.');
            return;
        }

        $responses = [
            [
                'pengaduan_id' => $pengaduans[0]->id,
                'user_id' => $admin->id,
                'message' => 'Terima kasih atas laporan Anda. Kami telah menerima pengaduan ini dan akan segera menindaklanjuti.',
                'attachments' => null,
                'action_type' => 'response',
                'created_at' => now()->subDays(2),
            ],
            [
                'pengaduan_id' => $pengaduans[0]->id,
                'user_id' => $guru ? $guru->id : $admin->id,
                'message' => 'Masalah telah kami investigasi dan sudah kami bicarakan dengan siswa terkait. Kami juga akan meningkatkan pengawasan di area tersebut.',
                'attachments' => null,
                'action_type' => 'status_update',
                'created_at' => now()->subDays(1),
            ],
            [
                'pengaduan_id' => $pengaduans[0]->id,
                'user_id' => $admin->id,
                'message' => 'Pengaduan telah diselesaikan. Kami telah melakukan pembinaan kepada siswa yang bersangkutan dan mengadakan sosialisasi anti-bullying di kelas. Terima kasih atas laporan Anda.',
                'attachments' => null,
                'action_type' => 'completion',
                'created_at' => now()->subHours(2),
            ],
        ];

        if (count($pengaduans) > 1) {
            $responses[] = [
                'pengaduan_id' => $pengaduans[1]->id,
                'user_id' => $admin->id,
                'message' => 'Kami telah menerima laporan fasilitas yang rusak. Tim maintenance akan segera memperbaiki dalam 2-3 hari kerja.',
                'attachments' => null,
                'action_type' => 'response',
                'created_at' => now()->subHours(6),
            ];
        }

        foreach ($responses as $responseData) {
            ComplaintResponse::create($responseData);
        }

        // Update status pengaduan pertama menjadi selesai (tanpa trigger email untuk testing)
        if ($pengaduans->count() > 0) {
            $pengaduans[0]->update(['status' => 'Selesai']);
        }

        $this->command->info('ComplaintResponse seeder completed! Created ' . count($responses) . ' responses.');
        $this->command->info('Note: Email notifications will be sent automatically when status changes to "Selesai".');
    }
}
