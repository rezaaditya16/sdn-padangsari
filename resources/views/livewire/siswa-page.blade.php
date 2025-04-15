<div>
    <!-- Hero Section -->
    <div class="relative h-[400px] bg-cover bg-center mt-3" style="background-image: url('{{ asset('images/sekolah.png') }}'); background-attachment: fixed;">
        <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
            <div class="text-center text-white px-4">
                <h1 class="text-4xl md:text-5xl font-bold mb-2">DAFTAR SISWA</h1>
                <p class="text-xl md:text-2xl">SDN PADANGSARI 01</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto mt-8 px-4">
        <h1 class="text-4xl font-bold text-gray-800 mb-6">Daftar Siswa</h1>

        <!-- Filter Kelas -->
        <div class="mb-6 flex items-center gap-4">
            <label for="kelasFilter" class="text-lg font-medium text-black">Filter Kelas:</label>

            <!-- Custom Dropdown with Alpine.js -->
            <div x-data="{ open: false, selected: 'Semua Kelas' }" class="relative w-48">
                <button @click="open = !open" class="bg-[#7D0A0A] text-white border rounded px-4 py-2 w-full text-left flex justify-between items-center">
                    <span x-text="selected" class="mr-2"></span>
                    <!-- Dropdown Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform transition-transform duration-300" :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" @click.away="open = false" class="absolute mt-2 w-full bg-white border rounded shadow-lg z-10">
                    <ul class="text-black">
                        <li @click="selected = 'Semua Kelas'; open = false" class="px-4 py-2 hover:bg-[#FFFBDA] cursor-pointer">Semua Kelas</li>
                        <li @click="selected = 'Kelas 1'; open = false" class="px-4 py-2 hover:bg-[#FFFBDA] cursor-pointer">Kelas 1</li>
                        <li @click="selected = 'Kelas 2'; open = false" class="px-4 py-2 hover:bg-[#FFFBDA] cursor-pointer">Kelas 2</li>
                        <li @click="selected = 'Kelas 3'; open = false" class="px-4 py-2 hover:bg-[#FFFBDA] cursor-pointer">Kelas 3</li>
                        <li @click="selected = 'Kelas 4'; open = false" class="px-4 py-2 hover:bg-[#FFFBDA] cursor-pointer">Kelas 4</li>
                        <li @click="selected = 'Kelas 5'; open = false" class="px-4 py-2 hover:bg-[#FFFBDA] cursor-pointer">Kelas 5</li>
                        <li @click="selected = 'Kelas 6'; open = false" class="px-4 py-2 hover:bg-[#FFFBDA] cursor-pointer">Kelas 6</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tabel -->
        <div class="overflow-x-auto rounded-lg shadow-xl bg-white">
            <table class="min-w-full table-auto text-black">
                <thead class="bg-[#BF3131] text-black">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium">Nama Siswa</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Kelas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300">
                    @foreach ($students as $student)
                        <tr class="transition duration-300 ease-in-out hover:bg-[#FFFBDA]">
                            <td class="px-6 py-4 text-sm font-medium">{{ $student->name }}</td>
                            <td class="px-6 py-4 text-sm font-medium">{{ $student->class }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
