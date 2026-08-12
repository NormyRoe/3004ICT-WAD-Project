
@extends('layouts.app')

@section('title')
    Farm Details
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Farm Details reference data, {{ $name }}</h2>

    <!-- Back to Admin Menu Button  -->
    <x-back-admin />

    <!-- Page text  -->
    <p class="mt-4 text-stone-700">
        Below are the current details for the Tree Farm.  Use the form to update any details that need changing.
    </p>

    <div class="flex flex-row gap-x-20 mt-8">

        <!-- Current Farm Details  -->
        <div class="flex flex-col space-y-4 bg-yellow-100 p-6 rounded border border-yellow-800">
            <div>
                <label class="text-orange-900 font-semibold block">Farm Name</label>
                <label class="text-black block">Logan River Tree Farm</label>
            </div>
            <div>
                <label class="text-orange-900 font-semibold block">Street Address 1</label>
                <label class="text-black block">59-63 Chapman Drive</label>
            </div>
            <div>
                <label class="text-orange-900 font-semibold block">Street Address 2</label>
                <label class="text-black block">(Street Address 2)</label>
            </div>
            <div>
                <label class="text-orange-900 font-semibold block">Suburb</label>
                <label class="text-black block">Beenleigh</label>
            </div>
            <div>
                <label class="text-orange-900 font-semibold block">Postcode</label>
                <label class="text-black block">4207</label>
            </div>  
        </div>

        <!-- Update Farm Details  -->
        <div class="flex flex-col space-y-6">
            <form method="#" action="#">
                {{csrf_field()}}

                <!-- Form Fields -->
                <div>
                    <label class="text-orange-900 font-semibold block">Farm Name</label>
                    <input 
                        class="rounded w-full mt-2 p-2 border border-yellow-800 block"
                        type="text" 
                        name="name"
                        placeholder="Enter the farm's name"
                    >
                </div>
                
                <div>
                    <label class="text-orange-900 font-semibold block">Street Address 1</label>
                    <input 
                        class="rounded w-full mt-2 p-2 border border-yellow-800 block"
                        type="text" 
                        name="street_address_1"
                        placeholder="Enter street address 1"
                    >
                </div>
                
                <div>
                    <label class="text-orange-900 font-semibold block">Street Address 2</label>
                    <input 
                        class="rounded w-full mt-2 p-2 border border-yellow-800 block"
                        type="text" 
                        name="street_address_2"
                        placeholder="Enter street address 2"
                    >
                </div>

                <div>
                    <label class="text-orange-900 font-semibold block">Suburb</label>
                    <input 
                        class="rounded w-full mt-2 p-2 border border-yellow-800 block"
                        type="text" 
                        name="suburb"
                        placeholder="Enter suburb"
                    >
                </div>

                <div>
                    <label class="text-orange-900 font-semibold block">Postcode</label>
                    <input 
                        class="rounded w-full mt-2 p-2 border border-yellow-800 block"
                        type="text" 
                        name="postcode"
                        placeholder="postcode"
                    >
                </div>

                <!-- Buttons -->
                <div class="flex justify-evenly mt-6">
                    <input 
                        class="bg-amber-700 text-black px-4 py-2 rounded hover:bg-rose-700 cursor-pointer"
                        type="submit" 
                        name="submit" 
                        value="Update"
                    >
                    <input 
                        class="bg-stone-500 text-white px-4 py-2 rounded hover:bg-rose-700 cursor-pointer"
                        type="reset" 
                        name="reset" 
                        value="Reset">
                </div>

            </form>

        </div>        

    </div>

    <!-- Logo Upload -->
    <div class="mt-10 bg-yellow-100 p-6 rounded border border-yellow-800">

        <label class="text-orange-900 font-semibold block">Upload New Logo</label>

        <input 
            class="rounded w-full mt-2 p-2 border border-yellow-800 block"
            type="file"
            name="logo"
            accept="image/jpeg"
            disabled
        >

        <p class="text-stone-600 text-sm mt-2">
            Logo upload functionality will be enabled once controllers are implemented.<br><br>

            Only .jpeg files will be allowed

        </p>

    </div>

@endsection
