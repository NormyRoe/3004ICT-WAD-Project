@extends('layouts.app')

@section('title')
    Add Tree
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Add a New Tree</h2>

    <!-- Back to Index Button  -->
    <x-back-controller route='trees.index' label='Back to Trees Page' />
    
    <!-- ========================= -->
    <!-- Creation Form -->
    <!-- ========================= -->
    <form action="{{ route('trees.store') }}" method="POST" class="mt-6">
        @csrf

        <div class="mb-4">

            <!-- Plant ID  -->
            <label class="block text-green-900 font-semibold mb-2">Plant ID</label>
            <input 
                type="text" 
                name="plant_id" 
                class="border border-yellow-800 rounded p-2 w-64"
                value="{{ old('plant_id') }}"
                required
            >

            <!-- Tree Type  -->
            <label class="block text-green-900 font-semibold mb-2">Tree Type</label>
            <select 
                name="tree_type_id"
                class="p-2 border border-yellow-800 rounded text-xs md:text-sm"
                required
            >
                <!-- Empty option (deselect filter) -->
                <option value=""></option>

                <!-- Distinct values -->
                @foreach ($tree_types as $tree_type)
                    <option 
                        value="{{ $tree_type->id }}"
                        {{ old('tree_type_id') == $tree_type->id ? 'selected' : '' }}
                    >
                        {{ $tree_type->name }}
                    </option>
                @endforeach

            </select>

            <!-- Botanical Name  -->
            <label class="block text-green-900 font-semibold mb-2">Botanical Name</label>
            <input 
                type="text" 
                name="botanical_name" 
                class="border border-yellow-800 rounded p-2 w-64"
                value="{{ old('botanical_name') }}"
                required
            >

            <!-- Common Name  -->
            <label class="block text-green-900 font-semibold mb-2">Common Name</label>
            <input 
                type="text" 
                name="common_name" 
                class="border border-yellow-800 rounded p-2 w-64"
                value="{{ old('common_name') }}"
                required
            >

            <div class="mt-6 max-w-xl">
                <!-- Mature Height  -->
                <div class="mt-6">
                    <label class="block text-green-900 font-semibold text-center mb-2">Mature Height (in metres)</label>
                    <!-- Min and Max  -->
                    <div class="grid grid-cols-2 gap-2 mt-2">
                        <div class="text-center">
                            <label class="block text-green-900 font-semibold">Min</label>
                            <input 
                                type="text" 
                                name="height_min" 
                                class="border border-yellow-800 rounded p-2 w-64"
                                value="{{ old('height_min') }}"
                            >
                        </div>
                        <div class="text-center">
                            <label class="block text-green-900 font-semibold">Max</label>
                            <input 
                                type="text" 
                                name="height_max" 
                                class="border border-yellow-800 rounded p-2 w-64"
                                value="{{ old('height_max') }}"
                                required
                            >
                        </div>
                    </div>                
                </div>

                <!-- Mature Width  -->
                <div class="mt-6">
                    <label class="block text-green-900 font-semibold text-center mb-2">Mature Width (in metres)</label>
                    <!-- Min and Max  -->
                    <div class="grid grid-cols-2 gap-2 mt-2">
                        <div class="text-center">
                            <label class="block text-green-900 font-semibold">Min</label>
                            <input 
                                type="text" 
                                name="width_min" 
                                class="border border-yellow-800 rounded p-2 w-64"
                                value="{{ old('width_min') }}"
                            >
                        </div>
                        <div class="text-center">
                            <label class="block text-green-900 font-semibold">Max</label>
                            <input 
                                type="text" 
                                name="width_max" 
                                class="border border-yellow-800 rounded p-2 w-64"
                                value="{{ old('width_max') }}"
                                required
                            >
                        </div>
                    </div>                
                </div>
            </div>

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
            
        </div>

        <!-- Button  -->
        <div class="flex mt-12 justify-center max-w-xl">
            <x-button-admin type="submit" value="Add Tree" />
        </div>

    </form>

@endsection
