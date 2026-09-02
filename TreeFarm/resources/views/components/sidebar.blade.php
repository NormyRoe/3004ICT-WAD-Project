
@props(['name'])

<!-- Sidebar -->
<aside class="w-full md:w-64 bg-amber-600 p-5 min-h-screen">

    <!-- Logged In Text -->
    <div class="text-green-900 font-semibold mb-4">
        Logged in as: {{ $name }}
    </div>

    <!-- Navigation Menu -->
    <x-navigation />

    <!-- Logout Option -->
    <div class="text-center mt-6">
        
        <form method="POST" action="{{ route('logout') }}"
          onsubmit="return confirm('Are you sure that you want to logout?');"
        >
            @csrf
            <button class="text-rose-800 font-semibold hover:underline">
                Logout
            </button>

        </form>

    </div>

</aside>
