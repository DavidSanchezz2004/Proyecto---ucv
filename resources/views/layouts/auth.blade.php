<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Iniciar Sesión') — SOL-Access Manager</title>
    
    <!-- Montserrat Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"
          integrity="sha384-XGjxtQfXaH2tnPFa9x+ruJTuLE3Aa6LhHSWRr1XeTyhezb4abCG4ccI5AkVDxqC+" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f1f5f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
            margin: 0;
        }
        /* Background circles matching the design */
        .bg-circle {
            position: absolute;
            border-radius: 50%;
            border: 2px solid #3b82f6;
            opacity: 0.6;
            z-index: 0;
        }
        .circle-1 { width: 220px; height: 220px; top: 12%; right: 20%; border-width: 4px; border-color: #60a5fa; }
        .circle-2 { width: 60px; height: 60px; top: 32%; right: 18%; border-color: #93c5fd; }
        .circle-3 { width: 90px; height: 90px; bottom: 25%; left: 18%; border-width: 3px; border-color: #60a5fa; }
        .circle-4 { width: 30px; height: 30px; bottom: 20%; left: 16%; border-color: #fff; opacity: 0.8; }

        @yield('styles')
    </style>
</head>
<body>
    <!-- Decoración de fondo -->
    <div class="bg-circle circle-1"></div>
    <div class="bg-circle circle-2"></div>
    <div class="bg-circle circle-3"></div>
    <div class="bg-circle circle-4"></div>

    <div style="z-index: 10; width: 100%; display: flex; justify-content: center; padding: 1rem;">
        @yield('content')
    </div>

    @stack('modals')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    @yield('scripts')
</body>
</html>
