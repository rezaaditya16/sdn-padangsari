<div>
    <!-- Hero Section -->
    <div class="relative h-[300px] md:h-[400px] bg-cover bg-center"
        style="background-image: url('{{ asset('images/sekolah.png') }}'); background-attachment: fixed;">
        <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
            <div class="text-center text-white px-4">
                <h1 class="text-3xl md:text-5xl font-bold mb-2">DAFTAR SISWA</h1>
                <p class="text-lg md:text-2xl">SDN PADANGSARI 01</p>
            </div>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="max-w-7xl mx-auto mt-8 px-4">
        <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-6">Daftar Siswa</h1>

        <!-- Filter Kelas -->
        <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4">
            <label for="kelasFilter" class="text-base md:text-lg font-medium text-black">Filter Kelas:</label>
            <select wire:model.live="selectedClass" id="kelasFilter"
                class="bg-[#7D0A0A] text-white border rounded px-4 py-2 w-full sm:w-48">
                <option value="">Semua Kelas</option>
                @foreach($classes as $class)
                    <option value="{{ $class }}">{{ $class }}</option>
                @endforeach
            </select>
        </div>

        <!-- Tabel Responsif -->
        {{-- <div class="overflow-x-auto rounded-lg shadow-xl bg-white">
            <table class="min-w-full text-sm md:text-base table-auto text-black">
                <thead class="bg-[#BF3131] text-white">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 text-left font-medium">Nama Siswa</th>
                        <th class="px-4 sm:px-6 py-3 text-left font-medium">Kelas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300">
                    @forelse ($students as $student)
                        <tr class="transition duration-300 ease-in-out hover:bg-[#FFFBDA]">
                            <td class="px-4 sm:px-6 py-4 font-medium">{{ $student->name }}</td>
                            <td class="px-4 sm:px-6 py-4 font-medium">{{ $student->classroom->name ?? 'Kelas tidak tersedia' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center py-4 text-gray-500">Tidak ada siswa ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div> --}}

        <!-- Grid Responsif -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-8">
            @forelse ($students as $student)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <!-- Foto -->
                    @if ($student->photo)
                        <img src="{{ asset('storage/' . $student->photo) }}" alt="{{ $student->name }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                            <span>Foto Tidak Tersedia</span>
                        </div>
                    @endif

                    <!-- Informasi Siswa -->
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $student->name }}</h3>
                        <p class="text-gray-600">Kelas: {{ $student->classroom->name ?? 'Kelas tidak tersedia' }}</p>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500">
                    Tidak ada siswa ditemukan.
                </div>
            @endforelse
        </div>
    </div>
</div>
