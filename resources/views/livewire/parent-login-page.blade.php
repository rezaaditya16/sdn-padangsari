<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <div class="text-center mb-6">
                <h2 class="text-3xl font-extrabold text-gray-900">
                    Login Orang Tua
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Masukkan NISN dan tanggal lahir siswa untuk mengajukan pengaduan
                </p>
            </div>

            <form wire:submit.prevent="login" class="space-y-6">
                <!-- NISN Input -->
                <div>
                    <label for="nisn" class="block text-sm font-medium text-gray-700">
                        NISN Siswa
                    </label>
                    <div class="mt-1">
                        <input wire:model="nisn" 
                               id="nisn" 
                               name="nisn" 
                               type="text" 
                               required 
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                               placeholder="Masukkan NISN siswa">
                    </div>
                    @error('nisn') 
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                    @enderror
                </div>

                <!-- Birth Date Input -->
                <div>
                    <label for="birth_date" class="block text-sm font-medium text-gray-700">
                        Tanggal Lahir Siswa
                    </label>
                    <div class="mt-1">
                        <input wire:model="birth_date" 
                               id="birth_date" 
                               name="birth_date" 
                               type="date" 
                               required 
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    </div>
                    @error('birth_date') 
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                    @enderror
                </div>

                <!-- Error Message -->
                @if($errorMessage)
                    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded relative">
                        {{ $errorMessage }}
                    </div>
                @endif

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Masuk
                    </button>
                </div>
            </form>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300" />
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Informasi</span>
                    </div>
                </div>

                <div class="mt-4 text-sm text-gray-600 text-center">
                    <p>Jika Anda tidak mengetahui NISN atau tanggal lahir siswa,</p>
                    <p>silakan hubungi pihak sekolah melalui halaman 
                        <a href="{{ route('kontak') }}" class="text-red-600 hover:text-red-500">kontak</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
