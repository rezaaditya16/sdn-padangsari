<div class="container mx-auto px-4 mt-32">
    <h1 class="text-center text-4xl font-bold mb-8">PENGUMUMAN</h1>

    @foreach ($pengumuman as $item)
        <div 
            x-data="{ open: false }" 
            class="bg-purple-100 p-8 rounded-3xl w-[95%] mx-auto my-10 transition-all duration-500 ease-in-out"
        >
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                <img src="{{ $item->image_url ?? 'https://via.placeholder.com/200x200.png?text=Gambar' }}" 
                     alt="Gambar" 
                     class="rounded-md w-96 h-96 object-cover">
                
                <div class="flex-1">
                    <h2 class="text-xl font-bold mb-2">{{ $item->title }}</h2>
                    <p class="text-gray-800">{{ Str::limit($item->description, 150) }}</p>

                    <div x-show="open" x-transition class="mt-4 text-gray-700">
                        {{ $item->description }}
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