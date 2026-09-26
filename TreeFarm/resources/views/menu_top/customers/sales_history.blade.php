
@extends('layouts.app')

@section('title')
    Customer Sales History
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Sales History for {{ $customer->first_name }} {{ $customer->last_name }}</h2>

    <!-- Back to Show Button  -->
    <x-back-controller route='customers.index' label="Back to the Customers Page" />
    

    <!-- Update Success Message  -->
    @if(session('success'))
        <div class="bg-amber-200 text-orange-900 p-4 rounded mb-4 mt-4 border border-amber-600 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- ========================= -->
    <!-- Non Delivered Orders -->
    <!-- (Filtering Table with Total) -->
    <!-- ========================= -->    

    <!-- Label  -->
    <div class="flex justify-between items-center mt-10">

        <h3 class="text-2xl font-bold text-green-900">Non-Delivered Orders</h3>       
        
    </div>

    @php

        // Set the headings to be displayed
        $otherSaleHeadings = [
            'Select', 
            'Status',
            'Date',
            'Tree',
            'Pot Size',
            'Quantity',
            'Total Cost',
            ];

        // Initialise an empty array for the rows
        $otherSaleRows = [];

        // For each sale in other_sales
        foreach ($other_sales as $sale)
            {

                // For each sale_item in sale_items
                foreach ($sale->sale_items as $sale_item)
                    {
                        // Add the contents of the sale_item variable to the table
                        $otherSaleRows[] = [
                            $sale_item->id,
                            $sale->status,
                            $sale->date->format('d/m/Y'),
                            $sale_item->common_name,
                            $sale_item->pot_size,
                            $sale_item->quantity,
                            $sale_item->total_price,
                        ];

                    }

            }

        // Hide No Columns
        $hideColumns = [3, 4];

    @endphp

    <x-table-filter
        :headings="$otherSaleHeadings" 
        :rows="$otherSaleRows"
        :hideColumns="$hideColumns"
        :filterColumns="[1, 2, 3, 4]"
        :showTotals="true"
        :sumColumn="6"
        tbodyId="other_sales_table_body"
        :paginate="true"
        filterPrefix="other_"
    />
    

    <!-- ========================= -->
    <!-- Delivered Orders -->
    <!-- (Filtering Table with Total) -->
    <!-- ========================= -->    

    <!-- Label  -->
    <div class="flex justify-between items-center mt-10">

        <h3 class="text-2xl font-bold text-green-900">Delivered Orders</h3>       
        
    </div>

    @php

        // Set the headings to be displayed
        $deliveredSaleHeadings = [
            'Select',
            'Date',
            'Tree',
            'Pot Size',
            'Quantity',
            'Total Cost',
            ];

        // Initialise an empty array for the rows
        $deliveredSaleRows = [];

        // For each sale in delivered_sales
        foreach ($delivered_sales as $sale)
            {

                // For each sale_item in sale_items
                foreach ($sale->sale_items as $sale_item)
                    {
                        // Add the contents of the sale_item variable to the table
                        $deliveredSaleRows[] = [
                            $sale_item->id,
                            $sale->date->format('d/m/Y'),
                            $sale_item->common_name,
                            $sale_item->pot_size,
                            $sale_item->quantity,
                            $sale_item->total_price,
                        ];

                    }

            }

        // Hide No Columns
        $hideColumns = [2, 3];

    @endphp

    <x-table-filter
        :headings="$deliveredSaleHeadings" 
        :rows="$deliveredSaleRows"
        :hideColumns="$hideColumns"
        :filterColumns="[1, 2, 3]"
        :showTotals="true"
        :sumColumn="5"
        tbodyId="delivered_sales_table_body"
        :paginate="true"
        filterPrefix="delivered_"
    />
    
    <!-- ========================= -->
    <!-- Import Scripts -->
    <!-- ========================= -->
    @push('scripts')
        
        <script src="{{ asset('js/table_helpers.js') }}"></script>
        <script src="{{ asset('js/menu_top/customers/sales_history.js') }}"></script>

    @endpush

@endsection

