
@extends('layouts.app')

@section('title')
    Delete Task Confirmation
@endsection

@section('content')

<x-confirm-delete
    :title="'Delete Task'"
    :message="'Are you sure you want to delete this Task record?'"
    :itemTitle="'Date: ' . $task->date->format('d/m/Y') . ' - Task: ' . $task->task->name"
    :details="[
        'Task ID' => $task->id,
        'Date' => $task->date->format('d/m/Y'),
        'Task' => $task->task->name,
        'Tree' => $task->tree ? $task->tree->plant_id . ', ' . $task->tree->common_name : '',
        'Quantity' => $task->quantity ?? '',
        'Existing Location' => $task->location_1 ? ($task->location_1->area->name . ' : Block ' . ($task->location_1->block?->name ?? '__') 
                                . ' : Aisle ' . ($task->location_1->aisle?->name ?? '__')) : '',
        'New Location' => $task->location_2 ? ($task->location_2->area->name . ' : Block ' . ($task->location_2->block?->name ?? '__') 
                                . ' : Aisle ' . ($task->location_2->aisle?->name ?? '__')) : '',
        'Pot Size' => $task->pot_size?->size ?? '',
    ]"
    :deleteRoute="route('allocated_tasks.destroy', $task->id)"
    :cancelRoute="route('allocated_tasks.index')"
    :name="auth()->user()->first_name"
/>

@endsection
