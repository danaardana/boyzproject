// Initialize Laravel Echo
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});

// Listen for contact message events
window.Echo.private('admin.notifications')
    .listen('ContactMessageEvent', (e) => {
        // Update unread messages count
        updateUnreadCount(e.unreadCount);
        
        // Update recent messages
        updateRecentMessages(e.recentMessages);
    });

// Polling for real-time updates (fallback if Echo is not working)
let lastMessageCheck = Date.now();
let pollingInterval;

// Start polling when the page loads
document.addEventListener('DOMContentLoaded', function() {
    // Initial load
    checkForNewMessages();
    
    // Start polling every 10 seconds
    pollingInterval = setInterval(checkForNewMessages, 10000);
    
    // Stop polling when page is hidden (browser tab not active)
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            clearInterval(pollingInterval);
        } else {
            // Resume polling when tab becomes active again
            pollingInterval = setInterval(checkForNewMessages, 10000);
            // Immediate check when returning to the tab
            checkForNewMessages();
        }
    });
});

// Function to check for new messages via API
async function checkForNewMessages() {
    try {
        const response = await fetch('/admin/api/messages/notifications', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            }
        });
        
        if (response.ok) {
            const data = await response.json();
            
            // Update unread messages count
            updateUnreadCount(data.unread_count);
            
            // Update recent messages
            updateRecentMessages(data.recent_messages);
            
            lastMessageCheck = Date.now();
        }
    } catch (error) {
        console.error('Error checking for new messages:', error);
    }
}

// Function to update unread messages count
function updateUnreadCount(count) {
    const badgeElement = document.querySelector('#page-header-messages-dropdown .badge');
    
    if (badgeElement) {
        if (count > 0) {
            badgeElement.textContent = count;
            badgeElement.style.display = 'inline-block';
            badgeElement.classList.remove('d-none');
        } else {
            badgeElement.style.display = 'none';
            badgeElement.classList.add('d-none');
        }
    }
    
    // Also update the unread count in the dropdown header
    const unreadLink = document.querySelector('#page-header-messages-dropdown + .dropdown-menu .col-auto a span');
    if (unreadLink) {
        unreadLink.textContent = count;
    }
}

// Function to update recent messages
function updateRecentMessages(messages) {
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