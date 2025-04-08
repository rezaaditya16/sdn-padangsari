<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
    <div class="site-wrap" id="home-section">
        <div class="site-mobile-menu site-navbar-target">
            <div class="site-mobile-menu-header">
                <div class="site-mobile-menu-close mt-3">
                    <span class="icon-close2 js-menu-toggle"></span>
                </div>
            </div>
            <div class="site-mobile-menu-body"></div>
        </div>
<div class="min-h-screen flex flex-col items-center bg-white">
        <!-- Image Slider Section -->
        <div class="w-full max-w-5xl mx-auto mt-10 px-4">
            <div x-data="{ currentSlide: 0, totalSlides: 2 }" class="relative overflow-hidden rounded-lg">
            <div x-data="{ currentSlide: 0, totalSlides: 3 }" class="relative overflow-hidden">
        <!-- Slider Images -->
        <div class="flex transition-transform duration-500 ease-in-out whitespace-nowrap" 
             :style="{ transform: `translateX(-${currentSlide * 100}%)` }">
            <div class="min-w-full">
                <img src="{{ asset('images/img1.jpeg') }}" alt="Slide 1" class="w-full h-auto max-h-96 object-cover">
            </div>
            <div class="min-w-full">
                <img src="{{ asset('images/img2.jpg') }}" alt="Slide 2" class="w-full h-auto max-h-96 object-cover">
            </div>
            <div class="min-w-full">
                <img src="{{ asset('images/UcapanSelamat.jpg') }}" alt="Slide 3" class="w-full h-auto max-h-96 object-cover">
            </div>
            <div class="min-w-full">
                <img src="{{ asset('images/ramadhan.jpg') }}" alt="Slide 3" class="w-full h-auto max-h-96 object-cover">
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="absolute inset-0 flex justify-between items-center px-4">
            <button @click="currentSlide = (currentSlide === 0 ? totalSlides - 1 : currentSlide - 1)" 
                    class="bg-black bg-opacity-50 text-white px-4 py-2 rounded-full hover:bg-opacity-75 focus:outline-none">
                &#10094;
            </button>
            <button @click="currentSlide = (currentSlide === totalSlides - 1 ? 0 : currentSlide + 1)" 
                    class="bg-black bg-opacity-50 text-white px-4 py-2 rounded-full hover:bg-opacity-75 focus:outline-none">
                &#10095;
            </button>
        </div>
    </div>

           
        </div>
    </div>

    <!-- Full-width header -->
    <div class="w-full bg-blue-900 mt-6">
        <div class="max-w-5xl mx-auto px-4 py-4">
            <h1 class="text-yellow-400 text-2xl font-bold uppercase text-center">
                SELAMAT DATANG DI WEBSITE SD NEGERI PADANGSARI 01
            </h1>
        </div>
    </div>

 <!-- Sambutan Kepala Sekolah Section -->
<div class="w-full max-w-6xl mx-auto mt-10 p-6 bg-gray-100 shadow-md rounded-lg flex flex-col md:flex-row items-start gap-10 px-4">
    
    <!-- Gambar Kepala Sekolah -->
    <div class="flex flex-col items-center md:items-start w-full md:w-[15%]">
        <h2 class="text-2xl font-bold mb-5 text-center md:text-left leading-tight">
            Sambutan<br>Kepala<br>Sekolah
        </h2>
        <div class="overflow-hidden rounded-md shadow-lg transition-transform duration-300 ease-in-out hover:scale-105">
            <img src="{{ asset('images/kepalasekolah.png') }}" 
                alt="Kepala Sekolah" 
                class="w-full h-auto max-w-md object-cover">
        </div>
        
    </div>

    <!-- Isi Sambutan -->
    <div class="text-gray-700 text-justify w-full md:w-[70%] space-y-4">
        <p><span class="ml-4">Assalamu'alaikum wr.wb.</span></p>
        <p><span class="ml-4">Puji syukur kami panjatkan kehadirat  Allah SWT, Tuhan Yang Maha Esa yang telah memberikan rahmat dan hidayahNya sehingga pembuatan website SD Negeri Padangsari 01 Semarang ini dapat terlaksana dengan lancar tanpa suatu halangan apa pun. kami merasa bangga mendapatkan kesempatan untuk mengikuti workshop pelatihan pembuatan website sekolah. Kami akan berupaya untuk mengembangkan ilmu yang sudah diberikan melalui workshop untuk kemajuan SD Negeri Padangsari 01 terutama dibidang pendidikan dan memeberikan informasi secara detail tentang SD Negeri Padangsari 01. Dilihat dari perkembangan zaman, teknologi dan kebutuhan akan informasi mau tidak mau kita harus mengikutinya.</span></p>
        <p><span class="ml-4">Kami berusaha menyajikan informasi tentang Siswa, Guru, karyawan, tendik dan kegiatan-kegiatan disekolah SDN Padangsari 01, informasi atau pengumuman penting yang dibutuhkan oleh masyarakat umum. selain itu, kami juga memberikan sedikit informasi tentang tempat Pariwisata, Kesehatan yang ada disekitar SDN Padangsari 01. </span></p>
        <p><span class="ml-4">Semoga dengan adanya website ini dapat membantu dunia pariwisata, pendidikan dan masyarakat umum untuk mengetahui dan memahami SDN Padangsari 01 dan sekitarnya. Kami berharap, dengan adanya website ini dapat memberikan manfaat bagi semua pihak yang membutuhkan. Besar harapan kami mengharapkan masukan dari berbagai pihak agar website kami lebih bagus dalam segi tampilan dan lain-lain sehingga dapat memenuhi kebutuhan akan informasi dalam dunia pendidikan khususnya. Kami akan terus belajar, menggembangkan dan memperbaiki dalam segi tampilan, isi dan mutu website. Terimakasih  atas dukungannya, semoga website kami lebih maju untuk mencapai SD Negeri Padangsari 01 yang lebih baik.</span></p>
        <p class="mt-2"><span class="ml-4">Wassalamu'alaikum wr.wb.</span></p>
    </div>

</div>




</div>