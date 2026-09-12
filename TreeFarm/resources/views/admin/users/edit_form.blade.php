@extends('layouts.app')

@section('title')
    Edit a User
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Update an existing User</h2>

    <!-- Back to Index Button  -->
    <x-back-controller route='users.index' label='Back to Users Page' />
    
    <!-- ========================= -->
    <!-- Update Form -->
    <!-- ========================= -->
    <form method="POST" action="{{ route('users.update', $user->id) }}" class="mt-6">
        @csrf
        {{ method_field('PUT') }}
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

            <!-- First Name  -->
            <label class="block text-green-900 font-semibold mb-2">First Name</label>
            <input 
                type="text" 
                name="first_name" 
                class="border border-yellow-800 rounded p-2 w-64"
                value="{{ old('first_name', $user->first_name) }}"
                required
            >

            <!-- Surname  -->
            <label class="block text-green-900 font-semibold mb-2">Surname</label>
            <input 
                type="text" 
                name="surname" 
                class="border border-yellow-800 rounded p-2 w-64"
                value="{{ old('surname', $user->last_name) }}"
                required
            >

            <!-- Job Title  -->
            <label class="block text-green-900 font-semibold mb-2">Job Title</label>
            <input 
                type="text" 
                name="job_title" 
                class="border border-yellow-800 rounded p-2 w-64"
                value="{{ old('job_title', $user->job_title) }}"
                required
            >

            <!-- Email Address  -->
            <label class="block text-green-900 font-semibold mb-2">Email Address</label>
            <input 
                type="text" 
                name="email" 
                class="border border-yellow-800 rounded p-2 w-64"
                value="{{ old('email', $user->email) }}"
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
                        {{ old('manager_id', $user->manager_id) == $manager->id ? 'selected' : '' }}
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
                            {{ $user->roles->contains($role->id) ? 'checked' : '' }}
                        >
                        <span>{{ $role->name }}</span>
                    </label>
                @endforeach

            </div>

            <!-- Change User's Password  -->
            <div class="mt-6 space-y-4 bg-yellow-100 p-6 rounded border border-yellow-800">

                <label class="text-orange-900 font-semibold block">
                    Use the following field to change {{ $user->first_name }}'s password
                </label>

                <div>
                    <label class="block text-green-900 font-semibold mb-2">Password</label>
                    <input 
                        class="rounded w-full text-black mt-2 p-2 border border-yellow-800 block"
                        type="password" 
                        name="password"
                        placeholder="Enter password"
                    >
                </div>
                
            </div>
            
        </div>

        <!-- Button  -->
        <x-button-admin type="submit" value="Update User" />

    </form>

@endsection
