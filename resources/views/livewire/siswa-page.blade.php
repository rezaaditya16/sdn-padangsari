<div>
    <div class="relative h-[400px] bg-cover bg-center mt-3" style="background-image: url('{{ asset('images/sekolah.png') }}'); background-attachment: fixed;">
        <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
            <div class="text-center text-white px-4">
                <h1 class="text-4xl md:text-5xl font-bold mb-2">DAFTAR SISWA</h1>
                <p class="text-xl md:text-2xl">SDN PADANGSARI 01</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto mt-8">
        <h1 class="text-4xl font-bold mb-6">Students</h1>

        <!-- Filter Kelas -->
        <div class="mb-4 flex flex-wrap items-center gap-4">
            <label for="kelasFilter" class="text-lg">Filter kelas:</label>
            <select id="kelasFilter" wire:model="kelasFilter" class="bg-gray-800 text-white border border-gray-600 rounded px-4 py-2">
                <option value="all">Semua Kelas</option>
                <option value="Kelas 1">Kelas 1</option>
                <option value="Kelas 2">Kelas 2</option>
                <option value="Kelas 3">Kelas 3</option>
                <option value="Kelas 4">Kelas 4</option>
                <option value="Kelas 5">Kelas 5</option>
                <option value="Kelas 6">Kelas 6</option>
            </select>
        </div>

        <!-- Tabel -->
        <div class="overflow-x-auto rounded-lg shadow-lg">
            <table class="min-w-full bg-gray-800 text-white">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left">Nama Siswa</th>
                        <th class="px-6 py-3 text-left">Kelas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr class="border-b border-gray-600">
                            <td class="px-6 py-4">{{ $student->name }}</td>
                            <td class="px-6 py-4">{{ $student->class }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>