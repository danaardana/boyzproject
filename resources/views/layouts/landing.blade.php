<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Boys Project')</title>
    <link rel="shortcut icon" href="{{ asset('landing/images/favicon.ico') }}">
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('landing/css/master.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/responsive.css') }}">

    @stack('styles') <!-- Untuk tambahan CSS di halaman tertentu -->

</head>

<body>
    

    <!--=== Wrapper Start ======-->
    <div class="wrapper">

    @include('partials.navbar')
        

    @yield('content')

    
    @include('partials.footer')
    </div>
    <!--=== Wrapper End ======-->

    <!-- JavaScript -->
    <script src="{{ asset('landing/js/jquery.min.js') }}"></script>
    <script src="{{ asset('landing/js/validator.js') }}"></script>
    <script src="{{ asset('landing/js/plugins.js') }}"></script>
    <script src="{{ asset('landing/js/master.js') }}"></script>
    <script src="{{ asset('landing/js/bootsnav.js') }}"></script>
    @stack('scripts') <!-- Untuk tambahan script di halaman tertentu -->
</body>
</html>
