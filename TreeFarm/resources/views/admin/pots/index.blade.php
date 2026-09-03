
@extends('layouts.app')

@section('title')
    Pots
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Pots reference data, {{ auth()->user()->first_name }}</h2>

    <!-- Back to Admin Menu Button  -->
    <x-back-admin />

    <!-- Page text  -->
    <p class="mt-4 text-stone-700">
        Below are the current Pot sizes.
    </p>

    <!-- Update Success Message  -->
    @if(session('success'))
        <div class="bg-amber-200 text-orange-900 p-4 rounded mb-4 mt-4 border border-amber-600 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- ========================= -->
    <!-- Pot Sizes (Basic Table) -->
    <!-- ========================= -->
    

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Pot Sizes</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update" value="Update" />
            <a href="{{ route('pot_sizes.create') }}">
                <x-button-admin type="button" name="add" value="Add" />
            </a>
            <x-button-admin type="submit" name="delete" value="Delete" />
        </div>
        
    </div>

    @php
        // Set the headings to be displayed
        $potSizeHeadings = ['Select', 'Size'];

        // Initialise an empty array for the rows
        $potSizeRows = [];

        // For each pot in pot_sizes
        foreach ($pot_sizes as $pot)
            {
                // Add the contents of the size variable to the table
                $potSizeRows[] = [
                    $pot->id, 
                    $pot->size
                ];
            }

        // Hide No Columns
        $hideColumns = [];

    @endphp

    <x-table-basic 
        :headings="$potSizeHeadings" 
        :rows="$potSizeRows"
        tbodyId="pot_size_table_body"
        :paginate="false"
    />

    <!-- ========================= -->
    <!-- Import Scripts -->
    <!-- ========================= -->
    @push('scripts')
        <script>

            const potSizesEditRoute = "{{ route('pot_sizes.edit', ':id') }}";
            const potSizesDeleteRoute = "{{ route('pot_sizes.delete_confirm', ':id') }}";

        </script>
        <script src="{{ asset('js/table_helpers.js') }}"></script>
        <script src="{{ asset('js/admin/pots.js') }}"></script>
    @endpush
    
@endsection
