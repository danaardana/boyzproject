
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

@section("title", "| $type table ")

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
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $language["Website_Content"] }}</a></li>
                                    <li class="breadcrumb-item active">{{ ucwords($type) }}</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                 
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="card-header">
                                        <h4 class="card-title">{{ ucwords($type) }}</h4>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                                        <div>
                                            <button type="button" class="btn btn-primary waves-effect" data-bs-toggle="modal"
                                        data-bs-target=".modal-add">{{ $language["Add"] }}</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="">
                            </div>
                            <div class="card-body">
                            @if ($type === 'categories')
                                <table  id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ $language["Show_Order"] }}</th>
                                            <th>{{ $language["Title"] }}</th>
                                            <th>{{ $language["Image"] }}</th>
                                            <th>Hyperlink</th>
                                            <th> </th>
                                        </tr>
                                    </thead>
                                        @foreach ($SectionContents as $subsection)
                                        @php
                                            $extraData = json_decode($subsection->extra_data);
                                        @endphp
                                            <tr>
                                                <td>{{ $subsection->show_order }}</td>
                                                <td>{{ $subsection->content_key }}</td>
                                                <td>    
                                                    @if ($extraData && isset($extraData->image))
                                                    <img class="avatar-md" alt="{{ $extraData->image }}" 
                                                    src="{{ asset($extraData->image) }}" data-holder-rendered="true">
                                                    @else
                                                    Image Not Set
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($extraData && isset($extraData->link))
                                                    {{ $extraData->link }}
                                                    @else
                                                    Link Not Set
                                                    @endif</td>
                                                <td>
                                                    <button type="button" class="btn btn-light waves-effect bx bx-pencil" data-bs-toggle="modal"
                                                    data-bs-target=".modal-{{ $subsection->id }}"></button>
                                                </td>
                                            </tr>
                                    
                                            <!-- Modal for updating item -->
                                            <div class="modal fade modal-{{ $subsection->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="myLargeModalLabel">{{ $language["Edit"] }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">   
                                                                <div class="card">
                                                                    <div class="">
                                                                            <img class="card-img-top img-fluid" alt="{{ ($extraData->image) ?? 'Not Set' }}" 
                                                                            src="{{ asset(($extraData->image) ?? '') }}" data-holder-rendered="true">
                                                                    </div>         
                                                                    <div class="card-body">                       
                                                                        <div class="mb-3">
                                                                            <label for="example-number-input" class="form-label">{{ $language["Show_Order"] }}</label>
                                                                            <input class="form-control" type="number" value="{{ $subsection->show_order }}" id="example-number-input">
                                                                        </div>                                                         
                                                                        <div class="mb-3">
                                                                            <label for="example-text-input" class="form-label">{{ $language["Title"] }}</label>
                                                                            <input class="form-control" type="text" value="{{ $subsection->content_key }}" id="example-text-input">
                                                                        </div>                                                   
                                                                        <div class="mb-3">
                                                                            <label for="example-text-input" class="form-label">{{ $language["Description"] }}</label>
                                                                            <input class="form-control" type="text" value="{{ $subsection->content_value }}" id="example-text-input">
                                                                        </div>                                        
                                                                        <div class="mb-3">
                                                                            <label for="example-text-input" class="form-label">Hyperlink</label>
                                                                            <input class="form-control" type="text" value="{{ ($extraData->link) ?? 'Not Set' }}" id="example-text-input">
                                                                        </div>                                                                        
                                                                        <div class="mb-3">     
                                                                            <label for="example-url-input" class="form-label">{{ $language["Image"] }}</label>
                                                                            <input class="form-control" type="url" value="{{ ($extraData->image) ?? 'Not Set' }}" id="example-url-input">                                                
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-primary">Save changes</button>
                                                            </div>
                                                        </form>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <table  id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th> </th>
                                        </tr>
                                    </thead>
                                            <tr>
                                                <td>No Data</td>
                                            </tr>                                    
                                    </tbody>
                                </table>
                           
                            @endif
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