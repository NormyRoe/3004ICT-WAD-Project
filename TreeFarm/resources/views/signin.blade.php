
@extends('layouts.master')

@section('title')
    {{ $farmName }} Signin
@endsection


@section('body')
    <!-- Main Layout -->
    <main class="max-w-md mx-auto mt-10 p-8">
        
        <!-- Login Form Title -->
        <div>
            <h2 class="text-4xl text-rose-700 text-center font-bold mb-6">User Login</h2>
        </div>

        <!-- Registration Success Message  -->
        @if (session('status'))
            <div class="bg-amber-200 text-orange-900 p-4 rounded mb-4 border border-amber-600 shadow-sm">
                {{ session('status') }}
            </div>
        @endif

        <!-- Login Form -->
        <div>
            <form method="POST" action="{{ route('login') }}">
                {{csrf_field()}}
                <div class="flex flex-col space-y-6">

                    <!-- Form Fields -->
                    <div>
                        <label class="text-orange-900 font-semibold block">Username or Email Address</label>
                        <input 
                            class="rounded w-full mt-2 p-2 border border-yellow-800 block"
                            type="text" 
                            name="login"
                            required
                            placeholder="Enter username or email address"
                        >
                        <x-input-error :messages="$errors->get('login')" class="mt-2" />
                    </div>

                    <div>
                        <label class="text-orange-900 font-semibold mt-4 block">Password</label>
                        <input 
                            class="rounded text-black mt-2 p-2 border border-yellow-800 block"
                            type="password" 
                            name="password"
                            required
                            placeholder="Enter password"
                        >
                        <x-input-error :messages="$errors->get('password')" class="mt-2" /><br>

                        <!-- Forgot Password link -->
                        @if (Route::has('password.forgot'))
                            <a class="underline text-sm text-orange-900 font-semibold hover:bg-stone-500 hover:text-white" 
                                href="{{ route('password.forgot') }}"
                            >
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

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
                        <a class="text-orange-900 font-semibold hover:underline" href="{{ route('register') }}">Register</a>
                    </div>

                </div>

            </form>

        </div>

    </main>
@endsection
