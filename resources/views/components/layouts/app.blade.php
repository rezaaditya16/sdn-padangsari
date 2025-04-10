<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SDNPadangsari01</title>
    @livewireStyles
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    

    


</head>
<body class="flex flex-col min-h-screen font-roboto overflow-x-hidden">
    {{-- Header --}}

    {{-- Sidebar (Navbar Vertikal) --}}
    @include('components.navbar')

    {{-- Konten Utama --}}
    <div class="flex-grow">
        {{ $slot }}
    </div>

    {{-- Footer --}}
    @include('components.footer')


    @livewireScripts
</body>
</html>
