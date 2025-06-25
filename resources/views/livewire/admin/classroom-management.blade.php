<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Kelas</h1>
            <p class="text-sm text-gray-600">Manajemen kelas SDN Padangsari 01</p>
        </div>
        <button wire:click="showCreateModal" 
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
            <i class="fas fa-plus"></i>
            Tambah Kelas
        </button>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex flex-col md:flex-row gap-4 mb-4">
            <div class="flex-1">
                <input type="text" wire:model.live="search" placeholder="Cari nama kelas..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
    </div>

    <!-- Classrooms Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama Kelas
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jumlah Siswa
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jumlah Guru
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
                    @forelse($classrooms as $classroom)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 rounded-lg bg-blue-100 flex items-center justify-center mr-4">
                                        <i class="fas fa-chalkboard text-blue-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $classroom->name }}</div>
                                        <div class="text-sm text-gray-500">Kelas {{ $classroom->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i class="fas fa-user-graduate text-gray-400 mr-2"></i>
                                    <span class="text-sm text-gray-900">{{ $classroom->students_count }} siswa</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i class="fas fa-chalkboard-teacher text-gray-400 mr-2"></i>
                                    <span class="text-sm text-gray-900">{{ $classroom->teachers_count }} guru</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div>{{ $classroom->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $classroom->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <button wire:click="viewClassroom({{ $classroom->id }})" 
                                        class="text-gray-600 hover:text-gray-900 transition" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button wire:click="editClassroom({{ $classroom->id }})" 
                                        class="text-blue-600 hover:text-blue-900 transition" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="confirmDelete({{ $classroom->id }})" 
                                        class="text-red-600 hover:text-red-900 transition" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <i class="fas fa-chalkboard text-gray-300 text-5xl mb-4"></i>
                                    <p class="text-lg font-medium mb-2">Belum ada data kelas</p>
                                    <p class="text-sm">Klik tombol "Tambah Kelas" untuk menambah kelas baru</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200">
            {{ $classrooms->links() }}
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click.self="closeModal">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/3 shadow-lg rounded-md bg-white">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ $editMode ? 'Edit Kelas' : 'Tambah Kelas Baru' }}
                    </h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form wire:submit.prevent="storeClassroom">
                    <div class="space-y-4">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kelas</label>
                            <input type="text" wire:model="form.name" placeholder="Contoh: 1A, 2B, 3C" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            @error('form.name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
    @if($showViewModal && $selectedClassroom)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click.self="closeModal">
            <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white max-h-screen overflow-y-auto">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Detail Kelas {{ $selectedClassroom->name }}</h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="space-y-6">
                    <!-- Classroom Info -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-900 mb-2">Informasi Kelas</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600">{{ $selectedClassroom->name }}</div>
                                <div class="text-sm text-gray-600">Nama Kelas</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600">{{ $selectedClassroom->students->count() }}</div>
                                <div class="text-sm text-gray-600">Total Siswa</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-purple-600">{{ $selectedClassroom->teachers->count() }}</div>
                                <div class="text-sm text-gray-600">Total Guru</div>
                            </div>
                        </div>
                    </div>

                    <!-- Students List -->
                    @if($selectedClassroom->students->count() > 0)
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3">Daftar Siswa ({{ $selectedClassroom->students->count() }})</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($selectedClassroom->students as $student)
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        @if($student->photo)
                                            <img src="{{ Storage::url($student->photo) }}" alt="{{ $student->name }}" 
                                                class="h-10 w-10 rounded-full object-cover mr-3">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                                <i class="fas fa-user-graduate text-blue-600"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $student->name }}</div>
                                            <div class="text-sm text-gray-600">NISN: {{ $student->nisn }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Teachers List -->
                    @if($selectedClassroom->teachers->count() > 0)
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3">Daftar Guru ({{ $selectedClassroom->teachers->count() }})</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($selectedClassroom->teachers as $teacher)
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        @if($teacher->photo)
                                            <img src="{{ Storage::url($teacher->photo) }}" alt="{{ $teacher->name }}" 
                                                class="h-10 w-10 rounded-full object-cover mr-3">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                                <i class="fas fa-chalkboard-teacher text-green-600"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $teacher->name }}</div>
                                            <div class="text-sm text-gray-600">{{ $teacher->position }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($selectedClassroom->students->count() == 0 && $selectedClassroom->teachers->count() == 0)
                        <div class="text-center py-8">
                            <i class="fas fa-users-slash text-gray-300 text-4xl mb-2"></i>
                            <p class="text-gray-500">Belum ada siswa atau guru di kelas ini</p>
                        </div>
                    @endif
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
                    <p class="text-sm text-gray-600 mb-4">
                        Apakah Anda yakin ingin menghapus kelas <strong>{{ $selectedClassroom->name ?? '' }}</strong>?
                    </p>
                    @if($selectedClassroom && ($selectedClassroom->students->count() > 0 || $selectedClassroom->teachers->count() > 0))
                        <div class="bg-yellow-50 p-3 rounded-lg mb-4">
                            <p class="text-sm text-yellow-800">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Kelas ini memiliki {{ $selectedClassroom->students->count() }} siswa dan {{ $selectedClassroom->teachers->count() }} guru. 
                                Menghapus kelas akan menghapus relasi mereka dengan kelas ini.
                            </p>
                        </div>
                    @endif
                    <div class="flex justify-center space-x-2">
                        <button wire:click="closeModal" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Batal
                        </button>
                        <button wire:click="deleteClassroom" 
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
