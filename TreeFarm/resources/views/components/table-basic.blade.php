
@props([
    'headings',
    'rows',
    'hideColumns' => [],
    'tbodyId' => null,
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

        <tbody @if($tbodyId) id="{{ $tbodyId }}" @endif>
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
        </tbody>
    </table>    

</div>
