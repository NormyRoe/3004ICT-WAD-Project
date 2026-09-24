
@extends('layouts.app')

@section('title')
    Sales by User Report
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Sales by User Report, {{ auth()->user()->first_name }}</h2>

    <!-- Back to Sales Reports Button  -->
    <x-back-controller route='reports.sales_reports' label='Back to Sales Reports Page' />

    <!-- Page text  -->
    <p class="mt-4 text-stone-700">
        Here are the total sales for each salesperson from {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} 
        to {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}:
    </p>


    <!-- ========================= -->
    <!-- Sales by User (Basic Table with Totals) -->
    <!-- ========================= -->

    @php
        // Set the headings to be displayed
        $saleHeadings = [
            'Salesperson', 
            'Total Delivery Fees',
            'Total Discounts',
            'Total Quantity',
            'Total Sales Amount',
        ];

        // Initialise an empty array for the rows
        $saleRows = [];

        // For each grouped sale in grouped_sales
        foreach ($grouped_sales as $grouped_sale)
            {
                // Add the contents of the grouped sale variable to the table
                $saleRows[] = [
                    $grouped_sale['user']->last_name . ', ' . $grouped_sale['user']->first_name, 
                    $grouped_sale['delivery_fees'],
                    $grouped_sale['total_discount'],
                    $grouped_sale['quantity'],
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
    <form action="{{ route('reports.sales_by_user_csv') }}" method="POST" class="mt-4">
        @csrf

        <input type="hidden" name="headings" value="{{ json_encode($saleHeadings) }}">
        <input type="hidden" name="rows" value="{{ json_encode($saleRows) }}">
        <x-button-admin type="submit" value="Export to CSV" />

    </form>
    
@endsection
