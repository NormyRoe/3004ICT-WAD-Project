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
            <img src="images/Logo.jpg" alt="Logo" width="90" height="90" >
            <h1 class="text-4xl font-bold text-green-700 px-8">Logan River Tree Farm</h1>
        </div>
    </header>

    @yield('body')
    
</body>
</html>