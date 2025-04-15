<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300" class="overflow-x-hidden">
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

    <!-- HERO SLIDER WITH BACKGROUND BLUR -->
    <div class="relative h-[400px] md:h-[500px] lg:h-[600px] overflow-hidden">
      <div 
        class="absolute inset-0 bg-cover bg-center scale-110 blur-sm brightness-75"
        style="background-image: url('{{ asset('images/sekolah.png') }}'); background-attachment: fixed; z-index: 0;">
      </div>
      <div class="absolute inset-0 bg-black bg-opacity-50 z-10"></div>
      <div class="relative z-20 flex items-center justify-center h-full">
        <div 
          x-data="{ currentSlide: 0, totalSlides: 3 }"
          x-init="setInterval(() => currentSlide = (currentSlide + 1) % totalSlides, 5000)"
          class="relative w-full h-full max-w-full overflow-hidden rounded-lg">
          <div 
            class="flex transition-transform duration-500 ease-in-out w-full h-full"
            :style="{ transform: 'translateX(-' + (currentSlide * 100) + '%)' }">
            <template x-for="(image, index) in ['UcapanSelamat.jpg', 'UcapanSelamat.jpg', 'UcapanSelamat.jpg']" :key="index">
              <div class="min-w-full h-full">
                <img 
                  :src="'{{ asset('images') }}/' + image"
                  :alt="'Slide ' + (index + 1)"
                  class="w-full h-full object-cover">
              </div>
            </template>
          </div>
          <div class="absolute inset-0 flex justify-between items-center px-4">
            <button 
              @click="currentSlide = (currentSlide === 0 ? totalSlides - 1 : currentSlide - 1)"
              class="bg-black bg-opacity-50 text-white px-3 py-2 rounded-full hover:bg-opacity-75">&#10094;
            </button>
            <button 
              @click="currentSlide = (currentSlide === totalSlides - 1 ? 0 : currentSlide + 1)"
              class="bg-black bg-opacity-50 text-white px-3 py-2 rounded-full hover:bg-opacity-75">&#10095;
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- WELCOME MARQUEE -->
    <div class="w-full bg-[#BF3131]">
      <div class="max-w-5xl mx-auto px-4 py-4">
        <h1 class="text-yellow-400 text-2xl font-bold uppercase whitespace-nowrap animate-marquee">
          SELAMAT DATANG DI WEBSITE SD NEGERI PADANGSARI 01
        </h1>
      </div>
    </div>

    <!-- PRINCIPAL'S GREETING -->
    <section class="w-full max-w-6xl mx-auto mt-12 p-6 bg-gray-100 shadow-md rounded-lg flex flex-col md:flex-row gap-10 px-4">
      <div class="md:w-[20%] flex flex-col items-center md:items-start" data-aos="fade-right" data-aos-duration="1000">
        <h2 class="text-2xl font-bold mb-5 text-center md:text-left">Sambutan<br>Kepala<br>Sekolah</h2>
        <div class="overflow-hidden rounded-md shadow-lg transition-transform duration-300 hover:scale-105">
          <img src="{{ asset('images/kepalasekolah.png') }}" alt="Kepala Sekolah" class="w-full h-auto object-cover">
        </div>
      </div>
      <div class="md:w-[75%] text-gray-700 text-justify space-y-4" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
        <p><span class="ml-4">Assalamu'alaikum wr.wb.</span></p>
        <p><span class="ml-4">Puji syukur kami panjatkan kehadirat Allah SWT...</span></p>
        <p><span class="ml-4">Semoga dengan adanya website ini dapat membantu dunia pariwisata...</span></p>
        <p><span class="ml-4">Wassalamu'alaikum wr.wb.</span></p>
      </div>
    </section>

    <!-- SCHOOL INFORMATION -->
    <section class="w-full max-w-6xl mx-auto mt-10 p-6 bg-gray-100 shadow-md rounded-lg px-4">
      <p class="text-gray-800 text-justify">
      Secara administrasi Sekolah Dasar (SD) Negeri Padangsari 01 berada di Jalan Damar Raya No 80 A Kecamatan Banyumanik...
      </p>
    </section>

    <!-- PHOTO GALLERY + LIGHTBOX -->
    <section x-data="{ showLightbox: false, selectedImage: '' }" class="max-w-6xl mx-auto mt-16 px-4 mb-20">
      <h2 class="text-center text-3xl font-bold italic mb-2">GALERI FOTO</h2>
      <h3 class="text-center text-xl font-semibold uppercase text-gray-700 mb-8">Serba Serbi SDN Padangsari 01</h3>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <template x-for="(image, index) in ['galeri1.jpg', 'galeri2.jpg', 'galeri3.jpg', 'galeri4.jpg', 'galeri5.jpg', 'galeri6.jpg']" :key="index">
          <div class="overflow-hidden rounded-lg shadow-md hover:shadow-xl transition duration-300 cursor-pointer">
            <img 
              :src="`{{ asset('images/') }}/${image}`" 
              :alt="`Galeri ${index + 1}`" 
              class="w-full h-60 object-cover hover:scale-105 transition duration-300"
              @click="selectedImage = `{{ asset('images/') }}/${image}`; showLightbox = true">
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
        @click.away="showLightbox = false">
        <div class="relative max-w-4xl mx-auto">
          <button @click="showLightbox = false" class="absolute top-2 right-2 text-white text-2xl z-50">&times;</button>
          <img :src="selectedImage" class="max-w-full max-h-screen rounded shadow-lg">
        </div>
      </div>
    </section>
  </div>
</body>
