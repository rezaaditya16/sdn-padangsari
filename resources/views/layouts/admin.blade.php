<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SDN Padangsari 01</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    @livewireStyles
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0" id="sidebar">
        <!-- Logo -->
        <div class="flex items-center justify-center h-16 bg-blue-600">
            <div class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-8 mr-2">
                <span class="text-white font-bold text-lg">SDN Padangsari</span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="mt-8">
            <!-- User Info -->
            <div class="px-4 py-3 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ str_replace('_', ' ', Auth::user()->role) }}</p>
                    </div>
                </div>
            </div>

            <!-- Menu Items -->
            <div class="mt-4">
                @if(in_array(Auth::user()->role, ['admin', 'super_admin']))
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 {{ request()->routeIs('admin.dashboard*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                @endif

                <a href="{{ route('admin.pengaduan.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 {{ request()->routeIs('admin.pengaduan*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-comments mr-3"></i>
                    Kelola Pengaduan
                    @php
                        $pendingCount = \App\Models\Pengaduan::whereIn('status', ['Diajukan', 'Diproses'])->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $pendingCount }}</span>
                    @endif
                </a>

                @if(in_array(Auth::user()->role, ['admin', 'super_admin']))
                <div class="mt-4 border-t pt-4">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wide">MANAJEMEN DATA</p>
                    
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 {{ request()->routeIs('admin.categories*') ? 'bg-blue-50 text-blue-600' : '' }}">
                        <i class="fas fa-tags mr-3"></i>
                        Kategori
                    </a>

                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 {{ request()->routeIs('admin.users*') ? 'bg-blue-50 text-blue-600' : '' }}">
                        <i class="fas fa-users mr-3"></i>
                        Users
                    </a>

                    <a href="{{ route('admin.students.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 {{ request()->routeIs('admin.students*') ? 'bg-blue-50 text-blue-600' : '' }}">
                        <i class="fas fa-user-graduate mr-3"></i>
                        Siswa
                    </a>

                    <a href="{{ route('admin.teachers.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 {{ request()->routeIs('admin.teachers*') ? 'bg-blue-50 text-blue-600' : '' }}">
                        <i class="fas fa-chalkboard-teacher mr-3"></i>
                        Guru
                    </a>

                    <a href="{{ route('admin.classrooms.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 {{ request()->routeIs('admin.classrooms*') ? 'bg-blue-50 text-blue-600' : '' }}">
                        <i class="fas fa-school mr-3"></i>
                        Kelas
                    </a>

                    <a href="{{ route('admin.announcements.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 {{ request()->routeIs('admin.announcements*') ? 'bg-blue-50 text-blue-600' : '' }}">
                        <i class="fas fa-bullhorn mr-3"></i>
                        Pengumuman
                    </a>

                    <a href="{{ route('admin.gallery.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 {{ request()->routeIs('admin.gallery*') ? 'bg-blue-50 text-blue-600' : '' }}">
                        <i class="fas fa-images mr-3"></i>
                        Galeri
                    </a>

                    <a href="{{ route('admin.email-settings') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 {{ request()->routeIs('admin.email-settings*') ? 'bg-blue-50 text-blue-600' : '' }}">
                        <i class="fas fa-envelope-open mr-3"></i>
                        Email Settings
                    </a>
                </div>
                @endif

                <a href="/" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200" target="_blank">
                    <i class="fas fa-globe mr-3"></i>
                    Website
                </a>
            </div>

            <!-- Logout -->
            <div class="absolute bottom-4 w-full px-4">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-200 rounded-lg">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Logout
                    </button>
                </form>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="lg:ml-64">
        <!-- Top Bar -->
        <header class="bg-white shadow-sm">
            <div class="flex items-center justify-between px-6 py-4">
                <!-- Mobile menu button -->
                <button class="lg:hidden text-gray-500 hover:text-gray-700" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Page Title -->
                <h1 class="text-2xl font-semibold text-gray-900">
                    @yield('page-title', 'Dashboard')
                </h1>

                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">{{ now()->format('d M Y') }}</span>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="p-6">
            @yield('content')
        </main>
    </div>

    @livewireScripts

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('.bg-green-500')?.remove();
            }, 5000);
        </script>
    @endif

    @if (session()->has('error'))
        <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg z-50">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('.bg-red-500')?.remove();
            }, 5000);
        </script>
    @endif

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        }
    </script>
</body>
</html>
