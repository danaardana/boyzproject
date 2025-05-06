
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
                                    <li class="breadcrumb-item active">Landing Page</li>
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
                                        <h4 class="card-title">Landing Page</h4>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-light waves-effect" data-bs-toggle="modal"
                                    data-bs-target=".modal-add">{{ $language["Add"] }}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">                                    
                                <!-- Modal for addding item -->
                                <div class="modal fade modal-add" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form>
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myLargeModalLabel">{{ $language["Edit"] }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">                                    
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">{{ $language["Name"] }}</label>
                                                        <select required class="form-control form-select">
                                                        <option value="">{{ $language["Choose_a_Category"] }}</option>    
                                                            @foreach ($sections as $section)
                                                               <option value="{{ $section->name }}">{{ $section->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="example-url-input" class="form-label">{{ $language["Title"] }}</label>
                                                        <input class="form-control" type="url" value="" id="example-url-input">
                                                    </div>                           
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">{{ $language["Description"] }}</label>
                                                        <input class="form-control" type="text" value="" id="example-text-input">
                                                    </div>                    
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">{{ $language["Content"] }}</label>
                                                        <input class="form-control" type="text" value="" id="example-text-input">
                                                    </div>                    
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">{{ $language["Btn_Text"] }}</label>
                                                        <input class="form-control" type="text" value="" id="example-text-input">
                                                    </div>                    
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">{{ $language["Btn_URL"] }}</label>
                                                        <input class="form-control" type="text" value="" id="example-text-input">
                                                    </div>                
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">{{ $language["Active"] }}</label>
                                                        <input class="form-control" type="text" value="0" id="example-text-input">
                                                    </div>          
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">{{ $language["Layout"] }}</label>
                                                        <input class="form-control" type="text" value="1" id="example-text-input">
                                                    </div>                
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">{{ $language["Show_Order"] }}</label>
                                                        <input class="form-control" type="text" value="0" id="example-text-input">
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

                                <h2>All Sections</h2>
                                <table  id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>{{ $language["Name"] }}</th>
                                            <th>{{ $language["Title"] }}</th>
                                            <th>{{ $language["Description"] }}</th>
                                            <th>{{ $language["Content"] }}</th>
                                            <th>{{ $language["Btn_Text"] }}</th>
                                            <th>{{ $language["Btn_URL"] }}</th>
                                            <th>{{ $language["Active"] }}</th>
                                            <th>{{ $language["Layout"] }} </th>
                                            <th>{{ $language["Show_Order"] }}</th>
                                            <th> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sections as $section)
                                            <tr>
                                                <td>{{ $section->id }}</td>
                                                <td><a href="{{ route('admin.subsection_tables', ['id' => $section->id]) }}">{{ $section->name }}</a></td>
                                                <td>{{ $section->title }}</td>
                                                <td>{{ Str::limit($section->description, 10)  }}</td>
                                                <td>{{ Str::limit($section->content, 10) ?? '-' }}</td>
                                                <td>{{ $section->butten_text ?? '-'  }}</td>
                                                <td>{{ $section->butten_link ?? '-'  }}</td>
                                                <td>{{ $section->is_active ? 'Active' : 'Non Active' }}</td>
                                                <td>{{ $section->layout }}</td>
                                                <td>{{ $section->show_order }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-light waves-effect bx bx-pencil" data-bs-toggle="modal"
                                                    data-bs-target=".modal-{{ $section->id }}"></button>
                                                </td>
                                            </tr>                                            
                                    
                                            <!-- Modal for updating item -->
                                            <div class="modal fade modal-{{ $section->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="myLargeModalLabel">{{ $language["Edit"] }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">                                    
                                                                <div class="mb-3">
                                                                    <label for="example-text-input" class="form-label">{{ $language["Name"] }}</label>
                                                                    <input class="form-control" type="text" value="{{ $section->name }}" id="example-text-input">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="example-url-input" class="form-label">{{ $language["Title"] }}</label>
                                                                    <input class="form-control" type="url" value="{{ $section->tittle }}" id="example-url-input">
                                                                </div>                           
                                                                <div class="mb-3">
                                                                    <label for="example-text-input" class="form-label">{{ $language["Description"] }}</label>
                                                                    <input class="form-control" type="text" value="{{ $section->description ?? 'Not Set'  }}" id="example-text-input">
                                                                </div>                    
                                                                <div class="mb-3">
                                                                    <label for="example-text-input" class="form-label">{{ $language["Content"] }}</label>
                                                                    <input class="form-control" type="text" value="{{ $section->content  ?? 'Not Set'  }}" id="example-text-input">
                                                                </div>                    
                                                                <div class="mb-3">
                                                                    <label for="example-text-input" class="form-label">{{ $language["Btn_Text"] }}</label>
                                                                    <input class="form-control" type="text" value="{{ $section->butten_text ?? 'Not Set'  }}" id="example-text-input">
                                                                </div>                    
                                                                <div class="mb-3">
                                                                    <label for="example-text-input" class="form-label">{{ $language["Btn_URL"] }}</label>
                                                                    <input class="form-control" type="text" value="{{ $section->butten_link ?? 'Not Set'  }}" id="example-text-input">
                                                                </div>                
                                                                <div class="mb-3">
                                                                    <label for="example-text-input" class="form-label">{{ $language["Active"] }}</label>
                                                                    <input class="form-control" type="text" value="{{ $section->is_active ? 'Active' : 'Non Active' }}" id="example-text-input">
                                                                </div>                
                                                                <div class="mb-3">
                                                                    <label for="example-text-input" class="form-label">{{ $language["Show_Order"] }}</label>
                                                                    <input class="form-control" type="text" value="{{ $section->show_order }}" id="example-text-input">
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