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

    <!-- Override margin top dari layout utama untuk home page -->
    <style>
      .flex-grow { margin-top: 0 !important; }
    </style>

    <!-- HERO SLIDER WITH BACKGROUND BLUR -->
<div class="relative h-[200px] sm:h-[300px] md:h-[450px] lg:h-[500px] overflow-hidden -mt-11">
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
<section class="w-full max-w-6xl mx-auto mt-12 px-4">
  <div class="bg-white border-2 rounded-xl shadow-2xl p-8 flex flex-col md:flex-row gap-10">
    <div class="md:w-[20%] flex flex-col items-center md:items-start" data-aos="fade-right" data-aos-duration="1000">
      <h2 class="text-2xl font-bold mb-5 text-center md:text-left text-gray-800">Sambutan<br>Kepala<br>Sekolah</h2>
      <div class="overflow-hidden rounded-md shadow-lg transition-transform duration-300 hover:scale-105">
        <img src="{{ asset('images/kepalasekolah.png') }}" alt="Kepala Sekolah" class="w-full h-auto object-cover">
      </div>
    </div>
    <div class="md:w-[75%] text-gray-800 text-justify space-y-4" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
      <p><span class="ml-4">Assalamu'alaikum wr.wb.</span></p>
      <p><span class="ml-4">Puji syukur kami panjatkan kehadirat Allah SWT, Tuhan Yang Maha Esa yang telah memberikan rahmat dan hidayahNya sehingga pembuatan website SD Negeri Padangsari 01 Semarang ini dapat terlaksana dengan lancar tanpa suatu halangan apa pun. Kami merasa bangga mendapatkan kesempatan untuk mengikuti workshop pelatihan pembuatan website sekolah. Kami akan berupaya untuk mengembangkan ilmu yang sudah diberikan melalui workshop untuk kemajuan SD Negeri Padangsari 01 terutama di bidang pendidikan dan memberikan informasi secara detail tentang SD Negeri Padangsari 01. Dilihat dari perkembangan zaman, teknologi dan kebutuhan akan informasi, mau tidak mau kita harus mengikutinya.</span></p>
      <p><span class="ml-4">Kami berusaha menyajikan informasi tentang siswa, guru, karyawan, tendik, dan kegiatan-kegiatan di sekolah SDN Padangsari 01, serta informasi atau pengumuman penting yang dibutuhkan oleh masyarakat umum. Selain itu, kami juga memberikan sedikit informasi tentang tempat pariwisata dan kesehatan yang ada di sekitar SDN Padangsari 01.</span></p>
      <p><span class="ml-4">Semoga dengan adanya website ini dapat membantu dunia pariwisata, pendidikan, dan masyarakat umum untuk mengetahui dan memahami SDN Padangsari 01 dan sekitarnya. Kami berharap, dengan adanya website ini dapat memberikan manfaat bagi semua pihak yang membutuhkan. Besar harapan kami mengharapkan masukan dari berbagai pihak agar website kami lebih bagus dalam segi tampilan dan lain-lain sehingga dapat memenuhi kebutuhan akan informasi dalam dunia pendidikan khususnya. Kami akan terus belajar, mengembangkan, dan memperbaiki dalam segi tampilan, isi, dan mutu website. Terima kasih atas dukungannya, semoga website kami lebih maju untuk mencapai SD Negeri Padangsari 01 yang lebih baik.</span></p>
      <p><span class="ml-4">Wassalamu'alaikum wr.wb.</span></p>
    </div>
  </div>
</section>

<!-- ADMINISTRASI SEKOLAH -->
<section class="w-full max-w-6xl mx-auto mt-10 px-4">
  <div class="bg-white border-2 rounded-xl shadow-2xl p-8">
    <p class="text-gray-800 text-justify">
      Secara administrasi Sekolah Dasar (SD) Negeri Padangsari 01 berada di Jalan Damar Raya No. 80 A, Kecamatan Banyumanik. SD Negeri Padangsari 01 terdiri dari beberapa bangunan utama, dengan rincian 7 (tujuh) ruangan kelas, 1 (satu) ruangan guru, 1 (satu) ruang kepala sekolah, 1 (satu) ruangan perpustakaan, mushola, ruang UKS, dan 2 (dua) kantin yang berada di dalam sekolah.
    </p>
  </div>
</section>


<section class="max-w-6xl mx-auto mt-16 px-4 mb-20" data-aos="fade-up" data-aos-duration="1000">
  <h2 class="text-center text-4xl font-extrabold text-gray-800 mb-2">TENTANG KAMI</h2>
  <h3 class="text-center text-2xl font-semibold uppercase text-red-700 tracking-wide mb-10">SD Negeri Padangsari 01</h3>

  <div class="flex flex-col md:flex-row gap-10 items-center bg-white border-2 rounded-xl shadow-2xl p-8" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
    <!-- Gambar Sekolah -->
    <div class="md:w-1/2 w-full overflow-hidden rounded-lg shadow-lg hover:shadow-2xl transition duration-300" data-aos="zoom-in" data-aos-delay="400">
      <img
        src="{{ asset('images/sekolh.jpg') }}"
        alt="Foto Sekolah"
        class="w-full h-full object-cover rounded-lg transform hover:scale-105 transition duration-500 ease-in-out"
      >
    </div>

    <!-- Deskripsi Sekolah -->
    <div class="md:w-1/2 w-full text-justify text-gray-800 space-y-4" data-aos="fade-left" data-aos-delay="600">
      <p>
        <span class="ml-4 font-bold text-lg text-red-700">SD NEGERI PADANGSARI 01</span> adalah sekolah dasar negeri yang berlokasi di <strong>Kecamatan Banyumanik, Kota Semarang, Jawa Tengah</strong>.
      </p>
      <p>
        Sekolah ini berdiri sejak <strong>1 Januari 1970</strong> dan berada di bawah naungan <strong>Kementerian Pendidikan dan Kebudayaan</strong>.
      </p>
      <p>
        Saat ini, SDN Padangsari 01 memiliki <strong>198 siswa</strong> dan didukung oleh <strong>10 guru profesional</strong> yang berdedikasi untuk mencetak generasi bangsa yang unggul dan berkarakter.
      </p>
      <p>
        Sekolah ini telah terakreditasi A dengan Nomor SK Akreditasi 817/BAN-SM/SK/2019 pada tanggal 1 Oktober 2019.

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
            <a href="{{ url('/galeri') }}" class="inline-block bg-red-500 text-white px-6 py-3 rounded hover:bg-red-700 transition-all duration-200">
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
            <a href="{{ url('/pengumuman') }}" class="inline-block bg-yellow-300 text-gray-900 font-semibold px-6 py-3 rounded hover:bg-yellow-500 transition-all duration-200">
              Lihat Pengumuman
            </a>
          </div>
        </div>
      </div>
    </section>


  </div>
</body>
