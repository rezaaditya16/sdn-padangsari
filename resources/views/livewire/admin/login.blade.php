<div class="max-w-md w-full space-y-8">
    <!-- Header -->
    <div class="text-center">
        <div class="flex justify-center mb-4">
            <div class="bg-white p-4 rounded-full shadow-lg">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SDN Padangsari" class="h-16 w-16">
            </div>
        </div>
        <h1 class="text-3xl font-bold text-gray-900">Admin Login</h1>
        <p class="mt-2 text-sm text-gray-600">SDN Padangsari 01 - Sistem Pengaduan</p>
    </div>

    <!-- Form -->
    <div class="bg-white py-8 px-6 shadow-xl rounded-lg">
        <form wire:submit.prevent="login" class="space-y-6">
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-envelope mr-2 text-gray-500"></i>Email
                </label>
                <input wire:model="email" type="email" id="email" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('email') border-red-500 @enderror"
                    placeholder="Masukkan email admin">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-lock mr-2 text-gray-500"></i>Password
                </label>
                <input wire:model="password" type="password" id="password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('password') border-red-500 @enderror"
                    placeholder="Masukkan password">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input wire:model="remember" type="checkbox" id="remember" 
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-700">
                    Ingat saya
                </label>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" 
                    class="w-full flex justify-center items-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200"
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-50 cursor-not-allowed">
                    
                    <span wire:loading.remove>
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </span>
                    <span wire:loading>
                        <i class="fas fa-spinner fa-spin mr-2"></i>Sedang login...
                    </span>
                </button>
            </div>
        </form>

        <!-- Info Login -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Role yang tersedia:</h3>
            <div class="text-xs text-gray-600 space-y-1">
                <div class="flex justify-between">
                    <span>Super Admin:</span>
                    <span class="font-mono">admin@sdnpadangsari.sch.id</span>
                </div>
                <div class="flex justify-between">
                    <span>Kepala Sekolah:</span>
                    <span class="font-mono">kepsek@sdnpadangsari.sch.id</span>
                </div>
                <div class="flex justify-between">
                    <span>Guru BK:</span>
                    <span class="font-mono">bk@sdnpadangsari.sch.id</span>
                </div>
                <div class="flex justify-between">
                    <span>Guru Mapel:</span>
                    <span class="font-mono">gurumapel@sdnpadangsari.sch.id</span>
                </div>
                <div class="flex justify-between">
                    <span>Tenaga Pendidik:</span>
                    <span class="font-mono">tendik@sdnpadangsari.sch.id</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Website -->
    <div class="text-center">
        <a href="/" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Website
        </a>
    </div>
</div>
