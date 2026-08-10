
@extends('layouts.app')

@section('title')
    Profile
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Profile page, {{ $name }}</h2>

    <p class="mt-4 text-stone-700">
        Here are the current details of your profile.  Use the form to update your username, email address and/or password.
    </p><br>

    <div class="flex flex-row gap-x-20">
        <!-- Current Profile  -->
        <div class="flex flex-col space-y-4 bg-yellow-100 p-6 rounded border border-yellow-800">
            <div>
                <label class="text-orange-900 font-semibold block">First Name</label>
                <label class="text-black block">(First Name)</label>
            </div>
            <div>
                <label class="text-orange-900 font-semibold block">Surname</label>
                <label class="text-black block">(Surname)</label>
            </div>
            <div>
                <label class="text-orange-900 font-semibold block">Username</label>
                <label class="text-black block">(Username)</label>
            </div>
            <div>
                <label class="text-orange-900 font-semibold block">Email Address</label>
                <label class="text-black block">(Email Address)</label>
            </div>            
        </div>

        <!-- Update Profile Form  -->
        <div class="flex flex-col space-y-6">
            <form method="#" action="#">
                {{csrf_field()}}

                <!-- Form Fields -->
                <div>
                    <label class="text-orange-900 font-semibold block">Username</label>
                    <input 
                        class="rounded w-full mt-2 p-2 border border-yellow-800 block"
                        type="text" 
                        name="username"
                        placeholder="Enter username or email address"
                    >
                </div>
                
                <div>
                    <label class="text-orange-900 font-semibold block">Email Address</label>
                    <input 
                        class="rounded w-full mt-2 p-2 border border-yellow-800 block"
                        type="text" 
                        name="email"
                        placeholder="Enter email address"
                    >
                </div>
                
                <div>
                    <label class="text-orange-900 font-semibold mt-4 block">Password</label>
                    <input 
                        class="rounded text-black mt-2 p-2 border border-yellow-800 block"
                        type="password" 
                        name="password"
                        placeholder="Enter password"
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

@endsection
