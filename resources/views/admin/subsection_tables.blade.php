
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
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="card-header">
                                        <h4 class="card-title">{{ $language["Section_Content"] }}</h4>
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
                                <!-- Modal for adding subsection -->
                                <div class="modal fade modal-add" tabindex="-1" role="dialog" aria-labelledby="addSubsectionModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <form>
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addSubsectionModalLabel">
                                                        <i class="mdi mdi-plus-circle me-2"></i>Add New Subsection
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <!-- Basic Information -->
                                                        <div class="col-lg-6">
                                                            <div class="card border">
                                                                <div class="card-header bg-light">
                                                                    <h6 class="card-title mb-0">
                                                                        <i class="mdi mdi-information-outline me-1"></i>Content Information
                                                                    </h6>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="mb-3">
                                                                        <label for="subsection-category" class="form-label">{{ $language["Category"] }} <span class="text-danger">*</span></label>
                                                                        <select required class="form-control form-select" id="subsection-category">
                                                                            <option value="">Choose Section</option>
                                                                            @if(isset($sections) && $sections->isNotEmpty())
                                                                                @foreach($sections->unique('section_name') as $section)
                                                                                    <option value="{{ $section->section_name }}">{{ $section->section_name }}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="subsection-title" class="form-label">{{ $language["Title"] }} <span class="text-danger">*</span></label>
                                                                        <input class="form-control" type="text" id="subsection-title" placeholder="Enter content title" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="subsection-subtitle" class="form-label">{{ $language["Subtitle"] }}</label>
                                                                        <textarea class="form-control" id="subsection-subtitle" rows="3" placeholder="Enter content value"></textarea>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="subsection-description" class="form-label">{{ $language["Description"] }}</label>
                                                                        <textarea class="form-control" id="subsection-description" rows="2" placeholder="Enter description"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Settings & Metadata -->
                                                        <div class="col-lg-6">
                                                            <div class="card border">
                                                                <div class="card-header bg-light">
                                                                    <h6 class="card-title mb-0">
                                                                        <i class="mdi mdi-cog-outline me-1"></i>Settings & Metadata
                                                                    </h6>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="mb-3">
                                                                        <label for="subsection-type" class="form-label">{{ $language["Type"] }}</label>
                                                                        <select class="form-control form-select" id="subsection-type">
                                                                            <option value="text">Text</option>
                                                                            <option value="image">Image</option>
                                                                            <option value="video">Video</option>
                                                                            <option value="link">Link</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="subsection-order" class="form-label">{{ $language["Show_Order"] }}</label>
                                                                        <input class="form-control" type="number" id="subsection-order" min="0" value="0">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="subsection-extra-data" class="form-label">Extra Data (JSON)</label>
                                                                        <textarea class="form-control" id="subsection-extra-data" rows="4" placeholder='{"key": "value"}'></textarea>
                                                                        <small class="text-muted">Optional JSON data for additional configuration</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                        <i class="mdi mdi-close me-1"></i>Cancel
                                                    </button>
                                                    <button type="button" class="btn btn-primary">
                                                        <i class="mdi mdi-content-save me-1"></i>Save Subsection
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <h2 class="mb-4">
                                    <i class="mdi mdi-file-tree me-2"></i>{{ $sectionName ? "Section " . ucwords($sectionName) : "All Subsections" }}
                                    <small class="text-muted">({{ isset($sections) ? $sections->count() : 0 }} items)</small>
                                </h2>
                                <div class="table-responsive">
                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>{{ $language["Category"] }}</th>
                                            <th>{{ $language["Title"] }}</th>
                                            <th>{{ $language["Subtitle"] }}</th>
                                            <th>{{ $language["Type"] }}</th>
                                            <th>{{ $language["Show_Order"] }}</th>
                                            <th>{{ $language["Create"] }}</th>
                                                <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @if(isset($sections) && $sections->count() > 0)
                                        @foreach ($sections as $section)
                                            <tr>
                                                        <td>
                                                            <span class="badge badge-soft-secondary">{{ $loop->iteration }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-soft-info">{{ $section->section_name }}</span>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <h6 class="mb-1">{{ $section->content_key }}</h6>
                                                                @if($section->content_value)
                                                                    <p class="text-muted mb-0 small">{{ Str::limit($section->content_value, 50) }}</p>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if($section->description)
                                                                <span class="text-muted">{{ Str::limit($section->description, 30) }}</span>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-soft-primary">{{ ucfirst($section->type) }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="fw-medium">{{ $section->show_order }}</span>
                                                        </td>
                                                        <td>
                                                            <small class="text-muted">{{ \Carbon\Carbon::parse($section->created_at)->format('M d, Y') }}</small>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <button type="button" class="btn btn-light btn-sm waves-effect" data-bs-toggle="modal"
                                                                data-bs-target=".modal-{{ $section->id }}" title="Edit Subsection">
                                                                    <i class="mdi mdi-pencil"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-light btn-sm waves-effect" title="View Details">
                                                                    <i class="mdi mdi-eye"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-light btn-sm waves-effect text-danger" title="Delete">
                                                                    <i class="mdi mdi-delete"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                            </tr>

                                                    <!-- Edit Modal for each subsection -->
                                                    <div class="modal fade modal-{{ $section->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <form>
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">
                                                                            <i class="mdi mdi-pencil-circle me-2"></i>Edit Subsection: {{ $section->content_key }}
                                                                        </h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-lg-6">
                                                                                <div class="card border">
                                                                                    <div class="card-header bg-light">
                                                                                        <h6 class="card-title mb-0">Content Information</h6>
                                                                                    </div>
                                                                                    <div class="card-body">
                                                                                        <div class="mb-3">
                                                                                            <label class="form-label">{{ $language["Category"] }}</label>
                                                                                            <input class="form-control" type="text" value="{{ $section->section_name }}" readonly>
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <label class="form-label">{{ $language["Title"] }}</label>
                                                                                            <input class="form-control" type="text" value="{{ $section->content_key }}">
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <label class="form-label">{{ $language["Subtitle"] }}</label>
                                                                                            <textarea class="form-control" rows="3">{{ $section->content_value }}</textarea>
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <label class="form-label">{{ $language["Description"] }}</label>
                                                                                            <textarea class="form-control" rows="2">{{ $section->description }}</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <div class="card border">
                                                                                    <div class="card-header bg-light">
                                                                                        <h6 class="card-title mb-0">Settings & Metadata</h6>
                                                                                    </div>
                                                                                    <div class="card-body">
                                                                                        <div class="mb-3">
                                                                                            <label class="form-label">{{ $language["Type"] }}</label>
                                                                                            <select class="form-control form-select">
                                                                                                <option value="text" {{ $section->type == 'text' ? 'selected' : '' }}>Text</option>
                                                                                                <option value="image" {{ $section->type == 'image' ? 'selected' : '' }}>Image</option>
                                                                                                <option value="video" {{ $section->type == 'video' ? 'selected' : '' }}>Video</option>
                                                                                                <option value="link" {{ $section->type == 'link' ? 'selected' : '' }}>Link</option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <label class="form-label">{{ $language["Show_Order"] }}</label>
                                                                                            <input class="form-control" type="number" value="{{ $section->show_order }}">
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <label class="form-label">Extra Data (JSON)</label>
                                                                                            <textarea class="form-control" rows="4">{{ $section->extra_data }}</textarea>
                                                                                            <small class="text-muted">Optional JSON data for additional configuration</small>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                                        <button type="button" class="btn btn-primary">Update Subsection</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                        @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="8" class="text-center">No subsections available</td>
                                                </tr>
                                            @endif
                                    </tbody>
                                </table>                           
                                </div>                           
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