@props([
    'label' => null, 'name' => null, 'value' => null,
    'type' => 'text', 'required' => null, 'min' => null,
    'max' => null, 'class' => null, 'id' => null, 'accept' => null,
    'placeholder' => null, 'dataTest'=>null, 'step' => null
])

<div class="space-y-2">
    @if ($label)
        <label class="label mt-2" for="{{ $name ?? '' }}">{{ $label }}</label>
    @endif
    <input
        @if ($placeholder)  placeholder="{{ $placeholder}}"@endif
        @if ($step)  step="{{ $step }}"@endif
        @if ($class) class={{ "$class" }}
        @else class={{ "input" }}
        @endif
        id="{{ $id ?? $name}}"
        type="{{ $type }}"
        name="{{ $name ?? ''}}"
        @if ($type !== 'file')
            value="{{ $value ?? old($name) }}"
        @endif
        @if ($accept) accept={{ "{$accept}" }} @endif
        {{ $required ?? ''}}
        @if ($min !== null) min={{ "{$min}" }} @endif
        @if ($min !== null) max={{ "{$max}" }} @endif
        @if ($dataTest) data-test={{ "{$dataTest}" }} @endif
        >

    @error($name)
        <p class='error'>{{ $message }}</p>
    @enderror
</div>