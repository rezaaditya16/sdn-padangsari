<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin Dashboard' }} - SDN Padangsari 01</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <!-- Chart.js for statistics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        .sidebar-item:hover {
            background-color: #1e40af;
            transform: translateX(4px);
            transition: all 0.3s ease;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: transform 0.2s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-blue-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-10 mr-3">
                    <div>
                        <h1 class="text-white text-xl font-bold">SDN Padangsari 01</h1>
                        <p class="text-blue-200 text-sm">{{ $pageTitle ?? 'Dashboard Admin' }}</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="text-white">
                        <i class="fas fa-user-circle mr-2"></i>
                        {{ Auth::user()->name }}
                        <span class="text-blue-200 text-sm">({{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }})</span>
                    </div>
                    
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-blue-800 shadow-lg">
            <div class="p-4">
                <h3 class="text-white text-lg font-semibold mb-4">Menu Navigasi</h3>
                
                <nav class="space-y-2">
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.super-admin') }}" 
                           class="sidebar-item flex items-center px-4 py-3 text-white rounded-lg {{ request()->routeIs('admin.super-admin') ? 'bg-blue-700' : '' }}">
                            <i class="fas fa-crown mr-3"></i>
                            Super Admin Dashboard
                        </a>
                    @endif
                    
                    @if(Auth::user()->role === 'kepala_sekolah')
                        <a href="{{ route('admin.kepala-sekolah') }}" 
                           class="sidebar-item flex items-center px-4 py-3 text-white rounded-lg {{ request()->routeIs('admin.kepala-sekolah') ? 'bg-blue-700' : '' }}">
                            <i class="fas fa-school mr-3"></i>
                            Dashboard Kepala Sekolah
                        </a>
                    @endif
                    
                    @if(Auth::user()->role === 'guru_bk')
                        <a href="{{ route('admin.guru-bk') }}" 
                           class="sidebar-item flex items-center px-4 py-3 text-white rounded-lg {{ request()->routeIs('admin.guru-bk') ? 'bg-blue-700' : '' }}">
                            <i class="fas fa-user-friends mr-3"></i>
                            Dashboard Guru BK
                        </a>
                    @endif
                    
                    @if(Auth::user()->role === 'wali_kelas')
                        <a href="{{ route('admin.wali-kelas') }}" 
                           class="sidebar-item flex items-center px-4 py-3 text-white rounded-lg {{ request()->routeIs('admin.wali-kelas') ? 'bg-blue-700' : '' }}">
                            <i class="fas fa-chalkboard-teacher mr-3"></i>
                            Dashboard Wali Kelas
                        </a>
                    @endif
                    
                    @if(Auth::user()->role === 'guru_mapel')
                        <a href="{{ route('admin.guru-mapel') }}" 
                           class="sidebar-item flex items-center px-4 py-3 text-white rounded-lg {{ request()->routeIs('admin.guru-mapel') ? 'bg-blue-700' : '' }}">
                            <i class="fas fa-book mr-3"></i>
                            Dashboard Guru Mapel
                        </a>
                    @endif
                    
                    @if(Auth::user()->role === 'tenaga_pendidik')
                        <a href="{{ route('admin.tenaga-pendidik') }}" 
                           class="sidebar-item flex items-center px-4 py-3 text-white rounded-lg {{ request()->routeIs('admin.tenaga-pendidik') ? 'bg-blue-700' : '' }}">
                            <i class="fas fa-tools mr-3"></i>
                            Dashboard Tenaga Pendidik
                        </a>
                    @endif
                    
                    <div class="border-t border-blue-700 my-4"></div>
                    
                    <a href="{{ url('/') }}" class="sidebar-item flex items-center px-4 py-3 text-white rounded-lg">
                        <i class="fas fa-globe mr-3"></i>
                        Website Utama
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-x-hidden">
            <main class="p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.bg-green-100, .bg-red-100');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            });
        }, 5000);
    </script>
    
    @yield('scripts')
</body>
</html>
