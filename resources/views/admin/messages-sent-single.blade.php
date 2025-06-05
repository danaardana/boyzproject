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

@section("title", "| Sent Message Details ")

@section('content')
<div class="main-content">
<div class="page-content">
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Sent Message Details</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.messages.index', ['filter' => 'sent']) }}">Sent Messages</a></li>
                        <li class="breadcrumb-item active">Message Details</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
                <!-- Left sidebar -->
                <div class="email-leftbar card">
                    <div class="mail-list mt-4">
                        <a href="{{ route('admin.messages.index', ['filter' => 'inbox']) }}">
                            <i class="mdi mdi-email-outline me-2"></i> Inbox 
                            @php
                                $unreadCount = \App\Models\ContactMessage::where('is_read', false)->notDeleted()->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="ms-1 float-end badge bg-danger rounded-pill">{{ $unreadCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('admin.messages.index', ['filter' => 'important']) }}">
                            <i class="mdi mdi-star me-2"></i>Important
                        </a>
                        <a href="{{ route('admin.messages.index', ['filter' => 'sent']) }}" class="active">
                            <i class="mdi mdi-email-check-outline me-2"></i>Sent Mail
                        </a>
                        <a href="{{ route('admin.messages.index', ['filter' => 'trash']) }}">
                            <i class="mdi mdi-trash-can-outline me-2"></i>Trash
                        </a>
                    </div>

                    <h6 class="mt-4">Labels</h6>

                    <div class="mail-list mt-1">
                        <a href="#"><span class="mdi mdi-arrow-right-drop-circle text-info float-end"></span>Warranty</a>
                        <a href="#"><span class="mdi mdi-arrow-right-drop-circle text-warning float-end"></span>Installation</a>
                        <a href="#"><span class="mdi mdi-arrow-right-drop-circle text-primary float-end"></span>Support</a>
                        <a href="#"><span class="mdi mdi-arrow-right-drop-circle text-danger float-end"></span>General</a>
                    </div>
                </div>
                <!-- End Left sidebar -->

            <!-- Right Sidebar -->
            <div class="email-rightbar mb-3">

                <div class="card">
                    <div class="btn-toolbar gap-2 p-3" role="toolbar">
                        <div class="btn-group">
                            <a href="{{ route('admin.messages.index', ['filter' => 'sent']) }}" class="btn btn-primary waves-light waves-effect" title="Back to Sent Messages">
                                <i class="fa fa-arrow-left"></i>
                            </a>
                            <a href="{{ route('admin.messages.show', $response->contactMessage) }}" class="btn btn-success waves-light waves-effect" title="View Original Message">
                                <i class="fa fa-eye"></i> Original
                            </a>
                        </div>
                    </div>

                    <!-- Sent Message Details -->
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 mb-0">Reply sent to: {{ $response->contactMessage->customer->name ?? 'Unknown Customer' }}</h5>
                                <small class="text-muted">{{ $response->contactMessage->customer->email ?? 'N/A' }}</small>
                                <div class="mt-1">
                                    <span class="badge bg-success me-2">Sent</span>
                                    <span class="badge bg-info">By {{ $response->admin->name }}</span>
                                    @if($response->contactMessage->category)
                                    <span class="badge {{ $response->contactMessage->getCategoryBadgeClass() }}">
                                        {{ ucfirst($response->contactMessage->getCategory()) }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <small class="text-muted">{{ $response->created_at ? $response->created_at->format('M d, Y H:i') : 'N/A' }}</small>
                            </div>
                        </div>

                        <div class="border-start border-4 border-success ps-3 mb-4">
                            <h6 class="text-success mb-2">
                                <i class="mdi mdi-send me-1"></i>
                                Your Response:
                            </h6>
                            <p class="mb-0">{{ $response->message }}</p>
                        </div>

                        <!-- Response Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="font-size-13 text-muted mb-2">Response Details:</h6>
                                <ul class="list-unstyled mb-0">
                                    <li><strong>Sent by:</strong> {{ $response->admin->name }}</li>
                                    <li><strong>Sent to:</strong> {{ $response->contactMessage->customer->name }}</li>
                                    <li><strong>Customer Email:</strong> {{ $response->contactMessage->customer->email }}</li>
                                    <li><strong>Sent at:</strong> {{ $response->created_at ? $response->created_at->format('M d, Y H:i') : 'N/A' }}</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6 class="font-size-13 text-muted mb-2">Original Message Info:</h6>
                                <ul class="list-unstyled mb-0">
                                    <li><strong>Subject:</strong> {{ $response->contactMessage->content_key ?? 'Message' }}</li>
                                    <li><strong>Category:</strong> {{ $response->contactMessage->category ? ucfirst($response->contactMessage->getCategory()) : 'N/A' }}</li>
                                    <li><strong>Status:</strong> {{ $response->contactMessage->status ? ucfirst($response->contactMessage->getStatus()) : 'N/A' }}</li>
                                    <li><strong>Received:</strong> {{ $response->contactMessage->created_at ? $response->contactMessage->created_at->format('M d, Y H:i') : 'N/A' }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('admin.messages.show', $response->contactMessage) }}" class="btn btn-primary waves-effect">
                                <i class="mdi mdi-eye me-1"></i>View Full Conversation
                            </a>
                            <a href="{{ route('admin.messages.index', ['filter' => 'sent']) }}" class="btn btn-secondary waves-effect">
                                <i class="mdi mdi-arrow-left me-1"></i>Back to Sent Messages
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.partials.footer')

</div>

@endsection

@push('styles')
<style>
.border-success {
    border-color: #28a745 !important;
}

.mail-list a.active {
    background-color: #f0f8ff;
    color: #007bff;
    font-weight: 600;
}
</style>
@endpush 