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
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center clip-diagonal bg-white h-24 pl-4 pr-10 w-full md:w-auto">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-16 object-contain" />
                <div class="ml-4 text-black">
                    <!-- Tambahkan kelas responsif untuk ukuran teks -->
                    <h1 class="text-xl md:text-3xl font-bebas uppercase tracking-wide leading-tight">SDN Padangsari 01
                    </h1>
                    <p class="text-xs md:text-sm italic">Sekolah Unggul Berprestasi</p>
                </div>
            </div>

            <!-- Mobile button -->
            <button @click="mobileOpen = !mobileOpen" class="md:hidden p-4">
                <svg class="w-6 h-6" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-6 px-6 text-white py-4 font-bebas text-lg tracking-wide uppercase">
                <a href="{{ route('home') }}"
                    class="flex items-center gap-2 px-4 py-2 hover:bg-[#FFFBDA] hover:text-black rounded-xl transition duration-300 transform hover:scale-105">
                    <i class="fas fa-home"></i> Beranda
                </a>

                <!-- Profil Dropdown -->
                <div class="relative" @mouseenter="clearTimeout(profilTimeout); profilOpen = true"
                    @mouseleave="profilTimeout = setTimeout(() => profilOpen = false, 300)">
                    <button
                        class="flex items-center gap-2 px-3 py-2 hover:bg-[#FFFBDA] hover:text-black rounded-xl transition">
                        <i class="fas fa-user-circle"></i> Profil
                        <svg class="ml-1 h-4 w-4 transition-transform duration-300 ease-in-out"
                            :class="{ 'rotate-180': profilOpen }" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <ul x-show="profilOpen" x-transition x-cloak
                        class="absolute bg-[#FFFBDA] text-black mt-2 rounded-xl shadow-lg w-52 z-10 font-normal capitalize text-sm">
                        <li><a href="{{ route('visimisi') }}"
                                class="flex items-center gap-2 px-4 py-2 hover:bg-[#FFEC9E] rounded-xl"><i
                                    class="fas fa-school"></i> Profil Sekolah</a></li>
                        <li><a href="{{ route('guru') }}" class="flex items-center gap-2 px-4 py-2 hover:bg-[#FFEC9E] rounded-xl"><i
                                    class="fas fa-chalkboard-teacher"></i> Profil Guru</a></li>
                        <li><a href="{{ route('siswa') }}" class="flex items-center gap-2 px-4 py-2 hover:bg-[#FFEC9E] rounded-xl"><i
                                    class="fas fa-user-graduate"></i> Profil Siswa</a></li>
                    </ul>
                </div>
                
                <a href="https://sangjuara.semarangkota.go.id/" target="_blank"
                    class="flex items-center gap-2 px-4 py-2 hover:bg-[#FFFBDA] hover:text-black rounded-xl transition duration-300 transform hover:scale-105">
                    <i class="fas fa-trophy"></i> Sang Juara
                </a>
                <a href="{{ route('galeri') }}"
                    class="flex items-center gap-2 px-4 py-2 hover:bg-[#FFFBDA] hover:text-black rounded-xl transition duration-300 transform hover:scale-105">
                    <i class="fas fa-images"></i> Galeri
                </a>
                <a href="{{ route('pengumuman') }}"
                    class="flex items-center gap-2 px-4 py-2 hover:bg-[#FFFBDA] hover:text-black rounded-xl transition duration-300 transform hover:scale-105">
                    <i class="fas fa-bullhorn"></i> Pengumuman
                </a>
                <a href="{{ route('ppdb') }}"
                    class="flex items-center gap-2 px-4 py-2 hover:bg-[#FFFBDA] hover:text-black rounded-xl transition duration-300 transform hover:scale-105">
                    <i class="fas fa-user-plus"></i> PPDB
                </a>
                <a href="{{ route('pengaduan') }}"
                    class="flex items-center gap-2 px-4 py-2 hover:bg-[#FFFBDA] hover:text-black rounded-xl transition duration-300 transform hover:scale-105">
                    <i class="fas fa-comment-dots"></i> Pengaduan
                </a>
                <a href="{{ route('kontak') }}"
                    class="flex items-center gap-2 px-4 py-2 hover:bg-[#FFFBDA] hover:text-black rounded-xl transition duration-300 transform hover:scale-105">
                    <i class="fas fa-envelope"></i> Kontak
                </a>
                <a href="{{ route('admin.login') }}" 
                    class="flex items-center gap-2 px-4 py-2 bg-yellow-500 hover:bg-yellow-400 text-black rounded-xl transition duration-300 transform hover:scale-105 font-semibold">
                    <i class="fas fa-sign-in-alt"></i> Login Admin
                </a>

            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileOpen" x-transition x-cloak
            class="md:hidden px-4 pb-6 space-y-2 font-bebas uppercase tracking-wide text-base bg-[#BF3131] rounded-b-xl">
            <a href="{{ route('home') }}"
                class="flex items-center gap-2 py-2 px-4 rounded-xl hover:bg-[#FFFBDA] hover:text-black transition">
                <i class="fas fa-home"></i> Beranda
            </a>

            <!-- Dropdown Profil Mobile -->
            <div>
                <button @click="profilOpen = !profilOpen"
                    class="w-full flex items-center justify-between py-2 px-4 rounded-xl hover:bg-[#FFFBDA] hover:text-black transition">
                    <span class="flex items-center gap-2"><i class="fas fa-user-circle"></i> Profil</span>
                    <svg class="h-4 w-4 transform transition-transform duration-300 ease-in-out"
                        :class="{ 'rotate-180': profilOpen }" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="profilOpen" x-transition x-cloak class="pl-6 font-normal capitalize space-y-1 text-sm">
                    <a href="{{ route('visimisi') }}"
                        class="flex items-center gap-2 py-1 px-3 rounded hover:bg-[#FFFBDA] hover:text-black transition"><i
                            class="fas fa-school"></i> Profil Sekolah</a>
                    <a href="{{ route('guru') }}"
                        class="flex items-center gap-2 py-1 px-3 rounded hover:bg-[#FFFBDA] hover:text-black transition"><i
                            class="fas fa-chalkboard-teacher"></i> Profil Guru</a>
                    <a href="{{ route('siswa') }}"
                        class="flex items-center gap-2 py-1 px-3 rounded hover:bg-[#FFFBDA] hover:text-black transition"><i
                            class="fas fa-user-graduate"></i> Profil Siswa</a>
                </div>
            </div>

            <a href="https://sangjuara.semarangkota.go.id/" target="_blank"
                class="flex items-center gap-2 py-2 px-4 rounded-xl hover:bg-[#FFFBDA] hover:text-black transition"><i
                    class="fas fa-trophy"></i> Sang Juara</a>
            <a href="{{ route('galeri') }}"
                class="flex items-center gap-2 py-2 px-4 rounded-xl hover:bg-[#FFFBDA] hover:text-black transition"><i
                    class="fas fa-images"></i> Galeri</a>
            <a href="{{ route('pengumuman') }}"
                class="flex items-center gap-2 py-2 px-4 rounded-xl hover:bg-[#FFFBDA] hover:text-black transition"><i
                    class="fas fa-bullhorn"></i> Pengumuman</a>
            <a href="{{ route('ppdb') }}"
                class="flex items-center gap-2 py-2 px-4 rounded-xl hover:bg-[#FFFBDA] hover:text-black transition"><i
                    class="fas fa-user-plus"></i> PPDB</a>
            <a href="{{ route('pengaduan') }}"
                class="flex items-center gap-2 py-2 px-4 rounded-xl hover:bg-[#FFFBDA] hover:text-black transition"><i
                    class="fas fa-comment-dots"></i> Pengaduan</a>
            <a href="{{ route('kontak') }}"
                class="flex items-center gap-2 py-2 px-4 rounded-xl hover:bg-[#FFFBDA] hover:text-black transition"><i
                    class="fas fa-envelope"></i> Kontak</a>
            <a href="{{ route('admin.login') }}"
                class="flex items-center gap-2 py-2 px-4 bg-yellow-500 hover:bg-yellow-400 text-black rounded-xl transition font-semibold"><i
                    class="fas fa-sign-in-alt"></i> Login Admin</a>

        </div>
    </nav>

<!-- Sub-navbar Sosial Media -->
<div class="bg-[#BF3131] mt-[95px] px-4 md:px-6 py-2 mb-8">
    <div class="max-w-screen-xl mx-auto flex items-center space-x-4">
        <a href="https://www.instagram.com/sdnpadangsari01?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="
            target="_blank" aria-label="Instagram"
            class="w-9 h-9 flex items-center justify-center rounded-full bg-white hover:bg-gray-100 transition-all duration-300 ease-in-out transform hover:scale-110 hover:rotate-3 shadow">
            <i class="fab fa-instagram text-[#C13584] text-lg"></i>
        </a>
        <a href="https://www.youtube.com/@sdnegeripadangsari0144" target="_blank" aria-label="YouTube"
            class="w-9 h-9 flex items-center justify-center rounded-full bg-white hover:bg-gray-100 transition-all duration-300 ease-in-out transform hover:scale-110 hover:rotate-3 shadow">
            <i class="fab fa-youtube text-[#FF0000] text-lg"></i>
        </a>
        <a href="https://wa.me/6281234567890" target="_blank" aria-label="WhatsApp"
            class="w-9 h-9 flex items-center justify-center rounded-full bg-white hover:bg-gray-100 transition-all duration-300 ease-in-out transform hover:scale-110 hover:rotate-3 shadow">
            <i class="fab fa-whatsapp text-[#25D366] text-lg"></i>
        </a>
    </div>
</div>
