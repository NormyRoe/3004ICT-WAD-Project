
@props([
    'route',
    'label',
])

<!-- Back Button for Controller pages  -->
<div class="m-8">
    <a href="{{ route($route) }}" 
        class="text-orange-900 font-semibold hover:underline"
    >
    ← {{ $label }}
    </a>
</div>
