<div>
    <!-- Hero Section -->
    <div class="relative h-[400px] bg-cover bg-center mt-3" style="background-image: url('{{ asset('images/sekolah.png') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
            <div class="text-center text-white px-4">
                <h1 class="text-4xl md:text-5xl font-bold mb-2">PROFIL SEKOLAH</h1>
                <p class="text-xl md:text-2xl">SDN PADANGSARI 01</p>
            </div>
        </div>
    </div>

    <!-- Form Pengaduan -->
    <div class="max-w-2xl mx-auto pt-24 px-6 pb-12">
        <div class="bg-white shadow-xl rounded-2xl p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Form Pengaduan</h2>

            @if (session()->has('message'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit.prevent="submit" class="space-y-5">
                <!-- Nama -->
                <div>
                    <label class="block font-medium mb-1 text-gray-700">Nama</label>
                    <input type="text" wire:model="nama" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan nama Anda">
                    @error('nama') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Surel -->
                <div>
                    <label class="block font-medium mb-1 text-gray-700">Surel</label>
                    <input type="email" wire:model="surel" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan alamat surel Anda">
                    @error('surel') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Nomor Kontak -->
                <div>
                    <label class="block font-medium mb-1 text-gray-700">Nomor Kontak</label>
                    <input type="text" wire:model="nomor_kontak" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan nomor telepon Anda">
                    @error('nomor_kontak') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block font-medium mb-1 text-gray-700">Deskripsi</label>
                    <textarea wire:model="deskripsi" rows="5" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan deskripsi pengaduan Anda"></textarea>
                    @error('deskripsi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Tombol Submit -->
                <div>
                    <button type="submit" class="bg-[#FFB200] hover:bg-[#FF9D23] transition duration-200 text-white font-semibold px-6 py-3 rounded-lg shadow-md">
                        Kirim Pengaduan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
