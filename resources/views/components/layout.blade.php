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
    </head>

    <body class="bg-background text-foreground justify-center">
        <x-nav/>
        <main class="">
            {{ $slot }}
        </main>
        @session('success')
            <div id="message" class="bg-primary px-4 py-3 fixed bottom-4 right-4 rounded-lg">{{ $value }}</div>
        @endsession
    </body>
</html>
