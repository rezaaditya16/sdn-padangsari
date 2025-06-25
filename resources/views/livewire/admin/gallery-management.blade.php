<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Kelola Galeri</h1>
            <p class="text-gray-600">Kelola foto dan dokumentasi kegiatan sekolah</p>
        </div>

        <!-- Action Buttons -->
        <div class="mb-6 flex flex-col sm:flex-row gap-4">
            <button wire:click="showCreateModal" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Tambah Foto
            </button>
            <div class="flex-1 max-w-md">
                <input wire:model.live="search" type="text" placeholder="Cari foto..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($galleries as $gallery)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="aspect-w-16 aspect-h-12 bg-gray-200">
                        @if($gallery->images && count($gallery->images) > 0)
                            <img src="{{ Storage::url($gallery->images[0]) }}" 
                                 alt="{{ $gallery->title }}" 
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 flex items-center justify-center bg-gray-200">
                                <i class="fas fa-image text-gray-400 text-3xl"></i>
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2">{{ $gallery->title }}</h3>
                        @if($gallery->description)
                            <p class="text-sm text-gray-600 mb-3 line-clamp-3">{{ $gallery->description }}</p>
                        @endif
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">
                                {{ $gallery->created_at->format('d M Y') }}
                            </span>
                            <div class="flex space-x-2">
                                <button wire:click="editGallery({{ $gallery->id }})" 
                                    class="text-blue-600 hover:text-blue-800 text-sm">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="deleteGallery({{ $gallery->id }})" 
                                    onclick="confirm('Yakin ingin hapus foto ini?') || event.stopImmediatePropagation()"
                                    class="text-red-600 hover:text-red-800 text-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-images text-6xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada foto</h3>
                    <p class="text-gray-600 mb-4">Mulai tambahkan foto kegiatan sekolah</p>
                    <button wire:click="showCreateModal" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Foto Pertama
                    </button>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($galleries->hasPages())
            <div class="mt-8">
                {{ $galleries->links() }}
            </div>
        @endif
    </div>

    <!-- Create/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-lg max-w-md w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">
                        {{ $editMode ? 'Edit Foto' : 'Tambah Foto' }}
                    </h3>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form wire:submit.prevent="saveGallery" class="space-y-4">
                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Judul</label>
                        <input wire:model="form.title" type="text" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('form.title') border-red-500 @enderror">
                        @error('form.title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea wire:model="form.description" rows="3" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('form.description') border-red-500 @enderror"></textarea>
                        @error('form.description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            {{ $editMode ? 'Ganti Foto (opsional)' : 'Upload Foto' }}
                        </label>
                        <input wire:model="form.image" type="file" accept="image/*" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('form.image') border-red-500 @enderror">
                        @error('form.image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @if($editMode && !$form['image'])
                            <p class="mt-1 text-sm text-gray-600">Foto saat ini akan tetap digunakan jika tidak mengganti</p>
                        @endif
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" wire:click="closeModal" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove>
                                {{ $editMode ? 'Update' : 'Simpan' }}
                            </span>
                            <span wire:loading>
                                <i class="fas fa-spinner fa-spin mr-2"></i>
                                Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
