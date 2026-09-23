
@extends('layouts.app')

@section('title')
    Sales
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Sales area, {{ auth()->user()->first_name }}</h2>

    <!-- Page text  -->
    <p class="mt-4 text-stone-700">
        Here are the current and completed/cancelled sales:
    </p>

    <!-- Update Success Message  -->
    @if(session('success'))
        <div class="bg-amber-200 text-orange-900 p-4 rounded mb-4 mt-4 border border-amber-600 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- ========================= -->
    <!-- Current Sales (Filtering Table with Total) -->
    <!-- ========================= -->

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Current Sales</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update" value="Update" />
            <a href="{{ route('sales.create') }}">
                <x-button-admin type="submit" name="add" value="Add" />
            </a>
        </div>
        
    </div>
    

    @php

        // Set the headings to be displayed
        $currentSaleHeadings = [
            'Select',
            "Status",
            "Customer",
            "Date",
            "Delivery_Notes",
            "Delivery_Kms",
            "Delivery_Fee",
            "Discount",
            "Total_Sales",
            "User",
        ];

        // Initialise an empty array for the rows
        $currentSaleRows = [];

        // For each sale in current_sales
        foreach ($current_sales as $sale)
            {
                // Add the contents of the sale variable to the table
                $currentSaleRows[] = [
                    $sale->id,
                    $sale->status,
                    $sale->customer->last_name . ', ' . $sale->customer->first_name,
                    $sale->date->format('d/m/Y'),
                    $sale->delivery_notes ?? '',
                    $sale->delivery_kms ?? '',
                    $sale->delivery_fee ?? '',
                    $sale->discount ?? '',
                    $sale->total_sales_price ?? 0,
                    $sale->user->last_name. ', ' .$sale->user->first_name,
                ];
            }

        // Hide Columns on small screens
        $hideColumns = [4, 5, 6, 7, 9];

    @endphp

    <x-table-filter
        :headings="$currentSaleHeadings" 
        :rows="$currentSaleRows"
        :hideColumns="$hideColumns"
        :filterColumns="[1, 3, 8, 9]"
        :showTotals="true"
        :sumColumn="8"
        tbodyId="current_sales_table_body"
        :paginate="true"
        filterPrefix="current_"
    />

    <!-- ========================= -->
    <!-- Completed and Cancelled Sales -->
    <!-- (Filtering Table with Total) -->
    <!-- ========================= -->

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Completed and Cancelled Sales (last 6 Months)</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="view" value="View" />
        </div>
    </div>
    

    @php

        // Set the headings to be displayed
        $completedSaleHeadings = [
            'Select',
            "Status",
            "Customer",
            "Date",
            "Delivery_Notes",
            "Delivery_Kms",
            "Delivery_Fee",
            "Discount",
            "Total_Sales",
            "User",
        ];

        // Initialise an empty array for the rows
        $completedSaleRows = [];

        // For each sale in completed_sales
        foreach ($completed_sales as $sale)
            {
                // Add the contents of the sale variable to the table
                $completedSaleRows[] = [
                    $sale->id,
                    $sale->status,
                    $sale->customer->last_name . ', ' . $sale->customer->first_name,
                    $sale->date->format('d/m/Y'),
                    $sale->delivery_notes ?? '',
                    $sale->delivery_kms ?? '',
                    $sale->delivery_fee ?? '',
                    $sale->discount ?? '',
                    $sale->total_sales_price ?? 0,
                    $sale->user->last_name. ', ' .$sale->user->first_name,
                ];
            }

        // Hide Columns on small screens
        $hideColumns = [4, 5, 6, 7, 9];

    @endphp

    <x-table-filter
        :headings="$completedSaleHeadings" 
        :rows="$completedSaleRows"
        :hideColumns="$hideColumns"
        :filterColumns="[1, 3, 8, 9]"
        :showTotals="true"
        :sumColumn="8"
        tbodyId="completed_sales_table_body"
        :paginate="true"
        filterPrefix="completed_"
    />

    <!-- ========================= -->
    <!-- Import Scripts -->
    <!-- ========================= -->
    @push('scripts')
        <script>

            const salesEditRoute = "{{ route('sales.edit', ':id') }}";
            const salesShowRoute = "{{ route('sales.show', ':id') }}";

        </script>
        <script src="{{ asset('js/table_helpers.js') }}"></script>
        <script src="{{ asset('js/menu_top/sales/sales.js') }}"></script>

    @endpush


@endsection
