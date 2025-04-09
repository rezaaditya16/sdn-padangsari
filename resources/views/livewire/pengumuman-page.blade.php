<div class="container mx-auto px-4 mt-32">
<h1 class="text-center text-4xl font-bold mb-8">PENGUMUMAN</h1>
  <div x-data="{ open: false }" class="bg-purple-100 p-8 rounded-3xl max-w-8xl mx-auto my-10 transition-all duration-500 ease-in-out">
    <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
      
      <!-- Gambar -->
      <img src="{{ asset('images/logo.png') }}" alt="Gambar" class="rounded-md w-96 h-96 object-cover">
      
      <!-- Konten -->
      <div class="flex-1">
        <h2 class="text-xl font-bold mb-2">Judul</h2>
        <p class="text-gray-800">
          Lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum...
        </p>

        <!-- Konten Tambahan yang Disembunyikan -->
        <div x-show="open" x-transition class="mt-4 text-gray-700">
          Ini adalah bagian tambahan dari pengumuman yang hanya muncul saat tombol diklik. Bisa berisi informasi detail, file lampiran, atau apapun.
        </div>

        <!-- Tombol -->
        <div class="text-right mt-6">
          <button 
            @click="open = !open" 
            class="bg-purple-500 hover:bg-purple-600 text-white px-6 py-2 rounded-full transition">
            <span x-text="open ? 'Sembunyikan' : 'Selengkapnya'"></span>
          </button>
        </div>
      </div>
    </div>

  </div>
</div>