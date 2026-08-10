
<!-- Table with filtering, sorting and searching -->
<!-- With responsive behaviour -->
<div class="mt-6">

    <!-- Search Bar -->
    <div class="mb-4">
        <input 
            type="text"
            placeholder="Search..."
            class="w-full p-2 border border-yellow-800 rounded"
        >
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

