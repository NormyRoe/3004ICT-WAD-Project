
@props([
    'headings',
    'rows',
    'hideColumns' => [],
])

<!-- Basic Table without filtering, sorting or searching --> 
<!-- With responsive behaviour -->
<div class="overflow-x-auto mt-6">
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
