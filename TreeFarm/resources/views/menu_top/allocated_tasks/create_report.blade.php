@extends('layouts.app')

@section('title')
    Add Report Task
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Add a New Report Task</h2>

    <!-- Back to Index Button  -->
    <x-back-controller route='allocated_tasks.index' label='Back to Tasks Page' />

    <!-- Error Message  -->
    @if (count($errors) > 0)
        <div class="text-red-600 text-sm mt-1">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <!-- ========================= -->
    <!-- Creation Form -->
    <!-- ========================= -->
    <form action="{{ route('allocated_tasks.store_report') }}" method="POST" class="mt-6">
        @csrf

        <div class="mb-4">

            <!-- ========================= -->
            <!-- Row: Date, Task, Notes -->
            <!-- ========================= -->
            <div class="flex flex-row flex-wrap gap-x-12 gap-y-4 mb-4">
                <!-- Date  -->
                <div class="mt-4">
                    <label class="block text-green-900 font-semibold block">Date</label>
                    <input 
                        type="date" 
                        name="date" 
                        id="date"
                        class="border border-yellow-800 rounded p-2 w-64"
                        value="{{ old('date') }}"
                        required
                    >
                </div>

                <!-- Task  -->
                <div class="mt-4">
                    <label class="block text-green-900 font-semibold block">Task</label>
                    <select 
                        name="task_id"
                        class="p-2 border border-yellow-800 rounded text-xs md:text-sm"
                        required
                    >
                        <!-- There is only the 'Report' option -->
                        <option 
                            value="{{ $task->id }}"
                        >
                            {{ $task->name }}
                        </option>

                    </select>
                </div>

            </div>

            <!-- ========================= -->
            <!-- Row: Notes -->
            <!-- ========================= -->
            <div class="flex flex-row flex-wrap gap-x-12 gap-y-4 mb-4">

                <!-- Notes  -->
                <div class="mt-4">
                    <label class="block text-green-900 font-semibold block">Notes</label>
                    <textarea 
                        type="text" 
                        name="notes" 
                        class="border border-yellow-800 rounded p-2 w-64"
                        required
                    >{{ old('notes') }}</textarea>
                </div>

            </div>

            <!-- ========================= -->
            <!-- Row: Tree and Existing Location -->
            <!-- ========================= -->
            <div class="flex flex-row flex-wrap gap-x-12 gap-y-4 mb-4">

                <!-- Tree  -->
                <div x-data="{ search: '', open: false }" class="mt-4">

                    <label class="block text-green-900 font-semibold">Tree</label>

                    <!-- Search box -->
                    <input 
                        x-model="search"
                        @input="
                            if (search.trim() === '') {
                                $refs.treeSelect.value = '';
                            }
                        "
                        @focus="open = true"
                        @click.away="open = false"
                        type="text"
                        placeholder="Search trees..."
                        class="border border-yellow-800 rounded p-2 w-64"
                        x-init="
                            @if(old('tree_id'))
                                search = '{{ $trees->firstWhere('id', old('tree_id'))->plant_id }}, {{ $trees->firstWhere('id', old('tree_id'))->common_name }}';
                                $refs.treeSelect.value = '{{ old('tree_id') }}';
                            @endif
                        "
                    >

                    <!-- Hidden select that actually submits -->
                    <select name="tree_id" x-ref="treeSelect" class="hidden">

                        <!-- Empty Placeholder -->
                        <option value=""></option> 

                        <!-- Options -->
                        @foreach ($trees as $tree)
                            <option value="{{ $tree->id }}">
                                {{ $tree->plant_id }}, {{ $tree->common_name }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Filtered dropdown -->
                    <ul 
                        x-show="open"
                        class="border border-yellow-800 bg-white rounded mt-1 max-h-40 overflow-y-auto w-64 absolute z-50"
                    >
                        @foreach ($trees as $tree)
                            <li 
                                @click="
                                    $refs.treeSelect.value = '{{ $tree->id }}';
                                    search = '{{ $tree->plant_id }}, {{ $tree->common_name }}';
                                    open = false;
                                "
                                x-show="@js(strtolower($tree->plant_id . ', ' . $tree->common_name)).includes(search.toLowerCase())"
                                class="p-2 hover:bg-yellow-200 cursor-pointer"
                            >
                                {{ $tree->plant_id }}, {{ $tree->common_name }}
                            </li>
                        @endforeach
                    </ul>

                </div>

                <!-- Location 1  -->
                <div x-data="{ search: '', open: false }" class="mt-4">

                    <label class="block text-green-900 font-semibold">Existing Location</label>

                    <!-- Search box -->
                    <input 
                        x-model="search"
                        @input="
                            if (search.trim() === '') {
                                $refs.location_1Select.value = '';
                            }
                        "
                        @focus="open = true"
                        @click.away="open = false"
                        type="text"
                        placeholder="Search locations by area or block..."
                        class="border border-yellow-800 rounded p-2 w-64"
                        x-init="
                            @php $loc1 = old('location_1_id'); @endphp
                            @if(old('location_1_id'))
                                const loc = @js($locations->firstWhere('id', $loc1));
                                search = loc.area.name + ' : Block ' 
                                    + (loc.block?.name ?? '__') 
                                    + ' : Aisle ' 
                                    + (loc.aisle?.name ?? '__');
                                $refs.location_1Select.value = '{{ $loc1 }}';
                            @endif
                        "
                    >

                    <!-- Hidden select that actually submits -->
                    <select name="location_1_id" x-ref="location_1Select" class="hidden">

                        <!-- Empty Placeholder -->
                        <option value=""></option> 
                        
                        <!-- Options -->
                        @foreach ($locations as $location)
                            <option value="{{ $location->id }}">
                                {{ $location->area->name }} : Block {{ $location->block?->name ?? '__' }} : 
                                Aisle {{ $location->aisle?->name ?? '__' }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Filtered dropdown -->
                    <ul 
                        x-show="open"
                        class="border border-yellow-800 bg-white rounded mt-1 max-h-40 overflow-y-auto w-64 absolute z-50"
                    >
                        @foreach ($locations as $location)

                            @php
                                $location_string = strtolower(
                                    $location->area->name
                                    . ' : Block ' . ($location->block?->name ?? '__')
                                    . ' : Aisle ' . ($location->aisle?->name ?? '__')
                                );
                            @endphp

                            <li 
                                @click="
                                    $refs.location_1Select.value = '{{ $location->id }}';
                                    search = '{{ $location->area->name }} : Block {{ $location->block?->name ?? "__" 
                                                }} : Aisle {{ $location->aisle?->name ?? "__" }}';
                                    open = false;
                                "
                                x-show="@js($location_string).includes(search.toLowerCase())"
                                class="p-2 hover:bg-yellow-200 cursor-pointer"
                            >
                                {{ $location->area->name }} : Block {{ $location->block?->name ?? '__' }} : 
                                Aisle {{ $location->aisle?->name ?? '__' }}
                            </li>
                        @endforeach
                    </ul>

                </div>

            </div>

        </div>

        <!-- Button  -->
        <div class="flex mt-12 justify-center max-w-xl">
            <x-button-admin type="submit" value="Add Report Task" />
        </div>

    </form>

    <!-- ========================= -->
    <!-- Load Script for Date -->
    <!-- ========================= -->
    @push('scripts')

        <script>

            if (!document.getElementById('date').value) {
                const today = new Date();
                const formatted = today.toLocaleDateString('en-CA');
                document.getElementById('date').value = formatted;
            }

        </script>

    @endpush


@endsection
