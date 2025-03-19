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
    
    <!-- IcoFont CDN -->

    <script src="https://cdn.jsdelivr.net/npm/icofont@1.0.0/main.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/icofont@1.0.0/dist/icofont.min.css" rel="stylesheet">
    
    <meta http-equiv="Content-Security-Policy" content="
    default-src * 'self' data: https://www.tiktok.com https://www.tiktokv.com; 
    img-src * 'self' data: blob: https://www.tiktok.com https://www.tiktokv.com https://yourdomain.com;
    style-src * 'self' 'unsafe-inline';
    script-src * 'self' 'unsafe-inline' 'unsafe-eval' https://www.tiktok.com https://www.tiktokv.com;
    frame-src * 'self' https://www.tiktok.com https://www.tiktokv.com;">


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
