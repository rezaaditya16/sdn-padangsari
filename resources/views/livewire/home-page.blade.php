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
<div class="relative h-[200px] sm:h-[300px] md:h-[450px] lg:h-[500px] overflow-hidden">
  <!-- Background Image with Blur -->
  <div 
    class="absolute inset-0 bg-cover bg-center blur-sm brightness-75"
    style="background-image: url('{{ asset('images/sekolah.png') }}'); background-attachment: fixed; z-index: 0;">
  </div>
  <!-- Semi-transparent Overlay -->
  <div class="absolute inset-0 bg-black bg-opacity-50 z-10"></div>
  <!-- Content Centered on Top of the Background -->
  <div class="relative z-20 flex items-center justify-center h-full">
    <div 
      x-data="{ currentSlide: 0, totalSlides: 3 }"
      x-init="setInterval(() => currentSlide = (currentSlide + 1) % totalSlides, 5000)"
      class="relative w-full h-full max-w-full overflow-hidden rounded-lg">
      
      <div 
        class="flex transition-transform duration-500 ease-in-out h-full"
        :style="{ transform: 'translateX(-' + (currentSlide * 100) + '%)' }">
        
        <template x-for="(image, index) in ['img1.jpeg', 'UcapanSelamat.jpg', 'img2.jpg']" :key="index">
          <div class="min-w-full h-full flex items-center justify-center">
            <img 
              :src="'{{ asset('images') }}/' + image"
              :alt="'Slide ' + (index + 1)"
              class="max-h-full max-w-full object-contain sm:w-[90%] sm:mx-auto transition-all duration-300 rounded-md">
          </div>
        </template>
      </div>

      <!-- Navigation Arrows -->
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
        <h1 class="text-[#FFFBDA] text-2xl font-bold uppercase whitespace-nowrap animate-marquee">
          SELAMAT DATANG DI WEBSITE SD NEGERI PADANGSARI 01
        </h1>
      </div>
    </div>

    <!-- PRINCIPAL'S GREETING -->
    <section class="w-full max-w-6xl mx-auto mt-12 p-6 bg-[#F1EFEC] shadow-md rounded-lg flex flex-col md:flex-row gap-10 px-4">
      <div class="md:w-[20%] flex flex-col items-center md:items-start" data-aos="fade-right" data-aos-duration="1000">
        <h2 class="text-2xl font-bold mb-5 text-center md:text-left">Sambutan<br>Kepala<br>Sekolah</h2>
        <div class="overflow-hidden rounded-md shadow-lg transition-transform duration-300 hover:scale-105">
          <img src="{{ asset('images/kepalasekolah.png') }}" alt="Kepala Sekolah" class="w-full h-auto object-cover">
        </div>
      </div>
      <div class="md:w-[75%] text-black text-justify space-y-4" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
        <p><span class="ml-4">Assalamu'alaikum wr.wb.</span></p>
        <p><span class="ml-4">Puji syukur kami panjatkan kehadirat  Allah SWT, Tuhan Yang Maha Esa yang telah memberikan rahmat dan hidayahNya sehingga pembuatan website SD Negeri Padangsari 01 Semarang ini dapat terlaksana dengan lancar tanpa suatu halangan apa pun. kami merasa bangga mendapatkan kesempatan untuk mengikuti workshop pelatihan pembuatan website sekolah. Kami akan berupaya untuk mengembangkan ilmu yang sudah diberikan melalui workshop untuk kemajuan SD Negeri Padangsari 01 terutama dibidang pendidikan dan memeberikan informasi secara detail tentang SD Negeri Padangsari 01. Dilihat dari perkembangan zaman, teknologi dan kebutuhan akan informasi mau tidak mau kita harus mengikutinya.</span></p>
        <p><span class="ml-4">Kami berusaha menyajikan informasi tentang Siswa, Guru, karyawan, tendik dan kegiatan-kegiatan disekolah SDN Padangsari 01, informasi atau pengumuman penting yang dibutuhkan oleh masyarakat umum. selain itu, kami juga memberikan sedikit informasi tentang tempat Pariwisata, Kesehatan yang ada disekitar SDN Padangsari 01.</span></p>
        <p><span class="ml-4">Semoga dengan adanya website ini dapat membantu dunia pariwisata, pendidikan dan masyarakat umum untuk mengetahui dan memahami SDN Padangsari 01 dan sekitarnya. Kami berharap, dengan adanya website ini dapat memberikan manfaat bagi semua pihak yang membutuhkan. Besar harapan kami mengharapkan masukan dari berbagai pihak agar website kami lebih bagus dalam segi tampilan dan lain-lain sehingga dapat memenuhi kebutuhan akan informasi dalam dunia pendidikan khususnya. Kami akan terus belajar, menggembangkan dan memperbaiki dalam segi tampilan, isi dan mutu website. Terimakasih  atas dukungannya, semoga website kami lebih maju untuk mencapai SD Negeri Padangsari 01 yang lebih baik.</span></p>

        <p><span class="ml-4">Wassalamu'alaikum wr.wb.</span></p>
      </div>
    </section>

    <section class="w-full max-w-6xl mx-auto mt-10 p-6 bg-[#F1EFEC] shadow-md rounded-lg px-4">
      <p class="text-black text-justify">
      Secara administrasi Sekolah Dasar (SD) Negeri Padangsari 01 berada di Jalan Damar Raya No 80 A Kecamatan Banyumanik. SD Negeri Padangsari 01 terdiri dari beberapa bangunan utama,  dgn rincian 7 (tujuh) ruangan Kelas, 1 (satu) ruangan Guru, 1 (satu) ruang Kepala Sekolah, 1 (satu) ruangan Perpustakaan, Mushola,  Ruang UKS, 2 (dua)kantin yang berada didalam sekolah. 
      </p>
    </section>


    <!-- TENTANG SDN PADANGSARI 01 -->
<section class="max-w-6xl mx-auto mt-16 px-4 mb-20">
  <h2 class="text-center text-3xl font-bold italic mb-2">TENTANG KAMI</h2>
  <h3 class="text-center text-xl font-semibold uppercase text-gray-700 mb-8">SD Negeri Padangsari 01</h3>

  <div class="flex flex-col md:flex-row gap-10 items-center bg-white rounded-lg shadow-lg p-6" data-aos="fade-up" data-aos-duration="1000">
    <!-- Gambar Sekolah -->
    <div class="md:w-1/2 w-full overflow-hidden rounded-lg shadow-md hover:shadow-xl transition duration-300" data-aos="fade-right" data-aos-duration="1000">
      <img 
        src="{{ asset('images/sekolh.jpg') }}" 
        alt="Foto Sekolah" 
        class="w-full h-full object-cover rounded-lg transform hover:scale-105 transition duration-500 ease-in-out"
      >
    </div>

    <!-- Deskripsi Sekolah -->
    <div class="md:w-1/2 w-full text-justify text-gray-800 space-y-4" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
      <p>
        <span class="ml-4 font-semibold">SD NEGERI PADANGSARI 01</span> merupakan salah satu sekolah jenjang SD berstatus Negeri yang berada di wilayah <strong>Kecamatan Banyumanik, Kota Semarang, Jawa Tengah</strong>. 
      </p>
      <p>
        Sekolah ini didirikan pada <strong>tanggal 1 Januari 1970</strong> dengan Nomor SK Pendirian di bawah naungan <strong>Kementerian Pendidikan dan Kebudayaan</strong>.
      </p>
      <p>
        Dalam kegiatan pembelajarannya, sekolah yang memiliki <strong>198 siswa</strong> ini dibimbing oleh <strong>10 guru profesional</strong> yang berkompeten di bidangnya untuk mencetak generasi penerus bangsa yang unggul dan berkarakter.
      </p>
    </div>
  </div>
</section>


    <section class="w-full px-6 py-20">
      <div class="max-w-screen-xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10">
        <!-- Kartu Acara Sekolah -->
        <div class="bg-white p-12 rounded-lg flex flex-col md:flex-row items-center gap-8 shadow-2xl">
          <!-- Gambar -->
          <div class="w-52 h-52">
            <img src="{{ asset('images/calendar.gif') }}" alt="Acara Sekolah" class="w-full h-full object-contain">
          </div>
    
          <!-- Konten -->
          <div>
            <h3 class="text-3xl font-extrabold text-gray-800 border-b-4 border-gray-700 inline-block mb-4">Acara Sekolah</h3>
            <p class="text-gray-800 text-lg mb-6">Lihat kegiatan-kegiatan tahunan SDN Padangsari 01 yang menarik di sini.</p>
            <a href="{{ url('/galeri') }}" class="inline-block bg-red-600 text-white px-6 py-3 rounded hover:bg-red-700 transition-all duration-200">
              Lihat galeri
            </a>
          </div>
        </div>
    
        <!-- Kartu Pengumuman -->
        <div class="bg-white p-12 rounded-lg flex flex-col md:flex-row items-center gap-8 shadow-2xl">
          <!-- Gambar -->
          <div class="w-52 h-52">
            <img src="{{ asset('images/megaphone.gif') }}" alt="Pengumuman" class="w-full h-full object-contain">
          </div>
    
          <!-- Konten -->
          <div>
            <h3 class="text-3xl font-extrabold text-gray-800 border-b-4 border-gray-700 inline-block mb-4">Pengumuman</h3>
            <p class="text-gray-800 text-lg mb-6">Baca pengumuman terbaru seputar kegiatan di SDN Padangsari 01</p>
            <a href="{{ url('/pengumuman') }}" class="inline-block bg-yellow-300 text-gray-900 font-semibold px-6 py-3 rounded hover:bg-yellow-400 transition-all duration-200">
              Lihat Pengumuman
            </a>
          </div>
        </div>
      </div>
    </section>
    
    
  </div>
</body>
