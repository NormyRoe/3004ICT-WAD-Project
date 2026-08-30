
@props([
    'title' => 'Delete Record',
    'message' => 'Are you sure you want to delete this record?',
    'itemTitle' => null,
    'details' => [],
    'deleteRoute',
    'cancelRoute',
    'name' => null,
])

@extends('layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <!-- Header Text -->
    <h2 class="text-3xl font-bold text-red-700">{{ $title }}</h2>

    <!-- Message Text -->
    <p class="mt-4 text-stone-700">
        {{ $message }}
    </p>

    @if($itemTitle)

        <!-- Item Title Text -->
        <p class="mt-2 font-semibold text-stone-900">
            {{ $itemTitle }}
        </p>

    @endif

    <!-- Item to be Deleted -->
    <div class="mt-6 p-4 border border-red-700 bg-red-100 rounded">
        @foreach($details as $label => $value)            
            <p><strong>{{ $label }}:</strong> {{ $value }}</p>
        @endforeach
    </div>

    <div class="flex gap-4 mt-8">

        <!-- Confirm Delete -->
        <form method="POST" action="{{ $deleteRoute }}">
            @csrf
            @method('DELETE')
            <x-button-admin type="submit" value="Yes, Delete" />
        </form>

        <!-- Cancel -->
        <a href="{{ $cancelRoute }}">
            <x-button-admin type="button" value="Cancel" />
        </a>
        
    </div>

@endsection
