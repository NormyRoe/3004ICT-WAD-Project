@extends('layouts.app')

@section('title')
    Add Task
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Add a New Task</h2>

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
    <form action="{{ route('allocated_tasks.update', $task->id) }}" method="POST" class="mt-6">
        @csrf
        {{ method_field('PUT') }}

        <div class="mb-4">

            <!-- ========================= -->
            <!-- Row: Date, Task, Notes -->
            <!-- ========================= -->
            <div class="flex flex-row flex-wrap gap-x-12 gap-y-4 mb-4">
                <!-- Date  -->
                <div class="mt-4">
                    <label class="block text-green-900 font-semibold block">Date</label>
                    <label class="text-orange-900 font-semibold block">{{ $task->date->format('d/m/Y') }}</label>
                </div>

                <!-- Task  -->
                <div class="mt-4">
                    <label class="block text-green-900 font-semibold block">Task</label>
                    <label class="text-orange-900 font-semibold block">{{ $task->task->name }}</label>
                </div>

                <!-- Notes  -->
                <div class="mt-4">
                    <label class="block text-green-900 font-semibold block">Notes</label>
                    <textarea 
                        type="text" 
                        name="notes" 
                        class="border border-yellow-800 rounded p-2 w-64"
                    >{{ old('notes', $task->notes) }}</textarea>
                </div>

            </div>

            <!-- ========================= -->
            <!-- Row: Tree, Quantity -->
            <!-- ========================= -->
            <div class="flex flex-row flex-wrap gap-x-12 gap-y-4 mb-4">

                <!-- Tree  -->
                <div class="mt-4">

                    <label class="block text-green-900 font-semibold">Tree</label>

                    @if ($task->tree)
                        <label class="text-orange-900 font-semibold block">{{ $task->tree->plant_id }}, {{ $task->tree->common_name }}</label>
                    @else
                        <label class="text-orange-900 font-semibold block">N/A</label>
                    @endif

                </div>

                <!-- Quantity  -->
                <div class="mt-4">
                    <label class="block text-green-900 font-semibold block">Quantity</label>

                    @if ($task->quantity)
                        <label class="text-orange-900 font-semibold block">{{ $task->quantity }}</label>
                    @else
                        <label class="text-orange-900 font-semibold block">N/A</label>
                    @endif

                </div>

            </div>
            
            <!-- ========================= -->
            <!-- Row: Existing Location, New Location -->
            <!-- ========================= -->
            <div class="flex flex-row flex-wrap gap-x-12 gap-y-4 mb-4">

                <!-- Location 1  -->
                <div class="mt-4">

                    <label class="block text-green-900 font-semibold">Existing Location</label>

                    @if ($task->location_1)
                        <label 
                            class="text-orange-900 font-semibold block"
                        >
                            {{ $task->location_1->area->name }} : Block {{ $task->location_1->block?->name ?? '__' }} : 
                                Aisle {{ $task->location_1->aisle?->name ?? '__' }}
                        </label>
                    @else
                        <label class="text-orange-900 font-semibold block">N/A</label>
                    @endif

                </div>

                <!-- Location 2  -->
                <div x-data="{ search: '', open: false }" class="mt-4">

                    <label class="block text-green-900 font-semibold">New Location</label>

                    <!-- Search box -->
                    <input 
                        x-model="search"
                        @input="
                            if (search.trim() === '') {
                                $refs.location_2Select.value = '';
                            }
                        "
                        @focus="open = true"
                        @click.away="open = false"
                        type="text"
                        placeholder="Search locations by area or block..."
                        class="border border-yellow-800 rounded p-2 w-64"
                        x-init="
                            @php $loc2 = old('location_2_id', $task->location_2_id); @endphp
                            @if(old('location_2_id'))
                                const loc = @js($locations->firstWhere('id', $loc2));
                                search = loc.area.name + ' : Block ' 
                                    + (loc.block?.name ?? '__') 
                                    + ' : Aisle ' 
                                    + (loc.aisle?.name ?? '__');
                                $refs.location_2Select.value = '{{ $loc2 }}';
                            @endif
                        "
                    >

                    <!-- Hidden select that actually submits -->
                    <select name="location_2_id" x-ref="location_2Select" class="hidden">
                        
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
                                    $refs.location_2Select.value = '{{ $location->id }}';
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

            <!-- ========================= -->
            <!-- Row: Pot Size -->
            <!-- ========================= -->
            <div class="flex flex-row flex-wrap gap-x-12 gap-y-4 mb-4">

                <!-- Pot Size  -->
                <div class="mt-4">
                    <label class="block text-green-900 font-semibold block">Pot Size</label>
                    <select 
                        name="pot_size_id"
                        class="p-2 border border-yellow-800 rounded text-xs md:text-sm"
                    >
                        <!-- Empty option (deselect filter) -->
                        <option value=""></option>

                        <!-- Distinct values -->
                        @foreach ($pot_sizes as $pot_size)
                            <option 
                                value="{{ $pot_size->id }}"
                                {{ old('pot_size_id', $task->pot_size_id) == $pot_size->id ? 'selected' : '' }}
                            >
                                {{ $pot_size->size }}
                            </option>
                        @endforeach

                    </select>
                </div>

            </div>
            
            <!-- ========================= -->
            <!-- Row: Allocated To -->
            <!-- ========================= -->
            <div class="flex flex-row flex-wrap gap-x-12 gap-y-4 mb-4">

                <!-- Allocated To (Multiple Selection)  -->
                <div class="mt-6 space-y-4">
                    <label class="block text-green-900 font-semibold mb-2">Allocated To:</label>

                    @if (auth()->user()->hasAnyRole(['Operational Manager', 'Owner', 'Sales Manager']))
                    
                        <!-- Display in a 4 column grid  -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
                            @if ($task->task->name === 'Report')

                                @foreach ($management_users as $user)
                                    <label class="flex items-center gap-3">                    
                                        <input 
                                            type="checkbox" 
                                            name="allocated_users[]" 
                                            value="{{ $user->id }}" 
                                            class="form-checkbox"
                                            {{ in_array($user->id, old('allocated_users', $allocated_user_ids)) ? 'checked' : '' }}
                                        >
                                        <span>{{ $user->last_name }}, {{ $user->first_name }}</span>
                                    </label>
                                @endforeach

                            @else

                                @foreach ($users as $user)
                                    <label class="flex items-center gap-3">                    
                                        <input 
                                            type="checkbox" 
                                            name="allocated_users[]" 
                                            value="{{ $user->id }}" 
                                            class="form-checkbox"
                                            {{ in_array($user->id, old('allocated_users', $allocated_user_ids)) ? 'checked' : '' }}
                                        >
                                        <span>{{ $user->last_name }}, {{ $user->first_name }}</span>
                                    </label>
                                @endforeach

                            @endif
                        </div>

                    @else

                        <!-- Read-only allocation list -->
                        @foreach ($task->allocated_task_users as $allocated)
                            <label class="flex items-center gap-3 opacity-70 cursor-not-allowed">
                                <input 
                                    type="checkbox" 
                                    checked 
                                    disabled
                                    class="form-checkbox"
                                >
                                <span>{{ $allocated->user->last_name }}, {{ $allocated->user->first_name }}</span>
                            </label>
                        @endforeach

                        <!-- Hidden inputs so the update() method still receives the correct list -->
                        @foreach ($allocated_user_ids as $id)
                            <input type="hidden" name="allocated_users[]" value="{{ $id }}">
                        @endforeach

                    @endif

                </div>

            </div>

            <!-- ========================= -->
            <!-- Row: Task Completed -->
            <!-- ========================= -->
            <div class="flex flex-row flex-wrap gap-x-12 gap-y-4 mb-4">

                <div class="mt-4">
                    <label class="block text-green-900 font-semibold">Task Completed</label>
                    <input 
                        type="checkbox" 
                        name="done" 
                        value="1"
                        class="form-checkbox h-5 w-5 text-green-900"
                        {{ old('done', $task->done) ? 'checked' : '' }}
                    >
                </div>

            </div>

        </div>

        <!-- Button  -->
        <div class="flex mt-12 justify-center max-w-xl">
            <x-button-admin type="submit" value="Update Task" />
        </div>

    </form>

@endsection
