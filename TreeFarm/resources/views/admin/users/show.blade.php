@extends('layouts.app')

@section('title')
    View a User
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">View a User Record</h2>

    <!-- Back to Index Button  -->
    <x-back-controller route='users.index' label='Back to Users Page' />

    <!-- Create/Update Success Message  -->
    @if(session('success'))
        <div class="bg-amber-200 text-orange-900 p-4 rounded mb-4 border border-amber-600 shadow-sm">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- ========================= -->
    <!-- Show Details -->
    <!-- ========================= -->

    <div class="flex flex-col space-y-4 bg-yellow-100 p-6 rounded border border-yellow-800 max-w-xl">
        <!-- First Name  -->
        <div>
            <label class="block text-green-900 font-semibold block">First Name</label>
            <label class="text-black block">{{ $user->first_name }}</label>
        </div>
        <!-- Surname  -->
        <div>
            <label class="block text-green-900 font-semibold block">Surname</label>
            <label class="text-black block">{{ $user->last_name }}</label>
        </div>
        <!-- Username  -->
        <div>
            <label class="block text-green-900 font-semibold block">Username</label>
            <label class="text-black block">{{ $user->username }}</label>
        </div>
        <!-- Job Title  -->
        <div>
            <label class="block text-green-900 font-semibold block">Job Title</label>
            <label class="text-black block">{{ $user->job_title }}</label>
        </div>
        <!-- Email Address  -->
        <div>
            <label class="block text-green-900 font-semibold block">Email Address</label>
            <label class="text-black block">{{ $user->email }}</label>
        </div>
        <!-- Manager  -->
        <div>
            <label class="block text-green-900 font-semibold block">Manager</label>
            @if ($user->manager)
                <label class="text-black block">{{ $user->manager->last_name }}, {{ $user->manager->first_name }}</label>
            @else
                <label class="text-black block"></label>
            @endif
        </div>
        <!-- Roles  -->
        <div>
            <label class="block text-green-900 font-semibold block">Roles</label>
            <ul class="list-disc ml-6">
                @foreach ($user->roles as $role)
                    <li>{{ $role->name }}</li>
                @endforeach
            </ul>
        </div>
        
        
    </div>

    <!-- ========================= -->
    <!-- Buttons -->
    <!-- ========================= -->
    
    <div class="flex justify-center gap-24 mt-10 max-w-xl">

        <!-- Update -->
        <a href="{{ route('users.edit', $user->id) }}">
            <x-button-admin type="button" value="Update" />
        </a>

        <!-- Deactivate -->
        @if ($user->status === 'Approved')
            <a href="{{ route('users.deactivate', $user->id) }}">
                <x-button-admin type="button" value="Deactivate" />
            </a>
        @endif

        <!-- Reactivate -->
        @if ($user->status === 'Inactive')
            <a href="{{ route('users.reactivate', $user->id) }}">
                <x-button-admin type="button" value="Reactivate" />
            </a>
        @endif

    </div>


@endsection
