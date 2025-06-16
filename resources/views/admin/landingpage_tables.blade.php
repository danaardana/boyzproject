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
                                            <form id="add-section-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myLargeModalLabel">Add Section</h5>
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
                                                        <select required class="form-control form-select" id="section-name" name="name">
                                                        <option value="">{{ $language["Choose_a_Category"] }}</option>    
                                                            @foreach ($sections as $section)
                                                               <option value="{{ $section->name }}">{{ $section->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="section-title" class="form-label">{{ $language["Title"] }}</label>
                                                        <input class="form-control" type="text" id="section-title" name="title" placeholder="Enter section title">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="section-description" class="form-label">{{ $language["Description"] }}</label>
                                                        <textarea class="form-control" id="section-description" name="description" rows="3" placeholder="Enter section description"></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="section-content" class="form-label">{{ $language["Content"] }}</label>
                                                        <textarea class="form-control" id="section-content" name="content" rows="3" placeholder="Enter section content"></textarea>
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
                                                        <input class="form-control" type="text" id="section-btn-text" name="button_text" placeholder="Button text">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="section-btn-url" class="form-label">{{ $language["Btn_URL"] }}</label>
                                                        <input class="form-control" type="url" id="section-btn-url" name="button_link" placeholder="https://example.com">
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="section-layout" class="form-label">{{ $language["Layout"] }}</label>
                                                                <select class="form-control form-select" id="section-layout" name="layout">
                                                                    <option value="1">Layout 1</option>
                                                                    <option value="2">Layout 2</option>
                                                                    <option value="3">Layout 3</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="section-order" class="form-label">{{ $language["Show_Order"] }}</label>
                                                                <input class="form-control" type="number" id="section-order" name="show_order" min="0" value="0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <div class="form-check form-switch form-switch-lg">
                                                            <input class="form-check-input" type="checkbox" id="section-active" name="is_active" value="1" checked>
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
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="bx bx-save me-1"></i>Save Section
                                                    </button>
                                                </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="card-title mb-0">All Sections</h4>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-secondary btn-sm" onclick="$('#datatable-buttons').DataTable().ajax.reload();">
                                            <i class="bx bx-refresh me-1"></i>Refresh
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="table-responsive">
                                    <table id="datatable-buttons" class="table table-bordered table-striped table-hover nowrap w-100">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center" style="width: 50px;">#</th>
                                                <th style="min-width: 120px;">{{ $language["Name"] }}</th>
                                                <th style="min-width: 120px; max-width: 180px;">{{ $language["Title"] }}</th>
                                                <th style="min-width: 140px; max-width: 200px;">{{ $language["Description"] }}</th>
                                                <th class="text-center" style="width: 80px;">{{ $language["Active"] }}</th>
                                                <th class="text-center" style="width: 80px;">{{ $language["Layout"] }}</th>
                                                <th class="text-center" style="width: 80px;">Order</th>
                                                <th class="text-center" style="width: 100px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sections as $section)
                                                <tr>
                                                    <td class="text-center">
                                                        <span class="fw-semibold text-muted">#{{ $section->id }}</span>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <a href="{{ route('admin.subsection_tables', ['id' => $section->id]) }}" 
                                                               class="text-dark fw-medium text-decoration-none">
                                                                {{ $section->name }}
                                                            </a>
                                                            @if($section->button_text)
                                                                <br><small class="text-muted">
                                                                    <i class="bx bx-link me-1"></i>{{ Str::limit($section->button_text, 20) }}
                                                                </small>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <span class="fw-medium">{{ Str::limit($section->title ?: 'No title', 25) }}</span>
                                                            @if($section->content)
                                                                <br><small class="text-muted">{{ Str::limit($section->content, 35) }}</small>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($section->description)
                                                            <span class="text-muted" data-bs-toggle="tooltip" 
                                                                  data-bs-placement="top" 
                                                                  title="{{ $section->description }}">
                                                                {{ Str::limit($section->description, 40) }}
                                                            </span>
                                                        @else
                                                            <small class="text-muted fst-italic">No description</small>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if($section->is_active)
                                                            <span class="badge bg-success-subtle text-success">
                                                                <i class="bx bx-check-circle me-1"></i>Active
                                                            </span>
                                                        @else
                                                            <span class="badge bg-danger-subtle text-danger">
                                                                <i class="bx bx-x-circle me-1"></i>Inactive
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-info-subtle text-info">
                                                            Layout {{ $section->layout }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-secondary-subtle text-secondary">
                                                            {{ $section->show_order }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex gap-1 justify-content-center">
                                                            <button type="button" 
                                                                    class="btn btn-soft-primary btn-sm edit-section" 
                                                                    data-id="{{ $section->id }}" 
                                                                    data-bs-toggle="tooltip" 
                                                                    data-bs-placement="top" 
                                                                    title="Edit Section">
                                                                <i class="bx bx-edit"></i>
                                                            </button>
                                                            <button type="button" 
                                                                    class="btn btn-soft-danger btn-sm delete-section" 
                                                                    data-id="{{ $section->id }}" 
                                                                    data-bs-toggle="tooltip" 
                                                                    data-bs-placement="top" 
                                                                    title="Delete Section">
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>                                            
                                        
                                                <!-- Static modals removed - using dynamic AJAX modals -->
                                            @endforeach
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

<!-- Dynamic Edit Modal Placeholder -->
<div id="dynamic-modal-placeholder"></div>

@endsection

@push("styles")
<!-- DataTables -->
<link href="{{ asset('admin/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{ asset('admin/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<!-- SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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

/* Enhanced Table Styles */
#datatable-buttons {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

#datatable-buttons thead th {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1rem 0.75rem;
}

#datatable-buttons tbody tr {
    transition: all 0.2s ease;
}

#datatable-buttons tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

#datatable-buttons tbody td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
    border-color: #f1f3f4;
}

/* Avatar and Image Styles */
.avatar-sm {
    width: 32px;
    height: 32px;
}

/* Badge Enhancements */
.badge {
    font-weight: 500;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    font-size: 0.75rem;
}

.bg-success-subtle {
    background-color: rgba(25, 135, 84, 0.1) !important;
    border: 1px solid rgba(25, 135, 84, 0.2);
}

.bg-danger-subtle {
    background-color: rgba(220, 53, 69, 0.1) !important;
    border: 1px solid rgba(220, 53, 69, 0.2);
}

.bg-info-subtle {
    background-color: rgba(13, 202, 240, 0.1) !important;
    border: 1px solid rgba(13, 202, 240, 0.2);
}

.bg-secondary-subtle {
    background-color: rgba(108, 117, 125, 0.1) !important;
    border: 1px solid rgba(108, 117, 125, 0.2);
}

/* Button Enhancements */
.btn-soft-primary {
    background-color: rgba(13, 110, 253, 0.1);
    border-color: rgba(13, 110, 253, 0.2);
    color: #0d6efd;
}

.btn-soft-primary:hover {
    background-color: rgba(13, 110, 253, 0.2);
    border-color: rgba(13, 110, 253, 0.3);
    color: #0d6efd;
    transform: translateY(-1px);
}

.btn-soft-danger {
    background-color: rgba(220, 53, 69, 0.1);
    border-color: rgba(220, 53, 69, 0.2);
    color: #dc3545;
}

.btn-soft-danger:hover {
    background-color: rgba(220, 53, 69, 0.2);
    border-color: rgba(220, 53, 69, 0.3);
    color: #dc3545;
    transform: translateY(-1px);
}

/* Table Responsive Improvements */
.table-responsive {
    border-radius: 8px;
    overflow: hidden;
}

/* DataTable Pagination */
.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0.375rem 0.75rem;
    margin: 0 0.125rem;
    border-radius: 4px;
    border: 1px solid #dee2e6;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #0d6efd;
    color: white !important;
    border-color: #0d6efd;
}

/* Loading States */
.btn-loading {
    position: relative;
    pointer-events: none;
}

.btn-loading::after {
    content: "";
    position: absolute;
    width: 16px;
    height: 16px;
    top: 50%;
    left: 50%;
    margin-left: -8px;
    margin-top: -8px;
    border: 2px solid transparent;
    border-top-color: currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Tooltip Customization */
.tooltip {
    font-size: 0.875rem;
}

/* Card Improvements */
.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border-radius: 12px;
}

.card-header {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-bottom: 1px solid #e9ecef;
    border-radius: 12px 12px 0 0 !important;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    #datatable-buttons thead th {
        padding: 0.75rem 0.5rem;
        font-size: 0.75rem;
    }
    
    #datatable-buttons tbody td {
        padding: 0.75rem 0.5rem;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
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

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{ asset('admin/js/app.js') }}"></script>

<script>
$(document).ready(function() {
    // CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        }
    });

    // Add section form submission
    $('#add-section-form').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        // Show loading state
        submitBtn.html('<i class="bx bx-loader-alt bx-spin me-1"></i>Saving...').prop('disabled', true);
        
        $.ajax({
            url: '{{ route("admin.sections.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'Accept': 'application/json'
            },
            success: function(response) {
                if (response.success) {
                    $('.modal-add').modal('hide');
                    $('#add-section-form')[0].reset();
                    
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    
                    // Reload the page to show new data
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred while saving the section.';
                
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    const firstError = Object.values(errors)[0][0];
                    errorMessage = firstError;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMessage
                });
            },
            complete: function() {
                // Reset button
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // Edit section
    $(document).on('click', '.edit-section', function() {
        const sectionId = $(this).data('id');
        
        $.ajax({
            url: `/admin/chatbot/sections/${sectionId}/edit`,
            type: 'GET',
            headers: {
                'Accept': 'application/json'
            },
            success: function(response) {
                // Create dynamic edit modal
                const modalHtml = createEditModal(response);
                $('#dynamic-modal-placeholder').html(modalHtml);
                $('#edit-section-modal').modal('show');
            },
            error: function(xhr) {
                console.error('Edit AJAX Error:', xhr);
                console.error('Status:', xhr.status);
                console.error('Response:', xhr.responseText);
                
                let errorMessage = 'Failed to load section data for editing.';
                if (xhr.status === 404) {
                    errorMessage = 'Section not found.';
                } else if (xhr.status === 403) {
                    errorMessage = 'Access denied. Please check your permissions.';
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMessage
                });
            }
        });
    });

    // Handle edit form submission
    $(document).on('submit', '#edit-section-form', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const sectionId = $('#edit-section-id').val();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        // Show loading state
        submitBtn.html('<i class="bx bx-loader-alt bx-spin me-1"></i>Updating...').prop('disabled', true);
        
        $.ajax({
            url: `/admin/chatbot/sections/${sectionId}`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-HTTP-Method-Override': 'PUT',
                'Accept': 'application/json'
            },
            success: function(response) {
                if (response.success) {
                    $('#edit-section-modal').modal('hide');
                    
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    
                    // Reload the page to show updated data
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred while updating the section.';
                
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    const firstError = Object.values(errors)[0][0];
                    errorMessage = firstError;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMessage
                });
            },
            complete: function() {
                // Reset button
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // Delete section
    $(document).on('click', '.delete-section', function() {
        const sectionId = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/chatbot/sections/${sectionId}`,
                    type: 'DELETE',
                    headers: {
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            
                            // Reload the page to show updated data
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to delete section.'
                        });
                    }
                });
            }
        });
    });

    // Function to create edit modal HTML
    function createEditModal(section) {
        return `
            <div class="modal fade" id="edit-section-modal" tabindex="-1" role="dialog" aria-labelledby="editSectionModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form id="edit-section-form" enctype="multipart/form-data">
                            <input type="hidden" id="edit-section-id" value="${section.id}">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editSectionModalLabel">Edit Section</h5>
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
                                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="name" value="${section.name}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Title</label>
                                                    <input class="form-control" type="text" name="title" value="${section.title || ''}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Description</label>
                                                    <textarea class="form-control" name="description" rows="3">${section.description || ''}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Content</label>
                                                    <textarea class="form-control" name="content" rows="3">${section.content || ''}</textarea>
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
                                                    <label class="form-label">Button Text</label>
                                                    <input class="form-control" type="text" name="button_text" value="${section.button_text || ''}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Button URL</label>
                                                    <input class="form-control" type="url" name="button_link" value="${section.button_link || ''}">
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Layout</label>
                                                            <select class="form-control form-select" name="layout">
                                                                <option value="1" ${section.layout == 1 ? 'selected' : ''}>Layout 1</option>
                                                                <option value="2" ${section.layout == 2 ? 'selected' : ''}>Layout 2</option>
                                                                <option value="3" ${section.layout == 3 ? 'selected' : ''}>Layout 3</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Show Order</label>
                                                            <input class="form-control" type="number" name="show_order" value="${section.show_order}" min="0">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <div class="form-check form-switch form-switch-lg">
                                                        <input class="form-check-input" type="checkbox" name="is_active" value="1" ${section.is_active ? 'checked' : ''}>
                                                        <label class="form-check-label">
                                                            <span class="fw-medium">Active</span>
                                                            <small class="text-muted d-block">Enable this section for display</small>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Image Upload Section -->
                                    <div class="col-12 mt-3">
                                        <div class="card border">
                                            <div class="card-header bg-light">
                                                <h6 class="card-title mb-0">
                                                    <i class="mdi mdi-image-outline me-1"></i>Image Upload
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                ${section.image ? `<div class="mb-3">
                                                    <label class="form-label">Current Image</label>
                                                    <div>
                                                        <img src="/storage/${section.image}" alt="Current image" style="max-width: 150px; height: auto;" class="border rounded">
                                                    </div>
                                                </div>` : ''}
                                                <div class="mb-3">
                                                    <label class="form-label">New Image</label>
                                                    <input class="form-control" type="file" name="image" accept="image/*">
                                                    <small class="text-muted">Optional. Max file size: 2MB. Leave empty to keep current image.</small>
                                                </div>
                                                ${section.image ? `<div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="remove_image" value="1">
                                                    <label class="form-check-label">
                                                        Remove current image
                                                    </label>
                                                </div>` : ''}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save me-1"></i>Update Section
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        `;
    }

    // Initialize tooltips
    function initializeTooltips() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                trigger: 'hover'
            });
        });
    }

    // Initialize tooltips on page load
    initializeTooltips();

    // Reinitialize tooltips after table redraws
    $('#datatable-buttons').on('draw.dt', function() {
        initializeTooltips();
    });

    // Enhanced refresh functionality
    window.refreshTable = function() {
        const table = $('#datatable-buttons').DataTable();
        table.ajax.reload(null, false); // Don't reset paging
        
        // Show loading toast
        Swal.fire({
            icon: 'info',
            title: 'Refreshing...',
            text: 'Loading latest data',
            timer: 1000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    };

    // Add loading states to buttons
    function addLoadingState(button, originalText) {
        button.html('<i class="bx bx-loader-alt bx-spin me-1"></i>Loading...').prop('disabled', true);
        return originalText;
    }

    function removeLoadingState(button, originalText) {
        button.html(originalText).prop('disabled', false);
    }

    // Enhance success messages with better styling
    function showSuccessMessage(title, text) {
        Swal.fire({
            icon: 'success',
            title: title,
            text: text,
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            background: '#d4edda',
            color: '#155724'
        });
    }

    function showErrorMessage(title, text) {
        Swal.fire({
            icon: 'error',
            title: title,
            text: text,
            confirmButtonColor: '#dc3545'
        });
    }
});
</script>

@endpush