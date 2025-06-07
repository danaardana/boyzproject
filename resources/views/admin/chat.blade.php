@extends('layouts.admin')

@include('admin.partials.navbar')  

@section("title", "| Chat ")

@push('styles')
<style>
    /* Enhanced Chat List Styling - No Avatars */
    .chat-leftsidebar {
        width: 350px !important;
        max-height: calc(100vh - 180px) !important;
        min-height: 600px !important;
    }
    
    .chat-message-list {
        max-height: calc(100vh - 280px) !important;
        min-height: 500px !important;
        overflow-y: auto !important;
    }
    
    .chat-list {
        padding-bottom: 20px !important;
    }
    
    .chat-list li a {
        padding: 18px 16px !important;
        border-radius: 8px;
        transition: all 0.3s ease;
        margin-bottom: 4px;
        display: block;
    }
    
    .chat-list li a:hover {
        background-color: #f8f9fa;
        transform: translateX(2px);
    }
    
    .chat-list li.active a {
        background-color: #e3f2fd;
        border-left: 4px solid #2196f3;
    }
    
    .chat-list li.unread a {
        background-color: #fff3cd;
        border-left: 4px solid #ffc107;
    }
    
    .chat-list li.resolved a {
        background-color: #d4edda;
        border-left: 4px solid #28a745;
        opacity: 0.8;
    }
    
    .chat-list h5 {
        font-size: 16px !important;
        font-weight: 600;
        margin-bottom: 4px !important;
    }
    
    .chat-list p {
        font-size: 14px !important;
        color: #6c757d;
        margin-bottom: 0;
        line-height: 1.4;
    }
    
    .chat-list .font-size-12 {
        font-size: 13px !important;
        color: #8a909d;
        font-weight: 500;
    }
    
    .chat-list .unread-message .badge {
        font-size: 11px;
        padding: 4px 8px;
        position: absolute;
        top: 10px;
        right: 10px;
    }
    
    .chat-list .d-flex {
        position: relative;
    }
    
    /* Custom scrollbar for chat list */
    .chat-message-list::-webkit-scrollbar {
        width: 6px;
    }
    
    .chat-message-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .chat-message-list::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    .chat-message-list::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }
    
    /* Filter button styling */
    .chat-filters .btn {
        font-size: 12px !important;
        padding: 4px 8px !important;
        border-radius: 6px !important;
    }
    
    .chat-filters .dropdown-menu {
        min-width: 180px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border: 1px solid #e3e6f0;
    }
    
    .chat-filters .dropdown-item {
        font-size: 13px;
        padding: 8px 16px;
    }
    
    .chat-filters .dropdown-item:hover {
        background-color: #f8f9fa;
    }
    
    .chat-filters .dropdown-item.active {
        background-color: #e3f2fd;
        color: #2196f3;
    }
    
    .chat-filters .dropdown-header {
        font-size: 11px;
        font-weight: 600;
        color: #6c757d;
        padding: 8px 16px 4px;
    }

    /* Chat Status Indicators */
    .conversation-status {
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 10px;
        font-weight: 500;
    }
    
    .status-active {
        background-color: #d4edda;
        color: #155724;
    }
    
    .status-waiting {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .status-resolved {
        background-color: #d1ecf1;
        color: #0c5460;
    }
</style>
@endpush

@section('content')

<div class="main-content">

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Live Chat Support</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Support</a></li>
                            <li class="breadcrumb-item active">Live Chat</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Chat Header -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Customer Conversations</h5>
                        <p class="text-muted mb-0">Manage live chat conversations from landing page</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="refreshConversations()">
                            <i class="bx bx-refresh me-1"></i>Refresh
                        </button>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bx bx-cog me-1"></i>Settings
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="bx bx-bell me-2"></i>Notifications</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bx bx-time me-2"></i>Auto-responses</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#"><i class="bx bx-help-circle me-2"></i>Chat Guidelines</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Chat Header -->



        <div class="d-lg-flex">
            <div class="chat-leftsidebar card">

                <div class="p-3">
                    <div class="search-box position-relative">
                        <input type="text" class="form-control rounded border" placeholder="Search conversations...">
                        <i class="bx bx-search search-icon"></i>
                    </div>
                </div>

                <div class="chat-leftsidebar-nav">
                    <div class="tab-content">
                        <div class="tab-pane show active">
                            <div class="chat-message-list" data-simplebar>
                                <div class="pt-3">
                                    <div class="px-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h5 class="font-size-14 mb-0">Active Conversations</h5>
                                            <div class="chat-filters">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bx bx-filter-alt me-1"></i>Filter
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="#" data-filter="all"><i class="bx bx-list-ul me-2"></i>All Conversations</a></li>
                                                        <li><a class="dropdown-item" href="#" data-filter="unread"><i class="bx bx-bell me-2"></i>Unread Only</a></li>
                                                        <li><a class="dropdown-item" href="#" data-filter="with-email"><i class="bx bx-envelope me-2"></i>With Email</a></li>
                                                        <li><a class="dropdown-item" href="#" data-filter="without-email"><i class="bx bx-user me-2"></i>Anonymous</a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><h6 class="dropdown-header">Sort By</h6></li>
                                                        <li><a class="dropdown-item" href="#" data-sort="newest"><i class="bx bx-time me-2"></i>Newest First</a></li>
                                                        <li><a class="dropdown-item" href="#" data-sort="oldest"><i class="bx bx-history me-2"></i>Oldest First</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="list-unstyled chat-list" id="conversationsList">
                                        @isset($conversations)
                                            @forelse($conversations as $conversation)
                                                <li class="{{ $conversation->hasUnreadMessages() ? 'unread' : '' }} {{ $conversation->status === 'resolved' ? 'resolved' : '' }}" 
                                                    data-conversation-id="{{ $conversation->id }}"
                                                    data-has-email="{{ $conversation->customer_email ? 'true' : 'false' }}">
                                                    <a href="#" onclick="loadConversation({{ $conversation->id }})">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                                <h5 class="text-truncate font-size-16 mb-1">
                                                                    {{ $conversation->customer_name }}
                                                                    @if($conversation->customer_email)
                                                                        <i class="bx bx-envelope text-success ms-1" title="Has Email"></i>
                                                                    @else
                                                                        <i class="bx bx-user text-muted ms-1" title="Anonymous"></i>
                                                                    @endif
                                                                    @if($conversation->status === 'resolved')
                                                                        <i class="bx bx-check-circle text-success ms-1" title="Resolved"></i>
                                                                    @endif
                                                                </h5>
                                                                <p class="text-truncate mb-0 font-size-13">
                                                                    {{ Str::limit($conversation->initial_message, 50) }}
                                                                </p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                                <div class="font-size-12">{{ $conversation->created_at->diffForHumans() }}</div>
                                                                @if($conversation->hasUnreadMessages())
                                                                    <span class="badge bg-danger rounded-pill">{{ $conversation->unreadCount() }}</span>
                                                                @endif
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                            @empty
                                                <li class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="bx bx-chat display-4 d-block mb-2"></i>
                                                        <p class="mb-0">No conversations yet</p>
                                                        <small>Conversations from the landing page will appear here</small>
                                                    </div>
                                        </li>
                                            @endforelse
                                        @else
                                            <!-- Demo conversations when no real data -->
                                            <li class="active">
                                            <a href="#">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                            <h5 class="text-truncate font-size-16 mb-1">
                                                                Sarah Johnson
                                                                <i class="bx bx-envelope text-success ms-1" title="Has Email"></i>
                                                            </h5>
                                                            <p class="text-truncate mb-0 font-size-13">Need help with my motorcycle headlight installation</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                            <div class="font-size-12">2 min</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                            <li class="unread">
                                            <a href="#">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                            <h5 class="text-truncate font-size-16 mb-1">
                                                                Mike Anonymous
                                                                <i class="bx bx-user text-muted ms-1" title="Anonymous"></i>
                                                            </h5>
                                                            <p class="text-truncate mb-0 font-size-13">Question about brake pad compatibility</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                            <div class="font-size-12">5 min</div>
                                                            <span class="badge bg-danger rounded-pill">2</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        @endisset
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- end chat-leftsidebar -->

            <div class="w-100 user-chat mt-4 mt-sm-0 ms-lg-1">
                <div class="card">
                    <div class="p-3 px-lg-4 border-bottom">
                        <div class="row">
                            <div class="col-xl-4 col-7">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="font-size-14 mb-1 text-truncate">
                                            <a href="#" class="text-dark" id="currentCustomerName">Select a conversation</a>
                                        </h5>
                                        <p class="text-muted text-truncate mb-0" id="currentCustomerStatus">Choose a conversation from the left</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8 col-5">
                                <ul class="list-inline user-chat-nav text-end mb-0">
                                    <li class="list-inline-item">
                                        <button class="btn nav-btn" type="button" id="transferBtn" style="display: none;">
                                            <i class="bx bx-transfer"></i>
                                        </button>
                                    </li>
                                    <li class="list-inline-item">
                                        <button class="btn nav-btn" type="button" id="resolveBtn" style="display: none;">
                                            <i class="bx bx-check-circle"></i>
                                            </button>
                                    </li>
                                    <li class="list-inline-item">
                                        <div class="dropdown">
                                            <button class="btn nav-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#" id="viewCustomerBtn">View Customer Info</a>
                                                <a class="dropdown-item" href="#" id="conversationHistoryBtn">Conversation History</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger" href="#" id="closeConversationBtn">Close Conversation</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>                                                                                                                                                                                                                                                                                        
                            </div>
                        </div>
                    </div>

                    <div class="chat-conversation p-3 px-2" data-simplebar id="chatMessages" style="height: 400px;">
                        <div class="text-center mt-5">
                            <div class="avatar-lg mx-auto">
                                <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                    <i class="bx bx-chat display-4"></i>
                                </div>
                                        </div>
                            <div class="mt-3">
                                <h5>Welcome to Live Chat Support</h5>
                                <p class="text-muted">Select a conversation from the left or start a new one to begin chatting with customers.</p>
                                        </div>
                                    </div>
                                </div>
                                
                    <div class="p-3 border-top" id="chatInput" style="display: none;">
                        <form id="replyForm">
                            <div class="row">
                                <div class="col">
                                    <div class="position-relative">
                                        <input type="text" class="form-control border bg-light-subtle" 
                                               id="messageInput" name="message" 
                                               placeholder="Type your reply...">
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary chat-send w-md waves-effect waves-light">
                                        <span class="d-none d-sm-inline-block me-2">Send</span> 
                                        <i class="mdi mdi-send float-end"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end user chat -->
        </div>
        <!-- End d-lg-flex  -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

    @include('admin.partials.footer')
    
</div>

@endsection

@push('scripts')
<script>
// Global variables
let currentConversationId = null;
let currentFilter = 'all';
let currentSort = 'newest';

$(document).ready(function() {
    console.log('💬 [DEBUG] Chat dashboard initialized');
    
    // Auto-refresh conversations every 30 seconds
    setInterval(function() {
        refreshConversations();
    }, 30000);
    
    // Filter and Sort functionality
    $('.chat-filters [data-filter]').on('click', function(e) {
        e.preventDefault();
        $('.chat-filters [data-filter]').removeClass('active');
        $(this).addClass('active');
        currentFilter = $(this).data('filter');
        applyFilters();
    });
    
    $('.chat-filters [data-sort]').on('click', function(e) {
        e.preventDefault();
        $('.chat-filters [data-sort]').removeClass('active');
        $(this).addClass('active');
        currentSort = $(this).data('sort');
        applyFilters();
    });
    
    function applyFilters() {
        let chatItems = $('.chat-list li[data-conversation-id]');
        
        chatItems.each(function() {
            let shouldShow = true;
            let hasEmail = $(this).data('has-email') === 'true';
            let isUnread = $(this).hasClass('unread');
            
            // Apply filters
            if (currentFilter === 'unread' && !isUnread) shouldShow = false;
            if (currentFilter === 'with-email' && !hasEmail) shouldShow = false;
            if (currentFilter === 'without-email' && hasEmail) shouldShow = false;
            
            $(this).toggle(shouldShow);
        });
        
        // Apply sorting (simplified)
        let visibleItems = $('.chat-list li[data-conversation-id]:visible');
        if (currentSort === 'oldest') {
            visibleItems.sort(function(a, b) {
                return $(a).data('conversation-id') - $(b).data('conversation-id');
            });
            } else {
            visibleItems.sort(function(a, b) {
                return $(b).data('conversation-id') - $(a).data('conversation-id');
            });
        }
        $('.chat-list').append(visibleItems);
    }
    
    // Initialize with default active states
    $('.chat-filters [data-filter="all"]').addClass('active');
    $('.chat-filters [data-sort="newest"]').addClass('active');
    
    // Handle reply form submission
    $('#replyForm').on('submit', function(e) {
        e.preventDefault();
        
        console.log('💬 [DEBUG] Reply form submitted, currentConversationId:', currentConversationId);
        
        if (!currentConversationId) {
            console.error('❌ [DEBUG] No conversation selected!');
            showErrorMessage('Please select a conversation first');
            return;
        }
        
        const message = $('#messageInput').val().trim();
        if (!message) {
            showErrorMessage('Please enter a message');
            return;
        }
        
        console.log('📤 [DEBUG] Sending reply:', message, 'to conversation:', currentConversationId);
        
        // Disable form while sending
        const submitBtn = $(this).find('button[type="submit"]');
        const originalBtnText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Sending...');
        $('#messageInput').prop('disabled', true);
        
        // Send reply via AJAX
        $.ajax({
            url: `/admin/chat/conversation/${currentConversationId}/reply`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            data: {
                message: message
            },
            success: function(response) {
                console.log('✅ [DEBUG] Reply sent successfully:', response);
                
                if (response.success) {
                    // Clear input
                    $('#messageInput').val('');
                    
                    // Reload conversation to show new message
                    loadConversation(currentConversationId);
                    
                    showSuccessMessage('Reply sent successfully');
                } else {
                    showErrorMessage('Failed to send reply');
                }
            },
            error: function(xhr) {
                console.error('❌ [DEBUG] Error sending reply:', xhr);
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMsg = 'Validation errors: ';
                    for (let field in errors) {
                        errorMsg += errors[field][0] + ' ';
                    }
                    showErrorMessage(errorMsg);
                } else {
                    showErrorMessage('Error sending reply. Please try again.');
                }
            },
            complete: function() {
                // Re-enable form
                submitBtn.prop('disabled', false).html(originalBtnText);
                $('#messageInput').prop('disabled', false).focus();
            }
        });
    });
    
    // Handle resolve conversation
    $('#resolveBtn').on('click', function() {
        if (!currentConversationId) return;
        
        if (confirm('Are you sure you want to resolve this conversation?')) {
            $.ajax({
                url: `/admin/chat/conversation/${currentConversationId}/resolve`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                success: function(response) {
                    if (response.success) {
                        showSuccessMessage('Conversation resolved successfully');
                        
                        // Update conversation status in list - remove unread indicators
                        $(`[data-conversation-id="${currentConversationId}"]`)
                            .removeClass('unread active')
                            .addClass('resolved');
                        
                        // Remove unread badge
                        $(`[data-conversation-id="${currentConversationId}"] .badge`).remove();
                            
                        // Clear chat area
                        $('#chatMessages').html(`
                            <div class="text-center mt-5">
                                <div class="avatar-lg mx-auto">
                                    <div class="avatar-title rounded-circle bg-soft-success text-success">
                                        <i class="bx bx-check-circle display-4"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <h5>Conversation Resolved</h5>
                                    <p class="text-muted">This conversation has been marked as resolved.</p>
                                </div>
                            </div>
                        `);
                        
                        $('#chatInput').hide();
                        $('#transferBtn, #resolveBtn').hide();
                        $('#currentCustomerName').text('Select a conversation');
                        $('#currentCustomerStatus').text('Choose a conversation from the left');
                        currentConversationId = null;
                    } else {
                        showErrorMessage('Failed to resolve conversation');
                    }
                },
                error: function() {
                    showErrorMessage('Error resolving conversation');
                }
            });
        }
    });
});

// Load conversation function with real AJAX calls
function loadConversation(conversationId) {
    console.log('💬 [DEBUG] loadConversation called with ID:', conversationId);
    
    if (!conversationId) {
        console.error('❌ [DEBUG] Invalid conversation ID provided');
        showErrorMessage('Invalid conversation ID');
        return;
    }
    
    // Set the current conversation ID FIRST
    currentConversationId = conversationId;
    console.log('✅ [DEBUG] currentConversationId set to:', currentConversationId);
    
    // Update active conversation in list
    $('.chat-list li').removeClass('active');
    $(`[data-conversation-id="${conversationId}"]`).addClass('active');
    
    // Show loading state
    $('#chatMessages').html(`
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="text-muted mt-2">Loading conversation...</p>
        </div>
    `);
    
    // Load conversation data via AJAX
    console.log('🌐 [DEBUG] Making AJAX request to:', `/admin/chat/conversation/${conversationId}`);
    
    $.ajax({
        url: `/admin/chat/conversation/${conversationId}`,
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        },
        success: function(response) {
            console.log('✅ [DEBUG] Conversation loaded successfully:', response);
            
            if (response.success) {
                const conversation = response.conversation;
                const messages = response.messages;
                
                // Update header
                $('#currentCustomerName').text(conversation.customer_name);
                $('#currentCustomerStatus').html(`
                    <span class="text-success">
                        <i class="mdi mdi-circle font-size-10 align-middle me-1"></i>
                        Live Chat ${conversation.customer_email ? `• ${conversation.customer_email}` : '• Anonymous'}
                    </span>
                `);
                
                // Show chat input and action buttons
                $('#chatInput').show();
                $('#transferBtn, #resolveBtn').show();
                
                // Load messages
                displayMessages(messages, conversation);
                
                // Mark conversation as read (remove unread indicator)
                $(`[data-conversation-id="${conversationId}"]`).removeClass('unread');
                $(`[data-conversation-id="${conversationId}"] .badge`).remove();
                
                console.log('✅ [DEBUG] Conversation display updated successfully');
                
            } else {
                console.error('❌ [DEBUG] Server returned success=false:', response);
                showErrorMessage('Failed to load conversation');
            }
        },
        error: function(xhr) {
            console.error('❌ [DEBUG] Error loading conversation:', xhr);
            console.error('❌ [DEBUG] Status:', xhr.status);
            console.error('❌ [DEBUG] Response:', xhr.responseText);
            
            showErrorMessage('Error loading conversation. Please try again.');
            
            $('#chatMessages').html(`
                <div class="text-center py-5">
                    <i class="bx bx-error-circle display-4 text-danger"></i>
                    <h5 class="mt-3">Error Loading Conversation</h5>
                    <p class="text-muted">Failed to load conversation. Please refresh and try again.</p>
                    <button class="btn btn-primary" onclick="loadConversation(${conversationId})">
                        <i class="bx bx-refresh me-1"></i>Retry
                    </button>
                </div>
            `);
        }
    });
}

function displayMessages(messages, conversation) {
    let messagesHtml = '<ul class="list-unstyled mb-0">';
    
    // Group messages by date
    let currentDate = '';
    
    messages.forEach(function(message) {
        const messageDate = new Date(message.created_at).toDateString();
        
        // Add date divider if new date
        if (messageDate !== currentDate) {
            currentDate = messageDate;
            const displayDate = new Date(message.created_at).toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            messagesHtml += `<li class="chat-day-title"><span class="title">${displayDate}</span></li>`;
        }
        
        const isAdmin = message.sender_type === 'admin';
        const messageTime = new Date(message.created_at).toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit'
        });
        
        messagesHtml += `
            <li ${isAdmin ? 'class="right"' : ''}>
                <div class="conversation-list">
                    <div class="ctext-wrap">
                        <div class="ctext-wrap-content">
                            <h5 class="conversation-name">
                                <a href="#" class="user-name">
                                    ${isAdmin ? 'Admin' : conversation.customer_name}
                                </a> 
                                <span class="time">${messageTime}</span>
                                ${message.message_type === 'system' ? '<span class="badge bg-info ms-1">System</span>' : ''}
                            </h5>
                            <p class="mb-0">${escapeHtml(message.message_content)}</p>
                        </div>
                    </div>
                </div>
            </li>
        `;
    });
    
    messagesHtml += '</ul>';
    $('#chatMessages').html(messagesHtml);
    
    // Scroll to bottom
    const chatContainer = document.getElementById('chatMessages');
    chatContainer.scrollTop = chatContainer.scrollHeight;
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function loadConversationsList() {
    // Reload the conversations list via AJAX
    // This would fetch updated conversation data
    console.log('Loading conversations list...');
}

function refreshConversations() {
    // Show loading indicator
    $('#conversationsList').html(`
        <li class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="text-muted mt-2">Refreshing conversations...</p>
        </li>
    `);
    
    // Reload page to get fresh data
    window.location.reload();
}

function showSuccessMessage(message) {
    // Show success alert
    let alertHtml = `
        <div class="alert alert-success alert-dismissible fade show position-fixed" 
             style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;" role="alert">
            <i class="bx bx-check-circle me-2"></i>
            <strong>Success!</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    $('body').append(alertHtml);
    setTimeout(() => $('.alert-success').fadeOut(), 5000);
}

function showErrorMessage(message) {
    // Show error alert
    let alertHtml = `
        <div class="alert alert-danger alert-dismissible fade show position-fixed" 
             style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;" role="alert">
            <i class="bx bx-error-circle me-2"></i>
            <strong>Error!</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    $('body').append(alertHtml);
    setTimeout(() => $('.alert-danger').fadeOut(), 7000);
}
</script>
@endpush
