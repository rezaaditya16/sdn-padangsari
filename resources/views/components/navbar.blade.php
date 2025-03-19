<nav class="bg-gray-800 text-white shadow-lg w-full fixed top-0 left-0">
    <div class="container mx-auto px-6">
        <div class="flex justify-between items-center py-4">
            {{-- Logo --}}
            <a href="/" class="text-lg font-semibold flex items-center">
                <img src="/storage/images/logo.png" alt="Logo" class="h-8 w-8 mr-2">
                SDN Padangsari
            </a>

            {{-- Menu Navigasi --}}
            <ul class="flex space-x-6">
                <li><a href="/about" class="hover:text-gray-300">About</a></li>
                <li><a href="/achievement" class="hover:text-gray-300">Achievement</a></li>
                <li><a href="/announcement" class="hover:text-gray-300">Announcement</a></li>
                <li><a href="/contact" class="hover:text-gray-300">Contact</a></li>
                <li><a href="/gallery" class="hover:text-gray-300">Gallery</a></li>
                <li><a href="/news" class="hover:text-gray-300">News</a></li>
                <li><a href="/profile" class="hover:text-gray-300">Profile</a></li>
                <li class="relative group">
                    <a href="#" class="hover:text-gray-300">More</a>
                    <ul class="absolute hidden group-hover:block bg-gray-700 text-white mt-2 rounded shadow-lg">
                        <li><a href="/extra1" class="block px-4 py-2 hover:bg-gray-600">Extra 1</a></li>
                        <li><a href="/extra2" class="block px-4 py-2 hover:bg-gray-600">Extra 2</a></li>
                        <li><a href="/extra3" class="block px-4 py-2 hover:bg-gray-600">Extra 3</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
