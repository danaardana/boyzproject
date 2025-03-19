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

    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>



    @stack('styles') <!-- Untuk tambahan CSS di halaman tertentu -->

</head>

<body>
    

    <!--=== Wrapper Start ======-->
    <div class="wrapper">

        @include('partials.navbar')

        
        

        @yield('content')

        

        
        @include('partials.footer')
        <!--=== GO TO TOP  ===-->
        <a href="#" id="back-to-top" title="Back to top">&uarr;</a>
        <!--=== GO TO TOP End ===-->
        
    </div>
    <!--=== Wrapper End ======-->

    <!-- JavaScript --><!-- Tambahkan ini di sebelum script Bootstrap -->

    <script src="{{ asset('landing/js/jquery.min.js') }}"></script>
    
    <script src="{{ asset('landing/js/validator.js') }}"></script>
    <script src="{{ asset('landing/js/plugins.js') }}"></script>
    <script src="{{ asset('landing/js/master.js') }}"></script>
    <script src="{{ asset('landing/js/bootsnav.js') }}"></script>

    <!-- Load Slick dan Waypoints -->
    <script src="{{ asset('landing/js/slick.min.js') }}"></script>
    
    @stack('scripts') <!-- Untuk tambahan script di halaman tertentu -->
</body>
</html>
