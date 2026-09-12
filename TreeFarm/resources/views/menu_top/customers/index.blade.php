
@extends('layouts.app')

@section('title')
    Customers
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Customers area, {{ auth()->user()->first_name }}</h2>

    <!-- Page text  -->
    <p class="mt-4 text-stone-700">
        Below are all of the customers that have been created in the application.
    </p>

    <!-- Update Success Message  -->
    @if(session('success'))
        <div class="bg-amber-200 text-orange-900 p-4 rounded mb-4 mt-4 border border-amber-600 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- ========================= -->
    <!-- Customers (Filtering Table) -->
    <!-- ========================= -->

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Customers</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="view" value="View" />
            <x-button-admin type="submit" name="update" value="Update" />
            <a href="{{ route('customers.create') }}">
                <x-button-admin type="submit" name="add" value="Add" />
            </a>            
        </div>
        
    </div>
    

    @php

        // Set the headings to be displayed
        $customerHeadings = [
            'Select',
            'Company',
            "First Name",
            "Surname",
            "Phone Number",
            "Email",
            "Street Address 1",
            "Street Address 2",
            "Suburb",
            "Postcode",
        ];

        // Initialise an empty array for the rows
        $customerRows = [];

        // For each customer in customers
        foreach ($customers as $customer)
            {
                // Add the contents of the customer variable to the table
                $customerRows[] = [
                    $customer->id, 
                    $customer->company,
                    $customer->first_name,
                    $customer->last_name,
                    $customer->phone_number,
                    $customer->email,
                    $customer->street_address_1,
                    $customer->street_address_2,
                    $customer->suburb,
                    $customer->postcode,
                ];
            }

        // Hide Columns on small screens
        $hideColumns = [3, 4, 5, 6, 7];

    @endphp

    <x-table-filter
        :headings="$customerHeadings" 
        :rows="$customerRows"
        :hideColumns="$hideColumns"
        :filterColumns="[1, 3, 8, 9]"
        tbodyId="customer_table_body"
        :paginate="true"
    />

    <!-- ========================= -->
    <!-- Import Scripts -->
    <!-- ========================= -->
    @push('scripts')
        <script>

            const customersEditRoute = "{{ route('customers.edit', ':id') }}";
            const customersShowRoute = "{{ route('customers.show', ':id') }}";

        </script>
        <script src="{{ asset('js/table_helpers.js') }}"></script>
        <script src="{{ asset('js/menu_top/customers.js') }}"></script>
    @endpush

@endsection
