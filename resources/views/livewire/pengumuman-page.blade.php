<div class="mt-[-90px]">
    <!-- Hero Section -->
    <div class="relative h-[400px] bg-cover bg-center" style="background-image: url('{{ asset('images/sekolah.png') }}'); background-attachment: fixed;">
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
                        <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('images/default.png') }}"
                             alt="Gambar"
                             class="rounded-md w-full h-64 object-cover">

                        <!-- Konten Pengumuman -->
                        <div>
                            <h2 class="text-xl font-bold mb-2">{{ $item->title }}</h2>
                            <p class="text-gray-800">{{ Str::limit($item->content, 150) }}</p>

                            <!-- Tombol Selengkapnya -->
                            <div class="text-right mt-6">
                                <button
                                    @click="open = true"
                                    class="bg-red-500 hover:bg-red-700 text-white px-6 py-2 rounded-full transition">
                                    Selengkapnya
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Detail -->
                    <div
                        x-show="open"
                        x-transition
                        class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center p-4"
                    >
                        <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full p-6 relative">
                            <!-- Tombol Tutup -->
                            <button
                                @click="open = false"
                                class="absolute top-2 right-2 text-gray-600 hover:text-red-500 text-2xl">
                                &times;
                            </button>

                            <!-- Konten Modal -->
                            <h2 class="text-2xl font-bold mb-4">{{ $item->title }}</h2>
                            <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('images/default.png') }}"
                                 alt="Gambar"
                                 class="rounded-md w-full h-64 object-cover mb-4">
                            <p class="text-gray-700">{{ $item->content }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
