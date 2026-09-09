
@extends('layouts.app')

@section('title')
    Delete Price Confirmation
@endsection

@section('content')

<x-confirm-delete
    :title="'Delete Price'"
    :message="'Are you sure you want to delete this Price?'"
    :itemTitle="$price->name ? 'Price: ' . $price->name : 'Pot Size: ' . ($price->pot_size?->size ?? '__')"
    :details="[
        'ID' => $price->id,
        'Name' => $price->name ?? '',
        'Pot Size' => $price->pot_size?->size ?? '',
        'Price' => '$ ' . ($price->price ?? ''),
        'Rate' => ($price->rate ?? '') . ' %',
    ]"
    :deleteRoute="route('prices.destroy', $price->id)"
    :cancelRoute="route('prices.index')"
    :name="auth()->user()->first_name"
>

    <!-- Conditional message inside the details box -->
    @if ($price->name && ($price->name == 'Delivery Rate' 
                            || $price->name == 'Delivery Minimum' 
                            || $price->name == 'GST'))

        <p class="mt-4 text-red-700 font-semibold">
            Deleting this price record will break system functionality.  Are you sure that you want to do that?
        </p>

    @endif
    @if ($price->pot_size)

        <p class="mt-4 text-red-700 font-semibold">
            This is a pot size price. Deleting this Pot Size price record will break system functionality, unless the Pot Size 
            itself has already been removed from the system.
        </p>

    @endif

</x-confirm-delete>

@endsection
