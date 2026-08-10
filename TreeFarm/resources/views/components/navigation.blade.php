

<!-- Navigation Menu -->
<label class="text-yellow-300 font-bold px-2">Menu</label>

<nav class="rounded border-2 border-emerald-700 mt-2 space-y-1">
    <a class="{{ request()->routeIs('tasks') ? 'bg-emerald-700 text-yellow-200 rounded' : '' }} block text-emerald-900 font-semibold 
                hover:bg-yellow-200 py-3 px-2" 
        href="{{ route('tasks') }}"
    >Tasks</a>
    <a class="{{ request()->routeIs('inventory') ? 'bg-emerald-700 text-yellow-200 rounded' : '' }} block text-emerald-900 font-semibold 
                hover:bg-yellow-200 py-3 px-2" 
        href="{{ route('inventory') }}"
    >Inventory</a>
    <a class="{{ request()->routeIs('sales') ? 'bg-emerald-700 text-yellow-200 rounded' : '' }} block text-emerald-900 font-semibold 
                hover:bg-yellow-200 py-3 px-2" 
        href="{{ route('sales') }}"
    >Sales</a>
    <a class="{{ request()->routeIs('customers') ? 'bg-emerald-700 text-yellow-200 rounded' : '' }} block text-emerald-900 font-semibold 
                hover:bg-yellow-200 py-3 px-2" 
        href="{{ route('customers') }}"
    >Customers</a>
    <a class="block text-emerald-900 font-semibold hover:bg-yellow-200 py-3 px-2" href="#"
    >Reports</a>
    <a class="{{ request()->routeIs('admin*') ? 'bg-emerald-700 text-yellow-200 rounded' : '' }} block text-emerald-900 font-semibold 
                hover:bg-yellow-200 py-3 px-2" 
        href="{{ route('admin') }}"
    >Admin</a>
    <a class="{{ request()->routeIs('profile') ? 'bg-emerald-700 text-yellow-200 rounded' : '' }} block text-emerald-900 font-semibold 
                hover:bg-yellow-200 py-3 px-2" 
        href="{{ route('profile') }}"
    >Profile</a>
</nav>
