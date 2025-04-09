<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
    <div class="site-wrap" id="home-section">
        <!-- Mobile Menu -->
        <div class="site-mobile-menu site-navbar-target">
            <div class="site-mobile-menu-header">
                <div class="site-mobile-menu-close mt-3">
                    <span class="icon-close2 js-menu-toggle"></span>
                </div>
            </div>
            <div class="site-mobile-menu-body"></div>
        </div>

<!-- SLIDER TANPA BG GRAY, FULL GAMBAR -->
<div class="flex flex-col items-center bg-white mt-32">
    <div class="w-full max-w-7xl mx-auto mt-6 px-0">
        <div 
            x-data="{ currentSlide: 0, totalSlides: 4 }"
            x-init="setInterval(() => currentSlide = (currentSlide + 1) % totalSlides, 5000)"
            class="relative overflow-hidden rounded-lg w-full h-[500px]"
        >
            <!-- Slider Images -->
            <div 
                class="flex transition-transform duration-500 ease-in-out w-full h-full"
                :style="{ transform: `translateX(-${currentSlide * 100}%)` }"
            >
                <template x-for="(image, index) in ['img1.jpeg', 'img2.jpg', 'UcapanSelamat.jpg', 'ramadhan.jpg']" :key="index">
                    <div class="min-w-full h-full">
                        <img 
                            :src="`{{ asset('images/') }}/${image}`"
                            :alt="`Slide ${index + 1}`"
                            class="w-full h-full object-cover"
                        >
                    </div>
                </template>
            </div>

            <!-- Navigation Buttons -->
            <div class="absolute inset-0 flex justify-between items-center px-4">
                <button 
                    @click="currentSlide = (currentSlide === 0 ? totalSlides - 1 : currentSlide - 1)"
                    class="bg-black bg-opacity-50 text-white px-3 py-2 rounded-full hover:bg-opacity-75"
                >
                    &#10094;
                </button>
                <button 
                    @click="currentSlide = (currentSlide === totalSlides - 1 ? 0 : currentSlide + 1)"
                    class="bg-black bg-opacity-50 text-white px-3 py-2 rounded-full hover:bg-opacity-75"
                >
                    &#10095;
                </button>
            </div>
        </div>
    </div>
</div>

        <!-- HEADER -->
        <div class="w-full bg-blue-900 mt-6">
            <div class="max-w-5xl mx-auto px-4 py-4">
                <h1 class="text-yellow-400 text-2xl font-bold uppercase text-center">
                    SELAMAT DATANG DI WEBSITE SD NEGERI PADANGSARI 01
                </h1>
            </div>
        </div>

        <!-- SAMBUTAN KEPALA SEKOLAH -->
        <div class="w-full max-w-6xl mx-auto mt-10 p-6 bg-gray-100 shadow-md rounded-lg flex flex-col md:flex-row items-start gap-10 px-4">
            <!-- Gambar Kepala Sekolah -->
            <div class="flex flex-col items-center md:items-start w-full md:w-[15%]">
                <h2 class="text-2xl font-bold mb-5 text-center md:text-left leading-tight">
                    Sambutan<br>Kepala<br>Sekolah
                </h2>
                <div class="overflow-hidden rounded-md shadow-lg transition-transform duration-300 ease-in-out hover:scale-105">
                    <img 
                        src="{{ asset('images/kepalasekolah.png') }}" 
                        alt="Kepala Sekolah" 
                        class="w-full h-auto max-w-md object-cover"
                    >
                </div>
            </div>

            <!-- Isi Sambutan -->
            <div class="text-gray-700 text-justify w-full md:w-[70%] space-y-4">
                <p><span class="ml-4">Assalamu'alaikum wr.wb.</span></p>
                <p><span class="ml-4">Puji syukur kami panjatkan ke hadirat Allah SWT, Tuhan Yang Maha Esa, yang telah memberikan rahmat dan hidayah-Nya sehingga pembuatan website SD Negeri Padangsari 01 Semarang ini dapat terlaksana dengan lancar tanpa suatu halangan apa pun. Kami merasa bangga mendapatkan kesempatan untuk mengikuti workshop pelatihan pembuatan website sekolah. Kami akan berupaya untuk mengembangkan ilmu yang sudah diberikan melalui workshop untuk kemajuan SD Negeri Padangsari 01, terutama di bidang pendidikan dan penyampaian informasi secara detail tentang SD Negeri Padangsari 01.</span></p>
                <p><span class="ml-4">Kami berusaha menyajikan informasi tentang siswa, guru, karyawan, tenaga pendidik, serta kegiatan-kegiatan di sekolah SDN Padangsari 01. Informasi atau pengumuman penting yang dibutuhkan oleh masyarakat umum juga akan kami tampilkan. Selain itu, kami memberikan informasi tambahan tentang tempat wisata dan layanan kesehatan di sekitar SDN Padangsari 01.</span></p>
                <p><span class="ml-4">Semoga dengan adanya website ini dapat membantu dunia pariwisata, pendidikan, dan masyarakat umum untuk lebih mengenal SDN Padangsari 01 dan lingkungannya. Kami berharap website ini memberikan manfaat bagi semua pihak yang membutuhkan informasi. Kami sangat mengharapkan masukan dari berbagai pihak agar website kami dapat lebih baik, baik dari segi tampilan maupun isi kontennya. Kami akan terus belajar dan memperbaiki tampilan, isi, dan mutu dari website ini. Terima kasih atas dukungan Anda, semoga SD Negeri Padangsari 01 semakin maju.</span></p>
                <p class="mt-2"><span class="ml-4">Wassalamu'alaikum wr.wb.</span></p>
            </div>
        </div>
        <!-- INFORMASI ADMINISTRASI SEKOLAH -->
<div class="w-full max-w-6xl mx-auto mt-10 p-6 bg-gray-100 shadow-md rounded-lg flex flex-col md:flex-row items-start gap-10 px-4">
    <p>
        Secara administrasi Sekolah Dasar (SD) Negeri Padangsari 01 berada di Jalan Damar Raya No 80 A Kecamatan Banyumanik. 
        SD Negeri Padangsari 01 terdiri dari beberapa bangunan utama, dengan rincian 7 (tujuh) ruangan Kelas, 1 (satu) ruang Guru, 
        1 (satu) ruang Kepala Sekolah, 1 (satu) ruangan Perpustakaan, Mushola, Ruang UKS, 2 (dua) kantin yang berada di dalam sekolah.
    </p>
</div>

<!-- GALERI FOTO + LIGHTBOX -->
<div x-data="{ showLightbox: false, selectedImage: '' }" class="max-w-6xl mx-auto mt-16 px-4 mb-20">
    <h2 class="text-center text-3xl font-bold italic mb-2">GALERI FOTO</h2>
    <h3 class="text-center text-xl font-semibold uppercase text-gray-700 mb-8">
        Serba Serbi SDN Padangsari 01
    </h3>

    <!-- Grid Galeri -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <template x-for="(image, index) in ['galeri1.jpg', 'galeri2.jpg', 'galeri3.jpg', 'galeri4.jpg', 'galeri5.jpg', 'galeri6.jpg']" :key="index">
            <div class="overflow-hidden rounded-lg shadow-md hover:shadow-xl transition duration-300 cursor-pointer">
                <img 
                    :src="`{{ asset('images/') }}/${image}`" 
                    :alt="`Galeri ${index + 1}`" 
                    class="w-full h-60 object-cover hover:scale-105 transition duration-300"
                    @click="selectedImage = `{{ asset('images/') }}/${image}`; showLightbox = true"
                >
            </div>
        </template>
    </div>

    <!-- Tombol Lihat Selengkapnya -->
    <div class="flex justify-center mt-10">
        <a href="{{ url('/galeri') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
            Lihat Semua Galeri
        </a>
    </div>

    <!-- LIGHTBOX -->
    <div 
        x-show="showLightbox"
        x-transition
        class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50"
        @click.away="showLightbox = false"
    >
        <div class="relative max-w-4xl mx-auto">
            <button @click="showLightbox = false" class="absolute top-2 right-2 text-white text-2xl z-50">&times;</button>
            <img :src="selectedImage" class="max-w-full max-h-screen rounded shadow-lg">
        </div>
    </div>
</div>

    </div>
</body>
