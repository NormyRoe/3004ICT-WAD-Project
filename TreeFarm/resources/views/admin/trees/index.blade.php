
@extends('layouts.app')

@section('title')
    Trees
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Welcome to the Trees reference data, {{ $name }}</h2>

    <!-- Back to Admin Menu Button  -->
    <x-back-admin />

    <!-- Page text  -->
    <p class="mt-4 text-stone-700">
        Below are the current Tree Types and Tree details.
    </p>

    <!-- Update Success Message  -->
    @if(session('success'))
        <div class="bg-amber-200 text-orange-900 p-4 rounded mb-4 mt-4 border border-amber-600 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- ========================= -->
    <!-- Tree Types (Basic Table with Total) -->
    <!-- ========================= -->
    

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Tree Types</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="update_type" value="Update" />
            <x-button-admin type="submit" name="add_type" value="Add" />
            <x-button-admin type="submit" name="delete_type" value="Delete" />
        </div>
        
    </div>

    @php

        // Set the headings to be displayed
        $treeTypeHeadings = ['Select', 'Type'];

        // Initialise an empty array for the rows
        $treeTypeRows = [];

        // For each type in tree_types
        foreach ($tree_types as $type)
            {
                // Add the contents of the name variable to the table
                $treeTypeRows[] = [
                    $type->id, 
                    $type->name
                ];
            }

        // Hide No Columns
        $hideColumns = [];

    @endphp

    <x-table-basic-total 
        :headings="$treeTypeHeadings" 
        :rows="$treeTypeRows"
        :sumColumn=null
        tbodyId="tree_type_table_body"
    />
    

    <!-- ========================= -->
    <!-- Trees (Filtering Table with Total) -->
    <!-- ========================= -->

    <!-- Label and Buttons -->
    <div class="flex justify-between items-center mt-10">
        <h3 class="text-2xl font-bold text-green-900">Trees</h3>
        <div class="flex gap-4">
            <x-button-admin type="submit" name="view_tree" value="View" />
            <x-button-admin type="submit" name="update_tree" value="Update" />
            <x-button-admin type="submit" name="add_tree" value="Add" />
            <x-button-admin type="submit" name="delete_tree" value="Delete" />
        </div>
        
    </div>
    

    @php

        // Set the headings to be displayed
        $treeHeadings = [
            'Select',
            "Plant I.D.",
            "Type",
            "Botanical Name",
            "Common Name",
            "Mature Height Min",
            "Mature Height Max",
            "Mature Width Min",
            "Mature Width Max"
        ];

        // Initialise an empty array for the rows
        $treeRows = [];

        // For each tree in trees
        foreach ($trees as $tree)
            {
                // Add the contents of the name variable to the table
                $treeRows[] = [
                    $tree->id, 
                    $tree->plant_id,
                    $tree->tree_type->name,
                    $tree->botanical_name,
                    $tree->common_name,
                    $tree->mature_height_min,
                    $tree->mature_height_max,
                    $tree->mature_width_min,
                    $tree->mature_width_max,
                ];
            }

        // Hide Botanical Name, Height and Width on small screens
        $hideColumns = [3, 5, 6, 7, 8];

    @endphp

    <x-table-filter
        :headings="$treeHeadings" 
        :rows="$treeRows"
        :hideColumns="$hideColumns"
        :filterColumns="[2, 5, 6, 7, 8]"
        :showTotals="true"
        :sumColumn=null
        tbodyId="tree_table_body"
    />

    <!-- ========================= -->
    <!-- AJAX Scripts -->
    <!-- ========================= -->
    <script>

        /******************************************************************
        * refresh_tree_types()
        * ------------------
        * Fetches the latest Tree Types from the database (via JSON route)
        * and rebuilds the <tbody> contents dynamically.
        *
        * This keeps the table up-to-date without reloading the page.
        *******************************************************************/
        function refresh_tree_types() {

            // Fetch the current database data
            fetch("{{ route('tree_types.json') }}")
                .then(response => response.json())
                .then(data => {

                    // Get the table body
                    const tbody = document.getElementById("tree_type_table_body");

                    // Clear existing rows
                    tbody.innerHTML = "";

                    // Rebuild each row
                    data.forEach(type => {

                        const row = document.createElement("tr");
                        row.classList.add("hover:bg-amber-200");

                        // Radio button column (for selecting a row)
                        const radioCell = `

                            <td class="px-2 py-1 border border-yellow-800 text-center w-12">
                                <input 
                                    type="radio" 
                                    name="selected_type" 
                                    value="${type.id}" 
                                    class="select-row"
                                >
                            </td>
                        `;

                        // Hidden ID column (index 0)
                        const hiddenIdCell = `<td class="hidden"></td>`;

                        // Name column
                        const nameCell = `
                            <td class="px-4 py-2 border border-yellow-800">
                                ${type.name}
                            </td>
                        `;

                        // Build the row HTML
                        row.innerHTML = radioCell + hiddenIdCell + nameCell;

                        // Add row to table
                        tbody.appendChild(row);

                    });
                })
                .catch(error => console.error("Error refreshing tree types:", error));

        }

        // Refresh every 5 seconds
        setInterval(refresh_tree_types, 5000);


        /******************************************************************
        * refresh_trees()
        * ------------------
        * Fetches the latest Trees from the database (via JSON route)
        * and rebuilds the <tbody> contents dynamically.
        *
        * This keeps the table up-to-date without reloading the page.
        *******************************************************************/
        function refresh_trees() {

            // Fetch the current database data
            fetch("{{ route('trees.json') }}")
                .then(response => response.json())
                .then(data => {

                    // Get the table body
                    const tbody = document.getElementById("tree_table_body");

                    // Clear existing rows
                    tbody.innerHTML = "";

                    // Rebuild each row
                    data.forEach(tree => {

                        const row = document.createElement("tr");
                        row.classList.add("hover:bg-amber-200");

                        // Radio button column (for selecting a row)
                        const radioCell = `

                            <td class="px-2 py-1 border border-yellow-800 text-center w-12">
                                <input 
                                    type="radio" 
                                    name="selected_tree" 
                                    value="${tree.id}" 
                                    class="select-row"
                                >
                            </td>
                        `;

                        // Hidden ID column (index 0)
                        const hiddenIdCell = `<td class="hidden"></td>`;

                        // Other columns
                        const otherCell = `
                            <td class="px-4 py-2 border border-yellow-800">
                                ${tree.plant_id}
                            </td>
                            <td class="px-4 py-2 border border-yellow-800">
                                ${tree.tree_type.name}
                            </td>
                            <td class="px-4 py-2 border border-yellow-800">
                                ${tree.botanical_name}
                            </td>
                            <td class="px-4 py-2 border border-yellow-800">
                                ${tree.common_name}
                            </td>
                            <td class="px-4 py-2 border border-yellow-800">
                                ${tree.mature_height_min}
                            </td>
                            <td class="px-4 py-2 border border-yellow-800">
                                ${tree.mature_height_max}
                            </td>
                            <td class="px-4 py-2 border border-yellow-800">
                                ${tree.mature_width_min}
                            </td>
                            <td class="px-4 py-2 border border-yellow-800">
                                ${tree.mature_width_max}
                            </td>
                        `;

                        // Build the row HTML
                        row.innerHTML = radioCell + hiddenIdCell + otherCell;

                        // Add row to table
                        tbody.appendChild(row);

                    });
                })
                .catch(error => console.error("Error refreshing trees:", error));

        }

        // Refresh every 5 seconds
        setInterval(refresh_trees, 5000);

        /******************************************************************
        * get_selected_tree_type_id()
        * -------------------
        * Returns the ID of the currently selected tree type (radio button).
        * If no row is selected, returns null.
        ********************************************************************/
        function get_selected_tree_type_id() {
            const selected = document.querySelector('input[name="selected_type"]:checked');
            return selected ? selected.value : null;
        }

        /******************************************************************
        * get_selected_tree_id()
        * -------------------
        * Returns the ID of the currently selected tree (radio button).
        * If no row is selected, returns null.
        ********************************************************************/
        function get_selected_tree_id() {
            const selected = document.querySelector('input[name="selected_tree"]:checked');
            return selected ? selected.value : null;
        }

        /******************************************************************
        * Update button handler for Tree Types
        * ----------------------
        * Redirects to the edit page for the selected Tree Type.
        *******************************************************************/    
        document.querySelector('input[name="update_type"]').addEventListener('click', function () {
            const id = get_selected_tree_type_id();

            if (!id) {
                alert("Please select a tree type to update.");
                return;
            }

            window.location.href = "{{ route('tree_types.edit', ':id') }}".replace(':id', id);

        });
    
        /******************************************************************
        * Delete button handler for Tree Types
        * ----------------------
        * Redirects to the delete confirmation page for the selected Tree Type.
        ******************************************************************/
        document.querySelector('input[name="delete_type"]').addEventListener('click', function () {
            const id = get_selected_tree_type_id();

            if (!id) {
                alert("Please select a tree type to delete.");
                return;
            }

            window.location.href = "{{ route('tree_types.delete_confirm', ':id') }}".replace(':id', id);
        });


        /******************************************************************
        * View button handler for Trees
        * ----------------------
        * Redirects to the show page for the selected Tree.
        *******************************************************************/
        document.querySelector('input[name="view_tree"]').addEventListener('click', function () {
            const id = get_selected_tree_id();

            if (!id) {
                alert("Please select a tree to view.");
                return;
            }

            window.location.href = "{{ route('trees.show', ':id') }}".replace(':id', id);

        });

        /******************************************************************
        * Update button handler for Trees
        * ----------------------
        * Redirects to the edit page for the selected Tree.
        *******************************************************************/
        document.querySelector('input[name="update_tree"]').addEventListener('click', function () {
            const id = get_selected_tree_id();

            if (!id) {
                alert("Please select a tree to update.");
                return;
            }

            window.location.href = "{{ route('trees.edit', ':id') }}".replace(':id', id);

        });


        /******************************************************************
        * Delete button handler for Trees
        * ----------------------
        * Redirects to the delete confirmation page for the selected Tree.
        ******************************************************************/
        document.querySelector('input[name="delete_tree"]').addEventListener('click', function () {
            const id = get_selected_tree_id();

            if (!id) {
                alert("Please select a tree to delete.");
                return;
            }

            window.location.href = "{{ route('trees.delete_confirm', ':id') }}".replace(':id', id);
        });

    </script>

@endsection

