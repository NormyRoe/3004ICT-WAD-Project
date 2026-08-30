
@extends('layouts.app')

@section('title')
    Pots
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Pots reference data, {{ $name }}</h2>

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
    />

    <!-- ========================= -->
    <!-- AJAX Scripts -->
    <!-- ========================= -->
    <script>

        /******************************************************************
        * refresh_pot_sizes()
        * ------------------
        * Fetches the latest Pot Sizes from the database (via JSON route)
        * and rebuilds the <tbody> contents dynamically.
        *
        * This keeps the table up-to-date without reloading the page.
        *******************************************************************/
        function refresh_pot_sizes() {

            // Fetch the current database data
            fetch("{{ route('pot_sizes.json') }}")
                .then(response => response.json())
                .then(data => {

                    // Get the table body
                    const tbody = document.getElementById("pot_size_table_body");

                    // Clear existing rows
                    tbody.innerHTML = "";

                    // Rebuild each row
                    data.forEach(pot => {

                        const row = document.createElement("tr");
                        row.classList.add("hover:bg-amber-200");

                        // Radio button column (for selecting a row)
                        const radioCell = `

                            <td class="px-2 py-1 border border-yellow-800 text-center w-12">
                                <input 
                                    type="radio" 
                                    name="selected_row" 
                                    value="${pot.id}" 
                                    class="select-row"
                                >
                            </td>
                        `;

                        // Hidden ID column (index 0)
                        const hiddenIdCell = `<td class="hidden"></td>`;

                        // Size column
                        const sizeCell = `
                            <td class="px-4 py-2 border border-yellow-800">
                                ${pot.size}
                            </td>
                        `;

                        // Build the row HTML
                        row.innerHTML = radioCell + hiddenIdCell + sizeCell;

                        // Add row to table
                        tbody.appendChild(row);
                    });
                })
                .catch(error => console.error("Error refreshing pot sizes:", error));

        }

        // Refresh every 5 seconds
        setInterval(refresh_pot_sizes, 5000);

        /******************************************************************
        * get_selected_row_id()
        * -------------------
        * Returns the ID of the currently selected row (radio button).
        * If no row is selected, returns null.
        ********************************************************************/
        function get_selected_row_id() {
            const selected = document.querySelector('input[name="selected_row"]:checked');
            return selected ? selected.value : null;
        }

        /******************************************************************
        * Update button handler
        * ----------------------
        * Redirects to the edit page for the selected Pot Size.
        *******************************************************************/
        document.querySelector('input[name="update"]').addEventListener('click', function () {
            const id = get_selected_row_id();

            if (!id) {
                alert("Please select a pot size to update.");
                return;
            }

            window.location.href = "{{ route('pot_sizes.edit', ':id') }}".replace(':id', id);

        });

        /******************************************************************
        * Delete button handler
        * ----------------------
        * Redirects to the delete confirmation page for the selected Pot Size.
        ******************************************************************/
        document.querySelector('input[name="delete"]').addEventListener('click', function () {
            const id = get_selected_row_id();

            if (!id) {
                alert("Please select a pot size to delete.");
                return;
            }

            window.location.href = "{{ route('pot_sizes.delete_confirm', ':id') }}".replace(':id', id);
        });

    </script>
    
@endsection
