<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use App\Mail\PengaduanCompletedMail;
use App\Models\Pengaduan;

class EmailSettings extends Component
{
    public $mailMailer;
    public $mailHost;
    public $mailPort;
    public $mailUsername;
    public $mailPassword;
    public $mailFromAddress;
    public $mailFromName;
    public $testEmail;
    
    protected $rules = [
        'mailMailer' => 'required|in:smtp,log,sendmail',
        'mailHost' => 'nullable|string',
        'mailPort' => 'nullable|integer',
        'mailUsername' => 'nullable|string',
        'mailPassword' => 'nullable|string',
        'mailFromAddress' => 'required|email',
        'mailFromName' => 'required|string',
        'testEmail' => 'nullable|email',
    ];

    public function mount()
    {
        $this->loadCurrentSettings();
    }

    public function loadCurrentSettings()
    {
        $this->mailMailer = env('MAIL_MAILER', 'log');
        $this->mailHost = env('MAIL_HOST', 'smtp.gmail.com');
        $this->mailPort = env('MAIL_PORT', '587');
        $this->mailUsername = env('MAIL_USERNAME', '');
        $this->mailPassword = env('MAIL_PASSWORD', '');
        $this->mailFromAddress = env('MAIL_FROM_ADDRESS', 'noreply@sdnpadangsari.sch.id');
        $this->mailFromName = env('MAIL_FROM_NAME', 'SDN Padangsari 01');
    }

    public function saveSettings()
    {
        $this->validate();

        try {
            $this->updateEnvFile();
            
            // Clear config cache
            Artisan::call('config:clear');
            
            session()->flash('message', 'Pengaturan email berhasil disimpan. Silakan restart aplikasi untuk menerapkan perubahan.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menyimpan pengaturan: ' . $e->getMessage());
        }
    }

    private function updateEnvFile()
    {
        $envPath = base_path('.env');
        $envContent = File::get($envPath);

        $updates = [
            'MAIL_MAILER' => $this->mailMailer,
            'MAIL_HOST' => $this->mailHost,
            'MAIL_PORT' => $this->mailPort,
            'MAIL_USERNAME' => $this->mailUsername,
            'MAIL_PASSWORD' => $this->mailPassword,
            'MAIL_FROM_ADDRESS' => '"' . $this->mailFromAddress . '"',
            'MAIL_FROM_NAME' => '"' . $this->mailFromName . '"',
        ];

        foreach ($updates as $key => $value) {
            $pattern = "/^{$key}=.*/m";
            $replacement = "{$key}={$value}";
            
            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, $replacement, $envContent);
            } else {
                $envContent .= "\n{$replacement}";
            }
        }

        File::put($envPath, $envContent);
    }

    public function sendTestEmail()
    {
        $this->validate(['testEmail' => 'required|email']);

        try {
            // Get a sample pengaduan for testing
            $pengaduan = Pengaduan::with(['student', 'category', 'assignedUser', 'complaintResponses.user'])
                ->first();

            if (!$pengaduan) {
                session()->flash('error', 'Tidak ada data pengaduan untuk test email.');
                return;
            }

            // Send test email
            Mail::to($this->testEmail)->send(new PengaduanCompletedMail($pengaduan));
            
            session()->flash('message', "Test email berhasil dikirim ke {$this->testEmail}");
            
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal mengirim test email: ' . $e->getMessage());
        }
    }

    public function getCurrentTemplate()
    {
        $templatePath = resource_path('views/emails/pengaduan-completed.blade.php');
        if (file_exists($templatePath)) {
            return File::get($templatePath);
        }
        return 'Template tidak ditemukan';
    }

    public function openTemplateEditor()
    {
        return redirect()->route('admin.email-template-editor');
    }

    public function previewTemplate()
    {
        try {
            // Get sample data
            $pengaduan = Pengaduan::with(['student', 'category', 'assignedUser', 'complaintResponses.user'])->first();
            
            if (!$pengaduan) {
                session()->flash('error', 'Tidak ada data pengaduan untuk preview template.');
                return;
            }

            // Generate preview HTML
            $mail = new PengaduanCompletedMail($pengaduan);
            
            session()->flash('message', 'Preview template berhasil. Silakan cek email log atau kirim test email.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal preview template: ' . $e->getMessage());
        }
    }

    public function resetTemplate()
    {
        try {
            $defaultTemplate = $this->getDefaultTemplate();
            $templatePath = resource_path('views/emails/pengaduan-completed.blade.php');
            
            File::put($templatePath, $defaultTemplate);
            
            session()->flash('message', 'Template berhasil direset ke default.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal reset template: ' . $e->getMessage());
        }
    }

    private function getDefaultTemplate()
    {
        return '<x-mail::message>
# Pengaduan Telah Diselesaikan

Yth. Orang Tua/Wali {{ $studentName }},

Kami informasikan bahwa pengaduan yang Anda laporkan telah diselesaikan oleh tim sekolah.

## Detail Pengaduan

**Judul:** {{ $pengaduan->title }}  
**Kategori:** {{ $categoryName }}  
**Tanggal Pengaduan:** {{ $pengaduan->created_at->format(\'d M Y, H:i\') }}  
**Ditangani Oleh:** {{ $handlerName }}  
**Status:** {{ $pengaduan->status }}  
**Diselesaikan Pada:** {{ $pengaduan->completed_at->format(\'d M Y, H:i\') }}

## Pesan Asli
{{ $pengaduan->message }}

@if($responses->count() > 0)
## Tanggapan dan Tindak Lanjut

@foreach($responses as $response)
**{{ $response->user->name }} ({{ $response->created_at->format(\'d M Y, H:i\') }}):**  
{{ $response->message }}

@endforeach
@endif

## Informasi Tambahan

- Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi sekolah melalui kontak yang tersedia
- Dokumentasi terkait penyelesaian masalah terlampir dalam email ini (jika ada)
- Terima kasih atas kepercayaan Anda kepada SDN Padangsari 01

<x-mail::button :url="config(\'app.url\')" color="success">
Kunjungi Website Sekolah
</x-mail::button>

Salam hormat,<br>
**SDN Padangsari 01**<br>
Tim Manajemen Sekolah
</x-mail::message>';
    }

    public function getBladeExample($variable)
    {
        return '{{ $' . $variable . ' }}';
    }

    public function render()
    {
        return view('livewire.admin.email-settings');
    }
}
