
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
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="card-header">
                                        <h4 class="card-title">{{ $language["Landing_Page"] }}</h4>
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
                                    <div class="row">
                                        <!-- Basic Information -->
                                        <div class="col-lg-6">
                                            <div class="card border">
                                                <div class="card-header bg-light">
                                                    <h6 class="card-title mb-0">
                                                        <i class="mdi mdi-information-outline me-1"></i>Basic Information
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <label for="section-name" class="form-label">{{ $language["Name"] }} <span class="text-danger">*</span></label>
                                                        <select required class="form-control form-select" id="section-name">
                                                        <option value="">{{ $language["Choose_a_Category"] }}</option>    
                                                            @foreach ($sections as $section)
                                                               <option value="{{ $section->name }}">{{ $section->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="section-title" class="form-label">{{ $language["Title"] }}</label>
                                                        <input class="form-control" type="text" id="section-title" placeholder="Enter section title">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="section-description" class="form-label">{{ $language["Description"] }}</label>
                                                        <textarea class="form-control" id="section-description" rows="3" placeholder="Enter section description"></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="section-content" class="form-label">{{ $language["Content"] }}</label>
                                                        <textarea class="form-control" id="section-content" rows="3" placeholder="Enter section content"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Button & Settings -->
                                        <div class="col-lg-6">
                                            <div class="card border">
                                                <div class="card-header bg-light">
                                                    <h6 class="card-title mb-0">
                                                        <i class="mdi mdi-cog-outline me-1"></i>Button & Settings
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <label for="section-btn-text" class="form-label">{{ $language["Btn_Text"] }}</label>
                                                        <input class="form-control" type="text" id="section-btn-text" placeholder="Button text">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="section-btn-url" class="form-label">{{ $language["Btn_URL"] }}</label>
                                                        <input class="form-control" type="url" id="section-btn-url" placeholder="https://example.com">
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="section-layout" class="form-label">{{ $language["Layout"] }}</label>
                                                                <select class="form-control form-select" id="section-layout">
                                                                    <option value="1">Layout 1</option>
                                                                    <option value="2">Layout 2</option>
                                                                    <option value="3">Layout 3</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="section-order" class="form-label">{{ $language["Show_Order"] }}</label>
                                                                <input class="form-control" type="number" id="section-order" min="0" value="0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <div class="form-check form-switch form-switch-lg">
                                                            <input class="form-check-input" type="checkbox" id="section-active" checked>
                                                            <label class="form-check-label" for="section-active">
                                                                <span class="fw-medium">{{ $language["Active"] }}</span>
                                                                <small class="text-muted d-block">Enable this section for display</small>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
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
                                                <div class="row">
                                                    <!-- Basic Information -->
                                                    <div class="col-lg-6">
                                                        <div class="card border">
                                                            <div class="card-header bg-light">
                                                                <h6 class="card-title mb-0">
                                                                    <i class="mdi mdi-information-outline me-1"></i>Basic Information
                                                                </h6>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="mb-3">
                                                                    <label class="form-label">{{ $language["Name"] }}</label>
                                                                    <input class="form-control" type="text" value="{{ $section->name }}" disabled>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">{{ $language["Title"] }}</label>
                                                                    <input class="form-control" type="text" value="{{ $section->title }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">{{ $language["Description"] }}</label>
                                                                    <textarea class="form-control" rows="3">{{ $section->description ?? '' }}</textarea>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">{{ $language["Content"] }}</label>
                                                                    <textarea class="form-control" rows="3">{{ $section->content ?? '' }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Button & Settings -->
                                                    <div class="col-lg-6">
                                                        <div class="card border">
                                                            <div class="card-header bg-light">
                                                                <h6 class="card-title mb-0">
                                                                    <i class="mdi mdi-cog-outline me-1"></i>Button & Settings
                                                                </h6>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="mb-3">
                                                                    <label class="form-label">{{ $language["Btn_Text"] }}</label>
                                                                    <input class="form-control" type="text" value="{{ $section->butten_text ?? '' }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">{{ $language["Btn_URL"] }}</label>
                                                                    <input class="form-control" type="url" value="{{ $section->butten_link ?? '' }}">
                                                                </div>
                                                                
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">{{ $language["Layout"] }}</label>
                                                                            <select class="form-control form-select">
                                                                                <option value="1" {{ $section->layout == 1 ? 'selected' : '' }}>Layout 1</option>
                                                                                <option value="2" {{ $section->layout == 2 ? 'selected' : '' }}>Layout 2</option>
                                                                                <option value="3" {{ $section->layout == 3 ? 'selected' : '' }}>Layout 3</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">{{ $language["Show_Order"] }}</label>
                                                                            <input class="form-control" type="number" value="{{ $section->show_order }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="mb-3">
                                                                    <div class="form-check form-switch form-switch-lg">
                                                                        <input class="form-check-input" type="checkbox" {{ $section->is_active ? 'checked' : '' }}>
                                                                        <label class="form-check-label">
                                                                            <span class="fw-medium">{{ $language["Active"] }}</span>
                                                                            <small class="text-muted d-block">Enable this section for display</small>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
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

<style>
.badge-soft-primary { background-color: rgba(116, 120, 141, 0.1); color: #74788d; }
.badge-soft-success { background-color: rgba(52, 168, 83, 0.1); color: #34a853; }
.badge-soft-danger { background-color: rgba(234, 67, 53, 0.1); color: #ea4335; }
.badge-soft-warning { background-color: rgba(251, 188, 52, 0.1); color: #fbbc34; }
.badge-soft-info { background-color: rgba(52, 168, 226, 0.1); color: #34a8e2; }
.badge-soft-secondary { background-color: rgba(116, 120, 141, 0.1); color: #74788d; }

.card-title-desc { 
    font-size: 0.875rem; 
    color: #6c757d; 
}
</style>
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