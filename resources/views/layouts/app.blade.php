<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- este stack me permite agregar css desde cualquier vista que use esta plantilla --}}
    @stack('css')

    <!-- Fonts Awesome-->
    <script src="https://kit.fontawesome.com/36273c56d4.js" crossorigin="anonymous"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

        {{-- menu de navegacion de la plantilla: --}}
        {{-- @livewire('navigation-menu') --}}

        {{-- mi propio menu de navegacion: --}}
        @livewire('navigation')

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        <div>
            @include('layouts.partials.app.footer')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Modals, este stack me permite agregar modales desde cualquier vista que usar esta plantilla -->
    @stack('modals')

    @livewireScripts

    {{-- este stack me permite agregar js desde cualquier vista que use esta plantilla --}}
    @stack('js')

    {{-- Escucha de eventos para mostrar alertas normales --}}
    @if (session('swal'))
        <script>
            Swal.fire({!! json_encode(session('swal')) !!});
        </script>
    @endif

    {{-- Escucha de eventos para mostrar alertas en LIVEWIRE --}}
    <script>
        Livewire.on('swal', data => {
            Swal.fire(data[0]);
        });
    </script>
</body>

</html>