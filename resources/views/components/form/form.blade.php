@props([
    'title', 'description', 'action', 'size' => 'max-w-md', 'file' => null, 'method' => null
])

<div class="flex items-center justify-center w-full min-h-[calc(100dvh-4rem)] px-4">
    <div class="w-full {{ $size }}">
        <div class="text-center">
            <h1 class="text-4xl font-bold tracking-tight mt-10">{{ $title }}</h1>
            <small class="text-muted-foreground mt-1">{{ $description }}</small>
        </div>
        <div>
            <form method="POST" action="{{ $action }}" id="form" @if ($file)enctype="{{ $file }}"@endif>
                @csrf
                @if ($method !== null)@method($method)@endif
                {{ $slot }}
            </form>
        </div>
    </div>
</div>
