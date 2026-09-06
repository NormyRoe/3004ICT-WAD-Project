@extends('layouts.app')

@section('title')
    View a Tree
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">View an existing Tree</h2>

    <!-- Back to Index Button  -->
    <x-back-controller route='trees.index' label='Back to Trees Page' />

    <!-- Create/Update Success Message  -->
    @if(session('success'))
        <div class="bg-amber-200 text-orange-900 p-4 rounded mb-4 border border-amber-600 shadow-sm">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- ========================= -->
    <!-- Show Details -->
    <!-- ========================= -->

    <div class="flex flex-col space-y-4 bg-yellow-100 p-6 rounded border border-yellow-800 max-w-xl">
        <!-- Plant ID  -->
        <div>
            <label class="block text-green-900 font-semibold block">Plant ID</label>
            <label class="text-black block">{{ $tree->plant_id }}</label>
        </div>
        <!-- Tree Type  -->
        <div>
            <label class="block text-green-900 font-semibold block">Tree Type</label>
            <label class="text-black block">{{ $tree->tree_type->name }}</label>
        </div>
        <!-- Botanical Name  -->
        <div>
            <label class="block text-green-900 font-semibold block">Botanical Name</label>
            <label class="text-black block">{{ $tree->botanical_name }}</label>
        </div>
        <!-- Common Name  -->
        <div>
            <label class="block text-green-900 font-semibold block">Common Name</label>
            <label class="text-black block">{{ $tree->common_name }}</label>
        </div>
        <!-- Mature Height  -->
        <div class="mt-6">
            <label class="block text-green-900 font-semibold text-center">Mature Height (in metres)</label>

            <!-- Min and Max  -->
            <div class="grid grid-cols-2 gap-2 mt-2">
                <div class="text-center">
                    <label class="block text-green-900 font-semibold">Min</label>
                    <label class="text-black block">{{ $tree->mature_height_min }}</label>
                </div>

                <div class="text-center">
                    <label class="block text-green-900 font-semibold">Max</label>
                    <label class="text-black block">{{ $tree->mature_height_max }}</label>
                </div>
            </div>

        </div>
        <!-- Mature Width  -->
        <div class="mt-6">
            <label class="block text-green-900 font-semibold text-center">Mature Width (in metres)</label>

            <!-- Min and Max  -->
            <div class="grid grid-cols-2 gap-2 mt-2">
                <div class="text-center">
                    <label class="block text-green-900 font-semibold">Min</label>
                    <label class="text-black block">{{ $tree->mature_width_min }}</label>
                </div>

                <div class="text-center">
                    <label class="block text-green-900 font-semibold">Max</label>
                    <label class="text-black block">{{ $tree->mature_width_max }}</label>
                </div>
            </div>

        </div>
    </div>

    <!-- ========================= -->
    <!-- Buttons -->
    <!-- ========================= -->
    
    <div class="flex justify-center gap-24 mt-10 max-w-xl">

        <!-- Update -->
        <a href="{{ route('trees.edit', $tree->id) }}">
            <x-button-admin type="button" value="Update" />
        </a>

        <!-- Delete -->
        <a href="{{ route('trees.delete_confirm', $tree->id) }}">
            <x-button-admin type="button" value="Delete" />
        </a>

    </div>


@endsection
