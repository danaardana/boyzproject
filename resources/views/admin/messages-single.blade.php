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

@section("title", "| Message Details ")

@section('content')
<div class="main-content">
<div class="page-content">
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Read Email</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.messages.index') }}">Email</a></li>
                        <li class="breadcrumb-item active">Read Email</li>
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
                        <a href="{{ route('admin.messages.index') }}" class="active">
                            <i class="mdi mdi-email-outline me-2"></i> Inbox 
                            <span class="ms-1 float-end">({{ \App\Models\ContactMessage::count() }})</span>
                        </a>
                        <a href="#"><i class="mdi mdi-star-outline me-2"></i>Starred</a>
                        <a href="#"><i class="mdi mdi-diamond-stone me-2"></i>Important</a>
                        <a href="#"><i class="mdi mdi-file-outline me-2"></i>Draft</a>
                        <a href="#"><i class="mdi mdi-email-check-outline me-2"></i>Sent Mail</a>
                        <a href="#"><i class="mdi mdi-trash-can-outline me-2"></i>Trash</a>
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
                            <a href="{{ route('admin.messages.index') }}" class="btn btn-primary waves-light waves-effect" title="Back to Inbox">
                                <i class="fa fa-inbox"></i>
                            </a>
                            @if(!$message->is_read)
                            <button type="button" class="btn btn-primary waves-light waves-effect mark-read" 
                                    data-id="{{ $message->id }}" title="Mark as Read">
                                <i class="fa fa-check"></i>
                            </button>
                            @endif
                            <button type="button" class="btn btn-primary waves-light waves-effect" 
                                    onclick="deleteMessage({{ $message->id }})" title="Delete">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary waves-light waves-effect dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-folder"></i> <i class="mdi mdi-chevron-down ms-1"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" onclick="assignToMe({{ $message->id }})">Assign to Me</a>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#assignModal">Assign to Other</a>
                            </div>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary waves-light waves-effect dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-tag"></i> <i class="mdi mdi-chevron-down ms-1"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" onclick="updateStatus('{{ \App\Models\ContactMessage::STATUS_NEW }}')">Mark as New</a>
                                <a class="dropdown-item" href="#" onclick="updateStatus('{{ \App\Models\ContactMessage::STATUS_IN_PROGRESS }}')">Mark as In Progress</a>
                                <a class="dropdown-item" href="#" onclick="updateStatus('{{ \App\Models\ContactMessage::STATUS_RESOLVED }}')">Mark as Resolved</a>
                                <a class="dropdown-item" href="#" onclick="updateStatus('{{ \App\Models\ContactMessage::STATUS_CLOSED }}')">Mark as Closed</a>
                            </div>
                        </div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-primary waves-light waves-effect dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                More <i class="mdi mdi-dots-vertical ms-2"></i>
                            </button>
                            <div class="dropdown-menu">
                                @if($message->is_read)
                                <a class="dropdown-item" href="#" onclick="markAsUnread({{ $message->id }})">Mark as Unread</a>
                                @endif
                                <a class="dropdown-item" href="#" onclick="toggleImportant({{ $message->id }})">Toggle Important</a>
                                <a class="dropdown-item" href="#" onclick="exportMessage({{ $message->id }})">Export</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#" onclick="deleteMessage({{ $message->id }})">Delete Message</a>
                            </div>
                        </div>
                    </div>

                    <!-- Original Message -->
                    <div class="card-body {{ !$message->is_read ? 'bg-light' : '' }}">
                        <div class="d-flex align-items-center mb-4">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 mb-0">{{ $message->customer->name ?? 'Unknown Customer' }}</h5>
                                <small class="text-muted">{{ $message->customer->email ?? 'N/A' }}</small>
                                <div class="mt-1">
                                    @if($message->category)
                                    <span class="badge {{ $message->getCategoryBadgeClass() }} me-2">
                                        {{ ucfirst($message->getCategory()) }}
                                    </span>
                                    @endif
                                    @if($message->status)
                                    <span class="badge {{ $message->getStatusBadgeClass() }}">
                                        {{ ucfirst($message->getStatus()) }}
                                    </span>
                                    @endif
                                    @if(!$message->is_read)
                                    <span class="badge bg-warning">Unread</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <small class="text-muted">{{ $message->created_at ? $message->created_at->format('M d, Y H:i') : 'N/A' }}</small>
                            </div>
                        </div>

                        <div class="border-start border-4 border-primary ps-3 mb-4">
                            <p class="text-muted mb-0">{{ $message->content }}</p>
                        </div>

                        <!-- Customer Information -->
                        @if($message->customer)
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="font-size-13 text-muted mb-2">Customer Details:</h6>
                                <ul class="list-unstyled mb-0">
                                    <li><strong>Name:</strong> {{ $message->customer->name }}</li>
                                    <li><strong>Email:</strong> {{ $message->customer->email }}</li>
                                    @if($message->customer->phone)
                                    <li><strong>Phone:</strong> {{ $message->customer->phone }}</li>
                                    @endif
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6 class="font-size-13 text-muted mb-2">Message Info:</h6>
                                <ul class="list-unstyled mb-0">
                                    <li><strong>Received:</strong> {{ $message->created_at ? $message->created_at->format('M d, Y H:i') : 'N/A' }}</li>
                                    @if($message->last_update_time)
                                    <li><strong>Last Updated:</strong> {{ $message->last_update_time->format('M d, Y H:i') }}</li>
                                    @endif
                                    @if($message->assignedAdmin)
                                    <li><strong>Assigned to:</strong> {{ $message->assignedAdmin->name }}</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        @endif

                        <button type="button" class="btn btn-secondary waves-effect mt-4" data-bs-toggle="modal" data-bs-target="#composemodal">
                            <i class="mdi mdi-reply me-1"></i>Reply
                        </button>
                    </div>
                    
                    <!-- Response Messages -->
                    @if($message->responses && $message->responses->count() > 0)
                        @foreach($message->responses as $response)
                        <div class="card-body border-top">
                            <div class="d-flex align-items-center mb-4">
                                <div class="flex-grow-1">
                                    <h5 class="font-size-14 mb-0">{{ $response->admin->name ?? 'Admin' }}</h5>
                                    <small class="text-muted">{{ $response->created_at ? $response->created_at->format('M d, Y H:i') : 'N/A' }}</small>
                                </div>
                            </div>

                            <div class="border-start border-4 border-success ps-3">
                                <p class="text-muted mb-0">{{ $response->message }}</p>
                            </div>
                        </div>
                        @endforeach
                    @endif

                </div>
            </div>
            <!-- card -->

        </div>
        <!-- end Col -->

    </div>
    <!-- end row -->

</div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<!-- Reply Modal -->
<div class="modal fade" id="composemodal" tabindex="-1" role="dialog" aria-labelledby="composemodalTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title font-size-16" id="composemodalTitle">Reply to {{ $message->customer->name ?? 'Customer' }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="replyForm" action="{{ route('admin.messages.respond', $message) }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label for="recipient" class="form-label">To</label>
                    <input type="email" class="form-control" id="recipient" 
                           value="{{ $message->customer->email ?? '' }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" 
                           value="Re: {{ $message->content_key ?? 'Your Message' }}" readonly>
                </div>
                
                <div class="mb-3">
                    <label for="response" class="form-label">Response</label>
                    <textarea class="form-control" id="response" name="response" rows="6" required 
                              placeholder="Type your response here..."></textarea>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Update Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="{{ \App\Models\ContactMessage::STATUS_IN_PROGRESS }}" 
                                {{ $message->status == \App\Models\ContactMessage::STATUS_IN_PROGRESS ? 'selected' : '' }}>
                            In Progress
                        </option>
                        <option value="{{ \App\Models\ContactMessage::STATUS_RESOLVED }}" 
                                {{ $message->status == \App\Models\ContactMessage::STATUS_RESOLVED ? 'selected' : '' }}>
                            Resolved
                        </option>
                        <option value="{{ \App\Models\ContactMessage::STATUS_CLOSED }}" 
                                {{ $message->status == \App\Models\ContactMessage::STATUS_CLOSED ? 'selected' : '' }}>
                            Closed
                        </option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Send <i class="fab fa-telegram-plane ms-1"></i></button>
            </div>
        </form>
    </div>
</div>
</div> 

<!-- Assign Modal -->
<div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Assign Message</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="assignForm" action="{{ route('admin.messages.assign', $message) }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label for="admin_id" class="form-label">Assign to Admin</label>
                    <select class="form-select" id="admin_id" name="admin_id" required>
                        <option value="">Select Admin</option>
                        @foreach(\App\Models\Admin::all() as $admin)
                            <option value="{{ $admin->id }}" 
                                    {{ $message->admin_id == $admin->id ? 'selected' : '' }}>
                                {{ $admin->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Assign</button>
            </div>
        </form>
    </div>
</div>
</div>

@include('admin.partials.footer')

</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Mark as read
    $('.mark-read').on('click', function() {
        var messageId = $(this).data('id');
        $.ajax({
            url: `/admin/messages/${messageId}/read`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                location.reload();
            },
            error: function() {
                alert('Error marking message as read.');
            }
        });
    });
    
    // Reply form submission
    $('#replyForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#composemodal').modal('hide');
                location.reload();
            },
            error: function() {
                alert('Error sending response.');
            }
        });
    });
    
    // Assign form submission
    $('#assignForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#assignModal').modal('hide');
                location.reload();
            },
            error: function() {
                alert('Error assigning message.');
            }
        });
    });
});

// Utility functions
function assignToMe(messageId) {
    $.ajax({
        url: `/admin/messages/${messageId}/assign`,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            location.reload();
        },
        error: function() {
            alert('Error assigning message.');
        }
    });
}

function updateStatus(status) {
    // This would need a route for updating status
    console.log('Update status to:', status);
}

function markAsUnread(messageId) {
    // This would need a route for marking as unread
    console.log('Mark as unread:', messageId);
}

function toggleImportant(messageId) {
    // This would need a route for toggling important
    console.log('Toggle important:', messageId);
}

function exportMessage(messageId) {
    // This would need a route for exporting
    console.log('Export message:', messageId);
}

function deleteMessage(messageId) {
    if (confirm('Are you sure you want to delete this message?')) {
        $.ajax({
            url: `/admin/messages/${messageId}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                window.location.href = '{{ route("admin.messages.index") }}';
            },
            error: function() {
                alert('Error deleting message.');
            }
        });
    }
}
</script>
@endpush