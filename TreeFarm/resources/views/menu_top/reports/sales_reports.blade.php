@extends('layouts.app')

@section('title')
    Sales Reports
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-green-900">Sales Reports</h2>

    <!-- Back to Reports Button  -->
    <x-back-controller route='reports' label='Back to Reports Page' />

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
    <!-- Sales by User Form -->
    <!-- ========================= -->
    <form action="{{ route('reports.sales_by_user') }}" method="POST" class="mt-6">
        @csrf

        <div class="mb-4">

            <h3 class="text-xl font-bold text-green-900 mb-2">Sales by User</h3>

            <!-- Sales by User  -->
            <div class="flex flex-wrap gap-12 mt-2">

                <!-- Start Date  -->
                <div class="mt-4">
                    <label class="block text-green-900 font-semibold block">Start Date</label>
                    <input 
                        type="date" 
                        name="user_start_date" 
                        id="user_start_date"
                        class="border border-yellow-800 rounded p-2 w-64"
                        value="{{ old('user_start_date') }}"
                        required
                    >
                </div>

                <!-- End Date  -->
                <div class="mt-4">
                    <label class="block text-green-900 font-semibold block">End Date</label>
                    <input 
                        type="date" 
                        name="user_end_date" 
                        id="user_end_date"
                        class="border border-yellow-800 rounded p-2 w-64"
                        value="{{ old('user_end_date') }}"
                        required
                    >
                </div>

                <!-- Button  -->
                <div class="flex mt-12 justify-center max-w-xl">
                    <x-button-admin type="submit" value="Generate Report" />
                </div>
            
        </div>

    </form>

    <!-- ========================= -->
    <!-- Sales by Tree/Pot Size Form -->
    <!-- ========================= -->
    <form action="{{ route('reports.sales_by_tree_pot') }}" method="POST" class="mt-8">
        @csrf

        <div class="mb-4">

            <h3 class="text-xl font-bold text-green-900 mb-2">Sales by Tree and Pot Size</h3>

            <!-- Sales by User  -->
            <div class="flex flex-wrap gap-x-12 gap-y-4 mb-2">

                <!-- Start Date  -->
                <div class="mt-4">
                    <label class="block text-green-900 font-semibold block">Start Date</label>
                    <input 
                        type="date" 
                        name="tree_start_date" 
                        id="tree_start_date"
                        class="border border-yellow-800 rounded p-2 w-64"
                        value="{{ old('tree_start_date') }}"
                        required
                    >
                </div>

                <!-- End Date  -->
                <div class="mt-4">
                    <label class="block text-green-900 font-semibold block">End Date</label>
                    <input 
                        type="date" 
                        name="tree_end_date" 
                        id="tree_end_date"
                        class="border border-yellow-800 rounded p-2 w-64"
                        value="{{ old('tree_end_date') }}"
                        required
                    >
                </div>

                <!-- Button  -->
                <div class="flex mt-12 justify-center max-w-xl">
                    <x-button-admin type="submit" value="Generate Report" />
                </div>
            
        </div>

    </form>

    <!-- ========================= -->
    <!-- Load Script for Date -->
    <!-- ========================= -->
    @push('scripts')

        <script>

            // Helper: format date as YYYY-MM-DD
            function formatDate(date) {
                return date.toISOString().split('T')[0];
            }

            // Today
            const today = new Date();

            // One month ago
            const oneMonthAgo = new Date();
            oneMonthAgo.setMonth(oneMonthAgo.getMonth() - 1);

            // Set defaults for Sales by User
            if (!document.getElementById('user_start_date').value) {
                document.getElementById('user_start_date').value = formatDate(oneMonthAgo);
            }

            if (!document.getElementById('user_end_date').value) {
                document.getElementById('user_end_date').value = formatDate(today);
            }

            // Set defaults for Sales by Tree/Pot Size
            if (!document.getElementById('tree_start_date').value) {
                document.getElementById('tree_start_date').value = formatDate(oneMonthAgo);
            }

            if (!document.getElementById('tree_end_date').value) {
                document.getElementById('tree_end_date').value = formatDate(today);
            }

        </script>

    @endpush


@endsection
