<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<!-- NAVBAR -->
<nav class="bg-gray-800 text-white shadow-lg w-full fixed top-0 left-0 z-50" x-data="{ open: false, dropdowns: { profil: false, galeri: false } }">
    <div class="container mx-auto px-6">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            <a wire:navigate href="/" class="text-lg font-semibold flex items-center">
                <img src="/images/logo.png" alt="Logo" class="h-22 w-28 mr-2">
                SDN 01 Padangsari
            </a>

            <!-- Burger Menu (Mobile) -->
            <button @click="open = !open" class="md:hidden text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>

            <!-- MENU DESKTOP -->
            <ul class="hidden md:flex space-x-6 items-center">
                <li><a wire:navigate href="/" class="hover:bg-blue-300 hover:text-gray-900 px-4 py-2 rounded-md">BERANDA</a></li>

                <!-- Dropdown Profil -->
                <li class="relative group">
                    <button @click="dropdowns.profil = !dropdowns.profil" class="inline-flex items-center hover:bg-blue-300 hover:text-gray-900 px-4 py-2 rounded-md">
                        PROFIL ▾
                    </button>
                    <ul x-show="dropdowns.profil" @click.away="dropdowns.profil = false" class="absolute bg-gray-700 text-white mt-2 rounded shadow-lg w-40 hidden md:block">
                        <li><a wire:navigate href="/visimisi" class="block px-4 py-2 hover:bg-gray-600">Profil Sekolah</a></li>
                        <li><a wire:navigate href="/struktur" class="block px-4 py-2 hover:bg-gray-600">Profil Guru</a></li>
                        <li><a wire:navigate href="/struktur" class="block px-4 py-2 hover:bg-gray-600">Profil Siswa</a></li>
                    </ul>
                </li>

                <!-- Dropdown Galeri -->
                <li class="relative group">
                    <button @click="dropdowns.galeri = !dropdowns.galeri" class="inline-flex items-center hover:bg-blue-300 hover:text-gray-900 px-4 py-2 rounded-md">
                        GALERI ▾
                    </button>
                    <ul x-show="dropdowns.galeri" @click.away="dropdowns.galeri = false" class="absolute bg-gray-700 text-white mt-2 rounded shadow-lg w-40 hidden md:block">
                        <li><a wire:navigate href="/foto" class="block px-4 py-2 hover:bg-gray-600">Foto</a></li>
                        <li><a wire:navigate href="/video" class="block px-4 py-2 hover:bg-gray-600">Video</a></li>
                    </ul>
                </li>

                <li><a wire:navigate href="/pengumuman" class="hover:bg-blue-300 hover:text-gray-900 px-4 py-2 rounded-md">PENGUMUMAN</a></li>
                <li><a wire:navigate href="/ppdb" class="hover:bg-blue-300 hover:text-gray-900 px-4 py-2 rounded-md">PPDB 2021/2022</a></li>
                <li><a wire:navigate href="/kontak" class="hover:bg-blue-300 hover:text-gray-900 px-4 py-2 rounded-md">KONTAK</a></li>
                <li><a wire:navigate href="/pengaduan" class="hover:bg-blue-300 hover:text-gray-900 px-4 py-2 rounded-md">PENGADUAN</a></li>
                <li><a wire:navigate href="/tentang" class="hover:bg-blue-300 hover:text-gray-900 px-4 py-2 rounded-md">TENTANG</a></li>
            </ul>
        </div>

        <!-- MENU MOBILE -->
        <ul x-show="open" class="md:hidden flex flex-col py-4 px-6 space-y-2 transition-all">
            <li><a wire:navigate href="/" class="block text-white py-2">BERANDA</a></li>

            <!-- Dropdown Profil (Mobile) -->
            <li>
                <button @click="dropdowns.profil = !dropdowns.profil" class="block text-white w-full text-left py-2">PROFIL ▾</button>
                <ul x-show="dropdowns.profil" class="bg-gray-700 text-white rounded mt-1">
                    <li><a wire:navigate href="/visimisi" class="block px-4 py-2">Profil Sekolah</a></li>
                    <li><a wire:navigate href="/struktur" class="block px-4 py-2">Profil Guru</a></li>
                    <li><a wire:navigate href="/struktur" class="block px-4 py-2">Profil Siswa</a></li>
                </ul>
            </li>

            <!-- Dropdown Galeri (Mobile) -->
            <li>
                <button @click="dropdowns.galeri = !dropdowns.galeri" class="block text-white w-full text-left py-2">GALERI ▾</button>
                <ul x-show="dropdowns.galeri" class="bg-gray-700 text-white rounded mt-1">
                    <li><a wire:navigate href="/foto" class="block px-4 py-2">Foto</a></li>
                    <li><a wire:navigate href="/video" class="block px-4 py-2">Video</a></li>
                </ul>
            </li>

            <li><a wire:navigate href="/pengumuman" class="block text-white py-2">PENGUMUMAN</a></li>
            <li><a wire:navigate href="/ppdb" class="block text-white py-2">PPDB 2021/2022</a></li>
            <li><a wire:navigate href="/kontak" class="block text-white py-2">KONTAK</a></li>
            <li><a wire:navigate href="/pengaduan" class="block text-white py-2">PENGADUAN</a></li>
            <li><a wire:navigate href="/tentang" class="block text-white py-2">TENTANG</a></li>
        </ul>
    </div>
</nav>

</body>
</html>
