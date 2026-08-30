
@props([
    'headings',
    'rows',
    'hideColumns' => [],
    'sumColumn' => null,
    'tbodyId' => null,
])

<!-- Basic Table without filtering, sorting or searching --> 
<!-- With responsive behaviour -->

<x-table-basic :headings="$headings" :rows="$rows" :hideColumns="$hideColumns" :tbodyId="$tbodyId" />

<!-- Total Table -->
<div class="overflow-x-auto mt-6">
    
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
