<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Navbar Sekolah</title>
</head>
<body class="bg-gray-100">

<!-- NAVBAR -->
<nav class="bg-gray-800 text-white shadow-lg w-full fixed top-0 left-0 z-50"
     x-data="{ open: false, dropdowns: { profil: false, galeri: false }, timers: { profil: null, galeri: null } }">
    <div class="container mx-auto px-6">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            <a wire:navigate href="/" class="text-lg font-semibold flex items-center">
                <img src="/images/logo.png" alt="Logo" class="h-22 w-28 mr-2">
                SDN 01 Padangsari
            </a>

            <!-- Burger Menu (Mobile) -->
            <button @click="open = !open" class="md:hidden text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
            </button>

            <!-- MENU DESKTOP -->
            <div class="hidden md:flex space-x-6 items-center">
                <a wire:navigate href="/" class="hover:bg-blue-300 hover:text-gray-900 px-4 py-2 rounded-md">BERANDA</a>

                <!-- Dropdown PROFIL -->
                <div class="relative"
                     @mouseenter="clearTimeout(timers.profil); dropdowns.profil = true"
                     @mouseleave="timers.profil = setTimeout(() => dropdowns.profil = false, 200)">
                    <button class="inline-flex items-center hover:bg-blue-300 hover:text-gray-900 px-4 py-2 rounded-md">
                        PROFIL ▾
                    </button>
                    <ul x-show="dropdowns.profil" x-transition
                        class="absolute left-0 bg-gray-700 text-white mt-2 rounded shadow-lg w-40 z-10">
                        <li><a wire:navigate href="/visimisi" class="block px-4 py-2 hover:bg-gray-600">Profil Sekolah</a></li>
                        <li><a wire:navigate href="/guru" class="block px-4 py-2 hover:bg-gray-600">Profil Guru</a></li>
                        <li><a wire:navigate href="/struktur" class="block px-4 py-2 hover:bg-gray-600">Profil Siswa</a></li>
                    </ul>
                </div>

                <!-- Dropdown GALERI -->
                <div class="relative"
                     @mouseenter="clearTimeout(timers.galeri); dropdowns.galeri = true"
                     @mouseleave="timers.galeri = setTimeout(() => dropdowns.galeri = false, 200)">
                    <button class="inline-flex items-center hover:bg-blue-300 hover:text-gray-900 px-4 py-2 rounded-md">
                        GALERI ▾
                    </button>
                    <ul x-show="dropdowns.galeri" x-transition
                        class="absolute left-0 bg-gray-700 text-white mt-2 rounded shadow-lg w-40 z-10">
                        <li><a wire:navigate href="/foto" class="block px-4 py-2 hover:bg-gray-600">Foto</a></li>
                        <li><a wire:navigate href="/video" class="block px-4 py-2 hover:bg-gray-600">Video</a></li>
                    </ul>
                </div>

                <a wire:navigate href="/pengumuman" class="hover:bg-blue-300 hover:text-gray-900 px-4 py-2 rounded-md">PENGUMUMAN</a>
                <a wire:navigate href="/ppdb" class="hover:bg-blue-300 hover:text-gray-900 px-4 py-2 rounded-md">PPDB 2021/2022</a>
                <a wire:navigate href="/kontak" class="hover:bg-blue-300 hover:text-gray-900 px-4 py-2 rounded-md">KONTAK</a>
                <a wire:navigate href="/pengaduan" class="hover:bg-blue-300 hover:text-gray-900 px-4 py-2 rounded-md">PENGADUAN</a>
                <a wire:navigate href="/tentang" class="hover:bg-blue-300 hover:text-gray-900 px-4 py-2 rounded-md">TENTANG</a>

                <!-- Ikon Sosial Media dan Login -->
                <div class="top-social ml-4 flex space-x-2">
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

        <!-- MENU MOBILE -->
        <div x-show="open" class="md:hidden flex flex-col py-4 px-6 space-y-2 transition-all">
            <a wire:navigate href="/" class="block text-white py-2">BERANDA</a>

            <!-- Dropdown PROFIL (Mobile) -->
            <div x-data="{ open: false }">
                <button @click="open = !open" class="block text-white w-full text-left py-2">PROFIL ▾</button>
                <ul x-show="open" class="bg-gray-700 text-white rounded mt-1">
                    <li><a wire:navigate href="/visimisi" class="block px-4 py-2">Profil Sekolah</a></li>
                    <li><a wire:navigate href="/guru" class="block px-4 py-2">Profil Guru</a></li>
                    <li><a wire:navigate href="/struktur" class="block px-4 py-2">Profil Siswa</a></li>
                </ul>
            </div>

            <!-- Dropdown GALERI (Mobile) -->
            <div x-data="{ open: false }">
                <button @click="open = !open" class="block text-white w-full text-left py-2">GALERI ▾</button>
                <ul x-show="open" class="bg-gray-700 text-white rounded mt-1">
                    <li><a wire:navigate href="/foto" class="block px-4 py-2">Foto</a></li>
                    <li><a wire:navigate href="/video" class="block px-4 py-2">Video</a></li>
                </ul>
            </div>

            <a wire:navigate href="/pengumuman" class="block text-white py-2">PENGUMUMAN</a>
            <a wire:navigate href="/ppdb" class="block text-white py-2">PPDB 2021/2022</a>
            <a wire:navigate href="/kontak" class="block text-white py-2">KONTAK</a>
            <a wire:navigate href="/pengaduan" class="block text-white py-2">PENGADUAN</a>
            <a wire:navigate href="/tentang" class="block text-white py-2">TENTANG</a>
        </div>
    </div>
</nav>

</body>
</html>
