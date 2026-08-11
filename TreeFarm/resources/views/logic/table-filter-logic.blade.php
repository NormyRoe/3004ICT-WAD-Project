
@php
    /*
    |--------------------------------------------------------------------------
    | Build distinct filter values for each filter column
    |--------------------------------------------------------------------------
    */
    $filterValuesLocal = [];

    foreach ($filterColumns as $colIndex) {
        $filterValuesLocal[$colIndex] = collect($rows)
            ->pluck($colIndex)
            ->unique()
            ->sort()
            ->values()
            ->toArray();
    }

    /*
    |--------------------------------------------------------------------------
    | Read selected filter values from GET parameters
    |--------------------------------------------------------------------------
    */
    $selectedFiltersLocal = [];

    foreach ($filterColumns as $colIndex) {
        $selectedFiltersLocal[$colIndex] = request("filter_$colIndex");
    }

    /*
    |--------------------------------------------------------------------------
    | Apply filtering logic to produce filteredRows
    |--------------------------------------------------------------------------
    */
    $filteredRowsLocal = $rows;

    foreach ($filterColumns as $colIndex) {

        $selected = $selectedFiltersLocal[$colIndex];

        if ($selected !== null && $selected !== '') {
            $filteredRowsLocal = array_filter($filteredRowsLocal, function($row) use ($colIndex, $selected) {
                return $row[$colIndex] == $selected;
            });
        }
    }

@endphp
