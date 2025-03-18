<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    <!-- Bootstrap atau CSS Admin -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin.css') }}">

    @stack('styles')
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <div class="main-content">
            <!-- Navbar Admin -->
            @include('admin.partials.navbar')

            <div class="container">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="{{ asset('assets/admin/js/admin.js') }}"></script>

    @stack('scripts')
</body>
</html>
