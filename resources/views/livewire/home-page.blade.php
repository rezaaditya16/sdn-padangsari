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

        <!-- HERO SLIDER DENGAN BACKGROUND BLUR -->
        <div class="relative h-[400px] overflow-hidden ">
            <!-- Background Blur -->
            <div 
                class="absolute inset-0 bg-cover bg-center scale-110 blur-sm brightness-75"
                style="background-image: url('{{ asset('images/sekolah.png') }}'); z-index: 0; background-attachment: fixed;"
            ></div>

            <!-- Lapisan gelap transparan -->
            <div class="absolute inset-0 bg-black bg-opacity-50 z-10"></div>

            <!-- Konten Slider -->
            <div class="relative z-20 w-full h-full flex items-center justify-center">
                <div 
                    x-data="{ currentSlide: 0, totalSlides: 4 }"
                    x-init="setInterval(() => currentSlide = (currentSlide + 1) % totalSlides, 5000)"
                    class="relative w-full max-w-6xl h-[300px] md:h-[400px] overflow-hidden rounded-lg"
                >
                    <!-- Gambar Slider -->
                    <div 
                        class="flex transition-transform duration-500 ease-in-out w-full h-full"
                        :style="{ transform: 'translateX(-' + (currentSlide * 100) + '%)' }"
                    >
                        <template x-for="(image, index) in ['img1.jpeg', 'img2.jpg', 'UcapanSelamat.jpg', 'ramadhan.jpg']" :key="index">
                            <div class="min-w-full h-full">
                                <img 
                                    :src="'{{ asset('images') }}/' + image"
                                    :alt="'Slide ' + (index + 1)"
                                    class="w-full h-full object-cover"
                                >
                            </div>
                        </template>
                    </div>

                    <!-- Navigasi Kiri dan Kanan -->
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
        <div class="w-full bg-[#BF3131] overflow-hidden">
  <div class="max-w-5xl mx-auto px-4 py-4">
    <h1 class="text-yellow-400 text-2xl font-bold uppercase whitespace-nowrap animate-marquee">
      SELAMAT DATANG DI WEBSITE SD NEGERI PADANGSARI 01
    </h1>
  </div>
</div>

        <!-- SAMBUTAN KEPALA SEKOLAH -->
        <div class="w-full max-w-6xl mx-auto mt-10 p-6 bg-gray-100 shadow-md rounded-lg flex flex-col md:flex-row items-start gap-10 px-4">
        <div class="flex flex-col items-center md:items-start w-full md:w-[15%]" data-aos="fade-right" data-aos-duration="1000">

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

            <div class="text-gray-700 text-justify w-full md:w-[70%] space-y-4" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">

                <p><span class="ml-4">Assalamu'alaikum wr.wb.</span></p>
                <p><span class="ml-4">Puji syukur kami panjatkan kehadirat  Allah SWT, Tuhan Yang Maha Esa yang telah memberikan rahmat dan hidayahNya sehingga pembuatan website SD Negeri Padangsari 01 Semarang ini dapat terlaksana dengan lancar tanpa suatu halangan apa pun. kami merasa bangga mendapatkan kesempatan untuk mengikuti workshop pelatihan pembuatan website sekolah. Kami akan berupaya untuk mengembangkan ilmu yang sudah diberikan melalui workshop untuk kemajuan SD Negeri Padangsari 01 terutama dibidang pendidikan dan memeberikan informasi secara detail tentang SD Negeri Padangsari 01. Dilihat dari perkembangan zaman, teknologi dan kebutuhan akan informasi mau tidak mau kita harus mengikutinya.</span></p>
                <p><span class="ml-4">Kami berusaha menyajikan informasi tentang Siswa, Guru, karyawan, tendik dan kegiatan-kegiatan disekolah SDN Padangsari 01, informasi atau pengumuman penting yang dibutuhkan oleh masyarakat umum. selain itu, kami juga memberikan sedikit informasi tentang tempat Pariwisata, Kesehatan yang ada disekitar SDN Padangsari 01. </span></p>
                <p><span class="ml-4">Semoga dengan adanya website ini dapat membantu dunia pariwisata, pendidikan dan masyarakat umum untuk mengetahui dan memahami SDN Padangsari 01 dan sekitarnya. Kami berharap, dengan adanya website ini dapat memberikan manfaat bagi semua pihak yang membutuhkan. Besar harapan kami mengharapkan masukan dari berbagai pihak agar website kami lebih bagus dalam segi tampilan dan lain-lain sehingga dapat memenuhi kebutuhan akan informasi dalam dunia pendidikan khususnya. Kami akan terus belajar, menggembangkan dan memperbaiki dalam segi tampilan, isi dan mutu website. Terimakasih  atas dukungannya, semoga website kami lebih maju untuk mencapai SD Negeri Padangsari 01 yang lebih baik.</span></p>
                <p class="mt-2"><span class="ml-4">Wassalamu'alaikum wr.wb.</span></p>
            </div>
        </div>

        <!-- INFORMASI ADMINISTRASI SEKOLAH -->
        <div class="w-full max-w-6xl mx-auto mt-10 p-6 bg-gray-100 shadow-md rounded-lg flex flex-col md:flex-row items-start gap-10 px-4">
            <p>
            Secara administrasi Sekolah Dasar (SD) Negeri Padangsari 01 berada di Jalan Damar Raya No 80 A Kecamatan Banyumanik. SD Negeri Padangsari 01 terdiri dari beberapa bangunan utama,  dgn rincian 7 (tujuh) ruangan Kelas, 1 (satu) ruangan Guru, 1 (satu) ruang Kepala Sekolah, 1 (satu) ruangan Perpustakaan, Mushola,  Ruang UKS, 2 (dua)kantin yang berada didalam sekolah. 
            </p>
        </div>

        <!-- GALERI FOTO + LIGHTBOX -->
        <div x-data="{ showLightbox: false, selectedImage: '' }" class="max-w-6xl mx-auto mt-16 px-4 mb-20">
            <h2 class="text-center text-3xl font-bold italic mb-2">GALERI FOTO</h2>
            <h3 class="text-center text-xl font-semibold uppercase text-gray-700 mb-8">
                Serba Serbi SDN Padangsari 01
            </h3>

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

            <div class="flex justify-center mt-10">
                <a href="{{ url('/galeri') }}" class="bg-[#F6DC43] text-black px-6 py-2 rounded-lg hover:bg-[#FFA725] transition">
                    Lihat Semua Galeri
                </a>
            </div>

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
