
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

@extends('layouts.admin')

@include('admin.partials.navbar')  

@section("title", "| user List ")

@section('content')

<div class="main-content">

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18"><?php echo $language["User_List"]; ?></h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo $language["User_Management"]; ?></a></li>
                            <li class="breadcrumb-item active"><?php echo $language["User_List"]; ?></li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="mb-3">
                    <h5 class="card-title">Admins List <span class="text-muted fw-normal ms-2">{{ $totalAdmins }}</span></h5>
                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                    <div>
                        <a href="#" class="btn btn-light"><i class="bx bx-plus me-1"></i>{{ $language["Add"] }}</a>
                    </div>
                </div>

            </div>
        </div>
        <!-- end row -->

        <div class="table-responsive mb-4">
            <table class="table align-middle datatable dt-responsive table-check nowrap" style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                <thead>
                    <tr>
                        <th scope="col">{{ $language["Name"] }}</th>
                        <th scope="col">Email</th>
                        <th scope="col">{{ $language["Verified"] }}</th>
                        <th style="width: 80px; min-width: 80px;">{{ $language["Action"] }}</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach($admins as $admin)
                    <tr>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>
                            @if ($admin->email_verified_at)
                                {{ $admin->email_verified_at }}
                            @else
                                <a href="{{ route('admin.email-verification', ['email' => $admin->email]) }}">
                                    {{ $language["Send_Verification"] }}
                                </a>
                            @endif
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">{{ $language["Edit"] }}</a></li>
                                    <li><a class="dropdown-item" href="#">{{ $language["Delete"] }}</a></li>
                                </ul>
                            </div>
                        </td>
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
