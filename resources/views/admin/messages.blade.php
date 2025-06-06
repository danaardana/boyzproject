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
                        <a href="{{ route('admin.messages.index', ['filter' => 'inbox']) }}" class="{{ $filter == 'inbox' ? 'active' : '' }}">
                            <i class="mdi mdi-email-outline me-2"></i> Inbox 
                            @if($unreadMessagesCount > 0)
                                <span class="ms-1 float-end badge bg-danger rounded-pill">{{ $unreadMessagesCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('admin.messages.index', ['filter' => 'important']) }}" class="{{ $filter == 'important' ? 'active' : '' }}">
                            <i class="mdi mdi-star me-2"></i>Important
                        </a>
                        <a href="{{ route('admin.messages.index', ['filter' => 'sent']) }}" class="{{ $filter == 'sent' ? 'active' : '' }}">
                            <i class="mdi mdi-email-check-outline me-2"></i>Sent Mail
                        </a>
                        <a href="{{ route('admin.messages.index', ['filter' => 'trash']) }}" class="{{ $filter == 'trash' ? 'active' : '' }}">
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
                                <button type="button" class="btn btn-primary waves-light waves-effect" onclick="window.location.href='{{ route('admin.messages.index', ['filter' => 'inbox']) }}'" title="View Inbox">
                                    <i class="fa fa-inbox"></i>
                                </button>
                                <button type="button" class="btn btn-primary waves-light waves-effect" id="star-selected" title="Toggle Important">
                                    <i class="far fa-star"></i>
                                </button>
                                @if($filter == 'trash')
                                    <button type="button" class="btn btn-success waves-light waves-effect" id="restore-selected" 
                                            data-bs-toggle="modal" data-bs-target="#bulkRestoreModal"
                                            title="Move to Inbox">
                                        <i class="fas fa-inbox"></i>
                                    </button>
                                @endif
                                <button type="button" class="btn btn-primary waves-light waves-effect" id="trash-selected" 
                                        data-bs-toggle="modal" data-bs-target="#bulkDeleteModal"
                                        title="{{ $filter == 'trash' ? 'Permanently Delete' : 'Move to Trash' }}">
                                    <i class="far fa-trash-alt"></i>
                                </button>
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
                            <li class="{{ !$message->is_read ? 'unread' : '' }} {{ $message->is_important ? 'important' : '' }}" data-message-id="{{ $message->id }}">
                                <div class="col-mail col-mail-1">
                                    <div class="checkbox-wrapper-mail">
                                        <input type="checkbox" id="chk{{ $message->id }}" value="{{ $message->id }}">
                                        <label for="chk{{ $message->id }}" class="toggle"></label>
                                    </div>
                                    <a href="{{ route('admin.messages.show', $message) }}" class="title">{{ $message->customer->name }}</a>
                                    <span class="star-toggle {{ $message->is_important ? 'fas fa-star text-warning' : 'far fa-star' }}" 
                                          data-message-id="{{ $message->id }}" 
                                          title="{{ $message->is_important ? 'Remove from Important' : 'Mark as Important' }}"></span>
                                </div>
                                <div class="col-mail col-mail-2">
                                    <a href="{{ route('admin.messages.show', $message) }}" class="subject">
                                        @if($message->category)
                                            <span class="badge {{ $message->getCategoryBadgeClass() }} me-2">{{ $message->getCategoryDisplayName() }}</span>
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

<!-- Bulk Delete Confirmation Modal -->
<div class="modal fade" id="bulkDeleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="bulkDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkDeleteModalLabel">
                    @if($filter == 'trash')
                        <i class="fas fa-exclamation-triangle text-danger me-2"></i>Permanent Delete Warning
                    @else
                        <i class="fas fa-trash-alt text-warning me-2"></i>Move to Trash
                    @endif
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($filter == 'trash')
                    <div class="alert alert-danger mb-3">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Warning!</strong> This action cannot be undone.
                    </div>
                    <p>You are about to <strong>permanently delete</strong> the selected messages from the database.</p>
                    <p class="text-muted">Once deleted, these messages and all their responses will be completely removed and cannot be recovered.</p>
                @else
                    <p>Are you sure you want to move the selected messages to trash?</p>
                    <p class="text-muted">You can restore them later from the trash if needed.</p>
                @endif
                
                <hr>
                <div class="selected-messages-preview">
                    <h6><i class="fas fa-list me-2"></i>Selected Messages:</h6>
                    <div id="selectedMessagesCount" class="text-muted">No messages selected</div>
                    <div id="selectedMessagesList" class="mt-2 small"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                @if($filter == 'trash')
                    <button type="button" class="btn btn-danger" id="confirmPermanentDelete">
                        <i class="fas fa-trash me-1"></i>Permanently Delete
                    </button>
                @else
                    <button type="button" class="btn btn-warning" id="confirmMoveToTrash">
                        <i class="fas fa-trash-alt me-1"></i>Move to Trash
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Bulk Restore Confirmation Modal -->
<div class="modal fade" id="bulkRestoreModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="bulkRestoreModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkRestoreModalLabel">
                    <i class="fas fa-inbox text-success me-2"></i>Move to Inbox
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success mb-3">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Restore Messages</strong> - Messages will be moved back to your inbox.
                </div>
                <p>Are you sure you want to restore the selected messages to your inbox?</p>
                <p class="text-muted">These messages will be moved out of trash and back to your regular inbox where you can process them normally.</p>
                
                <hr>
                <div class="selected-messages-preview">
                    <h6><i class="fas fa-list me-2"></i>Selected Messages:</h6>
                    <div id="selectedRestoreMessagesCount" class="text-muted">No messages selected</div>
                    <div id="selectedRestoreMessagesList" class="mt-2 small"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                <button type="button" class="btn btn-success" id="confirmRestore">
                    <i class="fas fa-inbox me-1"></i>Move to Inbox
                </button>
            </div>
        </div>
    </div>
</div>

@include('admin.partials.footer')
    
    </div>
    
    @endsection

@push('styles')
<style>
.message-list li.important {
    background-color: #fff3cd !important;
    border-left: 3px solid #ffc107;
}

.message-list li.important:hover {
    background-color: #fff3cd !important;
}

.star-toggle {
    cursor: pointer;
    transition: all 0.2s ease;
}

.star-toggle:hover {
    transform: scale(1.1);
}

.mail-list a.active {
    background-color: #f0f8ff;
    color: #007bff;
    font-weight: 600;
}
</style>
@endpush

@push('scripts')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Pusher for real-time updates
    const pusherKey = '{{ config('broadcasting.connections.pusher.key') }}';
    const pusherCluster = '{{ config('broadcasting.connections.pusher.options.cluster') }}';
    
    if (pusherKey && pusherKey !== '' && pusherKey !== 'your_app_key') {
        const pusher = new Pusher(pusherKey, {
            cluster: pusherCluster,
            encrypted: true
        });

        const channel = pusher.subscribe('admin.notifications');

        // Listen for ContactMessageEvent
        channel.bind('ContactMessageEvent', function(data) {
            console.log('📨 Messages page received notification:', data);
            
            // Update inbox unread count
            const inboxCountElement = document.getElementById('inbox-unread-count');
            if (inboxCountElement) {
                inboxCountElement.textContent = `(${data.unreadCount})`;
                console.log('✅ Updated inbox count to:', data.unreadCount);
            }
        });

        pusher.connection.bind('connected', function() {
            console.log('📡 Messages page connected to Pusher');
        });
    }

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

    // Star toggle handler for individual messages
    $('.star-toggle').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var messageId = $(this).data('message-id');
        var $star = $(this);
        var $li = $(this).closest('li');
        
        $.ajax({
            url: `/admin/messages/${messageId}/important`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.is_important) {
                    $star.removeClass('far fa-star').addClass('fas fa-star text-warning');
                    $star.attr('title', 'Remove from Important');
                    $li.addClass('important');
                } else {
                    $star.removeClass('fas fa-star text-warning').addClass('far fa-star');
                    $star.attr('title', 'Mark as Important');
                    $li.removeClass('important');
                }
            },
            error: function() {
                alert('Error toggling message importance.');
            }
        });
    });

    // Bulk star toggle
    $('#star-selected').on('click', function() {
        var selectedMessages = [];
        $('.message-list input:checked').each(function() {
            selectedMessages.push($(this).val());
        });
        
        if (selectedMessages.length === 0) {
            alert('Please select messages first.');
            return;
        }
        
        bulkToggleImportant(selectedMessages);
    });

    // Bulk trash - prepare modal
    $('#trash-selected').on('click', function() {
        var selectedMessages = [];
        var selectedMessageTitles = [];
        
        $('.message-list input:checked').each(function() {
            selectedMessages.push($(this).val());
            var $li = $(this).closest('li');
            var customerName = $li.find('.title').text().trim();
            var subject = $li.find('.subject').contents().filter(function() {
                return this.nodeType === 3; // Text nodes only
            }).text().replace(' – ', '').trim();
            selectedMessageTitles.push(`• ${customerName}: ${subject.substring(0, 50)}...`);
        });
        
        if (selectedMessages.length === 0) {
            alert('Please select messages first.');
            return false; // Prevent modal from opening
        }
        
        // Update modal content
        $('#selectedMessagesCount').text(`${selectedMessages.length} message(s) selected`);
        $('#selectedMessagesList').html(selectedMessageTitles.slice(0, 5).join('<br>') + 
            (selectedMessageTitles.length > 5 ? '<br><small class="text-muted">... and ' + 
            (selectedMessageTitles.length - 5) + ' more</small>' : ''));
        
        // Store selected messages for later use
        window.selectedMessagesForDelete = selectedMessages;
    });

    // Modal confirmation handlers
    $('#confirmMoveToTrash').on('click', function() {
        $('#bulkDeleteModal').modal('hide');
        showLoadingState();
        bulkMoveToTrash(window.selectedMessagesForDelete);
    });

    $('#confirmPermanentDelete').on('click', function() {
        $('#bulkDeleteModal').modal('hide');
        showLoadingState();
        bulkMoveToTrash(window.selectedMessagesForDelete);
    });

    // Bulk restore - prepare modal
    $('#restore-selected').on('click', function() {
        var selectedMessages = [];
        var selectedMessageTitles = [];
        
        $('.message-list input:checked').each(function() {
            selectedMessages.push($(this).val());
            var $li = $(this).closest('li');
            var customerName = $li.find('.title').text().trim();
            var subject = $li.find('.subject').contents().filter(function() {
                return this.nodeType === 3; // Text nodes only
            }).text().replace(' – ', '').trim();
            selectedMessageTitles.push(`• ${customerName}: ${subject.substring(0, 50)}...`);
        });
        
        if (selectedMessages.length === 0) {
            alert('Please select messages first.');
            return false; // Prevent modal from opening
        }
        
        // Update restore modal content
        $('#selectedRestoreMessagesCount').text(`${selectedMessages.length} message(s) selected`);
        $('#selectedRestoreMessagesList').html(selectedMessageTitles.slice(0, 5).join('<br>') + 
            (selectedMessageTitles.length > 5 ? '<br><small class="text-muted">... and ' + 
            (selectedMessageTitles.length - 5) + ' more</small>' : ''));
        
        // Store selected messages for later use
        window.selectedMessagesForRestore = selectedMessages;
    });

    // Restore modal confirmation handler
    $('#confirmRestore').on('click', function() {
        $('#bulkRestoreModal').modal('hide');
        showLoadingState();
        bulkRestoreFromTrash(window.selectedMessagesForRestore);
    });

    function bulkToggleImportant(messageIds) {
        var requests = messageIds.map(function(id) {
            return $.ajax({
                url: `/admin/messages/${id}/important`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        Promise.all(requests).then(function() {
            location.reload();
        }).catch(function() {
            alert('Error toggling message importance.');
        });
    }

    function bulkMoveToTrash(messageIds) {
        var currentFilter = new URLSearchParams(window.location.search).get('filter');
        var requests = messageIds.map(function(id) {
            return $.ajax({
                url: `/admin/messages/${id}/trash`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        Promise.all(requests).then(function() {
            if (currentFilter === 'trash') {
                showSuccessAlert(`${messageIds.length} message(s) permanently deleted from database`);
            } else {
                showSuccessAlert(`${messageIds.length} message(s) moved to trash successfully`);
            }
            
            // Reload after a short delay
            setTimeout(function() {
                location.reload();
            }, 1500);
        }).catch(function() {
            hideLoadingState();
            if (currentFilter === 'trash') {
                showErrorAlert('Error permanently deleting messages. Please try again.');
            } else {
                showErrorAlert('Error moving messages to trash. Please try again.');
            }
        });
    }

    function bulkRestoreFromTrash(messageIds) {
        var requests = messageIds.map(function(id) {
            return $.ajax({
                url: `/admin/messages/${id}/restore`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        Promise.all(requests).then(function() {
            showSuccessAlert(`${messageIds.length} message(s) restored to inbox successfully`);
            
            // Reload after a short delay
            setTimeout(function() {
                location.reload();
            }, 1500);
        }).catch(function() {
            hideLoadingState();
            showErrorAlert('Error restoring messages. Please try again.');
        });
    }

    function showLoadingState() {
        // Create loading overlay
        const loadingHtml = `
            <div id="loadingOverlay" class="d-flex justify-content-center align-items-center position-fixed" 
                 style="top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 9999;">
                <div class="text-center text-white">
                    <div class="spinner-border text-light mb-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div>Processing selected messages...</div>
                </div>
            </div>
        `;
        $('body').append(loadingHtml);
    }

    function hideLoadingState() {
        $('#loadingOverlay').remove();
    }

    function showSuccessAlert(message) {
        hideLoadingState();
        const alertHtml = `
            <div id="successAlert" class="alert alert-success alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 10000; min-width: 300px;">
                <i class="fas fa-check-circle me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        $('body').append(alertHtml);
        
        // Auto-hide after 3 seconds
        setTimeout(function() {
            $('#successAlert').alert('close');
        }, 3000);
    }

    function showErrorAlert(message) {
        hideLoadingState();
        const alertHtml = `
            <div id="errorAlert" class="alert alert-danger alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 10000; min-width: 300px;">
                <i class="fas fa-exclamation-circle me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        $('body').append(alertHtml);
        
        // Auto-hide after 5 seconds
        setTimeout(function() {
            $('#errorAlert').alert('close');
        }, 5000);
    }

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