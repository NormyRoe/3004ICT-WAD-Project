
@props(['name'])

<!-- Sidebar -->
<aside class="w-full md:w-64 bg-yellow-100 p-4">

    <!-- Logged In Text -->
    <div class="text-green-900 font-semibold mb-4">
        Logged in as: {{ $name }}
    </div>

    <!-- Navigation Menu -->
    <x-navigation />

</aside>
