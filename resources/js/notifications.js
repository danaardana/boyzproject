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

// Function to update unread messages count
function updateUnreadCount(count) {
    const badgeElement = document.querySelector('#page-header-messages-dropdown .badge');
    
    if (badgeElement) {
        if (count > 0) {
            badgeElement.textContent = count;
            badgeElement.style.display = 'inline-block';
        } else {
            badgeElement.style.display = 'none';
        }
    }
    
    // Also update the unread count in the dropdown header
    const unreadLink = document.querySelector('#page-header-messages-dropdown + .dropdown-menu .col-auto a');
    if (unreadLink) {
        unreadLink.textContent = `Unread (${count})`;
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
} 