@props([
    'title' => 'Dog Pack'
])


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="icon" type="image/x-icon" href="{{ Storage::url('assets/dogpacklogo.png') }}">
    </head>

    <body class="bg-background text-foreground min-h-screen overflow-x-hidden">
        
        <x-nav/>
        <x-mobile-top-bar/>
        <main class="mx-auto max-w-7xl w-full px-4 py-6 sm:px-6 lg:px-8 pb-24 md:pb-6">
            {{ $slot }}
        </main>
        <x-mobile-nav />
        @session('success')
            <div id="message" class="bg-primary px-4 py-3 fixed bottom-4 right-4 rounded-lg z-200">{{ $value }}</div>
        @endsession
        @session('error')
            <div id="message" class="bg-red-500 px-4 py-3 fixed bottom-4 right-4 rounded-lg text-white z-200">{{ $value }}</div>
        @endsession
    </body>
</html>
