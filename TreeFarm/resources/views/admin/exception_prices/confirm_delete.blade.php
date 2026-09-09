
@extends('layouts.app')

@section('title')
    Delete Exception Price Confirmation
@endsection

@section('content')

<x-confirm-delete
    :title="'Delete Exception Price'"
    :message="'Are you sure you want to delete this Exception Price?'"
    :itemTitle="$exception_price->tree->common_name . ', ' . $exception_price->pot_size->size"
    :details="[
        'ID' => $exception_price->id,
        'Tree' => $exception_price->tree->common_name,
        'Pot Size' => $exception_price->pot_size->size,
        'Price' => '$ ' . $exception_price->price,
    ]"
    :deleteRoute="route('exception_prices.destroy', $exception_price->id)"
    :cancelRoute="route('prices.index')"
    :name="auth()->user()->first_name"
>

    <!-- Conditional message inside the details box -->
    @if ($exception_price->price)

        <p class="mt-4 text-red-700 font-semibold">
            Deleting this exception price record will result in this Tree being charged the normal price for this Pot Size.
        </p>
        <p class="mt-4 text-red-700 font-semibold">
            Are you sure that you want to do that?
        </p>

    @endif
    

</x-confirm-delete>

@endsection
