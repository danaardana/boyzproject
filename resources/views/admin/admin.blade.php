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
                        <a href="#" class="btn btn-primary"><i class="bx bx-plus me-1"></i>Add New Admin</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered dt-responsive nowrap w-100" id="admins-datatable">
                                <thead class="table-light">
                                    <tr>
                                        <th><input type="checkbox" id="select-all"></th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
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
                                        <td>{{ $admin->email }}</td>
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
</script>
@endpush
