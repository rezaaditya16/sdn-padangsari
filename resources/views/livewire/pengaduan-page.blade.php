<div>
    <!-- Override margin dari layout untuk Pengaduan -->
    <style>
        .flex-grow { margin-top: 0 !important; }
    </style>

    <!-- Hero Section -->
    <div class="relative h-[400px] bg-cover bg-center -mt-8" style="background-image: url('{{ asset('images/sekolah.png') }}'); background-attachment: fixed;">
        <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
            <div class="text-center text-white px-4">
                <h1 class="text-4xl md:text-5xl font-bold mb-2">PENGADUAN</h1>
                <p class="text-xl md:text-2xl">SDN PADANGSARI 01</p>
            </div>
        </div>
    </div>

    @if($student)
        <!-- Info Siswa yang Login -->
        <div class="max-w-3xl mx-auto pt-8 px-6">
            <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-blue-600">Masuk sebagai orang tua dari:</p>
                        <p class="font-semibold text-blue-800">{{ $student->name }} - {{ $student->class }}</p>
                    </div>
                    <button wire:click="logout" class="text-sm text-blue-600 hover:text-blue-800">
                        Keluar
                    </button>
                </div>
            </div>
        </div>

        <!-- Form Pengaduan -->
        <div class="max-w-3xl mx-auto px-6 pb-20">
            <div class="bg-white shadow-2xl border-2 rounded-3xl p-10">
                <h2 class="text-3xl font-bold text-red-700 mb-8 flex items-center gap-3">
                    <img src="{{ asset('images/laptop.gif') }}" alt="Laptop GIF" class="w-12 h-12">
                    Form Pengaduan
                </h2>

                <!-- Success Message -->
                @if($successMessage)
                    <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg shadow-md">
                        {{ $successMessage }}
                    </div>
                @endif

                <!-- Error Message -->
                @if($errorMessage)
                    <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg shadow-md">
                        {{ $errorMessage }}
                    </div>
                @endif

                <form wire:submit.prevent="submit" class="space-y-6">
                    <!-- Kategori Pengaduan -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Kategori Pengaduan *</label>
                        <div class="relative">
                            <select wire:model="category_id" class="w-full border border-gray-300 rounded-xl py-3 pl-12 pr-4 shadow-sm focus:ring-2 focus:ring-red-900 focus:outline-none transition">
                                <option value="">Pilih Kategori Pengaduan</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                        </div>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $errors->first('category_id') }}</p>
                        @enderror
                    </div>

                    <!-- Judul Pengaduan -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Judul Pengaduan *</label>
                        <div class="relative">
                            <input wire:model="title" type="text" class="w-full border border-gray-300 rounded-xl py-3 pl-12 pr-4 shadow-sm focus:ring-2 focus:ring-red-900 focus:outline-none transition" placeholder="Masukkan judul pengaduan">
                            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                            </div>
                        </div>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $errors->first('title') }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi Pengaduan -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Deskripsi Pengaduan *</label>
                        <div class="relative">
                            <textarea wire:model="message" rows="6" class="w-full border border-gray-300 rounded-xl py-3 pl-12 pr-4 shadow-sm focus:ring-2 focus:ring-red-900 focus:outline-none transition resize-none" placeholder="Jelaskan detail pengaduan Anda..."></textarea>
                            <div class="absolute left-4 top-4 text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                        </div>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $errors->first('message') }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center pt-4">
                        <button type="submit" class="bg-red-700 hover:bg-red-800 text-white font-bold py-4 px-8 rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Kirim Pengaduan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- History Pengaduan -->
        @if($pengaduanHistory && $pengaduanHistory->count() > 0)
            <div class="max-w-3xl mx-auto px-6 pb-20">
                <div class="bg-white shadow-2xl border-2 rounded-3xl p-10">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Riwayat Pengaduan Anda
                    </h3>
                    
                    <div class="space-y-4">
                        @foreach($pengaduanHistory as $pengaduan)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                    <div class="flex-1">
                                        <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $pengaduan->title }}</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                                            <div>
                                                <span class="font-medium">Kategori:</span>
                                                <span class="ml-1">{{ $pengaduan->category->name ?? '-' }}</span>
                                            </div>
                                            <div>
                                                <span class="font-medium">Ditangani oleh:</span>
                                                <span class="ml-1">{{ $pengaduan->assignedUser ? $pengaduan->assignedUser->name : 'Belum ditugaskan' }}</span>
                                            </div>
                                            <div>
                                                <span class="font-medium">Tanggal:</span>
                                                <span class="ml-1">{{ $pengaduan->created_at->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                        <div class="mt-2 flex items-center gap-3">
                                            @php
                                                $statusClass = match($pengaduan->status) {
                                                    'Diajukan' => 'bg-blue-100 text-blue-800',
                                                    'Diproses' => 'bg-yellow-100 text-yellow-800', 
                                                    'Selesai' => 'bg-green-100 text-green-800',
                                                    default => 'bg-gray-100 text-gray-800'
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                                {{ $pengaduan->status }}
                                            </span>
                                            
                                            @if($pengaduan->complaintResponses->count() > 0)
                                                <span class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-700 text-xs rounded">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                    </svg>
                                                    {{ $pengaduan->complaintResponses->count() }} Tanggapan
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mt-4 md:mt-0 md:ml-4">
                                        <button wire:click="viewPengaduanDetail({{ $pengaduan->id }})" 
                                                class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Lihat Detail
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Tombol Lihat Semua -->
                    <div class="text-center mt-6 pt-4 border-t border-gray-200">
                        <button wire:click="viewAllPengaduan" 
                                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-200 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Lihat Semua Pengaduan ({{ $pengaduanHistory->count() > 5 ? 'Lebih dari 5' : $pengaduanHistory->count() }})
                        </button>
                    </div>
                </div>
            </div>
        @elseif($student)
            <!-- Pesan jika belum ada pengaduan -->
            <div class="max-w-3xl mx-auto px-6 pb-20">
                <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-3xl p-10 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Pengaduan</h3>
                    <p class="text-gray-500">Pengaduan yang Anda buat akan muncul di sini.</p>
                </div>
            </div>
        @endif
    @else
        <!-- Redirect ke login jika belum login -->
        <div class="max-w-3xl mx-auto pt-24 px-6 pb-20 text-center">
            <div class="bg-white shadow-2xl border-2 rounded-3xl p-10">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">
                    Akses Terbatas
                </h2>
                <p class="text-gray-600 mb-6">
                    Untuk mengajukan pengaduan, Anda harus login terlebih dahulu sebagai orang tua siswa.
                </p>
                <a href="{{ route('parent.login') }}"
                   class="bg-red-700 hover:bg-red-800 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition-all duration-300">
                    Login Orang Tua
                </a>
            </div>
        </div>
    @endif
</div>

<script>
    // Auto refresh history saat pengaduan baru dikirim
    document.addEventListener('livewire:init', () => {
        Livewire.on('pengaduan-submitted', () => {
            // Scroll ke history section setelah submit
            setTimeout(() => {
                const historySection = document.querySelector('[wire\\:click="viewAllPengaduan"]');
                if (historySection) {
                    historySection.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }, 500);
        });
    });
</script>
