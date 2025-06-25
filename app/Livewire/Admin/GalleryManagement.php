<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class GalleryManagement extends Component
{
    use WithPagination, WithFileUploads;

    protected $listeners = ['gallery-updated' => '$refresh'];

    public $search = '';
    public $showModal = false;
    public $showViewModal = false;
    public $showDeleteModal = false;
    public $editMode = false;
    public $galleryId = null;
    public $selectedGallery = null;

    public $form = [
        'title' => '',
        'description' => '',
        'image' => null
    ];

    protected $rules = [
        'form.title' => 'required|string|max:255',
        'form.description' => 'nullable|string|max:1000',
        'form.image' => 'nullable|image|max:5120'
    ];

    protected $messages = [
        'form.title.required' => 'Judul galeri harus diisi.',
        'form.title.max' => 'Judul maksimal 255 karakter.',
        'form.description.max' => 'Deskripsi maksimal 1000 karakter.',
        'form.image.image' => 'File harus berupa gambar.',
        'form.image.max' => 'Ukuran gambar maksimal 5MB.',
    ];

    public function mount()
    {
        // Component mounting - authorization handled by middleware
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

    public function editGallery($id)
    {
        $gallery = Gallery::findOrFail($id);
        $this->galleryId = $id;
        $this->selectedGallery = $gallery; // Set selectedGallery untuk akses di view
        $this->form = [
            'title' => $gallery->title,
            'description' => $gallery->description,
            'image' => null // Reset untuk upload baru
        ];
        $this->editMode = true;
        $this->showModal = true;
    }

    public function viewGallery($id)
    {
        $this->selectedGallery = Gallery::findOrFail($id);
        $this->showViewModal = true;
    }

    public function saveGallery()
    {
        $this->validate();

        $data = [
            'title' => $this->form['title'],
            'description' => $this->form['description'],
        ];
        
        // Handle single image upload
        if ($this->form['image']) {
            $imagePath = $this->form['image']->store('galleries', 'public');
            $data['images'] = [$imagePath]; // Store as array with single image
        }

        if ($this->editMode) {
            $gallery = Gallery::findOrFail($this->galleryId);
            
            // Hapus gambar lama jika ada gambar baru
            if ($this->form['image'] && $gallery->images) {
                foreach ($gallery->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            
            // Jika tidak ada gambar baru, pertahankan gambar lama
            if (!$this->form['image'] && $gallery->images) {
                $data['images'] = $gallery->images;
            }
            
            $gallery->update($data);
            
            // Refresh selectedGallery jika sedang di edit
            $this->selectedGallery = $gallery->fresh();
            
            session()->flash('message', 'Galeri berhasil diperbarui!');
        } else {
            // Untuk create baru, gambar wajib ada
            if (!$this->form['image']) {
                $this->addError('form.image', 'Gambar harus diupload untuk galeri baru.');
                return;
            }
            
            Gallery::create($data);
            session()->flash('message', 'Galeri berhasil ditambahkan!');
        }

        $this->closeModal();
        $this->dispatch('gallery-updated');
    }

    public function removeImage($galleryId, $imageIndex)
    {
        $gallery = Gallery::findOrFail($galleryId);
        $images = $gallery->images ?: [];
        
        if (isset($images[$imageIndex])) {
            // Hapus file dari storage
            Storage::disk('public')->delete($images[$imageIndex]);
            
            // Hapus dari array
            unset($images[$imageIndex]);
            $images = array_values($images); // Re-index array
            
            // Update database
            $gallery->update(['images' => $images]);
            
            // Refresh selectedGallery jika sedang di edit atau view
            if ($this->selectedGallery && $this->selectedGallery->id == $galleryId) {
                $this->selectedGallery = $gallery->fresh();
            }
            
            session()->flash('message', 'Gambar berhasil dihapus!');
            
            // Emit event untuk refresh komponen
            $this->dispatch('gallery-updated');
        }
    }

    public function confirmDelete($id)
    {
        $this->galleryId = $id;
        $this->selectedGallery = Gallery::findOrFail($id);
        $this->showDeleteModal = true;
    }

    public function deleteGallery()
    {
        $gallery = Gallery::findOrFail($this->galleryId);
        
        // Hapus semua gambar dari storage
        if ($gallery->images) {
            foreach ($gallery->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        
        $gallery->delete();
        
        session()->flash('message', 'Galeri berhasil dihapus!');
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
            'description' => '',
            'image' => null
        ];
        $this->galleryId = null;
        $this->editMode = false;
        $this->selectedGallery = null;
        $this->resetErrorBag();
    }

    public function getTotalGalleriesProperty()
    {
        return Gallery::count();
    }

    public function getGalleriesProperty()
    {
        return Gallery::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function render()
    {
        $galleries = $this->galleries;
        return view('livewire.admin.gallery-management', compact('galleries'));
    }
}
