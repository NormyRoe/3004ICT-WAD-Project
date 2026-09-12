
@extends('layouts.app')

@section('title')
    Profile
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Profile page, {{ auth()->user()->first_name }}</h2>

    <p class="mt-4 text-stone-700">
        Here are the current details of your profile.  Use the form to update your username, email address and/or password.
    </p><br>

    <!-- Update Success Message  -->
    @if(session('success'))
        <div class="bg-amber-200 text-orange-900 p-4 rounded mb-4 mt-4 border border-amber-600 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Update Reject Message  -->
    @if(session('reject'))
        <div class="bg-amber-200 text-orange-900 p-4 rounded mb-4 mt-4 border border-amber-600 shadow-sm">
            {{ session('reject') }}
        </div>
    @endif

    <!-- Blocked Message  -->
    @if(isset($blocked))
        <div class="bg-amber-200 text-orange-900 p-4 rounded mb-4 mt-4 border border-amber-600 shadow-sm">
            {{ $blocked }}
        </div>
    @endif

    <!-- ========================= -->
    <!-- Current Profile Details -->
    <!-- ========================= -->
    <div class="flex flex-row gap-x-20">   

        <div class="flex flex-col space-y-4 bg-yellow-100 p-6 rounded border border-yellow-800">

            <!-- First Name  -->
            <div>
                <label class="text-orange-900 font-semibold block">First Name</label>
                <label class="text-black block">{{ $user->first_name }}</label>
            </div>

            <!-- Surname  -->
            <div>
                <label class="text-orange-900 font-semibold block">Surname</label>
                <label class="text-black block">{{ $user->last_name }}</label>
            </div>

            <!-- Username  -->
            <div>
                <label class="text-orange-900 font-semibold block">Username</label>
                <label class="text-black block">{{ $user->username }}</label>
            </div>

            <!-- Job Title  -->
            <div>
                <label class="text-orange-900 font-semibold block">Job Title</label>
                <label class="text-black block">{{ $user->job_title }}</label>
            </div>

            <!-- Email Address  -->
            <div>
                <label class="text-orange-900 font-semibold block">Email Address</label>
                <label class="text-black block">{{ $user->email }}</label>
            </div>

            <!-- Manager  -->
            <div>
                <label class="text-orange-900 font-semibold block">Manager</label>
                @if ($user->manager)
                    <label class="text-black block">{{ $user->manager->last_name }}, {{ $user->manager->first_name }}</label>
                @else
                    <label class="text-black block"></label>
                @endif
            </div>

            <!-- Roles  -->
            <div>
                <label class="text-orange-900 font-semibold block">Roles</label>
                <ul class="list-disc ml-6">
                    @foreach ($user->roles as $role)
                        <li>{{ $role->name }}</li>
                    @endforeach
                </ul>
            </div>

        </div>

        <!-- ========================= -->
        <!-- Update Profile Form -->
        <!-- ========================= -->         
        <div class="flex flex-col space-y-6">

            <form method="POST" action="{{ route('user_profile.update', $user->id) }}" class="mt-6">
                {{csrf_field()}}

                <!-- Error Message  -->
                @if (count($errors) > 0)
                    <div class="text-red-600 text-sm mt-1 mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Username -->
                <div>
                    <label class="text-orange-900 font-semibold block">Username</label>
                    <input 
                        class="rounded w-full mt-2 p-2 border border-yellow-800 block"
                        type="text" 
                        name="username"
                        placeholder="Enter username or email address"
                    >
                </div>
                
                <!-- Email Address -->
                <div>
                    <label class="text-orange-900 font-semibold block">Email Address</label>
                    <input 
                        class="rounded w-full mt-2 p-2 border border-yellow-800 block"
                        type="text" 
                        name="email"
                        placeholder="Enter email address"
                    >
                </div>
                
                <!-- Password -->
                <div>
                    <label class="text-orange-900 font-semibold mt-4 block">Password</label>
                    <input 
                        class="rounded text-black mt-2 p-2 border border-yellow-800 block"
                        type="password" 
                        name="password"
                        placeholder="Enter password"
                    >
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="text-orange-900 font-semibold mt-4 block">Confirm Password</label>
                    <input 
                        class="rounded text-black mt-2 p-2 border border-yellow-800 block"
                        type="password" 
                        name="password_confirmation"
                        placeholder="Confirm password"
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
