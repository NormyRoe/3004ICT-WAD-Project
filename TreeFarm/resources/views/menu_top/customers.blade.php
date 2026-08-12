
@extends('layouts.app')

@section('title')
    Customers
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Customers area, {{ $name }}</h2>

    <!-- Page text  -->
    <p class="mt-4 text-stone-700">
        Here are all of the customers:
    </p>

    <!-- ========================= -->
    <!-- Customers (Filtering Table) -->
    <!-- ========================= -->

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Customers</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update" value="Update" />
            <x-button-admin type="submit" name="add" value="Add" />
            <x-button-admin type="submit" name="delete" value="Delete" />
        </div>
        
    </div>
    

    @php
        $customersHeadings = [
            "First_Name",
            "Last_Name",
            "Phone_Number",
            "Email",
            "Street_Address_1",
            "Street_Address_2",
            "Suburb",
            "Postcode",
        ];

        $customersRows = [
            ["Henry","Bloke", "41254758","henry@buy.com","7","Fitzroy Street","Holmview","4207"],
            ["Susan","Boil", "42568459","susan@wow.com","6","Hovea Street","Coomera","4209"],
        ];

        // Hide Columns on small screens
        $hideColumns = [2, 3, 4, 5];

    @endphp

    <x-table-filter
        :headings="$customersHeadings" 
        :rows="$customersRows"
        :hideColumns="$hideColumns"
        :filterColumns="[6, 7]"
    />

@endsection
