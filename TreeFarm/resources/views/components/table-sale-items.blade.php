
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

                    @if ($deletable)
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

                    @if ($deletable)

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

    @if ($deletable)

        <!-- Add Item Row -->
        <div class="flex flex-row gap-6 items-end mt-6">

            <!-- Inventory Dropdown -->
            <div>
                <label class="block text-green-900 font-semibold mb-2">Inventory Item</label>
                <select class="p-2 border border-yellow-800 rounded text-xs md:text-sm w-64">
                    <option value="">Select an item...</option>
                    <!-- Inventory items will be loaded later -->
                </select>
            </div>

            <!-- Quantity -->
            <div>
                <label class="block text-green-900 font-semibold mb-2">Quantity</label>
                <input type="number" class="border border-yellow-800 rounded p-2 w-32">
            </div>

            <!-- Add Button -->
            <div>
                <x-button-admin type="button" value="Add Item" />
            </div>

        </div>

    @endif

</div>
