@extends('layouts.app')

@section('title')
    View a Sale
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">View an existing Sale Record</h2>

    <!-- Back to Index Button  -->
    <x-back-controller route='sales.index' label='Back to Sales Page' />

    <!-- Update Success Message  -->
    @if(session('success'))
        <div class="bg-amber-200 text-orange-900 p-4 rounded mb-4 mt-4 border border-amber-600 shadow-sm">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- ========================= -->
    <!-- Show Details -->
    <!-- ========================= -->

    <div class="bg-yellow-100 p-6 rounded border border-yellow-800 max-w-xl">
        
        <!-- ========================= -->
        <!-- Row: Status, Date and People -->
        <!-- ========================= -->
        <div class="flex flex-row flex-wrap gap-x-12 gap-y-4 mb-4">

            <!-- Status  -->
            <div>
                <label class="text-green-900 font-semibold block">Status</label>
                <label class="text-black block">{{ $sale->status }}</label>
            </div>

            <!-- Date  -->
            <div>
                <label class="text-green-900 font-semibold block">Sales Date</label>
                <label class="text-black block">{{ $sale->date->format('d/m/Y') }}</label>
            </div>

            <!-- Salesperson  -->
            <div>
                <label class="text-green-900 font-semibold block">Salesperson</label>
                <label class="text-black block">
                    {{ $sale->user->last_name }}, {{ $sale->user->first_name }}
                </label>
            </div>

            <!-- Customer  -->
            <div>
                <label class="text-green-900 font-semibold block">Customer</label>
                <label class="text-black block">
                    {{ $sale->customer->last_name }}, {{ $sale->customer->first_name }}
                </label>
            </div>

        </div>

        <!-- ========================= -->
        <!-- Row: Delivery Notes and Kms -->
        <!-- ========================= -->
        <div class="flex flex-row gap-12 mb-4">

            <!-- Delivery Notes  -->
            <div>
                <label class="block text-green-900 font-semibold mb-2">Delivery Notes</label>
                <label class="text-black block">{!! nl2br(e($sale->delivery_notes)) !!}</label>
            </div>

            <!-- Delivery kms  -->
            <div>
                <label class="block text-green-900 font-semibold mb-2">Delivery Kms</label>
                <label class="text-black block">{{ $sale->delivery_kms }}</label>
            </div>

        </div>

        <!-- ========================= -->
        <!-- Row: Delivery Fee, Discount and Total Sales -->
        <!-- ========================= -->
        <div class="flex flex-row gap-12 mb-4">

            <!-- Delivery Fee  -->
            <div>
                <label class="block text-green-900 font-semibold mb-2">Delivery Fee</label>
                <label class="text-black block">${{ $sale->delivery_fee }}</label>
            </div>

            <!-- Discount  -->
            <div>
                <label class="block text-green-900 font-semibold mb-2">Discount</label>
                <label class="text-black block">${{ $sale->discount }}</label>
            </div>

            <!-- Total Sales  -->
            <div>
                <label class="block text-green-900 font-semibold mb-2">Total Sales</label>
                <label class="text-black block">${{ $sale->total_sales_price }}</label>
            </div>

        </div>
        
    </div>

    <!-- ========================= -->
    <!-- Sales Items -->
    <!-- ========================= -->
    <div class="mt-4">

        <x-table-sale-items 
            :sale="$sale" 
            :sale_items="$sale_items"
            :deletable="false"
        />

    </div>


@endsection
