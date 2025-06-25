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
                <input type="text" wire:model.live="search" placeholder="Cari pengumuman..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                            Tanggal Publish
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Dibuat
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($announcements as $announcement)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($announcement->image)
                                        <img src="{{ Storage::url($announcement->image) }}" alt="{{ $announcement->title }}" 
                                            class="h-16 w-16 rounded-lg object-cover mr-4">
                                    @else
                                        <div class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center mr-4">
                                            <i class="fas fa-bullhorn text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $announcement->title }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($announcement->content, 100) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div>{{ \Carbon\Carbon::parse($announcement->publish_date)->format('d M Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div>{{ $announcement->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $announcement->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <button wire:click="viewAnnouncement({{ $announcement->id }})" 
                                        class="text-gray-600 hover:text-gray-900 transition" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button wire:click="editAnnouncement({{ $announcement->id }})" 
                                        class="text-blue-600 hover:text-blue-900 transition" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="confirmDelete({{ $announcement->id }})" 
                                        class="text-red-600 hover:text-red-900 transition" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <i class="fas fa-bullhorn text-gray-300 text-5xl mb-4"></i>
                                    <p class="text-lg font-medium mb-2">Belum ada pengumuman</p>
                                    <p class="text-sm">Klik tombol "Tambah Pengumuman" untuk membuat pengumuman baru</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200">
            {{ $announcements->links() }}
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click.self="closeModal">
            <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white max-h-screen overflow-y-auto">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ $editMode ? 'Edit Pengumuman' : 'Tambah Pengumuman Baru' }}
                    </h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form wire:submit.prevent="storeAnnouncement">
                    <div class="space-y-4">
                        <!-- Title -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Judul Pengumuman</label>
                            <input type="text" wire:model="form.title" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            @error('form.title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Content -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Konten Pengumuman</label>
                            <textarea wire:model="form.content" rows="6"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                            @error('form.content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Publish Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Publish</label>
                            <input type="date" wire:model="form.publish_date" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            @error('form.publish_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Image Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gambar</label>
                            <input type="file" wire:model="form.image" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            @error('form.image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            
                            @if($form['image'] ?? false)
                                <div class="mt-2">
                                    <img src="{{ $form['image']->temporaryUrl() }}" alt="Preview" class="h-32 w-auto rounded-lg">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex justify-end space-x-2 mt-6">
                        <button type="button" wire:click="closeModal" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            {{ $editMode ? 'Update' : 'Simpan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- View Modal -->
    @if($showViewModal && $selectedAnnouncement)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click.self="closeModal">
            <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white max-h-screen overflow-y-auto">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Detail Pengumuman</h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $selectedAnnouncement->title }}</h1>
                        <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                            <span>Publish: {{ \Carbon\Carbon::parse($selectedAnnouncement->publish_date)->format('d M Y') }}</span>
                            <span>Dibuat: {{ $selectedAnnouncement->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>

                    @if($selectedAnnouncement->image)
                        <div>
                            <img src="{{ Storage::url($selectedAnnouncement->image) }}" alt="{{ $selectedAnnouncement->title }}" 
                                class="w-full h-64 object-cover rounded-lg">
                        </div>
                    @endif

                    <div class="prose max-w-none">
                        {!! nl2br(e($selectedAnnouncement->content)) !!}
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle text-red-600 text-5xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Konfirmasi Hapus</h3>
                    <p class="text-sm text-gray-600 mb-6">
                        Apakah Anda yakin ingin menghapus pengumuman ini? Tindakan ini tidak dapat dibatalkan.
                    </p>
                    <div class="flex justify-center space-x-2">
                        <button wire:click="closeModal" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Batal
                        </button>
                        <button wire:click="deleteAnnouncement" 
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
