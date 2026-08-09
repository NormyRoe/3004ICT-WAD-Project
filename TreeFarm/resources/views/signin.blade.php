
@extends('layouts.master')

@section('title')
    Logan River Tree Farm Signin
@endsection


@section('body')
    <!-- Main Layout -->
    <main class="max-w-md mx-auto mt-10 p-8">
        
        <!-- Login Form Title -->
        <div>
            <h2 class="text-4xl text-rose-700 text-center font-bold mb-6">User Login</h2>
        </div>

        <!-- Login Form -->
        <div>
            <form method="post" action="#">
                {{csrf_field()}}
                <label class="text-orange-900 font-semibold">Username or Email Address</label> <br>
                <input 
                    class="rounded w-full mt-2 p-2 border border-yellow-800"
                    type="text" 
                    name="name"
                    placeholder="Enter username or email address"
                > <br><br>
                <label class="text-orange-900 font-semibold mt-4">Password</label> <br>
                <input 
                    class="rounded text-black mt-2 p-2 border border-yellow-800"
                    type="password" 
                    name="password"
                    placeholder="Enter password"
                > <br><br>

                <!-- Buttons -->
                <div class="flex justify-evenly mt-6">
                    <input 
                        class="bg-amber-700 text-black px-4 py-2 rounded hover:bg-rose-700 cursor-pointer"
                        type="submit" 
                        name="submit" 
                        value="Submit"
                    >
                    <input 
                        class="bg-stone-500 text-white px-4 py-2 rounded hover:bg-rose-700 cursor-pointer"
                        type="reset" 
                        name="reset" 
                        value="Reset">
                </div>

                <!-- Register Link -->
                <div class="text-center mt-6">
                    <span class="text-stone-700">Click here to </span>
                    <a class="text-green-700 font-semibold hover:underline" href="#">Register</a>
                </div>

            </form>

        </div>

    </main>
@endsection
