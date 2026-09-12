
@extends('layouts.app')

@section('title')
    Users
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Users data, {{ auth()->user()->first_name }}</h2>

    <!-- Back to Admin Menu Button  -->
    <x-back-admin />

    <!-- Page text  -->
    <p class="mt-4 text-stone-700">
        Below are the Users Awaiting Approval, the Current Users and the Deactivated Users (which includes any that were rejected).
    </p>

    <!-- Update Success Message  -->
    @if(session('success'))
        <div class="bg-amber-200 text-orange-900 p-4 rounded mb-4 mt-4 border border-amber-600 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- ========================= -->
    <!-- Users Awaiting Approval (Basic Table with Total) -->
    <!-- ========================= -->
    

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Users Awaiting Approval</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="approve_user" value="Approve" />
            <x-button-admin type="submit" name="reject_user" value="Reject" />
        </div>
        
    </div>

    @php

        // Set the headings to be displayed
        $usersForApprovalHeadings = [
            'Select',
            'First Name',
            'Surname',
            'Username',
            'Email',
        ];

        // Initialise an empty array for the rows
        $usersForApprovalRows = [];

        // For each user in awaiting_approvals
        foreach ($awaiting_approvals as $user)
            {
                // Add the contents of the name variable to the table
                $usersForApprovalRows[] = [
                    $user->id, 
                    $user->first_name,
                    $user->last_name,
                    $user->username,
                    $user->email
                ];
            }

        // Hide No Columns
        $hideColumns = [];

    @endphp

    <x-table-basic-total 
        :headings="$usersForApprovalHeadings" 
        :rows="$usersForApprovalRows"
        :sumColumn=null
        tbodyId="for_approval_table_body"
        :paginate="false"
    />


    <!-- ========================= -->
    <!-- Current Users (Filtering Table with Total) -->
    <!-- ========================= -->

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Current Users</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update_current_user" value="Update" />
            <a href="{{ route('users.create') }}">
                <x-button-admin type="submit" name="add_current_user" value="Add" />
            </a>            
            <x-button-admin type="submit" name="view_current_user" value="View" />
            <x-button-admin type="submit" name="deactivate_user" value="Deactivate" />
        </div>
        
    </div>
    

    @php

        // Set the headings to be displayed
        $currentUserHeadings = [
            'Select',
            'First Name',
            'Surname',
            'Username',
            'Email',
            'Job Title',
        ];

        // Initialise an empty array for the rows
        $currentUserRows = [];

        // For each user in current_users
        foreach ($current_users as $user)
            {
                // Add the contents of the name variable to the table
                $currentUserRows[] = [
                    $user->id, 
                    $user->first_name,
                    $user->last_name,
                    $user->username,
                    $user->email,
                    $user->job_title,
                ];
            }

        // Hide Columns on small screens
        $hideColumns = [4, 5];

    @endphp

    <x-table-filter
        :headings="$currentUserHeadings" 
        :rows="$currentUserRows"
        :hideColumns="$hideColumns"
        :filterColumns="[2, 5]"
        :showTotals="true"
        :sumColumn=null
        tbodyId="current_users_table_body"
        :paginate="true"
    />

    <!-- ========================= -->
    <!-- Deactivated Users (Filtering Table with Total) -->
    <!-- ========================= -->

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Deactivated Users</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="view_old_user" value="View" />
            <x-button-admin type="submit" name="reactivate_user" value="Reactivate" />
        </div>
        
    </div>
    

    @php

        // Set the headings to be displayed
        $deactivatedUserHeadings = [
            'Select',
            'First Name',
            'Surname',
            'Username',
            'Email',
            'Job Title',
        ];

        // Initialise an empty array for the rows
        $deactivatedUserRows = [];

        // For each user in deactivated_users
        foreach ($deactivated_users as $user)
            {
                // Add the contents of the name variable to the table
                $deactivatedUserRows[] = [
                    $user->id, 
                    $user->first_name,
                    $user->last_name,
                    $user->username,
                    $user->email,
                    $user->job_title,
                ];
            }

        // Hide Columns on small screens
        $hideColumns = [4, 5];

    @endphp

    <x-table-filter
        :headings="$deactivatedUserHeadings" 
        :rows="$deactivatedUserRows"
        :hideColumns="$hideColumns"
        :filterColumns="[2, 5]"
        :showTotals="true"
        :sumColumn=null
        tbodyId="deactivated_users_table_body"
        :paginate="true"
    />

    <!-- ========================= -->
    <!-- Import Scripts -->
    <!-- ========================= -->
    @push('scripts')

        <script>

            const approveUserRoute = "{{ route('users.approval', ':id') }}";
            const rejectUserRoute = "{{ route('users.reject', ':id') }}";

            const currentUserEditRoute = "{{ route('users.edit', ':id') }}";
            const currentUserShowRoute = "{{ route('users.show', ':id') }}";
            const deactivateUserRoute = "{{ route('users.deactivate', ':id') }}";
            
            const oldUserShowRoute = "{{ route('users.show', ':id') }}";
            const reactivateUserRoute = "{{ route('users.reactivate', ':id') }}";

        </script>
        <script src="{{ asset('js/table_helpers.js') }}"></script>
        <script src="{{ asset('js/admin/users.js') }}"></script>

    @endpush
    
@endsection
