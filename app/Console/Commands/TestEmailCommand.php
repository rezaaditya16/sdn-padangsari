<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\PengaduanCompletedMail;
use App\Models\Pengaduan;

class TestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? 'test@example.com';
        
        $this->info('Testing email functionality...');
        $this->info('Mail Driver: ' . config('mail.default'));
        $this->info('Mail Host: ' . config('mail.mailers.smtp.host'));
        $this->info('Mail Port: ' . config('mail.mailers.smtp.port'));
        $this->info('Mail From: ' . config('mail.from.address'));
        $this->info('Mail From Name: ' . config('mail.from.name'));
        
        // Get test pengaduan
        $pengaduan = Pengaduan::with(['student', 'category', 'assignedToUser', 'complaintResponses.user'])->first();
        
        if (!$pengaduan) {
            $this->error('No pengaduan found for testing!');
            return Command::FAILURE;
        }
        
        $this->info('Using pengaduan: ' . $pengaduan->title);
        $this->info('Student: ' . $pengaduan->student->name);
        $this->info('Category: ' . $pengaduan->category->name);
        
        try {
            Mail::to($email)->send(new PengaduanCompletedMail($pengaduan));
            $this->info("✅ Test email sent successfully to: {$email}");
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("❌ Failed to send test email: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
