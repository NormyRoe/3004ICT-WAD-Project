
@extends('layouts.app')

@section('title')
    Delete Inventory Confirmation
@endsection

@section('content')

<x-confirm-delete
    :title="'Delete Inventory'"
    :message="'Are you sure you want to delete this Inventory record?'"
    :itemTitle="'Plant ID: ' . $inventory->tree->plant_id 
        . ' - Location: ' 
        . $inventory->location->area->name 
        . ' Block ' . ($inventory->location->block?->name ?? '__') 
        . ' Aisle ' . ($inventory->location->aisle?->name ?? '__')"
    :details="[
        'Inventory ID' => $inventory->id,
        'Plant ID' => $inventory->tree->plant_id,
        'Common Name' => $inventory->tree->common_name,
        'Area' => $inventory->location->area->name,
        'Block' => $inventory->location->block?->name ?? '',
        'Aisle' => $inventory->location->aisle?->name ?? '',
        'Quantity' => $inventory->quantity,
    ]"
    :deleteRoute="route('inventories.destroy', $inventory->id)"
    :cancelRoute="route('inventories.index')"
    :name="auth()->user()->first_name"
/>

@endsection
