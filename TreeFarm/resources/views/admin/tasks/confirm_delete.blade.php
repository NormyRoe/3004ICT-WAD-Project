
@extends('layouts.app')

@section('title')
    Delete Task Confirmation
@endsection

@section('content')

<x-confirm-delete
    :title="'Delete Task'"
    :message="'Are you sure you want to delete this Task?'"
    :itemTitle="$task->name"
    :details="[
        'ID' => $task->id,
        'Task' => $task->name,
    ]"
    :deleteRoute="route('tasks.destroy', $task->id)"
    :cancelRoute="route('tasks.index')"
    :name="auth()->user()->first_name"
>

    <!-- Conditional message inside the details box -->
    @if ($task->name && ($task->name == 'Destroy' 
                            || $task->name == 'Move' 
                            || $task->name == 'Re-Pot'
                            || $task->name == 'Report'))

        <p class="mt-4 text-red-700 font-semibold">
            Deleting this task record will break system functionality.  Are you sure that you want to do that?
        </p>

    @endif
    
</x-confirm-delete>

@endsection
