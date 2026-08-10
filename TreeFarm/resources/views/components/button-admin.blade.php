
@props([
    'type' => 'button',
    'name' => null,
    'value' => null,
])

<!-- Button for Admin sub-pages -->
<input 
    type="{{ $type }}"
    name="{{ $name }}"
    value="{{ $value }}"
    {{ $attributes->merge([
        'class' => 'bg-amber-700 text-black text-sm px-3 py-1 rounded-md hover:bg-rose-700 cursor-pointer'
    ]) }}
>
