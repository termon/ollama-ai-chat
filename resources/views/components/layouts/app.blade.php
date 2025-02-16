<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Gemini</title>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex min-h-screen flex-col">
    <header>
        <x-ui.nav class="bg-slate-50">
            <x-ui.nav.title class="flex items-center">
                <x-ui.svg variant="logo" size="xl" />
                <span>AI Chat Demos</span>
            </x-ui.nav.title>

        
            <x-slot:right>
                                        
            </x-slot>
        </x-ui.nav>
    </header>


    <x-ui.flash />

    <main class="container mx-auto my-2 flex-grow">
        {{ $slot }}
    </main>

    <footer class="border-t-2 bg-gray-50 border-gray-100 py-2 px-4 text-center">
        Copyright@ Ulster University {{ date('Y') }}
    </footer>

    @livewireScripts
</body>

</html>
