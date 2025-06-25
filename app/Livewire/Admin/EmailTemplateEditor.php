<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\File;
use App\Models\Pengaduan;
use App\Mail\PengaduanCompletedMail;
use Illuminate\Support\Facades\Mail;

class EmailTemplateEditor extends Component
{
    public $templateContent;
    public $previewEmail;
    
    protected $rules = [
        'templateContent' => 'required|string',
        'previewEmail' => 'nullable|email',
    ];

    public function mount()
    {
        $this->loadTemplate();
    }

    public function loadTemplate()
    {
        $templatePath = resource_path('views/emails/pengaduan-completed.blade.php');
        if (file_exists($templatePath)) {
            $this->templateContent = File::get($templatePath);
        } else {
            $this->templateContent = $this->getDefaultTemplate();
        }
    }

    public function saveTemplate()
    {
        $this->validate(['templateContent' => 'required|string']);

        try {
            $templatePath = resource_path('views/emails/pengaduan-completed.blade.php');
            
            // Backup current template
            $backupPath = resource_path('views/emails/pengaduan-completed.backup.' . date('Y-m-d-H-i-s') . '.blade.php');
            if (file_exists($templatePath)) {
                File::copy($templatePath, $backupPath);
            }
            
            // Save new template
            File::put($templatePath, $this->templateContent);
            
            session()->flash('message', 'Template email berhasil disimpan. Backup dibuat di: ' . basename($backupPath));
            
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menyimpan template: ' . $e->getMessage());
        }
    }

    public function previewTemplate()
    {
        $this->validate(['previewEmail' => 'required|email']);

        try {
            // Save current template temporarily
            $tempPath = resource_path('views/emails/pengaduan-completed-temp.blade.php');
            File::put($tempPath, $this->templateContent);
            
            // Get sample data
            $pengaduan = Pengaduan::with(['student', 'category', 'assignedUser', 'complaintResponses.user'])->first();
            
            if (!$pengaduan) {
                session()->flash('error', 'Tidak ada data pengaduan untuk preview template.');
                return;
            }

            // Create temporary mail class that uses temp template
            $mail = new class($pengaduan) extends PengaduanCompletedMail {
                public function content(): \Illuminate\Mail\Mailables\Content
                {
                    return new \Illuminate\Mail\Mailables\Content(
                        markdown: 'emails.pengaduan-completed-temp',
                        with: [
                            'pengaduan' => $this->pengaduan,
                            'responses' => $this->responses,
                            'studentName' => $this->pengaduan->student->name ?? 'Siswa',
                            'categoryName' => $this->pengaduan->category->name ?? 'Umum',
                            'handlerName' => $this->pengaduan->assignedUser->name ?? 'Tim Sekolah',
                        ]
                    );
                }
            };

            // Send preview email
            Mail::to($this->previewEmail)->send($mail);
            
            // Clean up temp file
            File::delete($tempPath);
            
            session()->flash('message', "Preview template berhasil dikirim ke: {$this->previewEmail}");
            
        } catch (\Exception $e) {
            // Clean up temp file if exists
            $tempPath = resource_path('views/emails/pengaduan-completed-temp.blade.php');
            if (file_exists($tempPath)) {
                File::delete($tempPath);
            }
            
            session()->flash('error', 'Gagal mengirim preview: ' . $e->getMessage());
        }
    }

    public function resetTemplate()
    {
        $this->templateContent = $this->getDefaultTemplate();
        session()->flash('message', 'Template direset ke default. Klik "Simpan Template" untuk menyimpan perubahan.');
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

    public function render()
    {
        return view('livewire.admin.email-template-editor');
    }
}
