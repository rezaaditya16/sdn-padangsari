<div>
    <!-- Hero Section -->
    <div class="relative h-[400px] bg-cover bg-center mt-3" style="background-image: url('{{ asset('images/sekolah.png') }}'); background-attachment: fixed;">
        <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
            <div class="text-center text-white px-4">
                <h1 class="text-4xl md:text-5xl font-bold mb-2">PROFIL SEKOLAH</h1>
                <p class="text-xl md:text-2xl">SDN PADANGSARI 01</p>
            </div>
        </div>
    </div>

    <!-- Form Pengaduan -->
    <div class="max-w-3xl mx-auto pt-24 px-6 pb-20">
        <div class="bg-white shadow-2xl border border-red-800 rounded-3xl p-10">
            <h2 class="text-3xl font-bold text-red-700 mb-8 flex items-center gap-3">
                <svg class="w-7 h-7 text-red-700" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 18.5a6.5 6.5 0 100-13 6.5 6.5 0 000 13z" />
                </svg>
                Form Pengaduan
            </h2>

            <!-- Flash Message -->
            @if (session()->has('message'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg shadow-md">
                    {{ session('message') }}
                </div>
            @endif

            <form action="mailto:aufa.fadholi@gmail.com" method="post" enctype="text/plain" class="space-y-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Nama Depan -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Nama Depan</label>
                        <div class="relative">
                            <input type="text" name="first_name" class="w-full border border-gray-300 rounded-xl py-3 pl-12 pr-4 shadow-sm focus:ring-2 focus:ring-yellow-400 focus:outline-none transition" placeholder="Masukkan nama depan">
                            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-yellow-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A9 9 0 1112 21"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Nama Belakang -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Nama Belakang</label>
                        <div class="relative">
                            <input type="text" name="last_name" class="w-full border border-gray-300 rounded-xl py-3 pl-12 pr-4 shadow-sm focus:ring-2 focus:ring-yellow-400 focus:outline-none transition" placeholder="Masukkan nama belakang">
                            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-yellow-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A9 9 0 1112 21"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Alamat Email</label>
                    <div class="relative">
                        <input type="email" name="email" class="w-full border border-gray-300 rounded-xl py-3 pl-12 pr-4 shadow-sm focus:ring-2 focus:ring-yellow-400 focus:outline-none transition" placeholder="Masukkan email aktif">
                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-yellow-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 12l-4 4m0 0l-4-4m4 4V8"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pesan -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Pesan</label>
                    <textarea name="message" rows="6" class="w-full border border-gray-300 rounded-xl py-3 px-4 shadow-sm focus:ring-2 focus:ring-yellow-400 focus:outline-none transition" placeholder="Tulis pesan atau keluhan Anda di sini..."></textarea>
                </div>

                <!-- Tombol Submit -->
                <div class="text-right">
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 transition text-white font-bold px-6 py-3 rounded-xl shadow-md inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Kirim Pesan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
