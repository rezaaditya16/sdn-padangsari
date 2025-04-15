<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Navbar Sekolah</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    .clip-diagonal {
      clip-path: polygon(0 0, 85% 0, 100% 100%, 0% 100%);
    }
    .font-bebas {
      font-family: 'Bebas Neue', cursive;
    }
    .font-poppins {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="bg-gray-100 pt-24 overflow-x-hidden overflow-y-auto font-poppins">

<!-- Navbar -->
<nav class="bg-[#7D0A0A] text-white fixed top-0 left-0 w-full z-50 shadow-md" x-data="{ open: false, openProfil: false, openGaleri: false }">
  <div class="flex items-center justify-between">
    <!-- Logo dan Judul -->
    <div class="flex items-center clip-diagonal bg-white h-24 pl-4 pr-10 w-full md:w-auto">
      <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-16 object-contain" />
      <div class="ml-4 text-[#434593]">
        <h1 class="text-3xl font-bebas uppercase tracking-wide leading-tight">SDN Padangsari 01</h1>
        <p class="text-sm italic">Sekolah Unggul Berprestasi</p>
      </div>
    </div>

    <!-- Tombol Mobile -->
    <button @click="open = !open" class="md:hidden p-4">
      <svg class="w-6 h-6" fill="none" stroke="white" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
      </svg>
    </button>

    <!-- Menu Desktop -->
    <div class="hidden md:flex space-x-6 px-6 text-white py-4 font-bebas text-lg tracking-wide uppercase">
      <a href="/" class="px-4 py-2 hover:bg-[#FFFBDA] hover:text-black rounded-xl transition duration-300 transform hover:scale-105">Beranda</a>

      <!-- Dropdown Profil -->
      <div class="relative" x-data="{ open: false, timeout: null }"
           @mouseenter="clearTimeout(timeout); open = true"
           @mouseleave="timeout = setTimeout(() => open = false, 300)">
        <button class="flex items-center px-3 py-2 hover:bg-[#FFFBDA] hover:text-black rounded-xl transition">
          Profil
          <svg class="ml-1 h-4 w-4 transition-transform duration-300 ease-in-out" :class="{ 'rotate-180': open }"
               xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <ul x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-2"
            x-cloak
            class="absolute bg-[#FFFBDA] text-black mt-2 rounded-xl shadow-lg w-52 z-10 font-normal capitalize text-sm">
          <li>
            <a href="/visimisi" class="flex items-center gap-2 px-4 py-2 hover:bg-[#FFEC9E] rounded-xl">
              <i class="fas fa-school"></i> Profil Sekolah
            </a>
          </li>
          <li>
            <a href="/guru" class="flex items-center gap-2 px-4 py-2 hover:bg-[#FFEC9E] rounded-xl">
              <i class="fas fa-chalkboard-teacher"></i> Profil Guru
            </a>
          </li>
          <li>
            <a href="/siswa" class="flex items-center gap-2 px-4 py-2 hover:bg-[#FFEC9E] rounded-xl">
              <i class="fas fa-user-graduate"></i> Profil Siswa
            </a>
          </li>
        </ul>
      </div>

      <!-- Dropdown Galeri -->
      <div class="relative" x-data="{ open: false, timeout: null }"
           @mouseenter="clearTimeout(timeout); open = true"
           @mouseleave="timeout = setTimeout(() => open = false, 300)">
        <button class="flex items-center px-3 py-2 hover:bg-[#FFFBDA] hover:text-black rounded-xl transition">
          Galeri
          <svg class="ml-1 h-4 w-4 transition-transform duration-300 ease-in-out" :class="{ 'rotate-180': open }"
               xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <ul x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-2"
            x-cloak
            class="absolute bg-[#FFFBDA] text-black mt-2 rounded-xl shadow-lg w-48 z-10 font-normal capitalize text-sm">
          <li>
            <a href="/foto" class="flex items-center gap-2 px-4 py-2 hover:bg-[#FFEC9E] rounded-xl">
              <i class="fas fa-image"></i> Foto
            </a>
          </li>
          <li>
            <a href="/video" class="flex items-center gap-2 px-4 py-2 hover:bg-[#FFEC9E] rounded-xl">
              <i class="fas fa-video"></i> Video
            </a>
          </li>
        </ul>
      </div>

      <a href="/pengumuman" class="px-4 py-2 hover:bg-[#FFFBDA] hover:text-black rounded-xl transition duration-300 transform hover:scale-105">Pengumuman</a>
      <a href="/ppdb" class="px-4 py-2 hover:bg-[#FFFBDA] hover:text-black rounded-xl transition duration-300 transform hover:scale-105">PPDB</a>
      <a href="/kontak" class="px-4 py-2 hover:bg-[#FFFBDA] hover:text-black rounded-xl transition duration-300 transform hover:scale-105">Kontak</a>
      <a href="/pengaduan" class="px-4 py-2 hover:bg-[#FFFBDA] hover:text-black rounded-xl transition duration-300 transform hover:scale-105">Pengaduan</a>
    </div>
  </div>

  <!-- Menu Mobile -->
  <div x-show="open"
       x-transition:enter="transition ease-out duration-300"
       x-transition:enter-start="opacity-0 -translate-y-4"
       x-transition:enter-end="opacity-100 translate-y-0"
       x-transition:leave="transition ease-in duration-200"
       x-transition:leave-start="opacity-100 translate-y-0"
       x-transition:leave-end="opacity-0 -translate-y-4"
       class="md:hidden px-6 pb-6 space-y-2 font-bebas uppercase tracking-wide text-base bg-[#BF3131] transform origin-top">

    <a href="/" class="block py-2 px-4 rounded-xl hover:bg-[#FFFBDA] hover:text-black transition duration-300">Beranda</a>

    <!-- Profil Mobile Dropdown with Smooth Animation -->
    <div>
      <button @click="openProfil = !openProfil"
              class="w-full flex items-center justify-between py-2 px-4 rounded-xl hover:bg-[#FFFBDA] hover:text-black transition duration-300">
        <span>Profil</span>
        <svg class="h-4 w-4 transform transition-transform duration-300 ease-in-out" :class="{ 'rotate-180': openProfil }"
             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
      </button>
      <div x-show="openProfil"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0 max-h-0"
           x-transition:enter-end="opacity-100 max-h-40"
           x-transition:leave="transition ease-in duration-200"
           x-transition:leave-start="opacity-100 max-h-40"
           x-transition:leave-end="opacity-0 max-h-0"
           x-cloak
           class="pl-4 font-normal capitalize space-y-1 overflow-hidden">
        <a href="/visimisi" class="block py-1 px-3 rounded hover:bg-[#FFFBDA] hover:text-black transition duration-200">Profil Sekolah</a>
        <a href="/guru" class="block py-1 px-3 rounded hover:bg-[#FFFBDA] hover:text-black transition duration-200">Profil Guru</a>
        <a href="/siswa" class="block py-1 px-3 rounded hover:bg-[#FFFBDA] hover:text-black transition duration-200">Profil Siswa</a>
      </div>
    </div>

    <!-- Galeri Mobile Dropdown with Smooth Animation -->
    <div>
      <button @click="openGaleri = !openGaleri"
              class="w-full flex items-center justify-between py-2 px-4 rounded-xl hover:bg-[#FFFBDA] hover:text-black transition duration-300">
        <span>Galeri</span>
        <svg class="h-4 w-4 transform transition-transform duration-300 ease-in-out" :class="{ 'rotate-180': openGaleri }"
             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
      </button>
      <div x-show="openGaleri"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0 max-h-0"
           x-transition:enter-end="opacity-100 max-h-40"
           x-transition:leave="transition ease-in duration-200"
           x-transition:leave-start="opacity-100 max-h-40"
           x-transition:leave-end="opacity-0 max-h-0"
           x-cloak
           class="pl-4 font-normal capitalize space-y-1 overflow-hidden">
        <a href="/foto" class="block py-1 px-3 rounded hover:bg-[#FFFBDA] hover:text-black transition duration-200">Foto</a>
        <a href="/video" class="block py-1 px-3 rounded hover:bg-[#FFFBDA] hover:text-black transition duration-200">Video</a>
      </div>
    </div>

    <!-- Menu lainnya -->
    <a href="/pengumuman" class="block py-2 px-4 rounded-xl hover:bg-[#FFFBDA] hover:text-black transition duration-300">Pengumuman</a>
    <a href="/ppdb" class="block py-2 px-4 rounded-xl hover:bg-[#FFFBDA] hover:text-black transition duration-300">PPDB</a>
    <a href="/kontak" class="block py-2 px-4 rounded-xl hover:bg-[#FFFBDA] hover:text-black transition duration-300">Kontak</a>
    <a href="/pengaduan" class="block py-2 px-4 rounded-xl hover:bg-[#FFFBDA] hover:text-black transition duration-300">Pengaduan</a>
  </div>
</nav>

<!-- Sub-navbar Sosial Media -->
<div class="bg-[#BF3131] mt-[90px] px-4 md:px-6 py-2 mb-8">
  <div class="max-w-screen-xl mx-auto flex items-center space-x-4">
    <a href="https://www.instagram.com/" target="_blank" aria-label="Instagram"
       class="w-9 h-9 flex items-center justify-center rounded-full bg-white hover:bg-gray-100 transition-all duration-300 ease-in-out transform hover:scale-110 hover:rotate-3 shadow">
      <i class="fab fa-instagram text-[#C13584] text-lg"></i>
    </a>
    <a href="https://www.youtube.com/" target="_blank" aria-label="YouTube"
       class="w-9 h-9 flex items-center justify-center rounded-full bg-white hover:bg-gray-100 transition-all duration-300 ease-in-out transform hover:scale-110 hover:rotate-3 shadow">
      <i class="fab fa-youtube text-[#FF0000] text-lg"></i>
    </a>
    <a href="https://wa.me/6281234567890" target="_blank" aria-label="WhatsApp"
       class="w-9 h-9 flex items-center justify-center rounded-full bg-white hover:bg-gray-100 transition-all duration-300 ease-in-out transform hover:scale-110 hover:rotate-3 shadow">
      <i class="fab fa-whatsapp text-[#25D366] text-lg"></i>
    </a>
  </div>
</div>

</body>
</html>
