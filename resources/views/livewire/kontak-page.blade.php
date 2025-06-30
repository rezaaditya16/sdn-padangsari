<!-- Konten Utama -->
<div class="max-w-screen overflow-x-hidden">
    <!-- Override margin dari layout untuk Kontak -->
    <style>
        .flex-grow { margin-top: 0 !important; }
    </style>

    <!-- Hero Section -->
    <div class="relative h-[400px] bg-cover bg-center -mt-8" style="background-image: url('{{ asset('images/sekolah.png') }}'); background-attachment: fixed;">
        <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
            <div class="text-center text-white px-4">
                <h1 class="text-4xl md:text-5xl font-bold mb-2">PROFIL SEKOLAH</h1>
                <p class="text-xl md:text-2xl">SDN PADANGSARI 01</p>
            </div>
        </div>
    </div>

    <!-- Informasi Sekolah -->
    <div class="max-w-screen-xl mx-auto px-4 md:px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Alamat -->
            <div class="bg-white shadow-md rounded-xl p-6 text-center">
                <!-- Ubah warna ikon menjadi merah -->
                <i class="fas fa-map-marker-alt text-red-600 text-4xl mb-3"></i>
                <h5 class="text-lg font-semibold mb-2">Alamat</h5>
                <p class="text-gray-600 leading-relaxed">
                    SDN 01 Padangsari<br>
                    Jl. Raya Padangsari No. 01<br>
                    Kec. Padangsari, Kab. Pamekasan<br>
                    Madura, Jawa Timur
                </p>
            </div>

            <!-- Customer Service -->
            <div class="bg-white shadow-md rounded-xl p-6 text-center">
                <!-- Ubah warna ikon menjadi hijau -->
                <i class="fas fa-headset text-green-600 text-4xl mb-3"></i>
                <h5 class="text-lg font-semibold mb-2">Customer Service</h5>
                <p class="text-gray-600 leading-relaxed">
                    Phone: (0324) 322-001<br>
                    Email: info@sdnpadangsari.sch.id
                </p>
            </div>

            <!-- Jam Kerja -->
            <div class="bg-white shadow-md rounded-xl p-6 text-center">
                <!-- Ubah warna ikon menjadi kuning -->
                <i class="fas fa-clock text-yellow-600 text-4xl mb-3"></i>
                <h5 class="text-lg font-semibold mb-2">Jam Kerja</h5>
                <p class="text-gray-600 leading-relaxed">
                    Senin - Jumat: 07.00 - 15.00<br>
                    Sabtu - Minggu: Libur
                </p>
            </div>
        </div>
    </div>

    <!-- Google Maps -->
    <div class="max-w-screen-xl mx-auto px-4 md:px-6 pb-12">
        <div class="rounded-xl overflow-hidden shadow-lg">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.3808993585653!2d110.42869157422747!3d-7.072872469054119!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708eb4122155c1%3A0x99967eaf4d77dfd6!2sSD%20Padangsari%2001!5e0!3m2!1sen!2sid!4v1712659355279!5m2!1sen!2sid"
                width="100%"
                height="450"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                class="w-full h-[450px]">
            </iframe>
        </div>
    </div>
</div>
