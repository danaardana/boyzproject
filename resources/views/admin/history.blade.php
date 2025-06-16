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

@section("title", "| Session History")

@section('content')

<div class="main-content">

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Comprehensive Session History</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">Admin Management</a></li>
                            <li class="breadcrumb-item active">Session History</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Enhanced Statistics Cards -->
        @if(isset($sessionStats) && !empty($sessionStats))
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Total Sessions</p>
                                <h4 class="mb-0">{{ $sessionStats['total_sessions'] ?? 0 }}</h4>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bx-desktop text-white font-size-20"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Unique Admins</p>
                                <h4 class="mb-0">{{ $sessionStats['unique_admins'] ?? 0 }}</h4>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-success">
                                    <span class="avatar-title">
                                        <i class="bx bx-user-check text-white font-size-20"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Current Admin</p>
                                <h4 class="mb-0">{{ $currentAdminSessions->count() ?? 0 }}</h4>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-danger">
                                    <span class="avatar-title">
                                        <i class="bx bx-user text-white font-size-20"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Today</p>
                                <h4 class="mb-0">{{ $adminSessions->filter(function($session) { return \Carbon\Carbon::parse($session['last_activity'])->isToday(); })->count() }}</h4>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-purple">
                                    <span class="avatar-title">
                                        <i class="bx bx-calendar text-white font-size-20"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Action Buttons and Filter -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="mb-3">
                    <h5 class="card-title">Complete Session History <span class="text-muted fw-normal ms-2">({{ $totalSessions }})</span></h5>
                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-end gap-2">
                    <form action="{{ route('admin.clean-sessions') }}" method="POST" onsubmit="return confirm('Are you sure you want to clean old sessions (older than 30 days)?')">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            <i class="bx bx-trash"></i> Clean Old Sessions
                        </button>
                    </form>
                    <a href="{{ route('admin.admin') }}" class="btn btn-primary">
                        <i class="bx bx-arrow-back"></i> Back to Admin Management
                    </a>
                </div>
            </div>
        </div>
        <!-- end row -->

        <!-- Detailed Sessions Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">All Admin Login Sessions</h4>
                        <p class="card-title-desc">Comprehensive tracking of all admin authentication sessions with detailed security information.</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered dt-responsive nowrap w-100" id="history-datatable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Admin</th>
                                        <th>Platform</th>
                                        <th>Browser</th>
                                        <th>User Agent</th>
                                        <th>Login Time</th>
                                        <th>Last Activity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($adminSessions->isNotEmpty())
                                        @foreach($adminSessions as $session)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2">
                                                        @if(strtolower($session['platform'] ?? '') === 'windows')
                                                            <i class="bx bx-desktop text-primary font-size-16"></i>
                                                        @elseif(strtolower($session['platform'] ?? '') === 'android')
                                                            <i class="bxl-android text-success font-size-16"></i>
                                                        @elseif(strtolower($session['platform'] ?? '') === 'ios' || strtolower($session['platform'] ?? '') === 'mac')
                                                            <i class="bxl-apple text-info font-size-16"></i>
                                                        @elseif(strtolower($session['platform'] ?? '') === 'linux')
                                                            <i class="bxl-tux text-warning font-size-16"></i>
                                                        @else
                                                            <i class="bx bx-question-mark text-muted font-size-16"></i>
                                                        @endif
                                                    </div>
                                                    <div>
                                                                                                <h6 class="mb-0">{{ $session['admin_name'] ?? 'Unknown' }}</h6>
                                        @if(($session['admin_id'] ?? 0) === auth('admin')->id())
                                            <span class="badge bg-info-subtle text-info">Current User</span>
                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary-subtle text-primary">
                                                    {{ $session['platform'] ?? 'Unknown' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary-subtle text-secondary">
                                                    {{ $session['browser'] ?? 'Unknown' }}
                                                </span>
                                            </td>
                                            <td>
                                                <small class="text-muted" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: block;" 
                                                       title="{{ $session['user_agent'] ?? 'N/A' }}">
                                                    {{ Str::limit($session['user_agent'] ?? 'N/A', 50) }}
                                                </small>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $session['login_time'] ?? 'N/A' }}</small>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $session['last_activity'] ?? 'N/A' }}</small>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No admin login sessions found.</td>
                                        </tr>
                                    @endif
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

<!-- Custom styles for purple background -->
<style>
.bg-purple {
    background-color: #7c60e0 !important;
}
.mini-stat-icon.bg-purple .avatar-title {
    background-color: #7c60e0 !important;
}
</style>
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
    $('#history-datatable').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'colvis'],
        order: [[4, 'desc']], // Sort by Login Time descending (column index 4)
        pageLength: 25,
        scrollX: true,
        columnDefs: [
            { targets: [3], orderable: false } // User Agent column is not orderable
        ]
    });
});

function showSessionDetails(sessionId) {
    // You can implement a modal or expand functionality here
    alert('Session ID: ' + sessionId + '\n\nFull session details can be implemented here.');
}
</script>
@endpush
