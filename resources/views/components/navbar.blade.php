<nav class="bg-gray-800 text-white shadow-lg w-full fixed top-0 left-0">
    <div class="container mx-auto px-6">
        <div class="flex justify-between items-center py-4">
            {{-- Logo --}}
            <a wire:navigate href="/" class="text-lg font-semibold flex items-center">
                <img src="/storage/images/logo.png" alt="Logo" class="h-8 w-8 mr-2">
                SDN 01 Padangsari
            </a>

            {{-- Menu Navigasi --}}
            <ul class="flex space-x-6">
                <li><a wire:navigate href="/about" class="hover:text-gray-300">About</a></li>
                <li><a wire:navigate href="/achievement" class="hover:text-gray-300">Achievement</a></li>
                <li><a wire:navigate href="/announcement" class="hover:text-gray-300">Announcement</a></li>
                <li><a wire:navigate href="/contact" class="hover:text-gray-300">Contact</a></li>
                <li><a wire:navigate href="/gallery" class="hover:text-gray-300">Gallery</a></li>
                <li><a wire:navigate href="/news" class="hover:text-gray-300">News</a></li>
                <li><a wire:navigate href="/profile" class="hover:text-gray-300">Profile</a></li>
                <li class="relative group">
                    <a wire:navigate href="#" class="hover:text-gray-300">More</a>
                    <ul class="absolute hidden group-hover:block bg-gray-700 text-white mt-2 rounded shadow-lg">
                        <li><a wire:navigate href="/extra1" class="block px-4 py-2 hover:bg-gray-600">Extra 1</a></li>
                        <li><a wire:navigate href="/extra2" class="block px-4 py-2 hover:bg-gray-600">Extra 2</a></li>
                        <li><a wire:navigate href="/extra3" class="block px-4 py-2 hover:bg-gray-600">Extra 3</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
