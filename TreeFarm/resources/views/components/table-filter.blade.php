
<!-- Table with filtering and sorting -->
<!-- With responsive behaviour -->

@props([
    'headings',
    'rows',
    'hideColumns' => [],
    'filterColumns' => [],
    'showTotals' => false,
    'sumColumn' => null,
    'tbodyId' => null,
    'paginate' => false,
    
])

<!-- ========================================= -->
<!-- Build filterValues (distinct values per column) -->
<!-- ========================================= -->

@php

    $filterValues = [];

    foreach ($filterColumns as $colIndex) {
        $filterValues[$colIndex] = collect($rows)
            ->pluck($colIndex)
            ->filter(fn($v) => $v !== null && $v !== '')   // remove empty values
            ->unique()
            ->sort()
            ->values()
            ->toArray();
    }

@endphp

<!-- ========================================= -->
<!-- Read selected filter values from GET parameters -->
<!-- ========================================= -->

@php

    $selectedFilters = [];

    foreach ($filterColumns as $colIndex) {
        $selectedFilters[$colIndex] = request("filter_$colIndex");
    }

@endphp

<!-- ========================================= -->
<!-- Apply filtering logic to produce filteredRows -->
<!-- ========================================= -->

@php

    $filteredRows = $rows;

    foreach ($filterColumns as $colIndex) {
        $selected = $selectedFilters[$colIndex];

        if ($selected !== null && $selected !== '') {
            $filteredRows = array_filter($filteredRows, function($row) use ($colIndex, $selected) {
                return $row[$colIndex] == $selected;
            });
        }
    }

    if($paginate)
    {
        $filteredRows = array_values($filteredRows);
    }
        

@endphp

<!-- ========================================= -->
<!-- Expose variables for Scripts -->
<!-- ========================================= -->
<script>

    window["{{ $tbodyId }}_paginate"] = @json($paginate);

    @if($paginate)

        window["{{ $tbodyId }}_data"] = @json($filteredRows);
        window["{{ $tbodyId }}_totalPages"] = Math.ceil({{ count($filteredRows) }} / 15);
        window["{{ $tbodyId }}_hideColumns"] = @json($hideColumns);

    @endif
                
</script>


<!-- ========================================= -->
<!-- Filter UI (dropdowns with labels) -->
<!-- ========================================= -->

<form method="GET">
    <div class="flex flex-wrap gap-6 mb-4 mt-4">

        @foreach ($headings as $index => $heading)
            @if(in_array($index, $filterColumns))

                <div class="flex flex-col">
                    <!-- Label ABOVE the dropdown -->
                    <label class="text-amber-800 font-semibold text-xs md:text-sm mb-1">
                        Filter by {{ $heading }}
                    </label>

                    <!-- Dropdown -->
                    <select 
                        name="filter_{{ $index }}"
                        onchange="this.form.submit()"
                        class="p-2 border border-yellow-800 rounded text-xs md:text-sm"
                    >
                        <!-- Empty option (deselect filter) -->
                        <option value=""></option>

                        <!-- Distinct values -->
                        @foreach ($filterValues[$index] as $value)
                            <option 
                                value="{{ $value }}"
                                {{ request("filter_$index") == $value ? 'selected' : '' }}
                            >
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>

            @endif
        @endforeach

    </div>
</form>


<!-- ========================================= -->
<!-- Table -->
<!-- ========================================= -->

<div class="overflow-x-auto">
    <table class="min-w-full border border-yellow-800 bg-yellow-100 rounded">
        <thead class="bg-amber-600 text-green-900">
            <tr>
                @foreach ($headings as $index => $heading)
                    <th class="px-4 py-2 font-semibold border border-yellow-800 whitespace-nowrap text-xs md:text-sm 
                        {{ in_array($index, $hideColumns ?? []) ? 'hidden md:table-cell' : '' }}">
                        {{ $heading }}
                    </th>
                @endforeach
            </tr>
        </thead>

        <tbody id="{{ $tbodyId }}">
            @if(!$paginate)
                @foreach ($rows as $row)
                    <tr class="hover:bg-amber-200">

                        <!-- Radio button column -->
                        <td class="px-2 py-1 border border-yellow-800 text-center w-12">
                            <input 
                                type="radio" 
                                name="selected_row" 
                                value="{{ $row[0] }}" 
                                class="select-row"
                            >
                        </td>

                        <!-- Other columns -->
                        @foreach ($row as $index => $cell)
                            @if ($index === 0)
                                <!-- Hide ID column -->
                                <td class="hidden"></td>
                            @else
                                <td class="px-4 py-2 border border-yellow-800 whitespace-nowrap text-xs md:text-sm 
                                    {{ in_array($index, $hideColumns ?? []) ? 'hidden md:table-cell' : '' }}">
                                    {{ $cell }}
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            @endif
        </tbody>

    </table>

    @if($paginate)

        <!-- ========================================= -->
        <!-- Pagination Footer -->
        <!-- ========================================= -->
        <div class="flex justify-between items-center mt-4 table-pagination">

            <!-- Previous Button -->
            <button 
                data-action="prev" 
                data-page-param="{{ $tbodyId }}"
                class="px-4 py-2 bg-amber-700 text-white rounded hover:bg-green-800">
                Previous
            </button>

            <!-- Page Number -->
            <span class="text-amber-800 font-bold">
                Page <span data-page-display>1</span>
            </span>

            <!-- Next Button -->
            <button 
                data-action="next" 
                data-page-param="{{ $tbodyId }}"
                class="px-4 py-2 bg-amber-700 text-white rounded hover:bg-green-800">
                Next
            </button>

        </div>

    @endif

    <!-- Render totals table -->
    @if ($showTotals)
        <x-table-filter-total :rows="$filteredRows" :sumColumn="$sumColumn" />
    @endif


</div>