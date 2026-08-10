
@props([
    'headings',
    'rows',
    'hideColumns' => [],
    'filterColumns' => [],
])

<!-- Table with filtering and sorting -->
<!-- With responsive behaviour -->
<div class="mt-6">
    
    <!-- Column Filters -->
    <div class="flex flex-wrap gap-4 mb-4">
        @foreach ($headings as $index => $heading)
            @if(in_array($index, $filterColumns))
                <select class="p-2 border border-yellow-800 rounded text-xs md:text-sm">
                    <option value="">Filter {{ $heading }}</option>
                </select>
            @endif
        @endforeach
    </div>

    <!-- Table -->
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

            <tbody>
                @foreach ($rows as $row)
                    <tr class="hover:bg-amber-200">
                        @foreach ($row as $index => $cell)
                            <td class="px-4 py-2 border border-yellow-800 whitespace-nowrap text-xs md:text-sm 
                                {{ in_array($index, $hideColumns ?? []) ? 'hidden md:table-cell' : '' }}">
                                {{ $cell }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>        

    </div>

</div>

