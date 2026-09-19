

<!-- Navigation Menu -->
<label class="text-yellow-300 font-bold px-2">Menu</label>

<nav class="rounded border-2 border-emerald-700 mt-2 space-y-1">

    <!-- Everyone can see these menu options -->
    <a class="{{ request()->routeIs('allocated_tasks.index') ? 'bg-emerald-700 text-yellow-200 rounded' : '' }} block text-emerald-900 font-semibold 
                hover:bg-yellow-200 py-3 px-2" 
        href="{{ route('allocated_tasks.index') }}"
    >Tasks</a>

    <a class="{{ request()->routeIs('inventories.index') ? 'bg-emerald-700 text-yellow-200 rounded' : '' }} block text-emerald-900 font-semibold 
                    hover:bg-yellow-200 py-3 px-2" 
            href="{{ route('inventories.index') }}"
    >Inventory</a>

    <!-- Only those with Sales access can see these menu options -->
    @can('sales-access')

        <a class="{{ request()->routeIs('sales.index') ? 'bg-emerald-700 text-yellow-200 rounded' : '' }} block text-emerald-900 font-semibold 
                    hover:bg-yellow-200 py-3 px-2" 
            href="{{ route('sales.index') }}"
        >Sales</a>

        <a class="{{ request()->routeIs('customers.index') ? 'bg-emerald-700 text-yellow-200 rounded' : '' }} block text-emerald-900 font-semibold 
                    hover:bg-yellow-200 py-3 px-2" 
            href="{{ route('customers.index') }}"
        >Customers</a>

    @endcan

    <!-- Everyone can see this menu option -->
    <a class="block text-emerald-900 font-semibold hover:bg-yellow-200 py-3 px-2" href="#"
    >Reports</a>

    <!-- Only those with Admin access can see this menu option -->
    @can('admin-access')

        <a class="{{ request()->routeIs('admin*') ? 'bg-emerald-700 text-yellow-200 rounded' : '' }} block text-emerald-900 font-semibold 
                    hover:bg-yellow-200 py-3 px-2" 
            href="{{ route('admin') }}"
        >Admin</a>
        
    @endcan

    <!-- Everyone can see this menu option -->
    <a class="{{ request()->routeIs('user_profile.show') ? 'bg-emerald-700 text-yellow-200 rounded' : '' }} block text-emerald-900 font-semibold 
                hover:bg-yellow-200 py-3 px-2" 
        href="{{ route('user_profile.show', auth()->id()) }}"
    >Profile</a>

</nav>
