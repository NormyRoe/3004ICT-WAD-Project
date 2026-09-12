@extends('layouts.app')

@section('title')
    Add User
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Add a New User</h2>

    <!-- Back to Index Button  -->
    <x-back-controller route='users.index' label='Back to Users Page' />
    
    <!-- ========================= -->
    <!-- Creation Form -->
    <!-- ========================= -->
    <form action="{{ route('users.store') }}" method="POST" class="mt-6">
        @csrf

        <div class="mb-4">

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

            <!-- Plant ID  -->
            <!-- First Name  -->
            <label class="block text-green-900 font-semibold mb-2">First Name</label>
            <input 
                type="text" 
                name="first_name" 
                class="border border-yellow-800 rounded p-2 w-64"
                value="{{ old('first_name') }}"
                required
            >

            <!-- Surname  -->
            <label class="block text-green-900 font-semibold mb-2">Surname</label>
            <input 
                type="text" 
                name="surname" 
                class="border border-yellow-800 rounded p-2 w-64"
                value="{{ old('surname') }}"
                required
            >

            <!-- Job Title  -->
            <label class="block text-green-900 font-semibold mb-2">Job Title</label>
            <input 
                type="text" 
                name="job_title" 
                class="border border-yellow-800 rounded p-2 w-64"
                value="{{ old('job_title') }}"
                required
            >

            <!-- Username  -->
            <label class="block text-green-900 font-semibold mb-2">Username</label>
            <input 
                type="text" 
                name="username" 
                class="border border-yellow-800 rounded p-2 w-64"
                value="{{ old('username') }}"
                required
            >

            <!-- Email Address  -->
            <label class="block text-green-900 font-semibold mb-2">Email Address</label>
            <input 
                type="text" 
                name="email" 
                class="border border-yellow-800 rounded p-2 w-64"
                value="{{ old('email') }}"
                required
            >

            <!-- Manager  -->
            <label class="block text-green-900 font-semibold mb-2">Manager</label>
            <select 
                name="manager_id"
                class="p-2 border border-yellow-800 rounded text-xs md:text-sm"
            >

                <!-- Empty option -->
                <option value=""></option>

                <!-- Distinct values -->
                @foreach ($managers as $manager)
                    <option 
                        value="{{ $manager->id }}"
                        {{ old('manager_id') == $manager->id ? 'selected' : '' }}
                    >
                        {{ $manager->last_name }}, {{ $manager->first_name }}
                    </option>
                @endforeach

            </select>

            <!-- Roles (Multiple Selection)  -->
            <div class="mt-6 space-y-4">
                <label class="block text-green-900 font-semibold mb-2">Roles</label>
                
                @foreach ($roles as $role)
                    <label class="flex items-center gap-3">                    
                        <input 
                            type="checkbox" 
                            name="roles[]" 
                            value="{{ $role->id }}" 
                            class="form-checkbox"
                        >
                        <span>{{ $role->name }}</span>
                    </label>
                @endforeach

            </div>

            <!-- Password  -->
            <div>
                <label class="block text-green-900 font-semibold mt-4">Password</label>
                <input 
                    class="rounded text-black mt-2 p-2 border border-yellow-800 block"
                    type="password" 
                    name="password"
                    placeholder="Enter password"
                    required
                >
            </div>
            
        </div>

        <!-- Button  -->
        <div class="flex mt-12 justify-center max-w-xl">
            <x-button-admin type="submit" value="Add User" />
        </div>

    </form>

@endsection
