<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Guru - SDN Padangsari 01</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body class="bg-gradient-to-br from-[#7D0A0A] to-[#BF3131] min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-2xl p-8 w-full max-w-md">
        <!-- Logo dan Header -->
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Logo SDN Padangsari 01" class="mx-auto h-20 w-20 mb-4">
            <h1 class="text-2xl font-bold text-[#7D0A0A]">Login Guru</h1>
            <p class="text-gray-600">SDN Padangsari 01</p>
        </div>

        <!-- Pesan Error -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Pesan Success -->
        @if (session('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <!-- Form Login -->
        <form method="POST" action="{{ route('teacher.login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                    <i class="fas fa-envelope mr-2"></i>Email
                </label>
                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#7D0A0A] focus:border-transparent"
                       placeholder="Masukkan email Anda"
                       required>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
                    <i class="fas fa-lock mr-2"></i>Password
                </label>
                <input type="password"
                       id="password"
                       name="password"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#7D0A0A] focus:border-transparent"
                       placeholder="Masukkan password Anda"
                       required>
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="mr-2">
                    <span class="text-sm text-gray-600">Ingat saya</span>
                </label>
            </div>

            <button type="submit"
                    class="w-full bg-[#7D0A0A] text-white py-2 px-4 rounded-md hover:bg-[#BF3131] transition duration-300 font-bold">
                <i class="fas fa-sign-in-alt mr-2"></i>Login
            </button>
        </form>

        <!-- Link Kembali ke Beranda -->
        <div class="text-center mt-6">
            <a href="/" class="text-[#7D0A0A] hover:text-[#BF3131] text-sm">
                <i class="fas fa-arrow-left mr-1"></i>Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
