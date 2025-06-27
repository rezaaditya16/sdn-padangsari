<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Pengumuman</h1>
            <p class="text-sm text-gray-600">Manajemen pengumuman SDN Padangsari 01</p>
        </div>
        <button wire:click="showCreateModal" 
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
            <i class="fas fa-plus"></i>
            Tambah Pengumuman
        </button>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex flex-col md:flex-row gap-4 mb-4">
            <div class="flex-1">
                <input type="text" wire:model.live="search" placeholder="Cari pengumuman berdasarkan judul atau konten..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
        
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div class="bg-blue-50 p-4 rounded-lg">
                <div class="text-2xl font-bold text-blue-600">{{ $this->totalAnnouncements }}</div>
                <div class="text-sm text-blue-600">Total Pengumuman</div>
            </div>
        </div>
    </div>

    <!-- Announcements Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Judul
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Gambar
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Publish
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Dibuat
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($announcements as $announcement)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $announcement->title }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($announcement->content, 100) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($announcement->image)
                                    <img src="{{ Storage::url($announcement->image) }}" alt="Gambar" 
                                        class="w-16 h-16 object-cover rounded-lg">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $announcement->publish_date ? $announcement->publish_date->format('d M Y') : 'Belum diset' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $announcement->created_at->format('d M Y H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="viewAnnouncement({{ $announcement->id }})" 
                                        class="text-blue-600 hover:text-blue-800 transition" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button wire:click="editAnnouncement({{ $announcement->id }})" 
                                        class="text-yellow-600 hover:text-yellow-800 transition" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="confirmDelete({{ $announcement->id }})" 
                                        class="text-red-600 hover:text-red-800 transition" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-bullhorn text-4xl mb-4 text-gray-300"></i>
                                <div class="text-lg font-medium">Belum ada pengumuman</div>
                                <div class="text-sm">Mulai dengan menambahkan pengumuman pertama</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $announcements->links() }}
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if($showModal)
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 max-h-screen overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    {{ $editMode ? 'Edit Pengumuman' : 'Tambah Pengumuman' }}
                </h3>
            </div>
            
            <form wire:submit="storeAnnouncement" class="p-6 space-y-4">
                <!-- Judul -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul Pengumuman</label>
                    <input type="text" wire:model="form.title" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan judul pengumuman">
                    @error('form.title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Konten -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konten</label>
                    <textarea wire:model="form.content" rows="6"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan konten pengumuman"></textarea>
                    @error('form.content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Tanggal Publish -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Publish</label>
                    <input type="date" wire:model="form.publish_date" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('form.publish_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Upload Gambar -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar {{ $editMode ? '(Kosongkan jika tidak ingin mengubah)' : '' }}
                    </label>
                    <input type="file" wire:model="form.image" accept="image/*"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('form.image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    
                    @if($form['image'])
                        <div class="mt-2">
                            <img src="{{ $form['image']->temporaryUrl() }}" alt="Preview" class="w-32 h-32 object-cover rounded-lg">
                        </div>
                    @endif
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" wire:click="closeModal" 
                        class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition">
                        Batal
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        {{ $editMode ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- View Modal -->
    @if($showViewModal && $selectedAnnouncement)
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl mx-4 max-h-screen overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Detail Pengumuman</h3>
            </div>
            
            <div class="p-6">
                <div class="space-y-4">
                    <div>
                        <h4 class="font-semibold text-gray-900 text-xl">{{ $selectedAnnouncement->title }}</h4>
                    </div>
                    
                    @if($selectedAnnouncement->image)
                    <div>
                        <img src="{{ Storage::url($selectedAnnouncement->image) }}" alt="Gambar" 
                            class="w-full max-w-md h-64 object-cover rounded-lg">
                    </div>
                    @endif
                    
                    <div>
                        <p class="text-gray-700 whitespace-pre-line">{{ $selectedAnnouncement->content }}</p>
                    </div>
                    
                    <div class="text-sm text-gray-500 space-y-1">
                        <div>Tanggal Publish: {{ $selectedAnnouncement->publish_date ? $selectedAnnouncement->publish_date->format('d M Y') : 'Belum diset' }}</div>
                        <div>Dibuat: {{ $selectedAnnouncement->created_at->format('d M Y H:i') }}</div>
                        @if($selectedAnnouncement->updated_at != $selectedAnnouncement->created_at)
                        <div>Diupdate: {{ $selectedAnnouncement->updated_at->format('d M Y H:i') }}</div>
                        @endif
                    </div>
                </div>
                
                <div class="flex justify-end pt-4 border-t border-gray-200 mt-6">
                    <button wire:click="closeModal" 
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal && $selectedAnnouncement)
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Konfirmasi Hapus</h3>
            </div>
            
            <div class="p-6">
                <p class="text-gray-700">
                    Apakah Anda yakin ingin menghapus pengumuman 
                    <strong>"{{ $selectedAnnouncement->title }}"</strong>? 
                    Tindakan ini tidak dapat dibatalkan.
                </p>
                
                <div class="flex justify-end gap-3 mt-6">
                    <button wire:click="closeModal" 
                        class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition">
                        Batal
                    </button>
                    <button wire:click="deleteAnnouncement" 
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('message') }}
        </div>
    @endif
</div>
