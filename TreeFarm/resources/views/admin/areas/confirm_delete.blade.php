
@extends('layouts.app')

@section('title')
    Delete Area Confirmation
@endsection

@section('content')

<x-confirm-delete
    :title="'Delete Area'"
    :message="'Are you sure you want to delete this Area?'"
    :itemTitle="'Area: ' . $area->name"
    :details="[
        'ID' => $area->id,
        'Area' => $area->name,
    ]"
    :deleteRoute="route('areas.destroy', $area->id)"
    :cancelRoute="route('locations.index')"
    :name="auth()->user()->first_name"
>

    <!-- Conditional message inside the details box -->
    @if ($area->name && $area->name == 'Delivery')

        <p class="mt-4 text-red-700 font-semibold">
            Deleting this area record will break system functionality.  Are you sure that you want to do that?
        </p>

    @endif
    
</x-confirm-delete>

@endsection