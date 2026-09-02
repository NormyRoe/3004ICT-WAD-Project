
@extends('layouts.app')

@section('title')
    Sales
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Sales area, {{ auth()->user()->first_name }}</h2>

    <!-- Page text  -->
    <p class="mt-4 text-stone-700">
        Here are the current and completed company sales:
    </p>

    <!-- ========================= -->
    <!-- Current Sales (Filtering Table with Total) -->
    <!-- ========================= -->

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Current Sales</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update" value="Update" />
            <x-button-admin type="submit" name="add" value="Add" />
        </div>
        
    </div>
    

    @php
        $currentSalesHeadings = [
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

        $currentSalesRows = [
            ["Awaiting Payment","Susan", "12/07/2026","Enter code 448 to enter community gate","2","115","0","400","Bob"],
            ["Awaiting Delivery","Henry", "20/07/2026","","5","250","100","5500","Susan"],
        ];

        // Hide Columns on small screens
        $hideColumns = [3, 4, 5, 6, 8];

    @endphp

    <x-table-filter
        :headings="$currentSalesHeadings" 
        :rows="$currentSalesRows"
        :hideColumns="$hideColumns"
        :filterColumns="[0, 2, 7, 8]"
        :showTotals="true"
        :sumColumn="7"
    />

    <!-- ========================= -->
    <!-- Completed Sales (Filtering Table with Total) -->
    <!-- ========================= -->

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Completed Sales</h3>
        <div class="flex gap-4">
            <!-- No buttons yet, but keep the div for layout consistency -->
        </div>
    </div>
    

    @php
        $completedSalesHeadings = [
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

        $completedSalesRows = [
            ["Delivered","Susan", "22/05/2026","Enter code 448 to enter community gate","2","115","300","10500","Bob"],
        ];

        // Hide Columns on small screens
        $hideColumns = [3, 4, 5, 6, 8];

    @endphp

    <x-table-filter-total 
        :headings="$completedSalesHeadings" 
        :rows="$completedSalesRows"
        :hideColumns="$hideColumns"
        :filterColumns="[0, 2, 7, 8]"
        :sumColumn="7"
    />


@endsection
