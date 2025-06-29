<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - SDN Padangsari 01</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-[#7D0A0A] text-white p-4 shadow-lg">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-10 mr-3">
                <div>
                    <h1 class="text-xl font-bold">Dashboard Guru</h1>
                    <p class="text-sm text-gray-300">SDN Padangsari 01</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm">
                    <i class="fas fa-user mr-2"></i>{{ Auth::guard('teacher')->user()->name }}
                </span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-sm">
                        <i class="fas fa-sign-out-alt mr-1"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 px-4">
        <!-- Welcome Card -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">
                Selamat Datang, {{ $teacher->name }}!
            </h2>
            <p class="text-gray-600">
                <i class="fas fa-chalkboard-teacher mr-2"></i>{{ $teacher->position }}
            </p>
            @if($teacher->classroom)
                <p class="text-gray-600">
                    <i class="fas fa-door-open mr-2"></i>{{ $teacher->classroom->name }}
                </p>
            @endif
        </div>

        <!-- Dashboard Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Card 1: Profil -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center">
                    <div class="bg-blue-500 text-white p-3 rounded-full">
                        <i class="fas fa-user-edit text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-800">Profil Saya</h3>
                        <p class="text-gray-600 text-sm">Kelola profil</p>
                    </div>
                </div>
            </div>

            <!-- Card 2: Siswa -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center">
                    <div class="bg-green-500 text-white p-3 rounded-full">
                        <i class="fas fa-user-graduate text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-800">Data Siswa</h3>
                        <p class="text-gray-600 text-sm">Lihat data siswa</p>
                    </div>
                </div>
            </div>

            <!-- Card 3: Materi -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center">
                    <div class="bg-yellow-500 text-white p-3 rounded-full">
                        <i class="fas fa-book text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-800">Materi</h3>
                        <p class="text-gray-600 text-sm">Kelola materi</p>
                    </div>
                </div>
            </div>

            <!-- Card 4: Tugas -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center">
                    <div class="bg-red-500 text-white p-3 rounded-full">
                        <i class="fas fa-tasks text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-800">Tugas</h3>
                        <p class="text-gray-600 text-sm">Kelola tugas</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Info -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Akun</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-600">Nama Lengkap</label>
                    <p class="text-gray-800">{{ $teacher->name }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Email</label>
                    <p class="text-gray-800">{{ $teacher->email }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Jabatan</label>
                    <p class="text-gray-800">{{ $teacher->position }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Kelas</label>
                    <p class="text-gray-800">
                        {{ $teacher->classroom ? $teacher->classroom->name : 'Tidak ada kelas' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
