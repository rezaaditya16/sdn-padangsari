<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navbar Sekolah</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-gray-100 pt-24">

<!-- Navbar -->
<nav class="bg-gray-800 text-white fixed top-0 left-0 w-full z-50 shadow-md" x-data="{ open: false }">
  <div class="container mx-auto px-4 md:px-6">
    <div class="flex justify-between items-center py-4">
      <!-- Logo -->
      <a href="/" class="flex items-center space-x-3">
        <img src="{{ asset('images/logo.png') }}" class="h-12 w-auto" alt="Logo">
        <span class="text-xl font-bold">SDN 01 Padangsari</span>
      </a>

      <!-- Hamburger (Mobile) -->
      <button @click="open = !open" class="md:hidden focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
      </button>

      <!-- Menu Desktop -->
      <div class="hidden md:flex items-center space-x-6">
        <a href="/" class="hover:text-blue-300">BERANDA</a>

        <!-- Dropdown PROFIL -->
        <div class="relative group">
          <button class="hover:text-blue-300">PROFIL ▾</button>
          <ul class="absolute bg-gray-700 text-white mt-2 rounded shadow-lg hidden group-hover:block w-40 z-10">
            <li><a href="/visimisi" class="block px-4 py-2 hover:bg-gray-600 hover:text-blue-300">Profil Sekolah</a></li>
            <li><a href="/guru" class="block px-4 py-2 hover:bg-gray-600 hover:text-blue-300">Profil Guru</a></li>
            <li><a href="/struktur" class="block px-4 py-2 hover:bg-gray-600 hover:text-blue-300">Profil Siswa</a></li>
          </ul>
        </div>

        <!-- Dropdown GALERI -->
        <div class="relative group">
          <button class="hover:text-blue-300">GALERI ▾</button>
          <ul class="absolute bg-gray-700 text-white mt-2 rounded shadow-lg hidden group-hover:block w-40 z-10">
            <li><a href="/foto" class="block px-4 py-2 hover:bg-gray-600 hover:text-blue-300">Foto</a></li>
            <li><a href="/video" class="block px-4 py-2 hover:bg-gray-600 hover:text-blue-300">Video</a></li>
          </ul>
        </div>

        <a href="/pengumuman" class="hover:text-blue-300">PENGUMUMAN</a>
        <a href="/ppdb" class="hover:text-blue-300">PPDB</a>
        <a href="/kontak" class="hover:text-blue-300">KONTAK</a>
        <a href="/pengaduan" class="hover:text-blue-300">PENGADUAN</a>
        <a href="/tentang" class="hover:text-blue-300">TENTANG</a>

        <!-- Sosmed -->
        <div class="flex space-x-2">
          <a href="https://web.facebook.com/SDNPedurunganKidul04" target="_blank"
             class="rounded-full border border-gray-300 p-2 w-9 h-9 flex items-center justify-center hover:bg-gray-200">
            <i class="fab fa-facebook-f text-blue-600"></i>
          </a>
          <a href="https://www.youtube.com/channel/UCkfW_EhreCzT6KsVeAGYHug" target="_blank"
             class="rounded-full border border-gray-300 p-2 w-9 h-9 flex items-center justify-center hover:bg-gray-200">
            <i class="fab fa-youtube text-red-600"></i>
          </a>
        </div>
      </div>
    </div>

    <!-- Mobile Menu -->
    <div 
      x-show="open" 
      x-transition:enter="transition-all ease-out duration-300" 
      x-transition:enter-start="opacity-0 max-h-0" 
      x-transition:enter-end="opacity-100 max-h-[500px]" 
      x-transition:leave="transition-all ease-in duration-200" 
      x-transition:leave-start="opacity-100 max-h-[500px]" 
      x-transition:leave-end="opacity-0 max-h-0" 
      class="md:hidden overflow-hidden rounded-b-lg text-white px-4 py-2 space-y-2"
    >
      <a href="/" class="block py-2 hover:text-blue-300">BERANDA</a>

      <!-- Dropdown Profil -->
      <div x-data="{ show: false }">
        <button @click="show = !show" class="w-full text-left py-2 hover:text-blue-300">PROFIL ▾</button>
        <div x-show="show" x-transition class="pl-4 space-y-1">
          <a href="/visimisi" class="block py-1 hover:text-blue-300">Profil Sekolah</a>
          <a href="/guru" class="block py-1 hover:text-blue-300">Profil Guru</a>
          <a href="/struktur" class="block py-1 hover:text-blue-300">Profil Siswa</a>
        </div>
      </div>

      <!-- Dropdown Galeri -->
      <div x-data="{ show: false }">
        <button @click="show = !show" class="w-full text-left py-2 hover:text-blue-300">GALERI ▾</button>
        <div x-show="show" x-transition class="pl-4 space-y-1">
          <a href="/foto" class="block py-1 hover:text-blue-300">Foto</a>
          <a href="/video" class="block py-1 hover:text-blue-300">Video</a>
        </div>
      </div>

      <a href="/pengumuman" class="block py-2 hover:text-blue-300">PENGUMUMAN</a>
      <a href="/ppdb" class="block py-2 hover:text-blue-300">PPDB</a>
      <a href="/kontak" class="block py-2 hover:text-blue-300">KONTAK</a>
      <a href="/pengaduan" class="block py-2 hover:text-blue-300">PENGADUAN</a>
      <a href="/tentang" class="block py-2 hover:text-blue-300">TENTANG</a>
    </div>
  </div>
</nav>


</body>
</html>
