<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Kelola Siswa</h1>
            <p class="text-gray-600">Kelola data siswa dan informasi akademik</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Siswa</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $this->totalStudents }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-user-graduate text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Siswa Aktif</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $this->activeStudents }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-door-open text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Kelas</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $this->totalClassrooms }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <i class="fas fa-graduation-cap text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Alumni</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $this->graduatedStudents }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons & Search -->
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex flex-col sm:flex-row gap-4">
                <button wire:click="showCreateModal" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Siswa
                </button>
                <button wire:click="exportStudents" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition flex items-center">
                    <i class="fas fa-file-excel mr-2"></i>
                    Export Excel
                </button>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                <select wire:model.live="classroomFilter" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kelas</option>
                    @foreach($this->classrooms as $classroom)
                        <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                    @endforeach
                </select>
                <input wire:model.live="search" type="text" placeholder="Cari siswa..." 
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-64">
            </div>
        </div>

        <!-- Students Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NISN</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Lahir</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($students as $student)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($student->photo)
                                                <img src="{{ Storage::url($student->photo) }}" alt="{{ $student->name }}" 
                                                    class="h-10 w-10 rounded-full object-cover">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-blue-600">{{ substr($student->name, 0, 2) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $student->parent_email ?? 'Tidak ada email' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $student->nisn }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $student->classroom->name ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $student->birth_date ? $student->birth_date->format('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <button wire:click="viewStudent({{ $student->id }})" 
                                            class="text-gray-600 hover:text-gray-900" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button wire:click="editStudent({{ $student->id }})" 
                                            class="text-blue-600 hover:text-blue-900" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="confirmDelete({{ $student->id }})" 
                                            class="text-red-600 hover:text-red-900" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="text-gray-400 mb-4">
                                        <i class="fas fa-users text-6xl"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada siswa</h3>
                                    <p class="text-gray-600 mb-4">Mulai tambahkan data siswa</p>
                                    <button wire:click="showCreateModal" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                                        <i class="fas fa-plus mr-2"></i>
                                        Tambah Siswa Pertama
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($students->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $students->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-lg max-w-2xl w-full p-6 max-h-screen overflow-y-auto">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">
                        {{ $editMode ? 'Edit Siswa' : 'Tambah Siswa' }}
                    </h3>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form wire:submit.prevent="saveStudent" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Name -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input wire:model="form.name" type="text" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('form.name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- NISN -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">NISN</label>
                            <input wire:model="form.nisn" type="text" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('form.nisn') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Parent Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Orang Tua (Opsional)</label>
                            <input wire:model="form.parent_email" type="email" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('form.parent_email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Birth Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                            <input wire:model="form.birth_date" type="date" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('form.birth_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Classroom -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                            <select wire:model="form.classroom_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Kelas</option>
                                @foreach($this->classrooms as $classroom)
                                    <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                                @endforeach
                            </select>
                            @error('form.classroom_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Photo Upload -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto (Opsional)</label>
                            <input wire:model="form.photo" type="file" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('form.photo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            
                            @if($form['photo'] ?? false)
                                <div class="mt-2">
                                    <img src="{{ $form['photo']->temporaryUrl() }}" alt="Preview" class="h-32 w-32 rounded-lg object-cover">
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" wire:click="closeModal" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
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
                        <p class="text-gray-600">Kelas: {{ $selectedStudent->classroom->name ?? '-' }}</p>
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
