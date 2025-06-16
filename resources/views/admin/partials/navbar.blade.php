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
<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('landing/images/favicon.ico') }}" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('landing/images/favicon.ico') }}" alt="" height="24"> <span class="logo-txt">Boy Projects</span>
                    </span>
                </a>

                <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('landing/images/favicon.ico') }}" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('landing/images/favicon.ico') }}" alt="" height="24"> <span class="logo-txt">Boy Projects</span>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item" id="page-header-search-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="search" class="icon-lg"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">
        
                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="{{ $language['Search'] }}" aria-label="Search Result">

                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <?php if ($lang == 'us') { ?>
                        <img class="me-2" src="{{ asset('admin/images/flags/us.jpg') }}" alt="English" height="16"> 
                    <?php } ?>
                    <?php if ($lang == 'id') { ?>
                        <img class="me-2" src="{{ asset('admin/images/flags/id.jpg') }}" alt="Bahasa" height="16"> 
                    <?php } ?>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    @foreach(['us' => 'English', 'id' => 'Indonesia'] as $code => $label)
                        @php
                            $query = request()->query();
                            $query['lang'] = $code;
                            $urlWithLang = url()->current() . '?' . http_build_query($query);
                        @endphp
                        <a href="{{ $urlWithLang }}" class="dropdown-item notify-item language">
                            <img src="{{ asset('admin/images/flags/' . $code . '.jpg') }}" alt="{{ $label }}" class="me-1" height="12"> <span class="align-middle">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item" id="mode-setting-btn">
                    <i data-feather="moon" class="bx bx-moon layout-mode-dark"></i>
                    <i data-feather="sun" class="bx bx-sun layout-mode-light"></i>
                </button>
            </div>

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-grid-alt icon-lg"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <div class="p-2">
                        <div class="row g-0">
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="{{ asset('admin/images/brands/shopee.png') }}" alt="Github">
                                    <span>Shopee</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="{{ asset('admin/images/brands/tokopedia.png') }}" alt="bitbucket">
                                    <span>Tokopedia</span>
                                </a>
                            </div>
                        </div>

                        <div class="row g-0">
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="{{ asset('admin/images/brands/olx.png') }}" alt="dribbble">
                                    <span>Olx</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="{{ asset('admin/images/brands/blibli.png') }}" alt="dropbox">
                                    <span>Blibli</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon position-relative" id="page-header-notifications-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="bell" class="icon-lg bx bx-bell"></i>
                    @if(isset($unreadNotifications) && $unreadNotifications > 0)
                        <span class="badge bg-danger rounded-pill" id="notifications-badge">{{ $unreadNotifications }}</span>
                    @else
                        <span class="badge bg-danger rounded-pill d-none" id="notifications-badge"></span>
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0">{{ $language["Notifications"] }}</h6>
                            </div>
                            <div class="col-auto">
                                <a href="#!" class="small text-reset text-decoration-underline" id="mark-all-notifications-read-btn">
                                    <span id="unread-text">{{ $language["Unread"] }} (<span id="unread-count">{{ $unreadNotifications ?? 0 }}</span>)</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;" id="notifications-container">
                        @forelse($recentNotifications ?? [] as $notification)
                            <a href="javascript:void(0)" class="text-reset notification-item {{ $notification->is_read ? '' : 'unread' }}" 
                               data-id="{{ $notification->id }}" 
                               onclick="markNotificationAsRead(this)">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 avatar-sm me-3">
                                        <span class="avatar-title bg-{{ $notification->color }}-subtle text-{{ $notification->color }} rounded-circle font-size-16">
                                            <i class="{{ $notification->icon }}"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-1">{{ $notification->title }}</h6>
                                            <div class="d-flex align-items-center gap-1">
                                                @if(!$notification->is_read)
                                                    <span class="badge badge-soft-primary">New</span>
                                                @endif
                                                <span class="badge badge-soft-{{ $notification->user_type === 'admin' ? 'info' : ($notification->user_type === 'system' ? 'dark' : 'secondary') }}">
                                                    {{ ucfirst($notification->user_type ?? 'System') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="font-size-13 text-muted">
                                            <p class="mb-1">{{ Str::limit($notification->message, 60) }}</p>
                                            <p class="mb-0">
                                                <i class="mdi mdi-clock-outline"></i>
                                                <span>{{ $notification->time_ago }}</span>
                                                @if($notification->user_name && $notification->user_name !== 'System')
                                                    <span class="ms-2">by {{ $notification->user_name }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-center p-3" id="no-notifications">
                                <p class="text-muted mb-0">{{ $language["No_notifications"] ?? "No notifications" }}</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="p-2 border-top d-grid">
                        <button class="btn btn-sm btn-link font-size-14 text-center text-danger" id="remove-all-btn" onclick="removeAllNotifications()">
                            <i class="mdi mdi-delete-sweep me-1"></i> 
                            <span>{{ $language["Remove_All"] ?? "Remove All" }}</span>
                        </button>
                    </div>
                </div>
            </div>

             <!-- Contact Messages Notification -->
             <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon position-relative" id="page-header-messages-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="message-square" class="icon-lg bx bx-message"></i>
                    @if($unreadMessages > 0)
                        <span class="badge bg-danger rounded-pill">{{ $unreadMessages }}</span>
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-messages-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0">{{ $language["Messages"] }}</h6>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('admin.messages.index') }}" class="small text-reset text-decoration-underline">
                                    {{ $language["Unread"] }} ({{ $unreadMessages }})
                                </a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        @forelse($recentMessages as $message)
                            <a href="{{ route('admin.messages.show', $message->id) }}" class="text-reset notification-item">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 avatar-sm me-3">
                                        <span class="avatar-title bg-primary rounded-circle font-size-16">
                                            <i class="bx bx-user"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $message->customer->name }}</h6>
                                        <div class="font-size-13 text-muted">
                                            <p class="mb-1">{{ Str::limit($message->content, 50) }}</p>
                                            <p class="mb-0">
                                                <i class="mdi mdi-clock-outline"></i>
                                                <span>{{ $message->created_at->diffForHumans() }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-center p-3">
                                <p class="text-muted mb-0">{{ $language["No_messages"] }}</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 text-center" href="{{ route('admin.messages.index') }}">
                            <i class="mdi mdi-arrow-right-circle me-1"></i>
                            <span>{{ $language["View_All"] }}</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item bg-light-subtle border-start border-end" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium">Admin</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="{{ route('admin.password.change') }}"><i class="mdi mdi mdi-face-man font-size-16 align-middle me-1"></i> {{ $language["Reset_Password"] }}</a>
                    <a class="dropdown-item" href="{{ route('admin.lockscreen') }}"><i class="mdi mdi-lock font-size-16 align-middle me-1"></i> {{ $language["Lock_screen"] }} </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('admin.logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('navbar-logout-form').submit();">
                        <i class="mdi mdi-logout font-size-16 align-middle me-1"></i> {{ $language["Logout"] }}
                    </a>
                    <form id="navbar-logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>

<script>
// Notification Management Functions
function markNotificationAsRead(element) {
    const notificationId = element.getAttribute('data-id');
    const badge = document.getElementById('notifications-badge');
    const unreadCount = document.getElementById('unread-count');
    
    console.log('Marking notification as read:', notificationId); // Debug log
    
    // Make AJAX request to mark as read
    fetch(`/admin/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('Mark as read response status:', response.status); // Debug log
        return response.json();
    })
    .then(data => {
        console.log('Mark as read response data:', data); // Debug log
        if (data.success) {
            // Remove unread styling
            element.classList.remove('unread');
            const newBadge = element.querySelector('.badge-soft-primary');
            if (newBadge) {
                newBadge.remove();
            }
            
            // Update badge count
            if (data.unreadCount !== undefined) {
                unreadCount.textContent = data.unreadCount;
                
                if (data.unreadCount === 0) {
                    badge.classList.add('d-none');
                } else {
                    badge.textContent = data.unreadCount;
                    badge.classList.remove('d-none');
                }
            }
            
            console.log('Successfully marked notification as read');
        } else {
            console.error('Server response indicated failure:', data.message);
        }
    })
    .catch(error => {
        console.error('Error marking notification as read:', error);
        alert('Error marking notification as read. Please try again.');
    });
}

function markAllNotificationsAsRead() {
    console.log('markAllNotificationsAsRead function called'); // Debug log
    
    const badge = document.getElementById('notifications-badge');
    const unreadCount = document.getElementById('unread-count');
    
    console.log('Badge element:', badge); // Debug log
    console.log('Unread count element:', unreadCount); // Debug log
    
    fetch('/admin/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('Response status:', response.status); // Debug log
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data); // Debug log
        if (data.success) {
            // Remove unread styling from all notifications in the unified notifications dropdown
            document.querySelectorAll('#notifications-container .notification-item.unread').forEach(item => {
                item.classList.remove('unread');
                const newBadge = item.querySelector('.badge-soft-primary');
                if (newBadge) {
                    newBadge.remove();
                }
            });
            
            // Update badge
            if (badge) {
                badge.classList.add('d-none');
            }
            if (unreadCount) {
                unreadCount.textContent = '0';
            }
            
            console.log('Successfully marked all notifications as read');
        } else {
            console.error('Server response indicated failure:', data.message);
        }
    })
    .catch(error => {
        console.error('Error marking all notifications as read:', error);
        alert('Error marking notifications as read. Please try again.');
    });
}

function removeAllNotifications() {
    if (!confirm('Are you sure you want to remove all notifications? This action cannot be undone.')) {
        return;
    }
    
    console.log('removeAllNotifications function called'); // Debug log
    
    const notificationsContainer = document.getElementById('notifications-container');
    const badge = document.getElementById('notifications-badge');
    const unreadCount = document.getElementById('unread-count');
    const noNotifications = document.getElementById('no-notifications');
    
    fetch('/admin/notifications/remove-all', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('Remove all response status:', response.status); // Debug log
        return response.json();
    })
    .then(data => {
        console.log('Remove all response data:', data); // Debug log
        if (data.success) {
            // Clear notifications container
            if (notificationsContainer) {
                notificationsContainer.innerHTML = '<div class="text-center p-3" id="no-notifications"><p class="text-muted mb-0">No notifications</p></div>';
            }
            
            // Update badge
            if (badge) {
                badge.classList.add('d-none');
            }
            if (unreadCount) {
                unreadCount.textContent = '0';
            }
            
            console.log('Successfully removed all notifications');
        } else {
            console.error('Server response indicated failure:', data.message);
        }
    })
    .catch(error => {
        console.error('Error removing all notifications:', error);
        alert('Error removing notifications. Please try again.');
    });
}

// Add click event to mark all read button
document.addEventListener('DOMContentLoaded', function() {
    const markAllBtn = document.getElementById('mark-all-notifications-read-btn');
    console.log('Mark all notifications button found:', markAllBtn); // Debug log
    if (markAllBtn) {
        markAllBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Mark all notifications clicked'); // Debug log
            markAllNotificationsAsRead();
        });
    }
    
    // Initialize real-time message checking
    initializeMessageChecking();
});

// Real-time message checking
let messagePollingInterval;

function initializeMessageChecking() {
    // Initial check
    checkForNewMessages();
    
    // Start polling every 10 seconds
    messagePollingInterval = setInterval(checkForNewMessages, 10000);
    
    // Stop polling when page is hidden (browser tab not active)
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            clearInterval(messagePollingInterval);
        } else {
            // Resume polling when tab becomes active again
            messagePollingInterval = setInterval(checkForNewMessages, 10000);
            // Immediate check when returning to the tab
            checkForNewMessages();
        }
    });
}

async function checkForNewMessages() {
    try {
        const response = await fetch('{{ route("admin.api.messages.notifications") }}', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            }
        });
        
        console.log('Messages API response status:', response.status); // Debug log
        
        if (response.ok) {
            const data = await response.json();
            console.log('Messages API data:', data); // Debug log
            
            // Update message badge
            updateMessageBadge(data.unread_count);
            
            // Update recent messages dropdown
            updateMessagesDropdown(data.recent_messages, data.unread_count);
        } else {
            console.error('Messages API failed with status:', response.status);
            const errorText = await response.text();
            console.error('Messages API error response:', errorText);
            
            if (response.status === 404) {
                console.error('Route /admin/api/messages/notifications not found. Check if route is properly defined.');
            } else if (response.status === 401) {
                console.error('Authentication required. User may need to log in again.');
            } else if (response.status === 403) {
                console.error('Access forbidden. Check user permissions.');
            }
        }
    } catch (error) {
        console.error('Error checking for new messages:', error);
    }
}

function updateMessageBadge(unreadCount) {
    const badgeElement = document.querySelector('#page-header-messages-dropdown .badge');
    
    if (badgeElement) {
        if (unreadCount > 0) {
            badgeElement.textContent = unreadCount;
            badgeElement.style.display = 'inline-block';
            badgeElement.classList.remove('d-none');
        } else {
            badgeElement.style.display = 'none';
            badgeElement.classList.add('d-none');
        }
    }
}

function updateMessagesDropdown(messages, unreadCount) {
    // Update unread count in dropdown header
    const unreadCountSpan = document.querySelector('#page-header-messages-dropdown + .dropdown-menu .col-auto a span');
    if (unreadCountSpan) {
        unreadCountSpan.textContent = unreadCount;
    }
    
    // Update messages container
    const messagesContainer = document.querySelector('#page-header-messages-dropdown + .dropdown-menu [data-simplebar]');
    
    if (messagesContainer) {
        if (messages.length === 0) {
            messagesContainer.innerHTML = `
                <div class="text-center p-3">
                    <p class="text-muted mb-0">No messages</p>
                </div>
            `;
            return;
        }
        
        let html = '';
        
        messages.forEach(message => {
            const unreadClass = !message.is_read ? 'unread' : '';
            const unreadBadge = !message.is_read ? '<span class="badge badge-soft-primary">New</span>' : '';
            
            html += `
                <a href="/admin/messages/${message.id}" class="text-reset notification-item ${unreadClass}">
                    <div class="d-flex">
                        <div class="flex-shrink-0 avatar-sm me-3">
                            <span class="avatar-title bg-primary rounded-circle font-size-16">
                                <i class="bx bx-user"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-1">${message.customer_name}</h6>
                                ${unreadBadge}
                            </div>
                            <div class="font-size-13 text-muted">
                                <p class="mb-1"><strong>${message.subject}</strong></p>
                                <p class="mb-1">${message.content}</p>
                                <p class="mb-0">
                                    <i class="mdi mdi-clock-outline"></i>
                                    <span>${message.time_ago}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            `;
        });
        
        messagesContainer.innerHTML = html;
    }
}
</script>

<!-- ========== Left Sidebar Start ========== -->
<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle arrow-none" href="{{ route('admin.dashboard') }}" id="topnav-dashboard" role="button">
                    <i class="bx bx-home-alt"></i>
                    <span data-key="t-dashboards">{{ $language["Dashboard"] }}</span>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle arrow-none" href="{{ route('landing-page') }}" id="topnav-dashboard" role="button">
                        <i class="bx bx-world"></i>
                        <span data-key="landing-page">{{ $language["Landing_Page"] }}</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class=" far fa-question-circle"></i>
                        <span data-key="support">{{ $language["Support"] }}</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                    <li><a href="{{ route('admin.faq') }}" data-key="faq">FAQ</a></li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow" data-key="t-level-1-2">{{ $language["Documentation"] }}</a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ route('admin.documentation.index') }}" data-key="t-level-2-0">All Documentation</a></li>
                                <li><a href="{{ route('admin.documentation.show', 'landing-page-system') }}" data-key="t-level-2-1">Landing Page System</a></li>
                                <li><a href="{{ route('admin.documentation.show', 'product-system') }}" data-key="t-level-2-2">Product System</a></li>
                                <li><a href="{{ route('admin.documentation.show', 'email-system') }}" data-key="t-level-2-3">E-mail System</a></li>
                                <li><a href="{{ route('admin.documentation.show', 'message-system') }}" data-key="t-level-2-4">Message System</a></li>
                                <li><a href="{{ route('admin.documentation.show', 'chat-system') }}" data-key="t-level-2-5">Chat System</a></li>
                                <li><a href="{{ route('admin.documentation.show', 'chatbot') }}" data-key="t-level-2-6">Chatbot Management</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="dripicons-message"></i>
                        <span data-key="support">{{ $language["Message"] }}</span>
                        
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{ route('admin.messages.index') }}" data-key="documentation">{{ $language["Message"] }}</a></li>
                    <li><a href="{{ route('admin.chat') }}" data-key="documentation">Chat</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="bx bx-bot"></i>
                        <span data-key="chatbot">Chatbot</span>
                        
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.chatbot') }}" data-key="auto-responses">Auto Responses</a></li>
                        <li><a href="{{ route('admin.chatbot.ml') }}" data-key="smart-responses">Smart Responses</a></li>
                    </ul>
                </li>

                <li>
                   <a href="javascript: void(0);" class="has-arrow">
                        <i class="dripicons-view-thumb"></i>
                        <span data-key="products-services">{{ $language["Products_&_Services"] }}</span>
                        
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.productsTables') }}" data-key="products">{{ $language["Products"] }}</a></li>
                        <li><a href="#" data-key="services">{{ $language["Services"] }}</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class=" dripicons-article"></i>
                        <span data-key="orders-queue">{{ $language["Orders_&_Queue"] }}</span>
                        
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="#" data-key="order">{{ $language["Incoming_Orders"] }}</a></li>
                        <li><a href="#" data-key="service">{{ $language["Service_Queue"] }}</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="dripicons-user-group"></i>
                        <span data-key="user-management">{{ $language["User_Management"] }}</span>
                        
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.admin') }}" data-key="user-list">Admin Management</a></li>
                        <li><a href="{{ route('admin.customers.index') }}" data-key="customer-list">Customer Management</a></li>
                        <li><a href="{{ route('admin.history') }}" data-key="user-history">Session History</a></li>
                    </ul>
                </li>

                <li class="menu-title" data-key="t-menu">{{ $language["Website_Content"] }}</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="dripicons-browser"></i>
                        <span data-key="landing-page-editor">{{ $language["Landing_Page_Editor"] }}</span>
                        
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.landingPageTables') }}" data-key="landing-page-edit">{{ $language["Landing_Page"] }}</a></li>
                        <li><a href="{{ route('admin.subsectionTables') }}" data-key="section-content">{{ $language["Section_Content"] }}</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('admin.productsTables') }}">
                        <i class="mdi mdi-package-variant"></i>
                        <span data-key="products">{{ $language["Products"] }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.portofolio') }}">
                        <i class=" bx bx-news"></i>
                        <span data-key="portofolio">{{ $language["Portfolio"] }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.testimonials') }}">
                        <i class="far fa-newspaper"></i>
                        <span data-key="testimonials">{{ $language["Testimonials"] }}</span>
                    </a>
                </li>                

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class=" dripicons-conversation"></i>
                        <span data-key="social=media">{{ $language["Social_Media"] }}</span>
                        
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.instagram') }}" data-key="instagram">{{ $language["Instagram_Feeds"] }}</a></li>
                        <li><a href="{{ route('admin.tiktok') }}" data-key="tiktok">{{ $language["TikTok_Feeds"] }}</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('admin.promotion') }}">
                        <i class="dripicons-tags"></i>
                        <span data-key="promotions-discounts">{{ $language["Promotions_&_Discounts"] }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.categories') }}">
                        <i class="dripicons-tags"></i>
                        <span data-key="promotions-discounts">{{ $language["Categories"] }}</span>
                    </a>
                </li>



            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->