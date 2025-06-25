<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SDNPadangsari01</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

    @livewireStyles
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Tailwind config to suppress production warning
        tailwind.config = {
            content: []
        }
    </script>
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    
    
    <style>
  @keyframes marquee {
    0%   { transform: translateX(100%); }
    100% { transform: translateX(-100%); }
  }

  .animate-marquee {
    animation: marquee 15s linear infinite;
  }
</style>

</head>
<body class="flex flex-col min-h-screen font-roboto overflow-x-hidden bg-gray-100 pt-24 font-poppins">
    {{-- Header --}}

    {{-- Sidebar (Navbar Vertikal) --}}
    @include('components.navbar')

    {{-- Konten Utama --}}
    <div class="flex-grow mt-[-45px]">
        {{-- Hero Section --}}
        {{ $slot }}
    </div>
    

    {{-- Footer --}}
    @include('components.footer')


    @livewireScripts
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init();
</script>
</body>
</html>
