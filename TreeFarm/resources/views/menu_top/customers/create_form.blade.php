@extends('layouts.app')

@section('title')
    Add Customer
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Add a New Customer</h2>

    <!-- Back to Index Button  -->
    <x-back-controller route='customers.index' label='Back to Customers Page' />
    
    <!-- ========================= -->
    <!-- Creation Form -->
    <!-- ========================= -->
    <form action="{{ route('customers.store') }}" method="POST" class="mt-6">
        @csrf

        <div class="flex flex-wrap gap-12 mt-6">

            <!-- ========================= -->
            <!-- Column 1: Identity & Contact -->
            <!-- ========================= -->
            <div class="flex flex-col space-y-4">

                <!-- First Name  -->
                <div>
                    <label class="block text-green-900 font-semibold mb-2">First Name</label>
                    <input 
                        type="text" 
                        name="first_name" 
                        class="border border-yellow-800 rounded p-2 w-64"
                        value="{{ old('first_name') }}"
                        required
                    >
                </div>     

                <!-- Surname  -->
                <div>
                    <label class="block text-green-900 font-semibold mb-2">Surname</label>
                    <input 
                        type="text" 
                        name="surname" 
                        class="border border-yellow-800 rounded p-2 w-64"
                        value="{{ old('surname') }}"
                        required
                    >
                </div>

                <!-- Company  -->
                <div>
                    <label class="block text-green-900 font-semibold mb-2">Company</label>
                    <input 
                        type="text" 
                        name="company" 
                        class="border border-yellow-800 rounded p-2 w-64"
                        value="{{ old('company') }}"
                    >
                </div>

                <!-- Phone Number  -->
                <div>
                    <label class="block text-green-900 font-semibold mb-2">Phone Number</label>
                    <input 
                        type="text" 
                        name="phone_number" 
                        class="border border-yellow-800 rounded p-2 w-64"
                        value="{{ old('phone_number') }}"
                        required
                    >
                </div>

                <!-- Email Address  -->
                <div>
                    <label class="block text-green-900 font-semibold mb-2">Email Address</label>
                    <input 
                        type="text" 
                        name="email" 
                        class="border border-yellow-800 rounded p-2 w-64"
                        value="{{ old('email') }}"
                        required
                    >
                </div>

            </div>

            <!-- ========================= -->
            <!-- Column 2: Address -->
            <!-- ========================= -->
            <div class="flex flex-col space-y-4">

                <!-- Street Address 1  -->
                <div>
                    <label class="block text-green-900 font-semibold mb-2">Street Address 1</label>
                    <input 
                        type="text" 
                        name="street_address_1" 
                        class="border border-yellow-800 rounded p-2 w-64"
                        value="{{ old('street_address_1') }}"
                        required
                    >
                </div>

                <!-- Street Address 2  -->
                <div>
                    <label class="block text-green-900 font-semibold mb-2">Street Address 2</label>
                    <input 
                        type="text" 
                        name="street_address_2" 
                        class="border border-yellow-800 rounded p-2 w-64"
                        value="{{ old('street_address_2') }}"
                    >
                </div>

                <!-- Suburb  -->
                <div>
                    <label class="block text-green-900 font-semibold mb-2">Suburb</label>
                    <input 
                        type="text" 
                        name="suburb" 
                        class="border border-yellow-800 rounded p-2 w-64"
                        value="{{ old('suburb') }}"
                        required
                    >
                </div>

                <!-- Postcode  -->
                <div>
                    <label class="block text-green-900 font-semibold mb-2">Postcode</label>
                    <input 
                        type="text" 
                        name="postcode" 
                        class="border border-yellow-800 rounded p-2 w-64"
                        value="{{ old('postcode') }}"
                        required
                    >
                </div>

            </div>

        </div>

        <div class="mt-4">

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
            
        </div>

        <!-- Button  -->
        <div class="flex mt-12 justify-center max-w-xl">
            <x-button-admin type="submit" value="Add Customer" />
        </div>

    </form>

@endsection
