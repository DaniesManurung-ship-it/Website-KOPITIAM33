{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - @yield('title', 'Café Kopitiam33')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --sage: #8BA888;
            --cream: #F5EFE6;
            --wood: #A67B5B;
            --accent: #D97642;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: #F5EFE6;
            overflow-x: hidden;
        }
        
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        .admin-content {
            flex: 1;
            padding: 1rem;
            transition: margin-left 0.3s;
        }
        
        @media (max-width: 768px) {
            .admin-content {
                margin-left: 0;
            }
        }
        
        .rotate-180 {
            transform: rotate(180deg);
        }
        
        [x-cloak] {
            display: none !important;
        }
    </style>
    
    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('styles')
</head>
<body>
    <div class="admin-wrapper">
        @include('admin.layouts.sidebar')
        
        <div class="admin-content">
            @yield('content')
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>