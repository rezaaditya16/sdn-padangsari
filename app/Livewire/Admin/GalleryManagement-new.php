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
        'images' => []
    ];

    protected $rules = [
        'form.title' => 'required|string|max:255',
        'form.description' => 'nullable|string|max:1000',
        'form.images.*' => 'nullable|image|max:5120'
    ];

    protected $messages = [
        'form.title.required' => 'Judul galeri harus diisi.',
        'form.title.max' => 'Judul maksimal 255 karakter.',
        'form.description.max' => 'Deskripsi maksimal 1000 karakter.',
        'form.images.*.image' => 'File harus berupa gambar.',
        'form.images.*.max' => 'Ukuran gambar maksimal 5MB.',
    ];

    public function mount()
    {
        // Check authentication
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya Super Admin yang dapat mengakses halaman ini.');
        }
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
        $this->form = [
            'title' => $gallery->title,
            'description' => $gallery->description,
            'images' => [] // Reset untuk upload baru
        ];
        $this->editMode = true;
        $this->showModal = true;
    }

    public function viewGallery($id)
    {
        $this->selectedGallery = Gallery::findOrFail($id);
        $this->showViewModal = true;
    }

    public function storeGallery()
    {
        $this->validate();

        $data = [
            'title' => $this->form['title'],
            'description' => $this->form['description'],
        ];
        
        // Handle multiple image uploads
        $imagesPaths = [];
        if ($this->form['images']) {
            foreach ($this->form['images'] as $image) {
                $imagesPaths[] = $image->store('galleries', 'public');
            }
        }

        if ($this->editMode) {
            $gallery = Gallery::findOrFail($this->galleryId);
            
            // Jika ada gambar baru, tambahkan ke gambar yang sudah ada
            if (!empty($imagesPaths)) {
                $existingImages = $gallery->images ?: [];
                $data['images'] = array_merge($existingImages, $imagesPaths);
            } else {
                // Pertahankan gambar lama jika tidak ada upload baru
                $data['images'] = $gallery->images;
            }
            
            $gallery->update($data);
            session()->flash('message', 'Galeri berhasil diperbarui!');
        } else {
            // Untuk create baru, minimal harus ada satu gambar
            if (empty($imagesPaths)) {
                $this->addError('form.images', 'Minimal harus ada satu gambar untuk galeri baru.');
                return;
            }
            
            $data['images'] = $imagesPaths;
            Gallery::create($data);
            session()->flash('message', 'Galeri berhasil ditambahkan!');
        }

        $this->closeModal();
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
            
            session()->flash('message', 'Gambar berhasil dihapus!');
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
            'images' => []
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

        return view('livewire.admin.gallery-management-new', compact('galleries'));
    }
}
