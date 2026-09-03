
@extends('layouts.master')

@section('title')
    {{ $farmName }} Forgot Password
@endsection

@section('body')

    <main class="max-w-md mx-auto mt-10 p-8">

        <h2 class="text-4xl text-rose-700 text-center font-bold mb-6">
            Reset Your Password
        </h2>

        <!-- Status Message -->
        @if (session('status'))
            <div class="bg-amber-200 text-orange-900 p-4 rounded mb-4 border border-amber-600 shadow-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <label class="text-orange-900 font-semibold block">Email Address</label>
            <input 
                class="rounded w-full mt-2 p-2 border border-yellow-800 block"
                type="email"
                name="email"
                required
                autofocus
            >
            <x-input-error :messages="$errors->get('email')" class="mt-2" />

            <div class="flex justify-center mt-6">
                <button 
                    class="bg-amber-700 text-black px-4 py-2 rounded hover:bg-rose-700 cursor-pointer"
                    type="submit"
                >
                    Send Reset Link
                </button>
            </div>
        </form>

    </main>

@endsection
