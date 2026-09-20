
@props([
    'sale',
    'sale_items',
    'prices' => [],
    'exception_prices' => [],
    'inventories' => [],
    'deletable' => false
    
])

<!-- ========================= -->
<!-- Sale Items Section -->
<!-- ========================= -->
<div class="mt-10">

    <h3 class="text-2xl font-bold text-green-900 mb-4">Sale Items</h3>

    <!-- Existing Items Table -->
    <div class="overflow-x-auto">

        <table class="min-w-full border border-yellow-800 bg-yellow-100 rounded">

            <thead class="bg-amber-600 text-green-900">
                <tr>
                    <th class="px-4 py-2 font-semibold border border-yellow-800 text-xs md:text-sm">Inventory Item</th>
                    <th class="px-4 py-2 font-semibold border border-yellow-800 text-xs md:text-sm">Quantity</th>
                    <th class="px-4 py-2 font-semibold border border-yellow-800 text-xs md:text-sm">Unit Price</th>
                    <th class="px-4 py-2 font-semibold border border-yellow-800 text-xs md:text-sm">Discount</th>
                    <th class="px-4 py-2 font-semibold border border-yellow-800 text-xs md:text-sm">Total Price</th>

                    @if ($deletable && $sale->status == "In Progress")
                        <th class="px-4 py-2 font-semibold border border-yellow-800 text-xs md:text-sm">Remove</th>
                    @endif
                    
                </tr>
            </thead>

            <tbody>
                
                @forelse ($sale_items as $item)

                <tr class="hover:bg-amber-200">

                    <td class="px-4 py-2 border border-yellow-800 text-xs md:text-sm">
                        {{ $item->inventory->pot_size->size }}, {{ $item->inventory->tree->common_name }}
                    </td>

                    <td class="px-4 py-2 border border-yellow-800 text-xs md:text-sm">
                        {{ $item->quantity }}
                    </td>

                    <td class="px-4 py-2 border border-yellow-800 text-xs md:text-sm">
                        ${{ number_format($item->unit_price, 2) }}
                    </td>

                    <td class="px-4 py-2 border border-yellow-800 text-xs md:text-sm">
                        ${{ $item->discount }}
                    </td>

                    <td class="px-4 py-2 border border-yellow-800 text-xs md:text-sm">
                        ${{ number_format($item->total_price, 2) }}
                    </td>

                    @if ($deletable && $sale->status == "In Progress")

                        <td class="px-4 py-2 border border-yellow-800 text-xs md:text-sm">
                            <button 
                                type="button" 
                                class="text-red-600 font-bold"
                                onclick="removeSaleItem({{ $item->id }})"
                            >
                                X
                            </button>
                        </td>

                    @endif
                    
                </tr>

                @empty

                    <tr class="hover:bg-amber-200">

                        <td class="px-4 py-2 border border-yellow-800 text-xs md:text-sm text-center text-stone-500">
                            No items yet
                        </td>
                        <td class="px-4 py-2 border border-yellow-800 text-xs md:text-sm"></td>
                        <td class="px-4 py-2 border border-yellow-800 text-xs md:text-sm"></td>
                        <td class="px-4 py-2 border border-yellow-800 text-xs md:text-sm"></td>
                        <td class="px-4 py-2 border border-yellow-800 text-xs md:text-sm"></td>

                        @if ($deletable)
                            <td class="px-4 py-2 border border-yellow-800 text-xs md:text-sm"></td>
                        @endif

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    @if ($deletable && $sale->status == "In Progress")

        <!-- Add Item Row -->
        <div class="flex flex-row flex-wrap gap-6 items-end mt-6">

            <!-- Inventory Dropdown -->
            <div x-data="{ search: '', open: false }" class="mt-4">

                <label class="block text-green-900 font-semibold">Inventory Item</label>

                <!-- Search box -->
                <input 
                    x-model="search"
                    @focus="open = true"
                    @click.away="open = false"
                    type="text"
                    placeholder="Search inventory..."
                    class="border border-yellow-800 rounded p-2 w-64"
                >

                <!-- Hidden select that actually submits -->
                <select name="inventory_id" x-ref="inventorySelect" class="hidden">
                    @foreach ($inventories as $inventory)
                        <option value="{{ $inventory->id }}">
                            {{ $inventory->pot_size->size }}, {{ $inventory->tree->common_name }}
                        </option>
                    @endforeach
                </select>

                <!-- Filtered dropdown -->
                <ul 
                    x-show="open"
                    class="border border-yellow-800 bg-white rounded mt-1 max-h-40 overflow-y-auto w-64 absolute z-50"
                >
                    @foreach ($inventories as $inventory)
                        <li 
                            @click="
                                $refs.inventorySelect.value = '{{ $inventory->id }}';
                                search = '{{ $inventory->pot_size->size }}, {{ $inventory->tree->common_name }} : {{ $inventory->quantity }}';
                                open = false;
                            "
                            x-show="@js(strtolower($inventory->pot_size->size . ', ' . $inventory->tree->common_name)).includes(search.toLowerCase())"
                            class="p-2 hover:bg-yellow-200 cursor-pointer text-xs md:text-sm"
                        >
                            {{ $inventory->pot_size->size }}, {{ $inventory->tree->common_name }} : {{ $inventory->quantity }}
                        </li>
                    @endforeach
                </ul>

            </div>

            <!-- Quantity -->
            <div>
                <label class="block text-green-900 font-semibold mb-2">Quantity</label>
                <input type="number" name="quantity" class="border border-yellow-800 rounded p-2 w-32">
            </div>

            <!-- Discount -->
            <div>
                <label class="block text-green-900 font-semibold mb-2">Discount</label>
                <input type="number" name="item_discount" class="border border-yellow-800 rounded p-2 w-32">
            </div>

            <!-- Add Button -->
            <div>
                <x-button-admin type="button" value="Add Item" data-add-item />
            </div>

        </div>

    @endif

</div>
