
<?php
// include language configuration file based on selected language
$lang = "us";
if (isset($_GET['lang'])) {
   $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
}
if( isset( $_SESSION['lang'] ) ) {
    $lang = $_SESSION['lang'];
}else {
    $lang = "us";
}
require_once ("./admin/lang/" . $lang . ".php");

?>
<!DOCTYPE html>
<html lang="<?php echo $lang ?>">

<head>
    
    <title>Dashboard | @yield('title')</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="Themesbrand" name="author"/>
    <link rel="shortcut icon" href="{{ asset('landing/images/favicon.ico') }}">
    <!-- preloader css -->
    <link rel="stylesheet" href="{{ asset('admin/css/preloader.min.css') }}" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('admin/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{ asset('admin/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    @stack('styles') <!-- Untuk tambahan CSS di halaman tertentu -->

</head>

<body>
<!-- Begin page -->
<div id="layout-wrapper"> 

    @yield('content')

</div>
<!-- END layout-wrapper -->

<!-- JAVASCRIPT -->
<script src="{{ asset('admin/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('admin/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('admin/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('admin/libs/feather-icons/feather.min.js') }}"></script>

<!-- pace js -->
<script src="{{ asset('admin/libs/pace-js/pace.min.js') }}"></script>

<script src="{{ asset('admin/js/app.js') }}"></script>

@stack('scripts') <!-- Untuk tambahan script di halaman tertentu -->

</body>

</html>