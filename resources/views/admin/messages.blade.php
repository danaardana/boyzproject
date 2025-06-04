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

@section("title", "| User History")

@section('content')



<div class="main-content">
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Inbox</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Messages</a></li>
                            <li class="breadcrumb-item active">Inbox</li>
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
                        <a href="#" class="active"><i class="mdi mdi-email-outline me-2"></i> Inbox <span class="ms-1 float-end">({{ $messages->count() }})</span></a>
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
                                <button type="button" class="btn btn-primary waves-light waves-effect"><i class="fa fa-inbox"></i></button>
                                <button type="button" class="btn btn-primary waves-light waves-effect"><i class="fa fa-exclamation-circle"></i></button>
                                <button type="button" class="btn btn-primary waves-light waves-effect"><i class="far fa-trash-alt"></i></button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary waves-light waves-effect dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-tag"></i> <i class="mdi mdi-chevron-down ms-1"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#" data-category="all">Show All Categories</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" data-category="{{ \App\Models\ContactMessage::CATEGORY_WARRANTY }}">Warranty</a>
                                    <a class="dropdown-item" href="#" data-category="{{ \App\Models\ContactMessage::CATEGORY_INSTALLATION }}">Installation</a>
                                    <a class="dropdown-item" href="#" data-category="{{ \App\Models\ContactMessage::CATEGORY_SUPPORT }}">Support</a>
                                    <a class="dropdown-item" href="#" data-category="{{ \App\Models\ContactMessage::CATEGORY_GENERAL }}">General</a>
                                </div>
                            </div>

                            <div class="btn-group">
                                <button type="button" class="btn btn-primary waves-light waves-effect dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    More <i class="mdi mdi-dots-vertical ms-2"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#" data-status="all">Show All Status</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" data-status="{{ \App\Models\ContactMessage::STATUS_NEW }}">New</a>
                                    <a class="dropdown-item" href="#" data-status="{{ \App\Models\ContactMessage::STATUS_IN_PROGRESS }}">In Progress</a>
                                    <a class="dropdown-item" href="#" data-status="{{ \App\Models\ContactMessage::STATUS_RESOLVED }}">Resolved</a>
                                    <a class="dropdown-item" href="#" data-status="{{ \App\Models\ContactMessage::STATUS_CLOSED }}">Closed</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" onclick="markAllAsRead()">Mark All as Read</a>
                                </div>
                            </div>
                        </div>
                        <ul class="message-list">
                            @foreach($messages as $message)
                            <li class="{{ !$message->is_read ? 'unread' : '' }}" data-message-id="{{ $message->id }}">
                                <div class="col-mail col-mail-1">
                                    <div class="checkbox-wrapper-mail">
                                        <input type="checkbox" id="chk{{ $message->id }}">
                                        <label for="chk{{ $message->id }}" class="toggle"></label>
                                    </div>
                                    <a href="{{ route('admin.messages.show', $message) }}" class="title">{{ $message->customer->name }}</a>
                                    <span class="star-toggle far fa-star"></span>
                                </div>
                                <div class="col-mail col-mail-2">
                                    <a href="{{ route('admin.messages.show', $message) }}" class="subject">
                                        @if($message->category)
                                            <span class="badge {{ $message->getCategoryBadgeClass() }} me-2">{{ ucfirst($message->getCategory()) }}</span>
                                        @endif
                                        {{ $message->content_key ?? 'Message' }} – 
                                        <span class="teaser">{{ Str::limit($message->content, 60) }}</span>
                                    </a>
                                    <div class="date">{{ $message->created_at ? $message->created_at->format('M d') : 'N/A' }}</div>
                                </div>
                                @if($message->status)
                                <div class="col-mail col-mail-status">
                                    <span class="badge {{ $message->getStatusBadgeClass() }}">{{ ucfirst($message->getStatus()) }}</span>
                                </div>
                                @endif
                            </li>
                            @endforeach
                        </ul>

                    </div> <!-- card -->

                    <div class="row">
                        <div class="col-7">
                            Showing {{ $messages->count() }} messages
                        </div>
                        <div class="col-5">
                            <div class="btn-group float-end">
                                <button type="button" class="btn btn-sm btn-success waves-effect"><i class="fa fa-chevron-left"></i></button>
                                <button type="button" class="btn btn-sm btn-success waves-effect"><i class="fa fa-chevron-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div> <!-- end Col-9 -->

            </div>

        </div><!-- End row -->
    </div> <!-- container-fluid -->
</div>

@include('admin.partials.footer')
    
    </div>
    
    @endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Mark as read handler
    $('.mark-read').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var messageId = $(this).data('id');
        var $li = $(this).closest('li');
        
        $.ajax({
            url: `/admin/messages/${messageId}/read`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $li.removeClass('unread');
                $(this).remove();
            },
            error: function() {
                alert('Error marking message as read.');
            }
        });
    });

    // Category filter
    $('[data-category]').on('click', function(e) {
        e.preventDefault();
        var category = $(this).data('category');
        filterMessages('category', category);
    });

    // Status filter
    $('[data-status]').on('click', function(e) {
        e.preventDefault();
        var status = $(this).data('status');
        filterMessages('status', status);
    });

    function filterMessages(type, value) {
        $('.message-list li').each(function() {
            var $li = $(this);
            var show = true;
            
            if (value === 'all') {
                // Show all messages
                show = true;
            } else if (type === 'category') {
                var badge = $li.find('.badge');
                if (badge.length > 0) {
                    var badgeText = badge.text().toLowerCase();
                    show = badgeText.includes(value.toLowerCase());
                } else {
                    show = false;
                }
            } else if (type === 'status') {
                var statusBadge = $li.find('.col-mail-status .badge');
                if (statusBadge.length > 0) {
                    var statusText = statusBadge.text().toLowerCase();
                    show = statusText.includes(value.toLowerCase());
                } else {
                    show = false;
                }
            }
            
            if (show) {
                $li.show();
            } else {
                $li.hide();
            }
        });
    }
});

// Mark all messages as read
function markAllAsRead() {
    if (confirm('Are you sure you want to mark all messages as read?')) {
        $.ajax({
            url: '/admin/messages/read-all',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('.message-list li.unread').removeClass('unread');
                $('.mark-read').remove();
            },
            error: function() {
                alert('Error marking all messages as read.');
            }
        });
    }
}
</script>
@endpush