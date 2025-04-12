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

<div class="container mx-auto px-4 mt-32">
    <h1 class="text-center text-4xl font-bold mb-8">PENGUMUMAN</h1>

    @foreach ($pengumuman as $item)
        <div 
            x-data="{ open: false }" 
            class="bg-purple-100 p-8 rounded-3xl w-[95%] mx-auto my-10 transition-all duration-500 ease-in-out"
        >
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                <img src="{{ $item->image ?? asset('images/default.png') }}" 
                     alt="Gambar" 
                     class="rounded-md w-96 h-96 object-cover">
                
                <div class="flex-1">
                    <h2 class="text-xl font-bold mb-2">{{ $item->title }}</h2>
                    <p class="text-gray-800">{{ Str::limit($item->content, 150) }}</p>

                    <div x-show="open" x-transition class="mt-4 text-gray-700">
                        {{ $item->content }}
                    </div>

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
    @endforeach
</div>
</div>