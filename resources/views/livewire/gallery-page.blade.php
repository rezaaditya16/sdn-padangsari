<div>
<div class="relative h-[400px] bg-cover bg-center mt-3" style="background-image: url('{{ asset('images/sekolah.png') }}'); background-attachment: fixed;">
    <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
        <div class="text-center text-white px-4">
            <h1 class="text-4xl md:text-5xl font-bold mb-2">GALERI</h1>
            <p class="text-xl md:text-2xl">SDN PADANGSARI 01</p>
        </div>
    </div>
</div>
<!-- Gallery Section -->
<div class="max-w-6xl mx-auto mt-10 px-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($galleries as $index => $gallery)
            <div class="bg-white p-4 rounded-xl shadow-md transition-transform duration-300 hover:scale-105">
                <h2 class="text-xl font-bold mb-1">{{ $gallery->title }}</h2>
                <p class="text-gray-600 mb-3 text-sm">{{ $gallery->description }}</p>

                <div 
                    class="relative cursor-pointer group" 
                    onclick="openGallery({{ $index }})"
                >
                    <img 
                        src="{{ asset('storage/' . $gallery->images[0]) }}" 
                        alt="{{ $gallery->title }}" 
                        class="w-full h-48 object-cover rounded-lg transition duration-300 group-hover:brightness-75"
                    />
                    <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center text-white font-semibold text-lg">
                        Lihat Galeri
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- Galeri Modal -->
    <div id="galleryModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-70 overflow-auto flex items-center justify-center p-6">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-4xl relative">
            <button onclick="closeGallery()" class="absolute top-2 right-2 text-black text-2xl hover:text-red-500">&times;</button>
            <div class="p-4 grid grid-cols-1 sm:grid-cols-2 gap-4" id="galleryImages"></div>
        </div>
    </div>
</div>
</div>