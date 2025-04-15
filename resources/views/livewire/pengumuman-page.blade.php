<div>
    <!-- Hero Section -->
    <div class="relative h-[400px] bg-cover bg-center mt-3" style="background-image: url('{{ asset('images/sekolah.png') }}'); background-attachment: fixed;">
      <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
          <div class="text-center text-white px-4">
              <h1 class="text-4xl md:text-5xl font-bold mb-2">PENGUMUMAN</h1>
              <p class="text-xl md:text-2xl">SDN PADANGSARI 01</p>
          </div>
      </div>
    </div>
  
    <div class="container mx-auto px-4 mt-32">
      <!-- Menggunakan Grid Layout -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($pengumuman as $item)
          <div 
              x-data="{ open: false }" 
              class="bg-gray-100 p-6 rounded-3xl transition-all duration-500 ease-in-out"
          >
            <div class="flex flex-col gap-6">
              <!-- Gambar -->
              <img src="{{ $item->image ?? asset('images/default.png') }}" 
                   alt="Gambar" 
                   class="rounded-md w-full h-64 object-cover">
              
              <!-- Konten Pengumuman -->
              <div>
                <h2 class="text-xl font-bold mb-2">{{ $item->title }}</h2>
                <p class="text-gray-800">{{ Str::limit($item->content, 150) }}</p>
  
                <div x-show="open" x-transition class="mt-4 text-gray-700">
                  {{ $item->content }}
                </div>
  
                <div class="text-right mt-6">
                  <button 
                      @click="open = !open" 
                      class="bg-red-500 hover:bg-red-700 text-white px-6 py-2 rounded-full transition">
                      <span x-text="open ? 'Sembunyikan' : 'Selengkapnya'"></span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
  