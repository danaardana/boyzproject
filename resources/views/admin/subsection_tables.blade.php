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
                                            <form id="add-subsection-form" enctype="multipart/form-data">
                                                @csrf
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
                                                                        <select required class="form-control form-select" id="subsection-category" name="section_name">
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
                                                                        <input class="form-control" type="text" id="subsection-title" name="content_key" placeholder="Enter content title" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="subsection-subtitle" class="form-label">{{ $language["Subtitle"] }}</label>
                                                                        <textarea class="form-control" id="subsection-subtitle" name="content_value" rows="3" placeholder="Enter content value"></textarea>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="subsection-description" class="form-label">{{ $language["Description"] }}</label>
                                                                        <textarea class="form-control" id="subsection-description" name="description" rows="2" placeholder="Enter description"></textarea>
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
                                                                        <select class="form-control form-select" id="subsection-type" name="type">
                                                                            <option value="text">Text</option>
                                                                            <option value="image">Image</option>
                                                                            <option value="video">Video</option>
                                                                            <option value="link">Link</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="subsection-order" class="form-label">{{ $language["Show_Order"] }}</label>
                                                                        <input class="form-control" type="number" id="subsection-order" name="show_order" min="0" value="0">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="subsection-extra-data" class="form-label">Extra Data (JSON)</label>
                                                                        <textarea class="form-control" id="subsection-extra-data" name="extra_data" rows="4" placeholder='{"key": "value"}'></textarea>
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
                                                    <button type="submit" class="btn btn-primary">
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
                                                            <div class="d-flex gap-1 justify-content-center">
                                                                <button type="button" 
                                                                        class="btn btn-soft-primary btn-sm edit-subsection" 
                                                                        data-id="{{ $section->id }}" 
                                                                        data-bs-toggle="tooltip" 
                                                                        data-bs-placement="top" 
                                                                        title="Edit Subsection">
                                                                    <i class="mdi mdi-pencil"></i>
                                                                </button>
                                                                <button type="button" 
                                                                        class="btn btn-soft-danger btn-sm delete-subsection" 
                                                                        data-id="{{ $section->id }}" 
                                                                        data-bs-toggle="tooltip" 
                                                                        data-bs-placement="top" 
                                                                        title="Delete Subsection">
                                                                    <i class="mdi mdi-delete"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                            </tr>

                                                    <!-- Static modals removed - using dynamic AJAX modals -->
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

.table-responsive {
    border-radius: 8px;
    overflow: hidden;
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

    // Add subsection form submission
    $('#add-subsection-form').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        // Show loading state
        submitBtn.html('<i class="mdi mdi-loading mdi-spin me-1"></i>Saving...').prop('disabled', true);
        
        $.ajax({
            url: '{{ route("admin.section-content.store") }}',
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
                    $('#add-subsection-form')[0].reset();
                    
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
                let errorMessage = 'An error occurred while saving the subsection.';
                
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

    // Edit subsection
    $(document).on('click', '.edit-subsection', function() {
        const subsectionId = $(this).data('id');
        
        $.ajax({
            url: '{{ route("admin.section-content.edit", ":id") }}'.replace(':id', subsectionId),
            type: 'GET',
            headers: {
                'Accept': 'application/json'
            },
            success: function(response) {
                if (response.success) {
                    // Create dynamic edit modal with the correct data structure
                    const modalHtml = createEditModal(response.data);
                    $('#dynamic-modal-placeholder').html(modalHtml);
                    $('#edit-subsection-modal').modal('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message || 'Failed to load subsection data for editing.'
                    });
                }
            },
            error: function(xhr) {
                console.error('Edit AJAX Error:', xhr);
                console.error('Status:', xhr.status);
                console.error('Response:', xhr.responseText);
                
                let errorMessage = 'Failed to load subsection data for editing.';
                if (xhr.status === 404) {
                    errorMessage = 'Subsection not found.';
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
    $(document).on('submit', '#edit-subsection-form', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const subsectionId = $('#edit-subsection-id').val();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        // Show loading state
        submitBtn.html('<i class="mdi mdi-loading mdi-spin me-1"></i>Updating...').prop('disabled', true);
        
        $.ajax({
            url: '{{ route("admin.section-content.update", ":id") }}'.replace(':id', subsectionId),
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
                    $('#edit-subsection-modal').modal('hide');
                    
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
                let errorMessage = 'An error occurred while updating the subsection.';
                
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

    // Delete subsection
    $(document).on('click', '.delete-subsection', function() {
        const subsectionId = $(this).data('id');
        
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
                    url: '{{ route("admin.section-content.destroy", ":id") }}'.replace(':id', subsectionId),
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
                            text: 'Failed to delete subsection.'
                        });
                    }
                });
            }
        });
    });

    // Function to create edit modal HTML
    function createEditModal(subsection) {
        return `
            <div class="modal fade" id="edit-subsection-modal" tabindex="-1" role="dialog" aria-labelledby="editSubsectionModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <form id="edit-subsection-form" enctype="multipart/form-data">
                            <input type="hidden" id="edit-subsection-id" value="${subsection.id}">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editSubsectionModalLabel">
                                    <i class="mdi mdi-pencil-circle me-2"></i>Edit Subsection: ${subsection.content_key}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <!-- Content Information -->
                                    <div class="col-lg-6">
                                        <div class="card border">
                                            <div class="card-header bg-light">
                                                <h6 class="card-title mb-0">
                                                    <i class="mdi mdi-information-outline me-1"></i>Content Information
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Category <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="section_name" value="${subsection.section_name}" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Title <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="content_key" value="${subsection.content_key}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Subtitle</label>
                                                    <textarea class="form-control" name="content_value" rows="3">${subsection.content_value || ''}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Description</label>
                                                    <textarea class="form-control" name="description" rows="2">${subsection.description || ''}</textarea>
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
                                                    <label class="form-label">Type</label>
                                                    <select class="form-control form-select" name="type">
                                                        <option value="text" ${subsection.type == 'text' ? 'selected' : ''}>Text</option>
                                                        <option value="image" ${subsection.type == 'image' ? 'selected' : ''}>Image</option>
                                                        <option value="video" ${subsection.type == 'video' ? 'selected' : ''}>Video</option>
                                                        <option value="link" ${subsection.type == 'link' ? 'selected' : ''}>Link</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Show Order</label>
                                                    <input class="form-control" type="number" name="show_order" value="${subsection.show_order || 0}" min="0">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Extra Data (JSON)</label>
                                                    <textarea class="form-control" name="extra_data" rows="4">${subsection.extra_data || ''}</textarea>
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
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-content-save me-1"></i>Update Subsection
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
});
</script>

@endpush