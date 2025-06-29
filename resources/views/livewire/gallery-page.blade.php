<div class="mt-[-120px]">
    <div class="relative h-[400px] bg-cover bg-center mt-3"
        style="background-image: url('{{ asset('images/sekolah.png') }}'); background-attachment: fixed;">
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

                    <div class="relative cursor-pointer group" onclick="openGallery({{ $index }})">
                        <img src="{{ asset('storage/' . $gallery->images[0]) }}" alt="{{ $gallery->title }}"
                            class="w-full h-48 object-cover rounded-lg transition duration-300 group-hover:brightness-75" />
                        <div
                            class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center text-white font-semibold text-lg">
                            Lihat Galeri
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Galeri Modal -->
        <div id="galleryModal"
            class="fixed inset-0 z-50 hidden bg-black bg-opacity-70 overflow-auto flex items-center justify-center p-6">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-4xl relative">
                <!-- Tombol Tutup -->
                <button onclick="closeGallery()"
                    class="absolute top-2 right-2 text-black text-2xl hover:text-red-500">&times;</button>
                <div class="p-6">
                    <!-- Title -->
                    <h2 id="galleryTitle" class="text-3xl font-bold text-gray-800 mb-4 text-center"></h2>
                    <!-- Description -->
                    <p id="galleryDescription" class="text-gray-600 mb-6 text-center"></p>
                    <!-- Gambar Utama -->
                    <div class="relative">
                        <img id="mainGalleryImage" src="" alt="" class="w-full h-96 object-cover rounded-lg shadow-md">
                        <!-- Navigasi Sebelumnya -->
                        {{-- <button id="prevImage" onclick="prevGalleryImage()"
                            class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75">
                            &larr;
                        </button> --}}
                        <!-- Navigasi Berikutnya -->
                        {{-- <button id="nextImage" onclick="nextGalleryImage()"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75">
                            &rarr;
                        </button>
                    </div> --}}
                    <!-- Thumbnail Gambar -->
                    <div class="grid grid-cols-4 gap-4 mt-4" id="galleryThumbnails"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const galleries = @json($galleries); // Ambil data galeri dari server
    let currentGalleryIndex = 0;
    let currentImageIndex = 0;

    function openGallery(index) {
        currentGalleryIndex = index;
        currentImageIndex = 0;

        const gallery = galleries[index];
        const modal = document.getElementById('galleryModal');
        const galleryTitle = document.getElementById('galleryTitle');
        const galleryDescription = document.getElementById('galleryDescription');
        const mainGalleryImage = document.getElementById('mainGalleryImage');
        const galleryThumbnails = document.getElementById('galleryThumbnails');

        // Set title dan description
        galleryTitle.textContent = gallery.title;
        galleryDescription.textContent = gallery.description;

        // Set gambar utama
        mainGalleryImage.src = `{{ asset('storage') }}/${gallery.images[0]}`;
        mainGalleryImage.alt = gallery.title;

        // Kosongkan thumbnail sebelum menambahkan gambar baru
        // galleryThumbnails.innerHTML = '';

        // Tambahkan thumbnail
        // gallery.images.forEach((image, i) => {
        //     const thumbnail = document.createElement('img');
        //     thumbnail.src = `{{ asset('storage') }}/${image}`;
        //     thumbnail.alt = gallery.title;
        //     thumbnail.className = 'w-full h-24 object-cover rounded-lg cursor-pointer';
        //     thumbnail.onclick = () => setMainImage(i);
        //     galleryThumbnails.appendChild(thumbnail);
        // });

        // Tampilkan modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeGallery() {
        const modal = document.getElementById('galleryModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    function setMainImage(index) {
        const gallery = galleries[currentGalleryIndex];
        const mainGalleryImage = document.getElementById('mainGalleryImage');
        // const galleryThumbnails = document.getElementById('galleryThumbnails').children;

        currentImageIndex = index;
        mainGalleryImage.src = `{{ asset('storage') }}/${gallery.images[index]}`;
        mainGalleryImage.alt = gallery.title;

        // Perbarui highlight thumbnail
        // Array.from(galleryThumbnails).forEach((thumbnail, i) => {
        //     if (i === index) {
        //         thumbnail.classList.add('ring-2', 'ring-red-500');
        //     } else {
        //         thumbnail.classList.remove('ring-2', 'ring-red-500');
        //     }
        // });
    }

    // function prevGalleryImage() {
    //     const gallery = galleries[currentGalleryIndex];
    //     currentImageIndex = (currentImageIndex - 1 + gallery.images.length) % gallery.images.length;
    //     setMainImage(currentImageIndex);
    // }

    // function nextGalleryImage() {
    //     const gallery = galleries[currentGalleryIndex];
    //     currentImageIndex = (currentImageIndex + 1) % gallery.images.length;
    //     setMainImage(currentImageIndex);
    // }
</script>
