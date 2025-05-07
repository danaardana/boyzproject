
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

use Illuminate\Support\Str;

?>

@extends('layouts.admin')

@include('admin.partials.navbar')  

@section("title", "| User History")

@section('content')

<div class="main-content">

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18"><?php echo $language["User_history"]; ?></h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo $language["User_Management"]; ?></a></li>
                            <li class="breadcrumb-item active">{{$language["User_history"]}} </li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="mb-3">
                    <h5 class="card-title">{{ $language["User_history"] }}<span class="text-muted fw-normal ms-2">({{ $totalSessions }})</span></h5>
                </div>
            </div>

            <div class="col-md-6">

            </div>
        </div>
        <!-- end row -->

        <div class="table-responsive mb-4">
            <table class="table align-middle datatable dt-responsive table-check nowrap" style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                <thead>
                    <tr>
                        <th scope="col">IP Add</th>
                        <th scope="col">User Agent</th>
                        <th scope="col">Platform</th>
                        <th scope="col">Browser</th>
                        <th scope="col">Device</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Desktop</th>
                        <th scope="col">Last Activity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sessions as $session)
                    <tr>
                        <td>{{ $session->ip_address }}</td>
                        <td>{{ $session->user_id }}</td>
                        <td>{{ $session->platform }}</td>
                        <td>{{ $session->browser }}</td>
                        <td>{{ $session->device }}</td>
                        <td>{{ $session->is_mobile ? 'Yes' : 'No' }}</td>
                        <td>{{ $session->is_desktop ? 'Yes' : 'No' }}</td>
                        <td>{{ $session->last_activity }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- end table -->
        </div>
        <!-- end table responsive -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

    @include('admin.partials.footer')
    
</div>

@endsection
