@extends('layouts.app')

@section('title')
    Approval
@endsection


@section('content')

    <h2 class="text-3xl font-bold text-green-900">
        Assign a Job Title, Manager and Roles to {{ $user->first_name }} {{ $user->last_name }}
    </h2>

    <!-- Back to Index Button  -->
    <x-back-controller route='users.index' label='Back to Users Page' />

    <!-- ========================= -->
    <!-- Assign Roles Form -->
    <!-- ========================= -->
        
    <form method="POST" action="{{ route('users.approve', $user->id) }}">
        @csrf

        <!-- Page text  -->
        <p class="mt-4 text-stone-700">
            Select one or more roles to assign to this user before approval.
        </p>
        <p class="mt-4 mb-4 text-stone-700">
            If the user has a manager, please select who the manager is.
        </p>

        <!-- Job Title  -->
        <label class="block text-green-900 font-semibold mb-2">{{ $user->first_name }}'s Job Title</label>
        <input 
            type="text" 
            name="job_title" 
            class="border border-yellow-800 rounded p-2 w-64"
            value="{{ old('job_title') }}"
            required
        >

        <!-- Manager  --> 
        <label class="block text-green-900 font-semibold mb-2">{{ $user->first_name }}'s Manager</label>
        <select 
            name="manager_id"
            class="p-2 border border-yellow-800 rounded text-xs md:text-sm"
        >
            <!-- Empty option (deselect filter) -->
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
            <label class="block text-green-900 font-semibold mb-2">{{ $user->first_name }}'s Roles</label>
            
            @foreach ($roles as $role)
                <label class="flex items-center gap-3">                    
                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="form-checkbox">
                    <span>{{ $role->name }}</span>
                </label>
            @endforeach

        </div>

        <!-- Error Message  -->
        @if (count($errors) > 0)
            <div class="text-red-600 text-sm mt-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Button  -->
        <x-button-admin type="submit" value="Confirm Approval" class="mt-6" />

    </form>

@endsection
