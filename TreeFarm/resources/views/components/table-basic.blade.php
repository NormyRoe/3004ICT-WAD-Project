
@props([
    'headings',
    'rows',
    'hideColumns' => [],
    'tbodyId' => null,
    'paginate' => false,
])

<!-- ========================================= -->
<!-- Update $rows for pagination -->
<!-- ========================================= -->

@php

    if($paginate)
    {
        $rows = array_values($rows);
    }
        

@endphp

<!-- ========================================= -->
<!-- Expose variables for Scripts -->
<!-- ========================================= -->
<script>

    window["{{ $tbodyId }}_paginate"] = @json($paginate);

    @if($paginate)

        window["{{ $tbodyId }}_data"] = @json($rows);
        window["{{ $tbodyId }}_totalPages"] = Math.ceil({{ count($rows) }} / 15);
        window["{{ $tbodyId }}_hideColumns"] = @json($hideColumns);

    @endif        
        
</script>



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

</div>
