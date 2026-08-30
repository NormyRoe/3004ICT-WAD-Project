
<!-- Table with filtering and sorting -->
<!-- With responsive behaviour -->
<!-- Table with totals -->

@props([
    'headings',
    'rows',
    'hideColumns' => [],
    'filterColumns' => [],
    'sumColumn' => null,
    'tbodyId' => null,
])


<!-- Render main filtered table -->
<x-table-filter :headings="$headings" :rows="$rows" :hideColumns="$hideColumns" :filterColumns="$filterColumns" :tbodyId="$tbodyId" />


<!-- ========================================= -->
<!-- Total Table (uses filteredRows) -->
<!-- ========================================= -->
<div class="mt-6">
    
    <table class="min-w-full border border-yellow-800 bg-yellow-100 rounded">
        <thead class="bg-amber-600 text-green-900">
            <tr>
                <th class="px-4 py-2 font-bold border border-yellow-800 whitespace-nowrap text-xs md:text-sm">
                    Total:
                </th>
            </tr>
        </thead>

        <tbody>
            <tr class="hover:bg-amber-200">
                <td class="px-4 py-2 border border-yellow-800 whitespace-nowrap text-xs md:text-sm">
                    @if($sumColumn !== null)
                        {{ collect($rows)->sum(fn($row) => $row[$sumColumn] ?? 0) }}
                    @else
                        {{ count($rows) }}
                    @endif
                </td>
            </tr>
        </tbody>

    </table>

</div>

