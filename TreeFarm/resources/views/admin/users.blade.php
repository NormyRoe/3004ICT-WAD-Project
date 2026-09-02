
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
        Below are the Users Awaiting Approval, and all other Users. These lists are hard-coded for now and will later be replaced with database data.
    </p>

    <!-- ========================= -->
    <!-- Users Awaiting Approval (Basic Table with Total) -->
    <!-- ========================= -->
    

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Users Awaiting Approval</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="approve" value="Approve" />
            <x-button-admin type="submit" name="reject" value="Reject" />
        </div>
        
    </div>

    @php
        $usersForApprovalHeadings = [
            'First_Name',
            'Last_Name',
            'username',
            'Email',
        ];

        $usersForApprovalRows = [
            ["Henry","Smith","hryn","henry@blah.com"],
            ["Lois", "Hammer", "lh4ever","loish@wish.com"],
        ];

        // Hide No Columns
        $hideColumns = [];

    @endphp

    <x-table-basic-total 
        :headings="$usersForApprovalHeadings" 
        :rows="$usersForApprovalRows"
        :sumColumn=null
    />


    <!-- ========================= -->
    <!-- Users (Filtering Table with Total) -->
    <!-- ========================= -->

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Users</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update" value="Update" />
            <x-button-admin type="submit" name="add" value="Add" />
            <x-button-admin type="submit" name="view_roles" value="View Roles" />
            <x-button-admin type="submit" name="deactivate" value="Deactivate" />
        </div>
        
    </div>
    

    @php
        $usersHeadings = [
            'First_Name',
            'Last_Name',
            'username',
            'Email',
            'Job_Title',
            'Status',
        ];

        $usersRows = [
            ["admin","admin","admin_ella","","admin","Active"],
            ["Bob","Brown","bobby","bob@dob.com","Sales Assistant","Active"],
            ["Lucy","Blue","cubl","lucy@dob.com","Operations Assistant","Inactive"],
        ];

        // Hide Columns on small screens
        $hideColumns = [3, 4];

    @endphp

    <x-table-filter
        :headings="$usersHeadings" 
        :rows="$usersRows"
        :hideColumns="$hideColumns"
        :filterColumns="[4, 5]"
        :showTotals="true"
        :sumColumn=null
    />
    
@endsection
