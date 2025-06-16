<!-- Notification Statistics -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title mb-0">System Activity & Notifications</h4>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-sm btn-primary" onclick="refreshNotificationStats()">
                            <i class="bx bx-refresh"></i> Refresh
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Total Notifications -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Total Notifications</p>
                                        <h4 class="mb-0" id="total-notifications">{{ $unreadNotifications + \App\Models\Notification::read()->count() }}</h4>
                                    </div>
                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                            <span class="avatar-title">
                                                <i class="bx bx-bell font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Unread Notifications -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Unread</p>
                                        <h4 class="mb-0 text-warning" id="unread-notifications">{{ $unreadNotifications }}</h4>
                                    </div>
                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-warning">
                                            <span class="avatar-title">
                                                <i class="bx bx-bell-plus font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Activities -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Admin Activities</p>
                                        <h4 class="mb-0 text-info" id="admin-notifications">{{ $unreadAdminNotifications }}</h4>
                                    </div>
                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-info">
                                            <span class="avatar-title">
                                                <i class="bx bx-user-check font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Activities -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Customer Activities</p>
                                        <h4 class="mb-0 text-success" id="customer-notifications">{{ $unreadCustomerNotifications }}</h4>
                                    </div>
                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-success">
                                            <span class="avatar-title">
                                                <i class="bx bx-user font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="row">
                    <div class="col-12">
                        <h5 class="font-size-16 mb-3">Recent Activities</h5>
                        <div class="activity-feed">
                            @forelse($recentNotifications->take(5) as $notification)
                                <div class="activity-item {{ $notification->is_read ? '' : 'unread' }}">
                                    <div class="activity-icon">
                                        <span class="avatar-title bg-{{ $notification->color }}-subtle text-{{ $notification->color }} rounded-circle">
                                            <i class="{{ $notification->icon }}"></i>
                                        </span>
                                    </div>
                                    <div class="activity-content">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-1">{{ $notification->title }}</h6>
                                            <div class="d-flex gap-1">
                                                @if(!$notification->is_read)
                                                    <span class="badge badge-soft-primary">New</span>
                                                @endif
                                                <span class="badge badge-soft-{{ $notification->user_type === 'admin' ? 'info' : ($notification->user_type === 'system' ? 'dark' : 'secondary') }}">
                                                    {{ ucfirst($notification->user_type) }}
                                                </span>
                                            </div>
                                        </div>
                                        <p class="text-muted mb-1">{{ $notification->message }}</p>
                                        <small class="text-muted">
                                            <i class="bx bx-time-five"></i> {{ $notification->time_ago }}
                                            @if($notification->user_name && $notification->user_name !== 'System')
                                                • by {{ $notification->user_name }}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <div class="avatar-md mx-auto mb-4">
                                        <div class="avatar-title bg-light rounded-circle">
                                            <i class="bx bx-bell-off font-size-24 text-muted"></i>
                                        </div>
                                    </div>
                                    <h5 class="font-size-16">No Recent Activities</h5>
                                    <p class="text-muted">No notifications available at the moment.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.activity-feed {
    max-height: 400px;
    overflow-y: auto;
}

.activity-item {
    display: flex;
    margin-bottom: 20px;
    padding: 15px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.activity-item.unread {
    background-color: #f8f9fa;
    border-left: 4px solid #556ee6;
}

.activity-item:hover {
    background-color: #f1f3f4;
}

.activity-icon {
    margin-right: 15px;
    flex-shrink: 0;
}

.activity-content {
    flex-grow: 1;
}

.mini-stats-wid .mini-stat-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<script>
function refreshNotificationStats() {
    fetch('/admin/notifications/stats', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('total-notifications').textContent = data.stats.total;
            document.getElementById('unread-notifications').textContent = data.stats.unread;
            
            // Update breakdown counts if available
            const adminCount = data.stats.by_user_type?.admin || 0;
            const customerCount = data.stats.by_user_type?.customer || 0;
            
            document.getElementById('admin-notifications').textContent = adminCount;
            document.getElementById('customer-notifications').textContent = customerCount;
        }
    })
    .catch(error => {
        console.error('Error fetching notification stats:', error);
    });
}

// Auto-refresh every 30 seconds
setInterval(refreshNotificationStats, 30000);
</script> 