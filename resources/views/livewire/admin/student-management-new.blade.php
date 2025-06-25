<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Data Siswa</h1>
            <p class="text-sm text-gray-600">Manajemen data siswa SDN Padangsari 01</p>
        </div>
        <button wire:click="showCreateModal" 
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
            <i class="fas fa-plus"></i>
            Tambah Siswa
        </button>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex flex-col md:flex-row gap-4 mb-4">
            <div class="flex-1">
                <input type="text" wire:model.live="search" placeholder="Cari nama, NISN, atau kelas..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
    </div>

    <!-- Students Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Foto
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama Siswa
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            NISN
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kelas
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Lahir
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($students as $student)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center">
                                    @if($student->photo)
                                        <img src="{{ Storage::url($student->photo) }}" alt="{{ $student->name }}" 
                                            class="h-16 w-16 rounded-full object-cover">
                                    @else
                                        <i class="fas fa-user-graduate text-gray-400 text-xl"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                @if($student->parent_email)
                                    <div class="text-sm text-gray-500">{{ $student->parent_email }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $student->nisn }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $student->class }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($student->birth_date)
                                    <div>{{ $student->birth_date->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $student->birth_date->age }} tahun</div>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <button wire:click="viewStudent({{ $student->id }})" 
                                        class="text-gray-600 hover:text-gray-900 transition" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button wire:click="editStudent({{ $student->id }})" 
                                        class="text-blue-600 hover:text-blue-900 transition" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="confirmDelete({{ $student->id }})" 
                                        class="text-red-600 hover:text-red-900 transition" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <i class="fas fa-user-graduate text-gray-300 text-5xl mb-4"></i>
                                    <p class="text-lg font-medium mb-2">Belum ada data siswa</p>
                                    <p class="text-sm">Klik tombol "Tambah Siswa" untuk menambah data siswa baru</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200">
            {{ $students->links() }}
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click.self="closeModal">
            <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white max-h-screen overflow-y-auto">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ $editMode ? 'Edit Data Siswa' : 'Tambah Siswa Baru' }}
                    </h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form wire:submit.prevent="storeStudent">
                    <div class="space-y-4">
                        <!-- NISN -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">NISN</label>
                            <input type="text" wire:model="form.nisn" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            @error('form.nisn') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Siswa</label>
                            <input type="text" wire:model="form.name" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            @error('form.name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Birth Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                            <input type="date" wire:model="form.birth_date" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            @error('form.birth_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Class -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                            <input type="text" wire:model="form.class" placeholder="Contoh: 1A, 2B, 3C" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            @error('form.class') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Parent Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Orang Tua (Opsional)</label>
                            <input type="email" wire:model="form.parent_email" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            @error('form.parent_email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Photo Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Siswa (Opsional)</label>
                            <input type="file" wire:model="form.photo" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            @error('form.photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            
                            @if($form['photo'] ?? false)
                                <div class="mt-2">
                                    <img src="{{ $form['photo']->temporaryUrl() }}" alt="Preview" class="h-32 w-32 rounded-lg object-cover">
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
    @if($showViewModal && $selectedStudent)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click.self="closeModal">
            <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white max-h-screen overflow-y-auto">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Detail Siswa</h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="space-y-4">
                    <div class="text-center">
                        @if($selectedStudent->photo)
                            <img src="{{ Storage::url($selectedStudent->photo) }}" alt="{{ $selectedStudent->name }}" 
                                class="h-32 w-32 rounded-full object-cover mx-auto mb-4">
                        @else
                            <div class="h-32 w-32 rounded-full bg-gray-200 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-user-graduate text-gray-400 text-4xl"></i>
                            </div>
                        @endif
                        <h2 class="text-xl font-bold text-gray-900">{{ $selectedStudent->name }}</h2>
                        <p class="text-gray-600">NISN: {{ $selectedStudent->nisn }}</p>
                        <p class="text-gray-600">Kelas: {{ $selectedStudent->class }}</p>
                        @if($selectedStudent->birth_date)
                            <p class="text-gray-600">Lahir: {{ $selectedStudent->birth_date->format('d M Y') }} ({{ $selectedStudent->birth_date->age }} tahun)</p>
                        @endif
                        @if($selectedStudent->parent_email)
                            <p class="text-gray-600">Email Orang Tua: {{ $selectedStudent->parent_email }}</p>
                        @endif
                        <p class="text-sm text-gray-500 mt-2">Terdaftar: {{ $selectedStudent->created_at->format('d M Y') }}</p>
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
                        Apakah Anda yakin ingin menghapus data siswa <strong>{{ $selectedStudent->name ?? '' }}</strong>? Tindakan ini tidak dapat dibatalkan.
                    </p>
                    <div class="flex justify-center space-x-2">
                        <button wire:click="closeModal" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Batal
                        </button>
                        <button wire:click="deleteStudent" 
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
