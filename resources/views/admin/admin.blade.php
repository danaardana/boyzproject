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

@section("title", "| Admin List ")

@section('content')

<div class="main-content">

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Admin Management</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin Management</a></li>
                            <li class="breadcrumb-item active">Admin List</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Stats Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Admins</p>
                                <h4 class="mb-2">{{ $totalAdmins }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="bx bx-user font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Verified Admins</p>
                                <h4 class="mb-2">{{ $admins->where('verified', true)->count() }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <i class="bx bx-check-shield font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Active Admins</p>
                                <h4 class="mb-2">{{ $admins->where('is_active', true)->count() }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-info rounded-3">
                                    <i class="bx bx-user-check font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Unverified Admins</p>
                                <h4 class="mb-2">{{ $admins->where('verified', false)->count() }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-warning rounded-3">
                                    <i class="bx bx-user-x font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="mb-3">
                    <h5 class="card-title">Admins List <span class="text-muted fw-normal ms-2">({{ $totalAdmins }})</span></h5>
                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                    <div>
                        <button type="button" class="btn btn-info" onclick="sendBulkEmails()"><i class="bx bx-mail-send me-1"></i>Send Bulk Emails</button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary waves-effect" data-bs-toggle="modal"
                    data-bs-target=".modal-add"><i class="bx bx-plus me-1"></i>Add New Admin</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">            
                        <!-- Modal for adding item -->
                        <div class="modal fade modal-add" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('admin.admins.store') }}" method="POST" id="add-admin-form">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myLargeModalLabel">Add New Admin</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">   
                                            <div class="card">      
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                                                <input class="form-control" type="text" name="name" id="name" 
                                                                       placeholder="Enter admin full name" required>
                                                                <div class="invalid-feedback name-error"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                                                <input class="form-control" type="email" name="email" id="email" 
                                                                       placeholder="Enter email address" required>
                                                                <div class="invalid-feedback email-error"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                                                <input class="form-control" type="password" name="password" id="password" 
                                                                       placeholder="Enter password (min 8 characters)" required minlength="8">
                                                                <div class="invalid-feedback password-error"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                                                <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" 
                                                                       placeholder="Confirm password" required minlength="8">
                                                                <div class="invalid-feedback password-confirmation-error"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="is_active" class="form-label">Status</label>
                                                                <select class="form-select" name="is_active" id="is_active">
                                                                    <option value="1" selected>Active</option>
                                                                    <option value="0">Inactive</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">Verification Status</label>
                                                                <div class="form-control-static">
                                                                    <span class="badge bg-warning">
                                                                        <i class="bx bx-time me-1"></i>Pending Verification (Default)
                                                                    </span>
                                                                    <small class="text-muted d-block mt-1">New admins must verify their email after creation</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="send_welcome_email" name="send_welcome_email" checked>
                                                            <label class="form-check-label" for="send_welcome_email">
                                                                Send welcome email with login credentials
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bx bx-plus me-1"></i>Create Admin
                                            </button>
                                        </div>
                                    </form>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                        <div class="table-responsive">
                            <table class="table table-bordered dt-responsive nowrap w-100" id="admins-datatable">
                                <thead class="table-light">
                                    <tr>
                                        <th><input type="checkbox" id="select-all"></th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Verified</th>
                                        <th>Last Login</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($admins as $admin)
                                    <tr>
                                        <td><input type="checkbox" data-admin-id="{{ $admin->id }}"></td>
                                        <td>{{ $admin->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <h6 class="mb-0">{{ $admin->name }}</h6>
                                                    @if($admin->id === auth('admin')->id())
                                                        <span class="badge bg-info">You</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($admin->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($admin->verified)
                                                <span class="badge bg-success">
                                                    <i class="bx bx-check me-1"></i>Verified
                                                </span>
                                            @else
                                                <span class="badge bg-warning">
                                                    <i class="bx bx-time me-1"></i>Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($admin->updated_at)
                                                <span class="text-muted">{{ $admin->updated_at->diffForHumans() }}</span>
                                            @else
                                                <span class="text-muted">Never</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $admin->created_at->format('M d, Y') }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                @if(!$admin->verified)
                                                    <button type="button" class="btn btn-success btn-sm verify-admin" 
                                                            data-id="{{ $admin->id }}" title="Verify Admin">
                                                        <i class="bx bx-check"></i>
                                                    </button>
                                                @endif
                                                @if($admin->is_active)
                                                    <button type="button" class="btn btn-warning btn-sm deactivate-admin" 
                                                            data-id="{{ $admin->id }}" title="Deactivate">
                                                        <i class="bx bx-user-x"></i>
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-info btn-sm activate-admin" 
                                                            data-id="{{ $admin->id }}" title="Activate">
                                                        <i class="bx bx-user-check"></i>
                                                    </button>
                                                @endif
                                                <div class="dropdown">
                                                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" 
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="#"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                        <li><a class="dropdown-item" href="#" onclick="sendSecurityCode({{ $admin->id }})"><i class="bx bx-key me-2"></i>Reset Password</a></li>
                                                        <li><a class="dropdown-item" href="#" onclick="sendVerificationEmail({{ $admin->id }})"><i class="bx bx-mail-send me-2"></i>Send Verification</a></li>
                                                        <li><a class="dropdown-item" href="#" onclick="sendReactivationEmail({{ $admin->id }})"><i class="bx bx-refresh me-2"></i>Send Reactivation</a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        @if($admin->id !== auth('admin')->id())
                                                            <li><a class="dropdown-item text-danger" href="#" onclick="deleteAdmin({{ $admin->id }})">
                                                                <i class="bx bx-trash me-2"></i>Delete
                                                            </a></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

    @include('admin.partials.footer')
    
</div>

@endsection

@push('styles')
<!-- DataTables -->
<link href="{{ asset('admin/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<!-- Required datatable js -->
<script src="{{ asset('admin/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- Buttons examples -->
<script src="{{ asset('admin/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

<script>
$(document).ready(function() {
    $('#admins-datatable').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'colvis'],
        order: [[1, 'asc']] // Sort by ID ascending (adjusted for checkbox column)
    });
    
    // Initialize sessions datatable if exists
    if ($('#sessions-datatable').length) {
        $('#sessions-datatable').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf'],
            order: [[5, 'desc']], // Sort by Login Time descending
            pageLength: 10
        });
    }
    
    // Select all checkbox functionality
    $('#select-all').on('change', function() {
        $('input[data-admin-id]').prop('checked', this.checked);
    });
    
    // Individual checkbox change
    $('input[data-admin-id]').on('change', function() {
        const totalCheckboxes = $('input[data-admin-id]').length;
        const checkedCheckboxes = $('input[data-admin-id]:checked').length;
        $('#select-all').prop('checked', totalCheckboxes === checkedCheckboxes);
    });

    // Add Admin Form Submission
    $('#add-admin-form').on('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').empty();
        
        // Basic client-side validation
        var name = $('#name').val().trim();
        var email = $('#email').val().trim();
        var password = $('#password').val();
        var passwordConfirmation = $('#password_confirmation').val();
        
        var hasErrors = false;
        
        if (!name) {
            $('#name').addClass('is-invalid');
            $('.name-error').html('Name is required');
            hasErrors = true;
        }
        
        if (!email || !email.includes('@')) {
            $('#email').addClass('is-invalid');
            $('.email-error').html('Valid email is required');
            hasErrors = true;
        }
        
        if (!password || password.length < 8) {
            $('#password').addClass('is-invalid');
            $('.password-error').html('Password must be at least 8 characters');
            hasErrors = true;
        }
        
        if (password !== passwordConfirmation) {
            $('#password_confirmation').addClass('is-invalid');
            $('.password-confirmation-error').html('Passwords do not match');
            hasErrors = true;
        }
        
        if (hasErrors) {
            showErrorMessage('Please fix the validation errors and try again.');
            return;
        }
        
        // Get form data
        var formData = new FormData(this);
        
        // Ensure boolean values are properly converted
        formData.set('is_active', $('#is_active').val() === '1' ? 1 : 0);
        formData.set('send_welcome_email', $('#send_welcome_email').is(':checked') ? 1 : 0);
        
        // Debug: Log form data
        console.log('Form Data being sent:');
        for (let [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }
        
        // Disable submit button
        var submitBtn = $(this).find('button[type="submit"]');
        var originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin me-1"></i>Creating...');
        
        // Send AJAX request
        $.ajax({
            url: '{{ route("admin.admins.store") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function(response) {
                console.log('Success response:', response);
                
                if (response.success) {
                    // Close modal
                    $('.modal-add').modal('hide');
                    
                    // Reset form
                    $('#add-admin-form')[0].reset();
                    
                    // Show success message
                    showSuccessMessage(response.message, response.email_sent);
                    
                    // Reload page to show new admin
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                } else {
                    showErrorMessage(response.message || 'Unknown error occurred');
                }
            },
            error: function(xhr) {
                console.log('Error response:', xhr);
                console.log('Response text:', xhr.responseText);
                
                if (xhr.status === 422) {
                    // Validation errors
                    var errors = xhr.responseJSON.errors;
                    
                    $.each(errors, function(field, messages) {
                        var input = $('[name="' + field + '"]');
                        input.addClass('is-invalid');
                        input.siblings('.invalid-feedback').html(messages[0]);
                        
                        // For specific error containers
                        $('.' + field + '-error').html(messages[0]);
                    });
                    
                    showErrorMessage('Please fix the validation errors and try again.');
                } else if (xhr.status === 419) {
                    showErrorMessage('Session expired. Please refresh the page and try again.');
                } else {
                    var errorMessage = 'Unknown error occurred';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        try {
                            var parsed = JSON.parse(xhr.responseText);
                            errorMessage = parsed.message || errorMessage;
                        } catch (e) {
                            errorMessage = 'Server error: ' + xhr.status;
                        }
                    }
                    showErrorMessage('Error creating admin: ' + errorMessage);
                }
            },
            complete: function() {
                // Re-enable submit button
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Email availability check
    var emailCheckTimeout;
    $('#email').on('keyup', function() {
        var email = $(this).val();
        var emailInput = $(this);
        
        clearTimeout(emailCheckTimeout);
        
        if (email.length > 0 && email.includes('@')) {
            emailCheckTimeout = setTimeout(function() {
                $.ajax({
                    url: '/admin/check-email',
                    method: 'POST',
                    data: {
                        email: email,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.exists) {
                            emailInput.addClass('is-invalid');
                            $('.email-error').html('This email is already registered');
                        } else {
                            emailInput.removeClass('is-invalid');
                            $('.email-error').empty();
                        }
                    },
                    error: function() {
                        // Ignore errors for now
                    }
                });
            }, 1000); // Check after 1 second of no typing
        }
    });

    // Reset form when modal is closed
    $('.modal-add').on('hidden.bs.modal', function() {
        $('#add-admin-form')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').empty();
        clearTimeout(emailCheckTimeout);
    });
    
    // Verify admin
    $('.verify-admin').on('click', function() {
        var adminId = $(this).data('id');
        if (confirm('Are you sure you want to verify this admin?')) {
            // AJAX call to verify admin
            $.ajax({
                url: `/admin/admins/${adminId}/verify`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert('Error verifying admin.');
                }
            });
        }
    });
    
    // Activate/Deactivate admin
    $('.activate-admin, .deactivate-admin').on('click', function() {
        var adminId = $(this).data('id');
        var action = $(this).hasClass('activate-admin') ? 'activate' : 'deactivate';
        
        if (confirm(`Are you sure you want to ${action} this admin?`)) {
            $.ajax({
                url: `/admin/admins/${adminId}/${action}`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert(`Error ${action}ing admin.`);
                }
            });
        }
    });
});

function deleteAdmin(adminId) {
    if (confirm('Are you sure you want to delete this admin? This action cannot be undone.')) {
        $.ajax({
            url: `/admin/admins/${adminId}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                location.reload();
            },
            error: function() {
                alert('Error deleting admin.');
            }
        });
    }
}

// Email sending functions
function sendReactivationEmail(adminId) {
    if (confirm('Send reactivation notification email to this admin?')) {
        $.ajax({
            url: '/admin/emails/reactivation',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                admin_id: adminId
            },
            success: function(response) {
                if (response.success) {
                    alert('Reactivation email sent successfully!');
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr) {
                let errorMessage = 'Error sending reactivation email.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                alert(errorMessage);
            }
        });
    }
}

function sendSecurityCode(adminId) {
    if (confirm('Send security code for password reset to this admin?')) {
        $.ajax({
            url: '/admin/emails/security-code',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                admin_id: adminId
            },
            success: function(response) {
                if (response.success) {
                    alert('Security code sent successfully! Code expires at: ' + response.expires_at);
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr) {
                let errorMessage = 'Error sending security code.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                alert(errorMessage);
            }
        });
    }
}

function sendVerificationEmail(adminId) {
    if (confirm('Send verification email to this admin?')) {
        $.ajax({
            url: '/admin/emails/verification',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                admin_id: adminId
            },
            success: function(response) {
                if (response.success) {
                    alert('Verification email sent successfully!');
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr) {
                let errorMessage = 'Error sending verification email.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                alert(errorMessage);
            }
        });
    }
}

// Bulk email functionality
function sendBulkEmails() {
    const selectedAdmins = [];
    $('input[type="checkbox"]:checked').each(function() {
        const adminId = $(this).data('admin-id');
        if (adminId) {
            selectedAdmins.push(adminId);
        }
    });

    if (selectedAdmins.length === 0) {
        alert('Please select at least one admin.');
        return;
    }

    const emailType = prompt('Enter email type (reactivation, security_code, verification):');
    if (!emailType || !['reactivation', 'security_code', 'verification'].includes(emailType)) {
        alert('Invalid email type. Please use: reactivation, security_code, or verification');
        return;
    }

    if (confirm(`Send ${emailType} emails to ${selectedAdmins.length} selected admin(s)?`)) {
        $.ajax({
            url: '/admin/emails/bulk',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                email_type: emailType,
                admin_ids: selectedAdmins
            },
            success: function(response) {
                let message = response.message;
                if (response.errors && response.errors.length > 0) {
                    message += '\n\nErrors:\n' + response.errors.join('\n');
                }
                alert(message);
            },
            error: function(xhr) {
                let errorMessage = 'Error sending bulk emails.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                alert(errorMessage);
            }
        });
    }
}

// Success and Error Message Functions
function showSuccessMessage(message, emailSent) {
    var emailText = emailSent ? ' Welcome email sent successfully.' : ' Welcome email could not be sent.';
    var fullMessage = message + emailText;
    
    // Create success alert
    var alertHtml = `
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
            <i class="bx bx-check-circle me-2"></i>
            <strong>Success!</strong> ${fullMessage}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    
    $('body').append(alertHtml);
    
    // Auto remove after 5 seconds
    setTimeout(function() {
        $('.alert-success').fadeOut('slow', function() {
            $(this).remove();
        });
    }, 5000);
}

function showErrorMessage(message) {
    // Create error alert
    var alertHtml = `
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
            <i class="bx bx-error-circle me-2"></i>
            <strong>Error!</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    
    $('body').append(alertHtml);
    
    // Auto remove after 7 seconds (longer for errors)
    setTimeout(function() {
        $('.alert-danger').fadeOut('slow', function() {
            $(this).remove();
        });
    }, 7000);
}
</script>
@endpush
