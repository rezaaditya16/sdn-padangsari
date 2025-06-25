<div>
    <!-- Hero Section -->
    <div class="relative h-[400px] bg-cover bg-center mt-3" style="background-image: url('{{ asset('images/sekolah.png') }}'); background-attachment: fixed;">
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
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
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
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
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
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
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
