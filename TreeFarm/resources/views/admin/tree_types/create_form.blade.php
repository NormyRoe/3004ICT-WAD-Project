@extends('layouts.app')

@section('title')
    Add Tree Type
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Add a New Tree Type</h2>

    <!-- Back to Index Button  -->
    <x-back-controller route='trees.index' label='Back to Trees Page' />
    
    <!-- ========================= -->
    <!-- Creation Form -->
    <!-- ========================= -->
    <form action="{{ route('tree_types.store') }}" method="POST" class="mt-6">
        @csrf

        <div class="mb-4">

            <!-- Type Label  -->
            <label class="block text-green-900 font-semibold mb-2">Type</label>

            <!-- Type Input Field  -->
            <input 
                type="text" 
                name="type" 
                class="border border-yellow-800 rounded p-2 w-64"
                value="{{ old('type') }}"
                required
            >

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
        <x-button-admin type="submit" value="Add Tree Type" />

    </form>
@endsection
