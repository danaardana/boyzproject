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
<!DOCTYPE html>
<html lang="<?php echo $lang ?>">

<head>    
    <title>Dashboard @yield('title')</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="Boy Projects Dashboard" name="description"/>
    <meta content="Boy Projects" name="author"/>
    <meta name="msapplication-TileColor" content="#556ee6">
    <meta name="theme-color" content="#556ee6">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('landing/images/favicon.ico') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('landing/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('landing/images/logo-white.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('landing/images/logo-white.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('landing/images/logo-white.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    
    <!-- preloader css -->
    <link rel="stylesheet" href="{{ asset('admin/css/preloader.min.css') }}" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('admin/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{ asset('admin/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <!-- choices css -->
    <link href="{{ asset('admin/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Remove Vite and add Mix compiled assets -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css" />
    @stack('styles')

</head>

<body>
<!-- Begin page -->
<div id="layout-wrapper"> 

    @yield('content')

</div>
<!-- END layout-wrapper -->

<!-- JAVASCRIPT -->
<script src="{{ asset('admin/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('admin/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('admin/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('admin/libs/feather-icons/feather.min.js') }}"></script>

<!-- pace js -->
<script src="{{ asset('admin/libs/pace-js/pace.min.js') }}"></script>

<script src="{{ asset('admin/js/app.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>

<!-- Add Pusher and Echo scripts directly -->
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    // Check if Pusher configuration exists
    const pusherKey = '{{ config('broadcasting.connections.pusher.key') }}';
    const pusherCluster = '{{ config('broadcasting.connections.pusher.options.cluster') }}';
    
    console.log('Pusher Config:', {
        key: pusherKey,
        cluster: pusherCluster,
        hasKey: pusherKey && pusherKey !== '' && pusherKey !== 'your_app_key'
    });
    
    if (pusherKey && pusherKey !== '' && pusherKey !== 'your_app_key') {
        // Try different clusters if mt1 doesn't work
        const clustersToTry = [pusherCluster, 'ap1', 'ap2', 'us2', 'eu'];
        let pusher = null;
        let currentClusterIndex = 0;

        function tryConnection(cluster) {
            console.log(`Trying to connect with cluster: ${cluster}`);
            
            if (pusher) {
                pusher.disconnect();
            }

            // Initialize Pusher with current cluster
            pusher = new Pusher(pusherKey, {
                cluster: cluster,
                encrypted: true,
                enabledTransports: ['ws', 'wss'],
                disabledTransports: ['sockjs']
            });

            // Handle connection events
            pusher.connection.bind('connected', function() {
                console.log(`✅ Successfully connected to Pusher with cluster: ${cluster}`);
                
                // Subscribe to the channel once connected
                const channel = pusher.subscribe('admin.notifications');

                // Listen for the event
                channel.bind('ContactMessageEvent', function(data) {
                    console.log('📨 Received notification:', data);
                    
                    // Update unread messages count - look for the badge inside the messages dropdown button
                    const badgeElement = document.querySelector('#page-header-messages-dropdown .badge');
                    if (badgeElement) {
                        if (data.unreadCount > 0) {
                            badgeElement.textContent = data.unreadCount;
                            badgeElement.style.display = 'inline-block';
                        } else {
                            badgeElement.style.display = 'none';
                        }
                        console.log('✅ Updated badge count to:', data.unreadCount);
                    } else {
                        console.log('❌ Badge element not found');
                    }
                    
                    // Update the unread count in the dropdown header
                    const dropdownMenu = document.querySelector('[aria-labelledby="page-header-messages-dropdown"]');
                    if (dropdownMenu) {
                        const unreadLink = dropdownMenu.querySelector('.col-auto a');
                        if (unreadLink) {
                            // Extract the text content and update just the count
                            const linkText = unreadLink.textContent;
                            const updatedText = linkText.replace(/\(\d+\)/, `(${data.unreadCount})`);
                            unreadLink.textContent = updatedText;
                            console.log('✅ Updated unread link text to:', updatedText);
                        } else {
                            console.log('❌ Unread link not found');
                        }

                        // Update recent messages in the dropdown
                        const messagesContainer = dropdownMenu.querySelector('[data-simplebar]');
                        if (messagesContainer) {
                            if (data.recentMessages.length === 0) {
                                messagesContainer.innerHTML = `
                                    <div class="text-center p-3">
                                        <p class="text-muted mb-0">No messages</p>
                                    </div>
                                `;
                            } else {
                                let html = '';
                                data.recentMessages.forEach(message => {
                                    html += `
                                        <a href="/admin/messages/${message.id}" class="text-reset notification-item">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 avatar-sm me-3">
                                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                        <i class="bx bx-user"></i>
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">${message.customer_name}</h6>
                                                    <div class="font-size-13 text-muted">
                                                        <p class="mb-1">${message.content.substring(0, 50)}${message.content.length > 50 ? '...' : ''}</p>
                                                        <p class="mb-0">
                                                            <i class="mdi mdi-clock-outline"></i>
                                                            <span>${message.created_at}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    `;
                                });
                                messagesContainer.innerHTML = html;
                            }
                            console.log('✅ Updated messages container with', data.recentMessages.length, 'messages');
                        } else {
                            console.log('❌ Messages container not found');
                        }
                    } else {
                        console.log('❌ Dropdown menu not found');
                    }
                });
            });

            pusher.connection.bind('disconnected', function() {
                console.log(`❌ Disconnected from Pusher (cluster: ${cluster})`);
            });

            pusher.connection.bind('error', function(err) {
                console.error(`❌ Pusher connection error with cluster ${cluster}:`, err);
                
                // Try next cluster
                currentClusterIndex++;
                if (currentClusterIndex < clustersToTry.length) {
                    setTimeout(() => {
                        tryConnection(clustersToTry[currentClusterIndex]);
                    }, 2000);
                } else {
                    console.error('❌ All clusters failed. Please check your Pusher credentials.');
                }
            });

            pusher.connection.bind('unavailable', function() {
                console.log(`⚠️ Pusher unavailable (cluster: ${cluster})`);
            });
        }

        // Start with the first cluster
        tryConnection(clustersToTry[0]);

    } else {
        console.warn('⚠️ Pusher not configured. Please add PUSHER_APP_KEY to your .env file for real-time notifications.');
        console.log('Current key:', pusherKey);
    }
</script>

<!-- Session Monitoring Script -->
<script>
$(document).ready(function() {
    // Session monitoring for cross-tab logout detection
    let sessionCheckInterval;
    
    function startSessionMonitoring() {
        // Check session status every 30 seconds
        sessionCheckInterval = setInterval(function() {
            $.ajax({
                url: '{{ route("admin.session.check") }}',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                success: function(response) {
                    if (!response.authenticated) {
                        // Session expired, redirect to login
                        clearInterval(sessionCheckInterval);
                        window.location.href = response.redirect || '{{ route("admin.login") }}';
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        // Unauthorized, session expired
                        clearInterval(sessionCheckInterval);
                        const response = xhr.responseJSON;
                        window.location.href = (response && response.redirect) || '{{ route("admin.login") }}';
                    }
                    // For other errors (network issues, etc.), continue checking
                }
            });
        }, 30000); // Check every 30 seconds
    }
    
    // Start monitoring when page loads
    startSessionMonitoring();
    
    // Handle page visibility changes (when tab becomes active/inactive)
    document.addEventListener('visibilitychange', function() {
        if (document.visibilityState === 'visible') {
            // Tab became visible, do immediate session check
            $.ajax({
                url: '{{ route("admin.session.check") }}',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                success: function(response) {
                    if (!response.authenticated) {
                        window.location.href = response.redirect || '{{ route("admin.login") }}';
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        const response = xhr.responseJSON;
                        window.location.href = (response && response.redirect) || '{{ route("admin.login") }}';
                    }
                }
            });
        }
    });
    
    // Handle beforeunload event
    window.addEventListener('beforeunload', function() {
        if (sessionCheckInterval) {
            clearInterval(sessionCheckInterval);
        }
    });
    
    // Global AJAX error handler for 401 responses
    $(document).ajaxError(function(event, xhr, settings) {
        if (xhr.status === 401) {
            // Clear any intervals
            if (sessionCheckInterval) {
                clearInterval(sessionCheckInterval);
            }
            
            // Redirect to login
            const response = xhr.responseJSON;
            const redirectUrl = (response && response.redirect) || '{{ route("admin.login") }}';
            
            // Show a brief message before redirecting
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Session Expired',
                    text: 'Your session has expired. Redirecting to login...',
                    timer: 2000,
                    showConfirmButton: false
                }).then(function() {
                    window.location.href = redirectUrl;
                });
            } else {
                alert('Your session has expired. Redirecting to login...');
                window.location.href = redirectUrl;
            }
        }
    });
});
</script>

<!-- Notification System Scripts -->
<script>
// Notification System Functions
$(document).ready(function() {
    // CSRF Token setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // Mark all notifications as read
    $('#mark-all-read-btn').on('click', function(e) {
        e.preventDefault();
        markAllNotificationsAsRead();
    });
    
    // Auto-refresh notifications every 30 seconds
    setInterval(function() {
        refreshNotifications();
    }, 30000);
});

// Function to mark a single notification as read
function markNotificationAsRead(element) {
    const notificationId = $(element).data('id');
    
    if (!notificationId) return;
    
    $.ajax({
        url: `/admin/notifications/${notificationId}/read`,
        type: 'POST',
        success: function(response) {
            if (response.success) {
                // Remove the "unread" class and "New" badge
                $(element).removeClass('unread');
                $(element).find('.badge-soft-primary').remove();
                
                // Update badge count
                updateNotificationBadge(response.unread_count);
                updateUnreadCount(response.unread_count);
            }
        },
        error: function(xhr) {
            console.error('Failed to mark notification as read:', xhr);
        }
    });
}

// Function to mark all notifications as read
function markAllNotificationsAsRead() {
    $.ajax({
        url: '/admin/notifications/mark-all-read',
        type: 'POST',
        success: function(response) {
            if (response.success) {
                // Remove all "unread" classes and "New" badges
                $('.notification-item').removeClass('unread');
                $('.notification-item .badge-soft-primary').remove();
                
                // Update badge count
                updateNotificationBadge(0);
                updateUnreadCount(0);
                
                // Show success message
                showNotificationToast('success', response.message);
            }
        },
        error: function(xhr) {
            console.error('Failed to mark all notifications as read:', xhr);
            showNotificationToast('error', 'Failed to mark all notifications as read');
        }
    });
}

// Function to remove all notifications
function removeAllNotifications() {
    // Show confirmation dialog
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This will permanently remove all notifications.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, remove all!'
        }).then((result) => {
            if (result.isConfirmed) {
                performRemoveAll();
            }
        });
    } else {
        if (confirm('Are you sure you want to remove all notifications? This action cannot be undone.')) {
            performRemoveAll();
        }
    }
}

// Function to actually remove all notifications
function performRemoveAll() {
    $.ajax({
        url: '/admin/notifications/remove-all',
        type: 'DELETE',
        success: function(response) {
            if (response.success) {
                // Clear the notifications container
                $('#notifications-container').html(`
                    <div class="text-center p-3" id="no-notifications">
                        <p class="text-muted mb-0">No notifications</p>
                    </div>
                `);
                
                // Update badge count
                updateNotificationBadge(0);
                updateUnreadCount(0);
                
                // Show success message
                showNotificationToast('success', response.message);
            }
        },
        error: function(xhr) {
            console.error('Failed to remove all notifications:', xhr);
            showNotificationToast('error', 'Failed to remove all notifications');
        }
    });
}

// Function to refresh notifications
function refreshNotifications() {
    $.ajax({
        url: '/admin/notifications',
        type: 'GET',
        success: function(response) {
            if (response.success) {
                updateNotificationsList(response.notifications);
                updateNotificationBadge(response.unread_count);
                updateUnreadCount(response.unread_count);
            }
        },
        error: function(xhr) {
            console.error('Failed to refresh notifications:', xhr);
        }
    });
}

// Function to update notifications list
function updateNotificationsList(notifications) {
    const container = $('#notifications-container');
    
    if (notifications.length === 0) {
        container.html(`
            <div class="text-center p-3" id="no-notifications">
                <p class="text-muted mb-0">No notifications</p>
            </div>
        `);
        return;
    }
    
    let html = '';
    notifications.forEach(function(notification) {
        const unreadClass = notification.is_read ? '' : 'unread';
        const newBadge = notification.is_read ? '' : '<span class="badge badge-soft-primary">New</span>';
        
        html += `
            <a href="javascript:void(0)" class="text-reset notification-item ${unreadClass}" 
               data-id="${notification.id}" onclick="markNotificationAsRead(this)">
                <div class="d-flex">
                    <div class="flex-shrink-0 avatar-sm me-3">
                        <span class="avatar-title bg-${notification.color}-subtle text-${notification.color} rounded-circle font-size-16">
                            <i class="${notification.icon}"></i>
                        </span>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-1">${notification.title}</h6>
                            ${newBadge}
                        </div>
                        <div class="font-size-13 text-muted">
                            <p class="mb-1">${notification.message.length > 60 ? notification.message.substring(0, 60) + '...' : notification.message}</p>
                            <p class="mb-0">
                                <i class="mdi mdi-clock-outline"></i>
                                <span>${notification.time_ago}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        `;
    });
    
    container.html(html);
}

// Function to update notification badge
function updateNotificationBadge(count) {
    const badge = $('#notifications-badge');
    if (count > 0) {
        badge.text(count).removeClass('d-none');
    } else {
        badge.addClass('d-none');
    }
}

// Function to update unread count text
function updateUnreadCount(count) {
    $('#unread-count').text(count);
}

// Function to show notification toast
function showNotificationToast(type, message) {
    if (typeof Swal !== 'undefined') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        
        Toast.fire({
            icon: type,
            title: message
        });
    } else if (typeof toastr !== 'undefined') {
        toastr[type](message);
    } else {
        console.log(`${type.toUpperCase()}: ${message}`);
    }
}

// Add custom CSS for unread notifications
const notificationStyles = `
<style>
.notification-item.unread {
    background-color: rgba(13, 110, 253, 0.05);
    border-left: 3px solid #0d6efd;
}

.notification-item:hover {
    background-color: rgba(0, 0, 0, 0.05);
}

.badge-soft-primary {
    background-color: rgba(13, 110, 253, 0.1);
    color: #0d6efd;
    font-size: 0.7em;
}

.avatar-title.bg-success-subtle {
    background-color: rgba(25, 135, 84, 0.1) !important;
}

.avatar-title.bg-warning-subtle {
    background-color: rgba(255, 193, 7, 0.1) !important;
}

.avatar-title.bg-danger-subtle {
    background-color: rgba(220, 53, 69, 0.1) !important;
}

.avatar-title.bg-info-subtle {
    background-color: rgba(13, 202, 240, 0.1) !important;
}

.avatar-title.bg-primary-subtle {
    background-color: rgba(13, 110, 253, 0.1) !important;
}

.text-success {
    color: #198754 !important;
}

.text-warning {
    color: #ffc107 !important;
}

.text-danger {
    color: #dc3545 !important;
}

.text-info {
    color: #0dcaf0 !important;
}

.text-primary {
    color: #0d6efd !important;
}
</style>
`;

// Inject the styles
$('head').append(notificationStyles);
</script>

@stack('scripts')

</body>

</html>