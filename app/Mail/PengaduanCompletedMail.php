<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use App\Models\Pengaduan;
use App\Models\ComplaintResponse;

class PengaduanCompletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengaduan;
    public $responses;
    public $attachments;

    /**
     * Create a new message instance.
     */
    public function __construct(Pengaduan $pengaduan, $attachments = [])
    {
        $this->pengaduan = $pengaduan;
        $this->responses = $pengaduan->complaintResponses()->with('user')->get();
        $this->attachments = $attachments;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[SDN Padangsari] Pengaduan Telah Diselesaikan - ' . $this->pengaduan->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.pengaduan-completed',
            with: [
                'pengaduan' => $this->pengaduan,
                'responses' => $this->responses,
                'studentName' => $this->pengaduan->student->name ?? 'Siswa',
                'categoryName' => $this->pengaduan->category->name ?? 'Umum',
                'handlerName' => $this->pengaduan->assignedUser->name ?? 'Tim Sekolah',
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
        
        foreach ($this->attachments as $filePath) {
            if (file_exists($filePath)) {
                $attachments[] = Attachment::fromPath($filePath);
            }
        }
        
        return $attachments;
    }
}
