
@extends('layouts.app')

@section('title')
    Sales by Tree and Pot Size Report
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Sales by Tree and Pot Size Report, {{ auth()->user()->first_name }}</h2>

    <!-- Back to Sales Reports Button  -->
    <x-back-controller route='reports.sales_reports' label='Back to Sales Reports Page' />

    <!-- Page text  -->
    <p class="mt-4 text-stone-700">
        Here are the total sales for each Tree and Pot Size comnbination from {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} 
        to {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}:
    </p>


    <!-- ========================= -->
    <!-- Sales by Tree and Pot Size -->
    <!-- (Basic Table with Totals) -->
    <!-- ========================= -->

    @php
        // Set the headings to be displayed
        $saleHeadings = [
            "Tree's Common Name",
            'Pot Size',
            'Total Quantity',
            'Total Discounts',            
            'Total Sales Amount',
        ];

        // Initialise an empty array for the rows
        $saleRows = [];

        // For each grouped sale in grouped_sales
        foreach ($grouped_sales as $grouped_sale)
            {
                // Add the contents of the grouped sale variable to the table
                $saleRows[] = [
                    $grouped_sale['common_name'], 
                    $grouped_sale['pot_size'],
                    $grouped_sale['quantity'],
                    $grouped_sale['total_discount'],
                    $grouped_sale['total_sales'],
                ];
            }

        // Hide No Columns
        $hideColumns = [];

    @endphp

    <x-table-basic-total
        :headings="$saleHeadings" 
        :rows="$saleRows"
        :sumColumn="4"
        tbodyId="sale_table_body"
        :paginate="false"
        :report="true"
    />

    <!-- ========================= -->
    <!-- Export to CSV form -->
    <!-- ========================= -->

    <form action="{{ route('reports.sales_by_tree_pot_csv') }}" method="POST" class="mt-4">
        @csrf

        <input type="hidden" name="headings" value="{{ json_encode($saleHeadings) }}">
        <input type="hidden" name="rows" value="{{ json_encode($saleRows) }}">
        <x-button-admin type="submit" value="Export to CSV" />

    </form>
    
@endsection
