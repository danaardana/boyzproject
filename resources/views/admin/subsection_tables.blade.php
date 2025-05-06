
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

@section("title", "Data ")

@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                    <li class="breadcrumb-item active"><?php echo $language["Section_Content"]; ?></li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                 
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <div class="col-2">
                                        <h4 class="card-title"><?php echo $language["Section_Content"]; ?></h4>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-light waves-effect" data-bs-toggle="modal"
                                    data-bs-target=".modal-add">{{ $language["Add"] }}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h2>{{ $sectionName ? "Section " . ucwords($sectionName) : "All Subsections" }}</h2>
                                <table  id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>{{ $language["Category"] }}</th>
                                            <th>{{ $language["Title"] }}</th>
                                            <th>{{ $language["Subtitle"] }}</th>
                                            <th>{{ $language["Description"] }}</th>
                                            <th>{{ $language["Type"] }}</th>
                                            <th>Extra Data</th>
                                            <th>{{ $language["Show_Order"] }}</th>
                                            <th>{{ $language["Create"] }}</th>
                                            <th>{{ $language["Update"] }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sections as $section)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $section->section_name }}</td>
                                                <td>{{ $section->content_key }}</td>
                                                <td>{{ Str::limit($section->content_value, 10)   }}</td>
                                                <td>{{ Str::limit($section->description, 10)?? 'Not Set'   }}</td>
                                                <td>{{ $section->type }}</td>
                                                <td>{{ Str::limit($section->extra_data, 10) ?? 'Not Set' }}</td>
                                                <td>{{ $section->show_order }}</td>
                                                <td>{{ \Carbon\Carbon::parse($section->created_at)->format('d F y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($section->updated_at)->format('d F Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>                           
                            </div>                            
                        </div>
                        <!-- end cardaa -->
                    </div> <!-- end col -->
                </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    @include('admin.partials.footer')
    
</div>

@endsection

@push("styles")
<!-- DataTables -->
<link href="{{ asset('admin/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{ asset('admin/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push("scripts")

<!-- Required datatable js -->
<script src="{{ asset('admin/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- Buttons examples -->
<script src="{{ asset('admin/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('admin/libs/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ asset('admin/libs/pdfmake/build/vfs_fonts.js') }}"></script>
<script src="{{ asset('admin/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- Responsive examples -->
<script src="{{ asset('admin/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

<!-- Datatable init js -->
<script src="{{ asset('admin/js/pages/datatables.init.js') }}"></script>

<script src="{{ asset('admin/js/app.js') }}"></script>

@endpush