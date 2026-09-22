
@extends('layouts.app')

@section('title')
    Delete Location Confirmation
@endsection

@section('content')

<x-confirm-delete
    :title="'Delete Location'"
    :message="'Are you sure you want to delete this Location?'"
    :itemTitle="'Location: ' 
        . $location->area->name 
        . ' Block ' . ($location->block?->name ?? '__') 
        . ' Aisle ' . ($location->aisle?->name ?? '__')"
    :details="[
        'ID' => $location->id,
        'Area' => $location->area->name,
        'Block' => $location->block?->name ?? '',
        'Aisle' => $location->aisle?->name ?? '',
    ]"
    :deleteRoute="route('locations.destroy', $location->id)"
    :cancelRoute="route('locations.index')"
    :name="auth()->user()->first_name"
>

    <!-- Conditional message inside the details box -->
    @if ($location->area->name && ($location->area->name == 'Delivery'
                            || str_starts_with($location->area->name, 'Potting')))

        <p class="mt-4 text-red-700 font-semibold">
            Deleting this location record will break system functionality.  Are you sure that you want to do that?
        </p>

    @endif
    
</x-confirm-delete>

@endsection
