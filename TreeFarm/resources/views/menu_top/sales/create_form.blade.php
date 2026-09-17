@extends('layouts.app')

@section('title')
    Add Sale
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Add a New Sale record</h2>

    <!-- Back to Index Button  -->
    <x-back-controller route='sales.index' label='Back to Sales Page' />

    <!-- Error Message  -->
    @if (count($errors) > 0)
        <div class="text-red-600 text-sm mt-1">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <!-- ========================= -->
    <!-- Creation Form -->
    <!-- ========================= -->
    <form action="{{ route('sales.store') }}" method="POST" class="mt-6">
        @csrf

        <div class="mb-4">

            <!-- Date  -->
            <div class="mt-4">
                <label class="block text-green-900 font-semibold block">Date</label>
                <input 
                    type="date" 
                    name="date" 
                    id="sale_date"
                    class="border border-yellow-800 rounded p-2 w-64"
                    value="{{ old('date') }}"
                    required
                >
            </div>

            <!-- Salesperson  -->
            <div class="mt-4">
                <label class="block text-green-900 font-semibold block">Salesperson</label>
                <select 
                    name="user_id"
                    class="p-2 border border-yellow-800 rounded text-xs md:text-sm"
                    required
                >
                    <!-- Empty option (deselect filter) -->
                    <option value=""></option>

                    <!-- Distinct values -->
                    @foreach ($sales_users as $user)
                        <option 
                            value="{{ $user->id }}"
                            {{ old('user_id') == $user->id ? 'selected' : '' }}
                        >
                            {{ $user->last_name }}, {{ $user->first_name }}
                        </option>
                    @endforeach

                </select>

            </div>

            <!-- Customer  -->
            <div x-data="{ search: '', open: false }" class="mt-4">

                <label class="block text-green-900 font-semibold">Customer</label>

                <!-- Search box -->
                <input 
                    x-model="search"
                    @focus="open = true"
                    @click.away="open = false"
                    type="text"
                    placeholder="Search customers..."
                    class="border border-yellow-800 rounded p-2 w-64"
                    x-init="
                        @if(old('customer_id'))
                            search = '{{ $customers->firstWhere('id', old('customer_id'))->last_name }}, {{ $customers->firstWhere('id', old('customer_id'))->first_name }}';
                            $refs.customerSelect.value = '{{ old('customer_id') }}';
                        @endif
                    "
                >

                <!-- Hidden select that actually submits -->
                <select name="customer_id" x-ref="customerSelect" class="hidden" required>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">
                            {{ $customer->last_name }}, {{ $customer->first_name }}
                        </option>
                    @endforeach
                </select>

                <!-- Filtered dropdown -->
                <ul 
                    x-show="open"
                    class="border border-yellow-800 bg-white rounded mt-1 max-h-40 overflow-y-auto w-64 absolute z-50"
                >
                    @foreach ($customers as $customer)
                        <li 
                            @click="
                                $refs.customerSelect.value = '{{ $customer->id }}';
                                search = '{{ $customer->last_name }}, {{ $customer->first_name }}';
                                open = false;
                            "
                            x-show="'{{ strtolower($customer->last_name . ', ' . $customer->first_name) }}'.includes(search.toLowerCase())"
                            class="p-2 hover:bg-yellow-200 cursor-pointer"
                        >
                            {{ $customer->last_name }}, {{ $customer->first_name }}
                        </li>
                    @endforeach
                </ul>

            </div>


            
        </div>

        <!-- Button  -->
        <div class="flex mt-12 justify-center max-w-xl">
            <x-button-admin type="submit" value="Add Sale" />
        </div>

    </form>

    <!-- ========================= -->
    <!-- Load Script for Date -->
    <!-- ========================= -->
    @push('scripts')

        <script>

            if (!document.getElementById('sale_date').value) {
                const today = new Date();
                const formatted = today.toLocaleDateString('en-CA');
                document.getElementById('sale_date').value = formatted;
            }

        </script>

    @endpush


@endsection
