@props([
    'title', 'type', 'route', 'options', 'category' => null, 'optionName' => null
])

<div class="absolute left-0 mt-2 rounded-xl bg-[oklch(0.25_0.03_268)] border border-white/10 shadow-lg p-1 space-y-1 z-50">
    <a href="{{ route($route, Arr::except(request()->query(), $type))}}"
        class="block px-3 py-2 rounded-lg text-white hover:bg-white/10"
        value="">{{ $title }}
    </a>
    @foreach ($options as $option)
        <a href="{{ route($route, array_merge(request()->query(), [
            $type  => $option
            ])) }}"
            class="filterOption block px-3 py-2 rounded-lg text-white hover:bg-white/10"
            value="{{ $option }}">{{$category === null ? $option. ' ' .$optionName : $option->label() }}
        </a>
    @endforeach
</div>
