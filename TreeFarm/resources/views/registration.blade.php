
@extends('layouts.master')

@section('title')
    {{ $farmName }} User Registration
@endsection


@section('body')
    <!-- Main Layout -->
    <main class="max-w-md mx-auto mt-10 p-8">
        
        <!-- Login Form Title -->
        <div>
            <h2 class="text-4xl text-rose-700 text-center font-bold mb-6">User Registration</h2>
        </div>

        <!-- Registration Form -->
        <div>
            <form method="POST" action="{{ route('register') }}">
                {{csrf_field()}}
                <div class="flex flex-col space-y-6">

                    <!-- Form Fields -->
                    <!-- First Name -->
                    <div>
                        <label class="text-orange-900 font-semibold block">First Name</label>
                        <input 
                            class="rounded w-full mt-2 p-2 border border-yellow-800 block"
                            type="text" 
                            name="first_name"
                            value="{{ old('first_name') }}"
                            required
                            placeholder="Enter your first name"
                        >
                        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                    </div>

                    <!-- Surname -->
                    <div>
                        <label class="text-orange-900 font-semibold block">Surname</label>
                        <input 
                            class="rounded w-full mt-2 p-2 border border-yellow-800 block"
                            type="text" 
                            name="surname"
                            value="{{ old('surname') }}"
                            required
                            placeholder="Enter surname"
                        >
                        <x-input-error :messages="$errors->get('surname')" class="mt-2" />
                    </div>
                    
                    <!-- Username -->
                    <div>
                        <label class="text-orange-900 font-semibold block">Username</label>
                        <input 
                            class="rounded w-full mt-2 p-2 border border-yellow-800 block"
                            type="text" 
                            name="username"
                            value="{{ old('username') }}"
                            required
                            placeholder="Enter username or email address"
                        >
                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label class="text-orange-900 font-semibold block">Email Address</label>
                        <input 
                            class="rounded w-full mt-2 p-2 border border-yellow-800 block"
                            type="text" 
                            name="email"
                            value="{{ old('email') }}"
                            required
                            placeholder="Enter email address"
                        >
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    
                    <!-- Password -->
                    <div>
                        <label class="text-orange-900 font-semibold block">Password</label>
                        <input 
                            class="rounded w-full text-black mt-2 p-2 border border-yellow-800 block"
                            type="password" 
                            name="password"
                            required
                            placeholder="Enter password"
                        >
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="text-orange-900 font-semibold block">Confirm Password</label>
                        <input 
                            class="rounded w-full text-black mt-2 p-2 border border-yellow-800 block"
                            type="password" 
                            name="password_confirmation"
                            required
                            placeholder="Confirm password"
                        >
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-evenly mt-6">
                        <input 
                            class="bg-amber-700 text-black px-4 py-2 rounded hover:bg-rose-700 cursor-pointer"
                            type="submit" 
                            name="submit" 
                            value="Register"
                        >
                        <input 
                            class="bg-stone-500 text-white px-4 py-2 rounded hover:bg-rose-700 cursor-pointer"
                            type="reset" 
                            name="reset" 
                            value="Reset">
                    </div>

                    <!-- Signin Link -->
                    <div class="text-center mt-6">
                        <span class="text-stone-700">Click here to </span>
                        <a class="text-orange-900 font-semibold hover:underline" href="{{ route('signin') }}">Sign in</a>
                    </div>

                </div>

            </form>

        </div>

    </main>
@endsection
