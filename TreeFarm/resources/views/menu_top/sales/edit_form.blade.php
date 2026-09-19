@extends('layouts.app')

@section('title')
    Edit a Sale
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Update an existing Sale record</h2>

    <!-- Back to Index Button  -->
    <x-back-controller route='sales.index' label='Back to Sales Page' />

    <!-- Creation/Update Success Message  -->
    @if(session('success'))
        <div class="bg-amber-200 text-orange-900 p-4 rounded mb-4 mt-4 border border-amber-600 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Message  -->
    @if (count($errors) > 0)
        <div class="text-red-600 text-sm mt-1">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    
    <!-- ========================= -->
    <!-- Update Form -->
    <!-- ========================= -->
    <form id="sale-form" action="{{ route('sales.update', $sale->id) }}" method="POST" class="mt-6">
        @csrf
        {{ method_field('PUT') }}

        <div class="mt-4">


            <!-- ========================= -->
            <!-- Row: Status, Date and People -->
            <!-- ========================= -->
            <div class="flex flex-row flex-wrap gap-x-12 gap-y-4 mb-4">

                <!-- Status  -->
                <div>
                    <label class="text-green-900 font-semibold block">Status</label>
                    <select 
                        name="status"
                         class="p-2 border border-yellow-800 rounded text-xs md:text-sm"
                        required
                    >
                        <!-- Options -->
                        <option 
                            value="In Progress"
                            {{ old('status', $sale->status) == 'In Progress' ? 'selected' : '' }}
                        >
                            In Progress
                        </option>
                        <option 
                            value="Awaiting Payment"
                            {{ old('status', $sale->status) == 'Awaiting Payment' ? 'selected' : '' }}
                        >
                            Awaiting Payment
                        </option>
                        <option 
                            value="Awaiting Delivery"
                            {{ old('status', $sale->status) == 'Awaiting Delivery' ? 'selected' : '' }}
                        >
                            Awaiting Delivery
                        </option>
                        <option 
                            value="Delivered"
                            {{ old('status', $sale->status) == 'Delivered' ? 'selected' : '' }}
                        >
                            Delivered
                        </option>

                    </select>

                </div>

                <!-- Date  -->
                <div>

                    <label class="text-green-900 font-semibold block">Sales Date</label>
                    <label class="text-orange-900 font-semibold block">{{ $sale->date->format('d/m/Y') }}</label>

                </div>

                <!-- Salesperson  -->
                <div>

                    <label class="text-green-900 font-semibold block">Salesperson</label>
                    <label class="text-orange-900 font-semibold block">
                        {{ $sale->user->last_name }}, {{ $sale->user->first_name }}
                    </label>

                </div>

                <!-- Customer  -->
                <div>

                    <label class="text-green-900 font-semibold block">Customer</label>
                    <label class="text-orange-900 font-semibold block">
                        {{ $sale->customer->last_name }}, {{ $sale->customer->first_name }}
                    </label>

                </div>

            </div>

            <!-- ========================= -->
            <!-- Row: Delivery Notes and Kms -->
            <!-- ========================= -->
            <div class="flex flex-row flex-wrap gap-x-12 gap-y-4 mb-4">

                <!-- Delivery Notes  -->
                <div>
                    <label class="block text-green-900 font-semibold mb-2">Delivery Notes</label>
                    <textarea
                        name="delivery_notes"
                        class="border border-yellow-800 rounded p-2 w-64 h-32 resize-y"
                    >{{ old('delivery_notes', $sale->delivery_notes) }}</textarea>
                </div>

                <!-- Delivery kms  -->
                <div>

                    <div>
                        <label class="block text-green-900 font-semibold mb-2">Delivery Kms</label>

                        @if ($sale->status == "In Progress")
                            <input 
                                type="text" 
                                name="delivery_kms" 
                                class="border border-yellow-800 rounded p-2 w-64"
                                value="{{ old('delivery_kms', $sale->delivery_kms) }}"
                                required
                            >
                        @else
                            <label class="text-orange-900 font-semibold block">
                                {{ $sale->delivery_kms }}
                            </label>
                        @endif

                    </label>
                    </div>

                    @if ($sale->status == "In Progress")

                        <!-- Calculate Button -->
                        <div class="mt-6">
                            <x-button-admin id="btn-calc-kms" type="button" value="Calculate Delivery Distance" />
                        </div>

                    @endif

                </div>

            </div>

            <!-- ========================= -->
            <!-- Row: Delivery Fee, Discount and Total Sales -->
            <!-- ========================= -->
            <div class="flex flex-row flex-wrap gap-x-12 gap-y-4 mb-4">

                <!-- Delivery Fee  -->
                <div>
                    <label class="block text-green-900 font-semibold mb-2">Delivery Fee ($)</label>

                    @if ($sale->status == "In Progress")
                        <input 
                            type="text" 
                            name="delivery_fee" 
                            class="border border-yellow-800 rounded p-2 w-64"
                            value="{{ old('delivery_fee', $sale->delivery_fee) }}"
                            required
                        >
                    @else
                        <label class="text-orange-900 font-semibold block">
                            {{ $sale->delivery_fee }}
                        </label>
                    @endif

                </div>

                <!-- Discount  -->
                <div>
                    <label class="block text-green-900 font-semibold mb-2">Discount ($)</label>

                    @if ($sale->status == "In Progress")
                        <input 
                            type="text" 
                            name="discount" 
                            class="border border-yellow-800 rounded p-2 w-64"
                            value="{{ old('discount', $sale->discount) }}"
                        >
                    @else
                        <label class="text-orange-900 font-semibold block">
                            {{ $sale->discount }}
                        </label>
                    @endif

                </div>

                <!-- Total Sales  -->
                <div>
                    <label class="block text-green-900 font-semibold mb-2">Total Sales ($)</label>

                    @if ($sale->status == "In Progress")
                        <input 
                            type="text" 
                            name="total_sales" 
                            class="border border-yellow-800 rounded p-2 w-64"
                            value="{{ old('total_sales', $sale->total_sales_price) }}"
                            required
                        >
                    @else
                        <label class="text-orange-900 font-semibold block">
                            {{ $sale->discount }}
                        </label>
                    @endif

                </div>

            </div>

            <!-- ========================= -->
            <!-- Sales Items -->
            <!-- ========================= -->
            <div class="mb-4">

                <x-table-sale-items 
                    :sale="$sale" 
                    :sale_items="$sale_items"
                    :prices="$prices"
                    :exception_prices="$exception_prices"
                    :inventories="$inventories"
                    :deletable="true"
                />

            </div>
            
        </div>

        <!-- Hidden field to store the sale items array -->
        <input type="hidden" name="items_json" id="items_json">

        @php

            // FARM ADDRESS BUILDER
            $farmStreet = $farm->street_address_2 
                ? (preg_match('/\d+/', $farm->street_address_2) ? $farm->street_address_2 : $farm->street_address_1)
                : $farm->street_address_1;

            $farmFullAddress = "{$farmStreet}, {$farm->suburb} {$farm->postcode}, Australia";

            // CUSTOMER ADDRESS BUILDER
            $custStreet = $sale->customer->street_address_2 
                ? (preg_match('/\d+/', $sale->customer->street_address_2) ? $sale->customer->street_address_2 : $sale->customer->street_address_1)
                : $sale->customer->street_address_1;

            $custFullAddress = "{$custStreet}, {$sale->customer->suburb} {$sale->customer->postcode}, Australia";

        @endphp

        <!-- Hidden field to store the farm's address -->
        <input type="hidden" id="farm_address" value="{{ $farmFullAddress }}">

        <!-- Hidden field to store the customer's address -->
        <input type="hidden" id="customer_address" value="{{ $custFullAddress }}">


        <!-- Button  -->
        <div class="flex mt-12 justify-center max-w-xl">
            <x-button-admin type="submit" value="Update Sale" />
        </div>

    </form>

    <!-- ========================= -->
    <!-- Import Scripts -->
    <!-- ========================= -->
    @push('scripts')
        <script>

            window.saleStatus = "{{ trim($sale->status) }}";
            window.existingSaleItems = @json($sale_items);
            window.prices = @json($prices);
            window.exceptionPrices = @json($exception_prices);

            // Build a lookup table for inventory names
            window.inventoryLookup = {
                @foreach ($inventories as $inventory)
                    "{{ $inventory->id }}": {
                        pot_size: "{{ $inventory->pot_size->size }}",
                        tree_name: "{{ $inventory->tree->common_name }}",
                        pot_size_id: {{ $inventory->pot_size_id }},
                        tree_id: {{ $inventory->tree_id }},
                        quantity: {{ $inventory->quantity }}
                    },
                @endforeach
            };

            window.calcKmsUrl = "{{ route('sales.calcKms') }}";

        </script>
        
        <script type="module" src="{{ asset('js/menu_top/sales/init.js') }}"></script>
        <script type="module" src="{{ asset('js/menu_top/sales/sales_items.js') }}"></script>
        <script type="module" src="{{ asset('js/menu_top/sales/form_fields.js') }}"></script>
        <script type="module" src="{{ asset('js/menu_top/sales/generate_kms.js') }}"></script>

    @endpush

@endsection
