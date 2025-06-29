<!-- Navbar Styles -->
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

<!-- Navbar -->
<nav class="bg-[#7D0A0A] text-white fixed top-0 left-0 w-full z-50 shadow-md" x-data="{ mobileOpen: false, profilOpen: false, profilTimeout: null }">
    <!-- Logo Area - Fixed Position -->
    <div class="absolute left-0 top-0 z-10">
        <div class="flex items-center clip-diagonal bg-white h-20 md:h-24 pl-4 pr-12 md:pr-16">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-12 md:h-16 md:w-16 object-contain flex-shrink-0" />
            <div class="ml-3 md:ml-4 text-black">
                <h1 class="text-base md:text-xl lg:text-2xl xl:text-3xl font-bebas uppercase tracking-wide leading-tight whitespace-nowrap">
                    SDN Padangsari 01
                </h1>
                <p class="text-xs md:text-sm italic whitespace-nowrap">Sekolah Unggul Berprestasi</p>
            </div>
        </div>
    </div>

    <!-- Navigation Container -->
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-end h-20 md:h-24 pl-72 md:pl-80 lg:pl-96">
            <!-- Mobile Menu Button -->
            <button @click="mobileOpen = !mobileOpen" class="md:hidden p-4 mr-2 ml-auto">
                <svg class="w-6 h-6" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center">
                <!-- Main Navigation -->
                <div class="flex items-center space-x-2 lg:space-x-4 font-bebas text-sm lg:text-base tracking-wide uppercase mr-4">
                    <a href="{{ route('home') }}"
                        class="flex items-center gap-1 lg:gap-2 px-2 lg:px-3 py-2 hover:bg-[#FFFBDA] hover:text-black rounded-lg transition duration-300">
                        <i class="fas fa-home text-sm"></i>
                        <span class="hidden lg:inline">Beranda</span>
                    </a>

                    <!-- Profil Dropdown -->
                    <div class="relative" @mouseenter="clearTimeout(profilTimeout); profilOpen = true"
                        @mouseleave="profilTimeout = setTimeout(() => profilOpen = false, 300)">
                        <button class="flex items-center gap-1 lg:gap-2 px-2 lg:px-3 py-2 hover:bg-[#FFFBDA] hover:text-black rounded-lg transition">
                            <i class="fas fa-user-circle text-sm"></i>
                            <span class="hidden lg:inline">Profil</span>
                            <svg class="w-3 h-3 lg:w-4 lg:h-4 transition-transform duration-300"
                                :class="{ 'rotate-180': profilOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <ul x-show="profilOpen" x-transition x-cloak
                            class="absolute right-0 bg-white text-black mt-2 rounded-lg shadow-lg w-48 z-20 font-normal text-sm">
                            <li><a href="{{ route('visimisi') }}"
                                    class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 rounded-lg">
                                    <i class="fas fa-school"></i> Profil Sekolah</a></li>
                            <li><a href="{{ route('guru') }}"
                                    class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 rounded-lg">
                                    <i class="fas fa-chalkboard-teacher"></i> Profil Guru</a></li>
                            <li><a href="{{ route('siswa') }}"
                                    class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 rounded-lg">
                                    <i class="fas fa-user-graduate"></i> Profil Siswa</a></li>
                        </ul>
                    </div>

                    <a href="{{ route('galeri') }}"
                        class="flex items-center gap-1 lg:gap-2 px-2 lg:px-3 py-2 hover:bg-[#FFFBDA] hover:text-black rounded-lg transition duration-300">
                        <i class="fas fa-images text-sm"></i>
                        <span class="hidden lg:inline">Galeri</span>
                    </a>

                    <a href="{{ route('pengumuman') }}"
                        class="flex items-center gap-1 lg:gap-2 px-2 lg:px-3 py-2 hover:bg-[#FFFBDA] hover:text-black rounded-lg transition duration-300">
                        <i class="fas fa-bullhorn text-sm"></i>
                        <span class="hidden lg:inline">Berita</span>
                    </a>

                    <a href="{{ route('ppdb') }}"
                        class="flex items-center gap-1 lg:gap-2 px-2 lg:px-3 py-2 hover:bg-[#FFFBDA] hover:text-black rounded-lg transition duration-300">
                        <i class="fas fa-user-plus text-sm"></i>
                        <span class="hidden lg:inline">PPDB</span>
                    </a>

                    <a href="{{ route('pengaduan') }}"
                        class="flex items-center gap-1 lg:gap-2 px-2 lg:px-3 py-2 hover:bg-[#FFFBDA] hover:text-black rounded-lg transition duration-300">
                        <i class="fas fa-comment-dots text-sm"></i>
                        <span class="hidden lg:inline">Pengaduan</span>
                    </a>

                    <a href="{{ route('kontak') }}"
                        class="flex items-center gap-1 lg:gap-2 px-2 lg:px-3 py-2 hover:bg-[#FFFBDA] hover:text-black rounded-lg transition duration-300">
                        <i class="fas fa-envelope text-sm"></i>
                        <span class="hidden lg:inline">Kontak</span>
                    </a>
                </div>

                <!-- Login Buttons -->
                <div class="flex items-center space-x-2 px-4">
                    <a href="{{ route('login') }}"
                        class="flex items-center gap-1 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-300 text-xs lg:text-sm font-semibold">
                        <i class="fas fa-user-check text-sm"></i>
                        <span>Login</span>
                    </a>

                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileOpen" x-transition x-cloak
            class="md:hidden bg-[#BF3131] rounded-b-xl shadow-lg">
            <div class="px-4 py-4 space-y-2 font-bebas uppercase tracking-wide ml-4">
                <a href="{{ route('home') }}"
                    class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-[#FFFBDA] hover:text-black transition">
                    <i class="fas fa-home w-5"></i> Beranda
                </a>

                <!-- Mobile Profil Dropdown -->
                <div>
                    <button @click="profilOpen = !profilOpen"
                        class="w-full flex items-center justify-between py-3 px-4 rounded-lg hover:bg-[#FFFBDA] hover:text-black transition">
                        <span class="flex items-center gap-3">
                            <i class="fas fa-user-circle w-5"></i> Profil
                        </span>
                        <svg class="w-4 h-4 transition-transform duration-300"
                            :class="{ 'rotate-180': profilOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="profilOpen" x-transition x-cloak class="pl-8 space-y-1 mt-2">
                        <a href="{{ route('visimisi') }}"
                            class="flex items-center gap-3 py-2 px-4 rounded-lg hover:bg-[#FFFBDA] hover:text-black transition text-sm font-normal">
                            <i class="fas fa-school w-4"></i> Profil Sekolah
                        </a>
                        <a href="{{ route('guru') }}"
                            class="flex items-center gap-3 py-2 px-4 rounded-lg hover:bg-[#FFFBDA] hover:text-black transition text-sm font-normal">
                            <i class="fas fa-chalkboard-teacher w-4"></i> Profil Guru
                        </a>
                        <a href="{{ route('siswa') }}"
                            class="flex items-center gap-3 py-2 px-4 rounded-lg hover:bg-[#FFFBDA] hover:text-black transition text-sm font-normal">
                            <i class="fas fa-user-graduate w-4"></i> Profil Siswa
                        </a>
                    </div>
                </div>

                <a href="{{ route('galeri') }}"
                    class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-[#FFFBDA] hover:text-black transition">
                    <i class="fas fa-images w-5"></i> Galeri
                </a>
                <a href="{{ route('pengumuman') }}"
                    class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-[#FFFBDA] hover:text-black transition">
                    <i class="fas fa-bullhorn w-5"></i> Pengumuman
                </a>
                <a href="{{ route('ppdb') }}"
                    class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-[#FFFBDA] hover:text-black transition">
                    <i class="fas fa-user-plus w-5"></i> PPDB
                </a>
                <a href="{{ route('pengaduan') }}"
                    class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-[#FFFBDA] hover:text-black transition">
                    <i class="fas fa-comment-dots w-5"></i> Pengaduan
                </a>
                <a href="{{ route('kontak') }}"
                    class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-[#FFFBDA] hover:text-black transition">
                    <i class="fas fa-envelope w-5"></i> Kontak
                </a>

                <!-- Mobile Login Buttons -->
                <div class="pt-4 border-t border-white/20 space-y-2">
                    <a href="{{ route('login') }}"
                        class="flex items-center gap-3 py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition font-semibold">
                        <i class="fas fa-user-check w-5"></i> Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Sub-navbar Sosial Media -->
<div class="bg-[#BF3131] fixed top-20 md:top-24 left-0 w-full z-40 px-4 md:px-6 py-2">
    <div class="max-w-7xl mx-auto flex items-center justify-center md:justify-start space-x-4">
        <a href="https://www.instagram.com/sdnpadangsari01" target="_blank" aria-label="Instagram"
            class="w-10 h-10 flex items-center justify-center rounded-full bg-white hover:bg-gray-100 transition-all duration-300 ease-in-out transform hover:scale-110 shadow-md">
            <i class="fab fa-instagram text-[#C13584] text-lg"></i>
        </a>
        <a href="https://www.youtube.com/@sdnegeripadangsari0144" target="_blank" aria-label="YouTube"
            class="w-10 h-10 flex items-center justify-center rounded-full bg-white hover:bg-gray-100 transition-all duration-300 ease-in-out transform hover:scale-110 shadow-md">
            <i class="fab fa-youtube text-[#FF0000] text-lg"></i>
        </a>
        <a href="https://wa.me/6281234567890" target="_blank" aria-label="WhatsApp"
            class="w-10 h-10 flex items-center justify-center rounded-full bg-white hover:bg-gray-100 transition-all duration-300 ease-in-out transform hover:scale-110 shadow-md">
            <i class="fab fa-whatsapp text-[#25D366] text-lg"></i>
        </a>
        <span class="text-white text-sm ml-4 hidden md:inline">Ikuti Media Sosial Kami</span>
    </div>
</div>
