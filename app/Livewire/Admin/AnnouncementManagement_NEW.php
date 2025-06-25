<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Announcement;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AnnouncementManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $showModal = false;
    public $showViewModal = false;
    public $showDeleteModal = false;
    public $editMode = false;
    public $announcementId = null;
    public $selectedAnnouncement = null;

    public $form = [
        'title' => '',
        'content' => '',
        'publish_date' => '',
        'image' => null
    ];

    protected $rules = [
        'form.title' => 'required|string|max:255',
        'form.content' => 'required|string',
        'form.publish_date' => 'required|date',
        'form.image' => 'nullable|image|max:2048'
    ];

    protected $messages = [
        'form.title.required' => 'Judul pengumuman harus diisi.',
        'form.content.required' => 'Konten pengumuman harus diisi.',
        'form.publish_date.required' => 'Tanggal publish harus diisi.',
        'form.publish_date.date' => 'Format tanggal tidak valid.',
        'form.image.image' => 'File harus berupa gambar.',
        'form.image.max' => 'Ukuran gambar maksimal 2MB.',
    ];

    public function mount()
    {
        // Check authentication
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya Super Admin yang dapat mengakses halaman ini.');
        }
        
        // Set default publish date
        $this->form['publish_date'] = now()->format('Y-m-d');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function showCreateModal()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function editAnnouncement($id)
    {
        $announcement = Announcement::findOrFail($id);
        $this->announcementId = $id;
        $this->form = [
            'title' => $announcement->title,
            'content' => $announcement->content,
            'publish_date' => $announcement->publish_date ? $announcement->publish_date->format('Y-m-d') : now()->format('Y-m-d'),
            'image' => null // Reset untuk upload baru
        ];
        $this->editMode = true;
        $this->showModal = true;
    }

    public function viewAnnouncement($id)
    {
        $this->selectedAnnouncement = Announcement::findOrFail($id);
        $this->showViewModal = true;
    }

    public function storeAnnouncement()
    {
        $this->validate();

        $data = [
            'title' => $this->form['title'],
            'content' => $this->form['content'],
            'publish_date' => $this->form['publish_date'],
        ];
        
        if ($this->form['image']) {
            $data['image'] = $this->form['image']->store('announcements', 'public');
        }

        if ($this->editMode) {
            $announcement = Announcement::findOrFail($this->announcementId);
            
            // Hapus gambar lama jika ada gambar baru
            if ($this->form['image'] && $announcement->image) {
                Storage::disk('public')->delete($announcement->image);
            }
            
            // Jika tidak ada gambar baru, pertahankan gambar lama
            if (!$this->form['image'] && $announcement->image) {
                $data['image'] = $announcement->image;
            }
            
            $announcement->update($data);
            session()->flash('message', 'Pengumuman berhasil diperbarui!');
        } else {
            // Untuk create baru, image wajib ada
            if (!$this->form['image']) {
                $this->addError('form.image', 'Gambar harus diupload untuk pengumuman baru.');
                return;
            }
            
            Announcement::create($data);
            session()->flash('message', 'Pengumuman berhasil ditambahkan!');
        }

        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $this->announcementId = $id;
        $this->selectedAnnouncement = Announcement::findOrFail($id);
        $this->showDeleteModal = true;
    }

    public function deleteAnnouncement()
    {
        $announcement = Announcement::findOrFail($this->announcementId);
        
        // Hapus gambar jika ada
        if ($announcement->image) {
            Storage::disk('public')->delete($announcement->image);
        }
        
        $announcement->delete();
        
        session()->flash('message', 'Pengumuman berhasil dihapus!');
        $this->showDeleteModal = false;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showViewModal = false;
        $this->showDeleteModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->form = [
            'title' => '',
            'content' => '',
            'publish_date' => now()->format('Y-m-d'),
            'image' => null
        ];
        $this->announcementId = null;
        $this->editMode = false;
        $this->selectedAnnouncement = null;
        $this->resetErrorBag();
    }

    public function getTotalAnnouncementsProperty()
    {
        return Announcement::count();
    }

    public function getAnnouncementsProperty()
    {
        return Announcement::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('content', 'like', '%' . $this->search . '%');
            })
            ->orderBy('publish_date', 'desc')
            ->paginate(10);
    }

    public function render()
    {
        $announcements = $this->announcements;

        return view('livewire.admin.announcement-management', compact('announcements'));
    }
}
