<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Pengaduan;
use App\Models\ComplaintResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ResponsePengaduan extends Component
{
    use WithFileUploads;

    public $pengaduan;
    public $message;
    public $attachments = [];
    public $newStatus;
    public $actionType = 'response';
    
    protected $rules = [
        'message' => 'required|string|max:2000',
        'attachments.*' => 'nullable|file|max:10240', // Max 10MB per file
        'newStatus' => 'nullable|in:Diajukan,Diproses,Selesai',
    ];

    protected $messages = [
        'message.required' => 'Pesan tanggapan harus diisi.',
        'message.max' => 'Pesan maksimal 2000 karakter.',
        'attachments.*.file' => 'File yang diupload tidak valid.',
        'attachments.*.max' => 'Ukuran file maksimal 10MB.',
    ];

    public function mount($pengaduanId)
    {
        $this->pengaduan = Pengaduan::with(['student', 'category', 'assignedUser', 'complaintResponses.user'])
            ->findOrFail($pengaduanId);
        
        // Check if user can handle this complaint
        if (!$this->pengaduan->canBeHandledBy(Auth::id())) {
            abort(403, 'Anda tidak memiliki akses untuk menangani pengaduan ini.');
        }

        $this->newStatus = $this->pengaduan->status;
    }

    public function sendResponse()
    {
        $this->validate();

        // Check permission again
        if (!$this->pengaduan->canBeHandledBy(Auth::id())) {
            session()->flash('error', 'Anda tidak memiliki akses untuk menangani pengaduan ini.');
            return;
        }

        try {
            // Upload attachments if any
            $uploadedFiles = [];
            if (!empty($this->attachments)) {
                foreach ($this->attachments as $attachment) {
                    $path = $attachment->store('complaint-responses', 'public');
                    $uploadedFiles[] = $path;
                }
            }

            // Determine action type
            $actionType = 'response';
            if ($this->newStatus !== $this->pengaduan->status) {
                $actionType = $this->newStatus === 'Selesai' ? 'completion' : 'status_update';
            }

            // Create response
            ComplaintResponse::create([
                'pengaduan_id' => $this->pengaduan->id,
                'user_id' => Auth::id(),
                'message' => $this->message,
                'attachments' => $uploadedFiles,
                'action_type' => $actionType,
            ]);

            // Update status if changed
            if ($this->newStatus !== $this->pengaduan->status) {
                $this->pengaduan->update(['status' => $this->newStatus]);
            }

            // Reset form
            $this->reset(['message', 'attachments']);
            $this->pengaduan = $this->pengaduan->fresh(['student', 'category', 'assignedUser', 'complaintResponses.user']);

            session()->flash('message', 'Tanggapan berhasil dikirim.');
            
            // If status changed to completed, email will be sent automatically via model event

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function removeAttachment($index)
    {
        unset($this->attachments[$index]);
        $this->attachments = array_values($this->attachments);
    }

    public function render()
    {
        return view('livewire.admin.response-pengaduan');
    }
}
