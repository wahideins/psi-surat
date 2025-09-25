<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Font Alexandria -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@100..900&display=swap" rel="stylesheet">
    <!-- Font Alexandria -->

    <!-- Font Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <!-- Font Inter -->

    <style>
        *,
        *::before,
        *::after {
        box-sizing: border-box; /* supaya padding & border tidak menambah ukuran total */
        margin: 0;
        padding: 0;
        }
        body{
            padding-top:5rem;
        }
        body::-webkit-scrollbar{
            display:none;
        }

    </style>
    @stack('styles')
</head>
<body>
    
    <nav>
        @yield('navbar')
    </nav>

    <main>
        @yield('main')
    </main>

    <footer>
        @yield('footer')
    </footer>

    @stack('scripts')
</body>
</html>