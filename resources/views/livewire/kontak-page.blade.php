<!-- Tambahkan di bagian <head> -->
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://kit.fontawesome.com/your-font-awesome-kit.js" crossorigin="anonymous"></script>

<!-- Konten Utama -->
<div class="max-w-screen overflow-x-hidden">
    <!-- Hero Section -->
    <div class="relative h-[400px] bg-cover bg-center" style="background-image: url('{{ asset('images/sekolah.png') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
            <div class="text-center text-white px-4">
                <h1 class="text-4xl md:text-5xl font-bold mb-2">PROFIL SEKOLAH</h1>
                <p class="text-xl md:text-2xl">SDN PEDURUNGAN KIDUL 04</p>
            </div>
        </div>
    </div>

    <!-- Kotak Informasi -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Alamat -->
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <i class="fas fa-map-marker-alt text-blue-600 text-4xl mb-3"></i>
            <h5 class="text-lg font-semibold">Alamat</h5>
            <p class="text-gray-600">
                SDN 01 Padangsari<br>
                Jl. Raya Padangsari No. 01<br>
                Kec. Padangsari, Kab. Pamekasan<br>
                Madura, Jawa Timur
            </p>
        </div>

        <!-- Customer Service -->
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <i class="fas fa-headset text-blue-600 text-4xl mb-3"></i>
            <h5 class="text-lg font-semibold">Customer Service</h5>
            <p class="text-gray-600">
                Phone: (0324) 322-001<br>
                Email: info@sdnpadangsari.sch.id
            </p>
        </div>

        <!-- Jam Kerja -->
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <i class="fas fa-clock text-blue-600 text-4xl mb-3"></i>
            <h5 class="text-lg font-semibold">Jam Kerja</h5>
            <p class="text-gray-600">
                Senin - Jumat: 07.00 - 15.00<br>
                Sabtu - Minggu: Libur
            </p>
        </div>
    </div>

    <!-- Google Maps -->
    <div class="flex justify-center pt-10 px-3">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.3808993585653!2d110.42869157422747!3d-7.072872469054119!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708eb4122155c1%3A0x99967eaf4d77dfd6!2sSD%20Padangsari%2001!5e0!3m2!1sen!2sid!4v1712659355279!5m2!1sen!2sid" 
            width="100%" 
            height="450" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade"
            class="w-full h-[450px] rounded-xl shadow-lg">
        </iframe>
    </div>
</div>
