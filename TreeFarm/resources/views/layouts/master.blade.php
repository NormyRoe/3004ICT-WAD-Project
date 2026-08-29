<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-emerald-400">


    <!-- Header Bar -->
    <header class="bg-yellow-300 shadow-lg p-4">
        <div class="max-w-5xl mx-auto flex items-center justify-center">
            <!-- Tree Farm's Logo - the modified time is used so that the browser knows when it has changed -->
            <img src="{{ asset('images/Logo.jpg') }}?v={{ filemtime(public_path('images/Logo.jpg')) }}" 
                    alt="Logo" width="90" height="90" >
                    <!-- Name of Tree Farm -->
            <h1 class="text-4xl font-bold text-green-700 px-8">{{ $farmName }}</h1>
        </div>
    </header>

    @yield('body')
    
</body>
</html>