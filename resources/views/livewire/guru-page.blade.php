<div>
    <!-- Override margin dari layout untuk Guru -->
    <style>
        .flex-grow { margin-top: 0 !important; }
    </style>

    <!-- Hero Section -->
    <div class="relative h-[400px] bg-cover bg-center -mt-8"
        style="background-image: url('{{ asset('images/sekolah.png') }}'); background-attachment: fixed;">
        <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
            <div class="text-center text-white px-4">
                <h1 class="text-4xl md:text-5xl font-bold mb-2">PROFIL GURU</h1>
                <p class="text-xl md:text-2xl">SDN PADANGSARI 01</p>
            </div>
        </div>
    </div>

    <!-- Konten Daftar Guru -->
    <div class="max-w-6xl mx-auto py-20 px-4">
        <h2 class="text-center text-2xl font-bold text-gray-800 mb-2">Daftar Guru</h2>
        <h3 class="text-center text-lg text-gray-600 mb-8">Tahun Ajaran 2024/2025</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($teachers as $teacher)
                <div class="bg-white rounded-lg shadow-md p-4 text-center transform transition duration-300 hover:scale-105 hover:shadow-xl">
                    <img src="{{ asset('storage/' . $teacher->photo) }}" alt="{{ $teacher->name }}" class="mx-auto h-64 object-cover rounded">
                    <p class="mt-4 font-semibold text-gray-800">{{ $teacher->name }}</p>
                    <p class="text-sm text-gray-600">{{ $teacher->position }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
