@extends('layouts.app')

@section('title')
    View a Task
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">View an existing Task</h2>

    <!-- Back to Index Button  -->
    <x-back-controller route='allocated_tasks.index' label='Back to Tasks Page' />

    <!-- Create/Update Success Message  -->
    @if(session('success'))
        <div class="bg-amber-200 text-orange-900 p-4 rounded mb-4 border border-amber-600 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- ========================= -->
    <!-- Build Location Strings -->
    <!-- ========================= -->
    @php

        // Build location_1 string
        $location_1 = '';

        if ($task->location_1) {
            $location_1 = $task->location_1->area->name;

            if ($task->location_1->block) {
                $location_1 .= ' : Block ' . $task->location_1->block->name;
            }

            if ($task->location_1->aisle) {
                $location_1 .= ' : Aisle ' . $task->location_1->aisle->name;
            }
        }

        // Build location_2 string
        $location_2 = '';

        if ($task->location_2) {
            $location_2 = $task->location_2->area->name;

            if ($task->location_2->block) {
                $location_2 .= ' : Block ' . $task->location_2->block->name;
            }

            if ($task->location_2->aisle) {
                $location_2 .= ' : Aisle ' . $task->location_2->aisle->name;
            }
        }

    @endphp
    
    <!-- ========================= -->
    <!-- Show Details -->
    <!-- ========================= -->

    <div class="bg-yellow-100 p-6 rounded border border-yellow-800 max-w-xl">

        <!-- ========================= -->
        <!-- Row: Date, Task, Notes -->
        <!-- ========================= -->
        <div class="flex flex-row flex-wrap gap-x-12 gap-y-4 mb-4">

            <!-- Date  -->
            <div>
                <label class="block text-green-900 font-semibold block">Date</label>
                <label class="text-black block">{{ $task->date->format('d/m/Y') }}</label>
            </div>

            <!-- Task  -->
            <div>
                <label class="block text-green-900 font-semibold block">Task</label>
                <label class="text-black block">{{ $task->task->name }}</label>
            </div>

            <!-- Notes  -->
            <div>
                <label class="block text-green-900 font-semibold block">Notes</label>
                <label class="text-black block">{{ $task->notes ?? '' }}</label>
            </div>

        </div>

        <!-- ========================= -->
        <!-- Row: Task Completed -->
        <!-- ========================= -->
        <div class="flex flex-row flex-wrap gap-x-12 gap-y-4 mb-4">

            <!-- Task Completed  -->
            <div>
                <label class="block text-green-900 font-semibold block">Task Completed</label>
                @if ($task->done === 0)
                    <label class="text-black block">No</label>
                @else
                    <label class="text-black block">Yes</label>
                @endif
                
            </div>

        </div>

        <!-- ========================= -->
        <!-- Row: Tree, Quantity -->
        <!-- ========================= -->
        <div class="flex flex-row flex-wrap gap-x-12 gap-y-4 mb-4">

            <!-- Tree  -->
            <div>
                <label class="block text-green-900 font-semibold block">Tree</label>
                <label class="text-black block">{{ $task->tree?->common_name ?? '' }}</label>
            </div>

            <!-- Quantity  -->
            <div>
                <label class="block text-green-900 font-semibold block">Quantity</label>
                <label class="text-black block">{{ $task->quantity ?? '' }}</label>
            </div>

        </div>
        
        <!-- ========================= -->
        <!-- Row: Existing Location, New Location -->
        <!-- ========================= -->
        <div class="flex flex-row flex-wrap gap-x-12 gap-y-4 mb-4">

            <!-- Location 1  -->
            <div>
                <label class="block text-green-900 font-semibold block">Existing Location</label>
                <label class="text-black block">{{ $location_1 }}</label>
            </div>

            <!-- Location 2  -->
            <div>
                <label class="block text-green-900 font-semibold block">New Location</label>
                <label class="text-black block">{{ $location_2 }}</label>
            </div>

        </div>
        
        <!-- ========================= -->
        <!-- Row: Current Pot Size and New Pot Size -->
        <!-- ========================= -->
        <div class="flex flex-row flex-wrap gap-x-12 gap-y-4 mb-4">

            <!-- Current Pot Size  -->
            <div>
                <label class="block text-green-900 font-semibold block">Current Pot Size</label>
                <label class="text-black block">{{ $task->current_pot_size?->size ?? '' }}</label>
            </div>

            <!-- New Pot Size  -->
            <div>
                <label class="block text-green-900 font-semibold block">New Pot Size</label>
                <label class="text-black block">{{ $task->new_pot_size?->size ?? '' }}</label>
            </div>

        </div>
        
        <!-- ========================= -->
        <!-- Row: Allocated To -->
        <!-- ========================= -->
        <div class="flex flex-row flex-wrap gap-x-12 gap-y-4 mb-4">

            <!-- Allocated To:  -->
            <div>
                <label class="block text-green-900 font-semibold block">Allocated To:</label>
                <ul class="list-disc ml-6">
                    @foreach ($allocated_users as $user)
                        <li>{{ $user->last_name }}, {{ $user->first_name }}</li>
                    @endforeach
                </ul>
            </div>

        </div>
        
    </div>

    <!-- ========================= -->
    <!-- Buttons -->
    <!-- ========================= -->
    
    <div class="flex justify-center gap-24 mt-10 max-w-xl">

        <!-- Update -->
        <a href="{{ route('allocated_tasks.edit', $task->id) }}">
            <x-button-admin type="button" value="Update" />
        </a>

        @can('admin-access')

            @if ($task->done == 0)
                <!-- Delete -->
                <a href="{{ route('allocated_tasks.delete_confirm', $task->id) }}">
                    <x-button-admin type="button" value="Delete" />
                </a>
            @endif
            
        @endcan

    </div>


@endsection
