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
<nav class="bg-[#434593] text-white fixed top-0 left-0 w-full z-50 shadow-md" x-data="{ open: false }">
  <div class="container mx-auto px-4 md:px-6">
    <div class="flex justify-between items-center py-4">
      <!-- Logo dan nama -->
    <div class="flex items-center w-full md:w-auto bg-white rounded-tr-[80px] pr-4">
      <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 p-2">
      <div class="ml-3">
        <h1 class="text-xl md:text-2xl font-bold text-[#434593]">SDN Padangsari 1</h1>
        <p class="text-sm text-[#434593]">Sekolah Unggul Berprestasi</p>
      </div>
    </div>

      <!-- Hamburger (Mobile) -->
      <button @click="open = !open" class="md:hidden focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
      </button>

      <!-- Menu Desktop -->
      <div class="hidden md:flex items-center space-x-6">
        <a href="/" class="hover:underline">Beranda</a>
        <div class="relative" x-data="{ open: false, timeout: null }"
             @mouseenter="clearTimeout(timeout); open = true"
             @mouseleave="timeout = setTimeout(() => open = false, 300)">
          <button class="hover:underline">Tentang Kami ▾</button>
          <ul x-show="open" x-transition.origin.top class="absolute bg-white text-[#434593] mt-2 rounded shadow-lg w-48 z-10">
            <li><a href="/visimisi" class="block px-4 py-2 hover:bg-gray-100">Profil Sekolah</a></li>
            <li><a href="/guru" class="block px-4 py-2 hover:bg-gray-100">Profil Guru</a></li>
            <li><a href="/struktur" class="block px-4 py-2 hover:bg-gray-100">Profil Siswa</a></li>
          </ul>
        </div>

        <div class="relative" x-data="{ open: false, timeout: null }"
             @mouseenter="clearTimeout(timeout); open = true"
             @mouseleave="timeout = setTimeout(() => open = false, 300)">
          <button class="hover:underline">Kegiatan Sekolah ▾</button>
          <ul x-show="open" x-transition.origin.top class="absolute bg-white text-[#434593] mt-2 rounded shadow-lg w-48 z-10">
            <li><a href="/foto" class="block px-4 py-2 hover:bg-gray-100">Foto</a></li>
            <li><a href="/video" class="block px-4 py-2 hover:bg-gray-100">Video</a></li>
          </ul>
        </div>

        <a href="/artikel" class="hover:underline">Artikel</a>
        <a href="/pengumuman" class="hover:underline">Pengumuman</a>
        <a href="/kontak" class="hover:underline">Hubungi Kami</a>
      </div>
    </div>
  </div>
</nav>

<!-- Sub-navbar Sosial Media -->
<div class="bg-[#434593] mt-[90px] px-4 md:px-6 py-2">
  <div class="max-w-screen-xl mx-auto flex space-x-4">
    <!-- Instagram -->
    <a href="https://www.instagram.com/" target="_blank"
       class="w-9 h-9 flex items-center justify-center rounded-full bg-white hover:bg-gray-100">
      <i class="fab fa-instagram text-[#C13584]"></i>
    </a>
    
    <!-- YouTube -->
    <a href="https://www.youtube.com/" target="_blank"
       class="w-9 h-9 flex items-center justify-center rounded-full bg-white hover:bg-gray-100">
      <i class="fab fa-youtube text-[#FF0000]"></i>
    </a>
    
    <!-- WhatsApp -->
    <a href="https://wa.me/6281234567890" target="_blank"
       class="w-9 h-9 flex items-center justify-center rounded-full bg-white hover:bg-gray-100">
      <i class="fab fa-whatsapp text-[#25D366]"></i>
    </a>
  </div>
</div>


</body>
</html>
