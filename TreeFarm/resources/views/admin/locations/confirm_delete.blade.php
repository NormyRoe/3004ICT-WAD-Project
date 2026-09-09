
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
/>

@endsection
