<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Boys Project')</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('landing/images/favicon.ico') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('landing/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('landing/images/logo-white.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('landing/images/logo-white.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('landing/images/logo-white.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('landing/css/master.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/chat-bubble.css') }}">
    
    <!-- IcoFont CDN -->

    <script src="https://cdn.jsdelivr.net/npm/icofont@1.0.0/main.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/icofont@1.0.0/dist/icofont.min.css" rel="stylesheet">
    
    <meta http-equiv="Content-Security-Policy" content="
    default-src * 'self' data: http: https: https://www.tiktok.com https://www.tiktokv.com; 
    img-src * 'self' data: blob: http: https: https://www.tiktok.com https://www.tiktokv.com https://yourdomain.com;
    style-src * 'self' 'unsafe-inline' http: https:;
    script-src * 'self' 'unsafe-inline' 'unsafe-eval' http: https: https://www.tiktok.com https://www.tiktokv.com;
    frame-src * 'self' http: https: https://www.tiktok.com https://www.tiktokv.com;">

    <script defer src="https://www.tiktok.com/embed.js"></script>

    @stack('styles') <!-- Untuk tambahan CSS di halaman tertentu -->

</head>

<body>
    

    <!--=== Wrapper Start ======-->
    <div class="wrapper">

        @include('landing.partials.navbar')   
        
        @yield('content')
        
        @include('landing.partials.footer')
        
    </div>
    <!--=== Wrapper End ======-->

    <!-- JavaScript -->
    <script src="{{ asset('landing/js/jquery.min.js') }}"></script>    
    <script src="{{ asset('landing/js/validator.js') }}"></script>
    <script src="{{ asset('landing/js/plugins.js') }}"></script>
    <script src="{{ asset('landing/js/master.js') }}"></script>
    <script src="{{ asset('landing/js/bootsnav.js') }}"></script>
    <script src="{{ asset('landing/js/chat-bubble.js') }}"></script>


    <!-- Load Slick dan Waypoints -->
    <script src="{{ asset('landing/js/slick.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js"></script>


    <script>
    $(document).ready(function() {
        var $grid = $('#portfolio-grid').isotope({
            itemSelector: '.portfolio-item',
            layoutMode: 'fitRows'
        });

        $('#portfolio-filter li').on('click', function() {
            $('#portfolio-filter li').removeClass('active');
            $(this).addClass('active');

            var filterValue = $(this).attr('data-group');
            if (filterValue == 'all') {
                $grid.isotope({ filter: '*' });
            } else {
                $grid.isotope({ filter: '[data-groups*="' + filterValue + '"]' });
            }

            console.log('Filter:', filterValue);
        });
    });
    </script>
    

    
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        if (window.tiktokEmbed) {
            window.tiktokEmbed();
        }
        if (window.instgrm) {
            window.instgrm.Embeds.process();
        }
    });
    </script>
    
    @stack('scripts')
</body>
</html>
