
@extends('layouts.app')

@section('title')
    Tasks
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Tasks reference data, {{ auth()->user()->first_name }}</h2>

    <!-- Back to Admin Menu Button  -->
    <x-back-admin />

    <!-- Page text  -->
    <p class="mt-4 text-stone-700">
        Below are the current Tasks list.
    </p>

    <!-- Update Success Message  -->
    @if(session('success'))
        <div class="bg-amber-200 text-orange-900 p-4 rounded mb-4 mt-4 border border-amber-600 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- ========================= -->
    <!-- Tasks (Basic Table) -->
    <!-- ========================= -->
    

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Tasks</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update" value="Update" />
            <a href="{{ route('tasks.create') }}">
                <x-button-admin type="submit" name="add" value="Add" />
            </a>            
            <x-button-admin type="submit" name="delete" value="Delete" />
        </div>
        
    </div>

    @php

        // Set the headings to be displayed
        $taskHeadings = ['Select', 'Task'];

        // Initialise an empty array for the rows
        $taskRows = [];

        // For each task in tasks
        foreach ($tasks as $task)
        {
            // Add the contents to the table
            $taskRows[] = [
                $task->id, 
                $task->name,
            ];
        }

        // Hide No Columns
        $hideColumns = [];

    @endphp

    <x-table-basic 
        :headings="$taskHeadings" 
        :rows="$taskRows"
        tbodyId="task_table_body"
        :paginate="true"
    />
    
    <!-- ========================= -->
    <!-- Import Scripts -->
    <!-- ========================= -->
    @push('scripts')

        <script>

            const tasksEditRoute = "{{ route('tasks.edit', ':id') }}";
            const tasksDeleteRoute = "{{ route('tasks.delete_confirm', ':id') }}";

        </script>
        <script src="{{ asset('js/table_helpers.js') }}"></script>
        <script src="{{ asset('js/admin/tasks.js') }}"></script>

    @endpush

@endsection
