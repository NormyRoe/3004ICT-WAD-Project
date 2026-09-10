
@extends('layouts.app')

@section('title')
    Prices
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Prices reference data, {{ auth()->user()->first_name }}</h2>

    <!-- Back to Admin Menu Button  -->
    <x-back-admin />

    <!-- Page text  -->
    <p class="mt-4 text-stone-700">
        Below are the Prices and Exception Prices.
    </p>

    <!-- Update Success Message  -->
    @if(session('success'))
        <div class="bg-amber-200 text-orange-900 p-4 rounded mb-4 mt-4 border border-amber-600 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- ========================= -->
    <!-- Prices (Basic Table) -->
    <!-- ========================= -->
    

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Prices</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update_price" value="Update" />
            <a href="{{ route('prices.create') }}">
                <x-button-admin type="submit" name="add_price" value="Add" />
            </a>
            <x-button-admin type="submit" name="delete_price" value="Delete" />
        </div>
        
    </div>

    @php

        // Set the headings to be displayed
        $priceHeadings = [
            'Select', 
            "Name",
            "Pot Size",
            "Price ($)",
            "Rate (%)",
        ];

        // Initialise an empty array for the rows
        $priceRows = [];

        // For each price in prices
        foreach ($prices as $price)
        {
            // Add the contents to the table
            $priceRows[] = [
                $price->id, 
                $price->name ?? '',
                $price->pot_size?->size ?? '',
                $price->price ?? '',
                $price->rate ?? ''
            ];
        }

        // Hide No Columns
        $hideColumns = [];

    @endphp

    <x-table-basic 
        :headings="$priceHeadings" 
        :rows="$priceRows"
        tbodyId="price_table_body"
        :paginate="true"
    />

    <!-- ========================= -->
    <!-- Exception Prices (Filtering Table with Total ) -->
    <!-- ========================= -->
    

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Exception Prices</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update_exception" value="Update" />
            <a href="{{ route('exception_prices.create') }}">
                <x-button-admin type="submit" name="add_exception" value="Add" />
            </a>            
            <x-button-admin type="submit" name="delete_exception" value="Delete" />
        </div>
        
    </div>

    @php

        // Set the headings to be displayed
        $exceptionHeadings = [
            'Select',
            "Tree",
            "Pot Size",
            "Price ($)",
        ];

        // Initialise an empty array for the rows
        $exceptionRows = [];

        // For each exception in exception_prices
        foreach ($exception_prices as $exception)
        {
            // Add the contents to the table
            $exceptionRows[] = [
                $exception->id, 
                $exception->tree->common_name,
                $exception->pot_size->size,
                $exception->price,
            ];
        }

        // Hide No Columns
        $hideColumns = [];

    @endphp

    <x-table-filter
        :headings="$exceptionHeadings" 
        :rows="$exceptionRows"
        :hideColumns="$hideColumns"
        :filterColumns="[1, 2, 3]"
        :showTotals="true"
        :sumColumn=null
        tbodyId="exception_price_table_body"
        :paginate="true"
    />

    <!-- ========================= -->
    <!-- Import Scripts -->
    <!-- ========================= -->
    @push('scripts')

        <script>

            const pricesEditRoute = "{{ route('prices.edit', ':id') }}";
            const pricesDeleteRoute = "{{ route('prices.delete_confirm', ':id') }}";

            const exceptionsEditRoute = "{{ route('exception_prices.edit', ':id') }}";
            const exceptionsDeleteRoute = "{{ route('exception_prices.delete_confirm', ':id') }}";

        </script>
        <script src="{{ asset('js/table_helpers.js') }}"></script>
        <script src="{{ asset('js/admin/prices.js') }}"></script>

    @endpush
    
@endsection
