
@extends('layouts.app')

@section('title')
    Delete Tree Confirmation
@endsection

@section('content')

<x-confirm-delete
    :title="'Delete Tree'"
    :message="'Are you sure you want to delete this Tree?'"
    :itemTitle="'Tree: ' . $tree->common_name"
    :details="[
        'ID' => $tree->id,
        'Botanical Name' => $tree->botanical_name,
        'Common Name' => $tree->common_name,
    ]"
    :deleteRoute="route('trees.destroy', $tree->id)"
    :cancelRoute="route('trees.index')"
    :name="auth()->user()->first_name"
/>

@endsection
