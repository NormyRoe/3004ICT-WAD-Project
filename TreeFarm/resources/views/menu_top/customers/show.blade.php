@extends('layouts.app')

@section('title')
    View a Customer
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">View an existing Customer</h2>

    <!-- Back to Index Button  -->
    <x-back-controller route='customers.index' label='Back to Customers Page' />

    <!-- Create/Update Success Message  -->
    @if(session('success'))
        <div class="bg-amber-200 text-orange-900 p-4 rounded mb-4 border border-amber-600 shadow-sm">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- ========================= -->
    <!-- Show Details -->
    <!-- ========================= -->

    <div class="flex flex-col space-y-4 bg-yellow-100 p-6 rounded border border-yellow-800 max-w-xl">
        <!-- First Name  -->
        <div>
            <label class="block text-green-900 font-semibold block">First Name</label>
            <label class="text-black block">{{ $customer->first_name }}</label>
        </div>
        <!-- Surname  -->
        <div>
            <label class="block text-green-900 font-semibold block">Surname</label>
            <label class="text-black block">{{ $customer->last_name }}</label>
        </div>
        <!-- Company  -->
        <div>
            <label class="block text-green-900 font-semibold block">Company</label>
            <label class="text-black block">{{ $customer->company }}</label>
        </div>
        <!-- Phone Number  -->
        <div>
            <label class="block text-green-900 font-semibold block">Phone Number</label>
            <label class="text-black block">{{ $customer->phone_number }}</label>
        </div>
        <!-- Email Address  -->
        <div>
            <label class="block text-green-900 font-semibold block">Email Address</label>
            <label class="text-black block">{{ $customer->email }}</label>
        </div>
        <!-- Street Address 1  -->
        <div>
            <label class="block text-green-900 font-semibold block">Street Address 1</label>
            <label class="text-black block">{{ $customer->street_address_1 }}</label>
        </div>
        <!-- Street Address 2  -->
        <div>
            <label class="block text-green-900 font-semibold block">Street Address 2</label>
            <label class="text-black block">{{ $customer->street_address_2 }}</label>
        </div>
        <!-- Suburb  -->
        <div>
            <label class="block text-green-900 font-semibold block">Suburb</label>
            <label class="text-black block">{{ $customer->suburb }}</label>
        </div>
        <!-- Postcode  -->
        <div>
            <label class="block text-green-900 font-semibold block">Postcode</label>
            <label class="text-black block">{{ $customer->postcode }}</label>
        </div>
        
    </div>

    <!-- ========================= -->
    <!-- Buttons -->
    <!-- ========================= -->
    
    <div class="flex justify-center gap-24 mt-10 max-w-xl">

        <!-- Update -->
        <a href="{{ route('customers.edit', $customer->id) }}">
            <x-button-admin type="button" value="Update" />
        </a>

        <!-- New Sale -->
        <a href="{{ route('customers.new_sale', $customer->id) }}">
            <x-button-admin type="button" value="New Sale" />
        </a>

        <!-- Sales History -->
        <a href="{{ route('customers.sales', $customer->id) }}">
            <x-button-admin type="button" value="Sales History" />
        </a>

    </div>


@endsection
