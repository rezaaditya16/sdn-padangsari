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