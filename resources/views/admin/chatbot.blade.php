@extends('layouts.admin')

@include('admin.partials.navbar')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Chatbot Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Chatbot</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card card-h-100">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Responses</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value" id="total-responses">{{ $stats['total'] }}</span>
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <i class="bx bx-bot text-primary display-6"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card card-h-100">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Active Responses</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value" id="active-responses">{{ $stats['active'] }}</span>
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <i class="bx bx-check-circle text-success display-6"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card card-h-100">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Inactive Responses</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value" id="inactive-responses">{{ $stats['inactive'] }}</span>
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <i class="bx bx-x-circle text-warning display-6"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card card-h-100">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">High Priority</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value" id="high-priority-responses">{{ $stats['high_priority'] }}</span>
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <i class="bx bx-up-arrow-alt text-danger display-6"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Test Response Card -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Test Auto Response</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="test-message" placeholder="Enter a message to test auto response matching...">
                                        <button class="btn btn-primary" type="button" id="test-response-btn">
                                            <i class="bx bx-test-tube me-1"></i> Test Response
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div id="test-result" class="mt-3" style="display: none;">
                                <div class="alert" id="test-alert">
                                    <strong>Result:</strong> <span id="test-message-text"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Auto Responses Management -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title">Auto Responses Management</h4>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#autoResponseModal">
                                        <i class="bx bx-plus me-1"></i> Add New Response
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Search and Filter Controls -->
                            <form method="GET" action="{{ route('admin.chatbot') }}" class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="search" id="search-input" placeholder="Search by keyword, response, or description..." value="{{ request('search') }}">
                                            <button class="btn btn-outline-secondary" type="submit" id="search-btn">
                                                <i class="bx bx-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-select" name="status" id="status-filter" onchange="this.form.submit()">
                                            <option value="">All Status</option>
                                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.chatbot') }}" class="btn btn-outline-secondary" id="refresh-btn">
                                                <i class="bx bx-refresh"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-success" id="export-btn">
                                                <i class="bx bx-export"></i> Export
                                            </button>
                                            <button type="button" class="btn btn-outline-danger" id="bulk-delete-btn" disabled>
                                                <i class="bx bx-trash"></i> Delete Selected
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <!-- Auto Responses Table -->
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap">
                                    <thead class="table-light">
                                        <tr>
                                            <th>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="select-all">
                                                </div>
                                            </th>
                                            <th>Priority</th>
                                            <th>Keyword</th>
                                            <th>Response</th>
                                            <th>Match Type</th>
                                            <th>Status</th>
                                            <th>Created By</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="responses-table-body">
                                        @forelse($autoResponses as $response)
                                        <tr data-id="{{ $response->id }}" class="table-row-hover">
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="response_ids[]" value="{{ $response->id }}">
                                                </div>
                                            </td>
                                            <td>
                                                <span class="priority-badge {{ $response->priority >= 100 ? 'priority-high' : ($response->priority >= 50 ? 'priority-medium' : 'priority-low') }}" data-priority="{{ $response->priority }}">
                                                    {{ $response->priority }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="keyword-tags">
                                                    <span class="keyword-tag primary">{{ $response->keyword }}</span>
                                                    @if($response->additional_keywords && count($response->additional_keywords) > 0)
                                                        @foreach($response->additional_keywords as $keyword)
                                                            <span class="keyword-tag secondary">{{ $keyword }}</span>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="response-preview" title="{{ $response->response }}">
                                                    {{ Str::limit($response->response, 100) }}
                                                    @if(strlen($response->response) > 100)
                                                        <small class="text-muted d-block mt-1">Click to view full response</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info text-capitalize">{{ str_replace('_', ' ', $response->match_type) }}</span>
                                                @if($response->case_sensitive)
                                                    <br><small class="text-muted"><i class="bx bx-case-sensitive"></i> Case Sensitive</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($response->is_active)
                                                    <span class="badge bg-success"><i class="bx bx-check me-1"></i>Active</span>
                                                @else
                                                    <span class="badge bg-warning"><i class="bx bx-pause me-1"></i>Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="creator-info">
                                                    <span class="creator-name">{{ $response->creator ? $response->creator->name : 'System' }}</span>
                                                    <small class="text-muted d-block">{{ $response->created_at->format('M d, Y') }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <button type="button" class="btn btn-outline-info btn-view" onclick="viewResponse({{ $response->id }})" title="View Details" data-bs-toggle="tooltip">
                                                        <i class="bx bx-show"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-primary btn-edit" onclick="editResponse({{ $response->id }})" title="Edit" data-bs-toggle="tooltip">
                                                        <i class="bx bx-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-{{ $response->is_active ? 'warning' : 'success' }} btn-toggle" 
                                                            onclick="toggleStatus({{ $response->id }})" title="{{ $response->is_active ? 'Deactivate' : 'Activate' }}" data-bs-toggle="tooltip">
                                                        <i class="bx bx-{{ $response->is_active ? 'pause' : 'play' }}"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger btn-delete" onclick="deleteResponse({{ $response->id }})" title="Delete" data-bs-toggle="tooltip">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="bx bx-message-dots display-1 text-muted mb-3"></i>
                                                    <h5 class="text-muted">No Auto Responses Found</h5>
                                                    <p class="text-muted mb-4">
                                                        @if(request('search') || request('status') !== null)
                                                            Try adjusting your search criteria or filters.
                                                        @else
                                                            Get started by creating your first auto response.
                                                        @endif
                                                    </p>
                                                    @if(!request('search') && request('status') === null)
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#autoResponseModal">
                                                            <i class="bx bx-plus me-1"></i>Create First Auto Response
                                                        </button>
                                                    @else
                                                        <a href="{{ route('admin.chatbot') }}" class="btn btn-outline-primary">
                                                            <i class="bx bx-refresh me-1"></i>Clear Filters
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" id="table-info">
                                        Showing {{ $autoResponses->firstItem() ?? 0 }} to {{ $autoResponses->lastItem() ?? 0 }} of {{ $autoResponses->total() }} entries
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <div class="dataTables_paginate paging_simple_numbers" id="table-pagination">
                                        {{ $autoResponses->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Auto Response Modal -->
<div class="modal fade" id="autoResponseModal" tabindex="-1" aria-labelledby="autoResponseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="autoResponseModalLabel">Add New Auto Response</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="autoResponseForm">
                <div class="modal-body">
                    <input type="hidden" id="response-id">
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="keyword" class="form-label">Primary Keyword <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="keyword" name="keyword" required>
                                <div class="form-text">Main keyword that triggers this response</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="priority" class="form-label">Priority</label>
                                <input type="number" class="form-control" id="priority" name="priority" min="0" max="999" value="0">
                                <div class="form-text">Higher number = higher priority</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="additional-keywords" class="form-label">Additional Keywords</label>
                        <input type="text" class="form-control" id="additional-keywords" placeholder="Enter additional keywords separated by commas">
                        <div class="form-text">Optional keywords that also trigger this response</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="match-type" class="form-label">Match Type <span class="text-danger">*</span></label>
                                <select class="form-select" id="match-type" name="match_type" required>
                                    <option value="contains">Contains</option>
                                    <option value="exact">Exact Match</option>
                                    <option value="starts_with">Starts With</option>
                                    <option value="ends_with">Ends With</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Options</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="case-sensitive" name="case_sensitive">
                                    <label class="form-check-label" for="case-sensitive">
                                        Case Sensitive
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is-active" name="is_active" checked>
                                    <label class="form-check-label" for="is-active">
                                        Active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="response" class="form-label">Response Message <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="response" name="response" rows="4" required placeholder="Enter the auto response message..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="2" placeholder="Optional description of what this auto response is for..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i> Save Response
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loading-overlay" style="display: none;">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

@endsection

@push('styles')
<style>
#loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.9);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    backdrop-filter: blur(2px);
}

.table td {
    vertical-align: middle;
}

.badge {
    font-size: 0.75em;
    transition: all 0.2s ease;
}

.badge:hover {
    transform: scale(1.05);
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    transition: all 0.2s ease;
}

.btn-sm:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.priority-high {
    color: #dc3545;
    font-weight: bold;
    animation: pulse 2s infinite;
}

.priority-medium {
    color: #fd7e14;
    font-weight: 500;
}

.priority-low {
    color: #6c757d;
}

.priority-badge {
    padding: 4px 8px;
    border-radius: 6px;
    background: rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.7; }
    100% { opacity: 1; }
}

.keyword-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.25rem;
}

.keyword-tag {
    background: #e9ecef;
    padding: 0.1rem 0.3rem;
    border-radius: 0.25rem;
    font-size: 0.7rem;
    border: 1px solid #dee2e6;
    transition: all 0.2s ease;
}

.keyword-tag:hover {
    background: #adb5bd;
    transform: translateY(-1px);
}

.keyword-tag.primary {
    background: #28a745;
    color: white;
    font-weight: 600;
    border-color: #28a745;
}

.keyword-tag.secondary {
    background: #6c757d;
    color: white;
    border-color: #6c757d;
}

.response-preview {
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    cursor: pointer;
    transition: all 0.3s ease;
}

.response-preview:hover {
    background-color: #f8f9fa;
    padding: 2px 4px;
    border-radius: 4px;
    transform: scale(1.02);
}

.table-row-hover {
    transition: all 0.3s ease;
}

.table-hover-highlight {
    background-color: #f8f9fa !important;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.empty-state {
    padding: 2rem;
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.searching {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23999' viewBox='0 0 16 16'%3E%3Cpath d='M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z'/%3E%3Cpath d='M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.creator-info {
    font-size: 0.875rem;
}

.creator-name {
    font-weight: 500;
    color: #495057;
}

.alert {
    animation: slideDown 0.3s ease-out;
    border: none;
    border-left: 4px solid;
}

.alert-success {
    border-left-color: #28a745;
    background: rgba(40, 167, 69, 0.1);
}

.alert-danger {
    border-left-color: #dc3545;
    background: rgba(220, 53, 69, 0.1);
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.modal-content {
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-control:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    border-color: #80bdff;
}

.is-invalid {
    animation: shake 0.5s ease-in-out;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.btn-view {
    --bs-btn-border-color: #6c757d;
    --bs-btn-color: #6c757d;
}

.btn-view:hover {
    --bs-btn-border-color: #495057;
    --bs-btn-color: #495057;
    background: rgba(108, 117, 125, 0.1);
}

.opacity-50 {
    opacity: 0.5 !important;
}

.table-success {
    background-color: rgba(25, 135, 84, 0.1) !important;
    transition: background-color 0.3s ease;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let currentPage = 1;
    let isLoading = false;
    let selectedIds = [];

    // Check authentication first
    checkAuthentication().then(() => {
        // Initialize only if authenticated - no need to load responses via AJAX since they're server-rendered
        initializeTooltips();
        startStatsRefresh(); // New function for stats only
        
        // Initialize tooltips when page loads
        setTimeout(() => {
            initializeTooltips();
        }, 1000);
        
        // Cleanup on page unload
        $(window).on('beforeunload', function() {
            stopAutoRefresh();
        });
    }).catch(() => {
        // Handle authentication failure
        showAlert('<i class="bx bx-lock me-2"></i><strong>Authentication Required!</strong> Redirecting to login...', 'warning');
        setTimeout(() => {
            window.location.href = '{{ route("admin.login") }}';
        }, 2000);
    });

    // Search functionality
    $('#search-input').on('keyup', debounce(function() {
        currentPage = 1;
        loadAutoResponses();
    }, 300));

    $('#search-btn').on('click', function() {
        currentPage = 1;
        loadAutoResponses();
    });

    // Filter functionality
    $('#status-filter').on('change', function() {
        currentPage = 1;
        loadAutoResponses();
    });

    // Refresh button
    $('#refresh-btn').on('click', function() {
        currentPage = 1;
        loadAutoResponses();
        updateStats();
    });

    // Select all checkbox
    $('#select-all').on('change', function() {
        const isChecked = $(this).is(':checked');
        $('input[name="response_ids[]"]').prop('checked', isChecked);
        updateSelectedIds();
    });

    // Individual checkboxes
    $(document).on('change', 'input[name="response_ids[]"]', function() {
        updateSelectedIds();
    });

    // Test response functionality
    $('#test-response-btn').on('click', function() {
        const message = $('#test-message').val().trim();
        if (!message) {
            alert('Please enter a message to test');
            return;
        }
        testAutoResponse(message);
    });

    $('#test-message').on('keypress', function(e) {
        if (e.which === 13) {
            $('#test-response-btn').click();
        }
    });

    // Form submission
    $('#autoResponseForm').on('submit', function(e) {
        e.preventDefault();
        saveAutoResponse();
    });

    // Export functionality
    $('#export-btn').on('click', function() {
        exportAutoResponses();
    });

    // Bulk delete
    $('#bulk-delete-btn').on('click', function() {
        if (selectedIds.length === 0) {
            alert('Please select responses to delete');
            return;
        }
        
        if (confirm(`Are you sure you want to delete ${selectedIds.length} selected response(s)?`)) {
            bulkDeleteResponses();
        }
    });

    // Modal events
    $('#autoResponseModal').on('show.bs.modal', function(e) {
        const button = $(e.relatedTarget);
        const responseId = button.data('id');
        
        if (responseId) {
            // Edit mode
            $('#autoResponseModalLabel').text('Edit Auto Response');
            loadResponseForEdit(responseId);
        } else {
            // Add mode
            $('#autoResponseModalLabel').text('Add New Auto Response');
            resetForm();
        }
    });

    // Functions
    function loadAutoResponses() {
        if (isLoading) return;
        isLoading = true;

        showLoading();

        const params = {
            page: currentPage,
            search: $('#search-input').val(),
            status: $('#status-filter').val(),
            per_page: 15
        };

        console.log('🔄 Loading auto responses with params:', params);

        $.get('{{ route("admin.chatbot.auto-responses") }}', params)
            .done(function(response) {
                console.log('✅ Auto responses loaded:', response);
                renderTable(response);
                renderPagination(response);
                updateTableInfo(response);
                
                // Show success message on first load
                if (currentPage === 1 && !$('#search-input').val()) {
                    setTimeout(() => {
                        showAlert('Auto responses loaded successfully!', 'success');
                    }, 100);
                }
            })
            .fail(function(xhr) {
                console.error('❌ Error loading auto responses:', xhr);
                let errorMessage = 'Failed to load auto responses';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage += ': ' + xhr.responseJSON.message;
                } else if (xhr.status === 401) {
                    errorMessage = 'Session expired. Please login again.';
                    showAlert('<i class="bx bx-lock me-2"></i><strong>Session Expired!</strong> Redirecting to login...', 'warning');
                    setTimeout(() => {
                        window.location.href = '{{ route("admin.login") }}';
                    }, 2000);
                    return; // Exit early to avoid duplicate alerts
                } else if (xhr.status === 403) {
                    errorMessage = 'Access denied. You do not have permission to view auto responses.';
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error. Please try again later.';
                }
                
                showAlert(errorMessage, 'danger');
                
                // Show empty state if error
                renderEmptyState();
            })
            .always(function() {
                hideLoading();
                isLoading = false;
            });
    }

    function renderTable(data) {
        const tbody = $('#responses-table-body');
        tbody.empty();

        if (data.data.length === 0) {
            tbody.append(`
                <tr>
                    <td colspan="8" class="text-center py-4">
                        <i class="bx bx-search display-4 text-muted"></i>
                        <p class="text-muted mt-2">No auto responses found</p>
                    </td>
                </tr>
            `);
            return;
        }

        data.data.forEach(function(response) {
            const row = createTableRow(response);
            tbody.append(row);
        });

        // Update select all checkbox
        const totalCheckboxes = $('input[name="response_ids[]"]').length;
        const checkedCheckboxes = $('input[name="response_ids[]"]:checked').length;
        $('#select-all').prop('indeterminate', checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes);
        $('#select-all').prop('checked', checkedCheckboxes === totalCheckboxes && totalCheckboxes > 0);
    }

    function createTableRow(response) {
        const priorityClass = response.priority >= 100 ? 'priority-high' : 
                             response.priority >= 50 ? 'priority-medium' : 'priority-low';
        
        const statusBadge = response.is_active ? 
            '<span class="badge bg-success"><i class="bx bx-check me-1"></i>Active</span>' : 
            '<span class="badge bg-warning"><i class="bx bx-pause me-1"></i>Inactive</span>';

        const keywords = [response.keyword, ...(response.additional_keywords || [])];
        const keywordTags = keywords.map(k => `<span class="keyword-tag">${escapeHtml(k)}</span>`).join(' ');

        // Format created date
        const createdDate = response.created_at ? new Date(response.created_at).toLocaleDateString() : 'Unknown';
        
        // Truncate response for preview
        const responsePreview = response.response.length > 100 ? 
            response.response.substring(0, 100) + '...' : response.response;

        return `
            <tr data-id="${response.id}" class="table-row-hover">
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="response_ids[]" value="${response.id}">
                    </div>
                </td>
                <td>
                    <span class="${priorityClass} priority-badge" data-priority="${response.priority}">
                        ${response.priority}
                    </span>
                </td>
                <td>
                    <div class="keyword-tags">
                        <span class="keyword-tag primary">${escapeHtml(response.keyword)}</span>
                        ${keywords.slice(1).map(k => `<span class="keyword-tag secondary">${escapeHtml(k)}</span>`).join(' ')}
                    </div>
                </td>
                <td>
                    <div class="response-preview" title="${escapeHtml(response.response)}">
                        ${escapeHtml(responsePreview)}
                        ${response.response.length > 100 ? '<small class="text-muted d-block mt-1">Click to view full response</small>' : ''}
                    </div>
                </td>
                <td>
                    <span class="badge bg-info text-capitalize">${response.match_type.replace('_', ' ')}</span>
                    ${response.case_sensitive ? '<br><small class="text-muted"><i class="bx bx-case-sensitive"></i> Case Sensitive</small>' : ''}
                </td>
                <td>${statusBadge}</td>
                <td>
                    <div class="creator-info">
                        <span class="creator-name">${response.creator ? response.creator.name : 'System'}</span>
                        <small class="text-muted d-block">${createdDate}</small>
                    </div>
                </td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-info btn-view" onclick="viewResponse(${response.id})" title="View Details" data-bs-toggle="tooltip">
                            <i class="bx bx-show"></i>
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-edit" onclick="editResponse(${response.id})" title="Edit" data-bs-toggle="tooltip">
                            <i class="bx bx-edit"></i>
                        </button>
                        <button type="button" class="btn btn-outline-${response.is_active ? 'warning' : 'success'} btn-toggle" 
                                onclick="toggleStatus(${response.id})" title="${response.is_active ? 'Deactivate' : 'Activate'}" data-bs-toggle="tooltip">
                            <i class="bx bx-${response.is_active ? 'pause' : 'play'}"></i>
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-delete" onclick="deleteResponse(${response.id})" title="Delete" data-bs-toggle="tooltip">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }

    function renderPagination(data) {
        const pagination = $('#table-pagination');
        pagination.empty();

        if (data.last_page <= 1) return;

        let paginationHtml = '<ul class="pagination pagination-rounded justify-content-end mb-2">';

        // Previous button
        if (data.current_page > 1) {
            paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${data.current_page - 1}">Previous</a></li>`;
        }

        // Page numbers
        for (let i = Math.max(1, data.current_page - 2); i <= Math.min(data.last_page, data.current_page + 2); i++) {
            const active = i === data.current_page ? 'active' : '';
            paginationHtml += `<li class="page-item ${active}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
        }

        // Next button
        if (data.current_page < data.last_page) {
            paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${data.current_page + 1}">Next</a></li>`;
        }

        paginationHtml += '</ul>';
        pagination.html(paginationHtml);

        // Pagination click events
        pagination.find('a.page-link').on('click', function(e) {
            e.preventDefault();
            currentPage = parseInt($(this).data('page'));
            loadAutoResponses();
        });
    }

    function updateTableInfo(data) {
        const start = (data.current_page - 1) * data.per_page + 1;
        const end = Math.min(start + data.per_page - 1, data.total);
        $('#table-info').text(`Showing ${start} to ${end} of ${data.total} entries`);
    }

    function updateStats() {
        $.get('{{ route("admin.chatbot.stats") }}')
            .done(function(response) {
                // Update stats from AJAX response if provided
                if (response.success && response.stats) {
                    $('#total-responses').text(response.stats.total);
                    $('#active-responses').text(response.stats.active);
                    $('#inactive-responses').text(response.stats.inactive);
                    $('#high-priority-responses').text(response.stats.high_priority);
                }
            })
            .fail(function(xhr) {
                console.error('Failed to update stats:', xhr);
                // Stats update failure is not critical, just log it
            });
    }

    function testAutoResponse(message) {
        $.post('{{ route("admin.chatbot.auto-responses.test") }}', {
            message: message,
            _token: '{{ csrf_token() }}'
        })
        .done(function(response) {
            const resultDiv = $('#test-result');
            const alertDiv = $('#test-alert');
            const messageSpan = $('#test-message-text');

            if (response.matched) {
                alertDiv.removeClass('alert-warning').addClass('alert-success');
                messageSpan.html(`✅ <strong>Match found!</strong><br>Response: "${response.response}"`);
            } else {
                alertDiv.removeClass('alert-success').addClass('alert-warning');
                messageSpan.text('❌ No matching auto response found');
            }

            resultDiv.show();
        })
        .fail(function(xhr) {
            console.error('Error testing response:', xhr);
            showAlert('Failed to test response', 'danger');
        });
    }

    function saveAutoResponse() {
        // Clear previous validation errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        
        // Show saving state
        const saveBtn = $('#save-response-btn');
        const originalBtnText = saveBtn.html();
        saveBtn.html('<i class="bx bx-loader-alt bx-spin me-1"></i>Saving...').prop('disabled', true);

        const formData = {
            keyword: $('#keyword').val().trim(),
            response: $('#response').val().trim(),
            priority: parseInt($('#priority').val()) || 0,
            additional_keywords: $('#additional-keywords').val().split(',').map(k => k.trim()).filter(k => k),
            match_type: $('#match-type').val(),
            case_sensitive: $('#case-sensitive').is(':checked'),
            is_active: $('#is-active').is(':checked'),
            description: $('#description').val().trim(),
            _token: '{{ csrf_token() }}'
        };

        const responseId = $('#response-id').val();
        const url = responseId ? 
            '{{ route("admin.chatbot.auto-responses.update", ":id") }}'.replace(':id', responseId) :
            '{{ route("admin.chatbot.auto-responses.store") }}';
        const method = responseId ? 'PUT' : 'POST';
        const action = responseId ? 'updated' : 'created';

        console.log(`🔄 ${action === 'created' ? 'Creating' : 'Updating'} auto response:`, formData);

        $.ajax({
            url: url,
            method: method,
            data: formData
        })
        .done(function(response) {
            console.log(`✅ Auto response ${action}:`, response);
            
            // Close modal with animation
            $('#autoResponseModal').modal('hide');
            
            // Show success message with better styling
            showAlert(`
                <i class="bx bx-check-circle me-2"></i>
                <strong>Success!</strong> Auto response ${action} successfully.
                ${action === 'created' ? ' New response is now available for the chatbot.' : ' Changes have been applied.'}
            `, 'success');
            
            // Reload data with smooth transition
            setTimeout(() => {
                loadAutoResponses();
                updateStats();
            }, 300);
            
            // Reset form for next use
            if (!responseId) {
                resetForm();
            }
        })
        .fail(function(xhr) {
            console.error(`❌ Error ${action === 'created' ? 'creating' : 'updating'} auto response:`, xhr);
            
            const errors = xhr.responseJSON?.errors;
            if (errors) {
                // Show field-specific validation errors
                Object.keys(errors).forEach(field => {
                    const fieldElement = $(`#${field.replace('_', '-')}`);
                    if (fieldElement.length) {
                        fieldElement.addClass('is-invalid');
                        fieldElement.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                    }
                });
                
                // Show general validation error
                showAlert('<i class="bx bx-error-circle me-2"></i><strong>Validation Error!</strong> Please check the form fields and try again.', 'danger');
            } else {
                let errorMessage = 'Failed to save auto response';
                if (xhr.status === 422) {
                    errorMessage = 'Invalid data provided. Please check your input.';
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error occurred. Please try again later.';
                } else if (xhr.responseJSON?.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                showAlert(`<i class="bx bx-error-circle me-2"></i><strong>Error!</strong> ${errorMessage}`, 'danger');
            }
        })
        .always(function() {
            // Restore save button
            saveBtn.html(originalBtnText).prop('disabled', false);
        });
    }

    // View Response Details
    function viewResponse(id) {
        $.get('{{ route("admin.chatbot.auto-responses.show", ":id") }}'.replace(':id', id))
            .done(function(response) {
                const data = response.data;
                
                const modalContent = `
                    <div class="modal fade" id="viewResponseModal" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h5 class="modal-title"><i class="bx bx-show me-2"></i>Auto Response Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-md-8">
                                            <h6 class="text-muted mb-1">Primary Keyword</h6>
                                            <span class="keyword-tag primary fs-6">${escapeHtml(data.keyword)}</span>
                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="text-muted mb-1">Priority Level</h6>
                                            <span class="badge bg-${data.priority >= 100 ? 'danger' : data.priority >= 50 ? 'warning' : 'success'} fs-6">${data.priority}</span>
                                        </div>
                                    </div>
                                    
                                    ${data.additional_keywords && data.additional_keywords.length > 0 ? `
                                    <div class="mb-3">
                                        <h6 class="text-muted mb-2">Additional Keywords</h6>
                                        <div class="keyword-tags">
                                            ${data.additional_keywords.map(k => `<span class="keyword-tag secondary">${escapeHtml(k)}</span>`).join(' ')}
                                        </div>
                                    </div>
                                    ` : ''}
                                    
                                    <div class="mb-3">
                                        <h6 class="text-muted mb-2">Auto Response</h6>
                                        <div class="bg-light p-3 rounded border" style="white-space: pre-wrap;">${escapeHtml(data.response)}</div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <h6 class="text-muted mb-1">Match Type</h6>
                                            <span class="badge bg-info text-capitalize">${data.match_type.replace('_', ' ')}</span>
                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="text-muted mb-1">Case Sensitive</h6>
                                            <p class="mb-0">${data.case_sensitive ? '<i class="bx bx-check text-success fs-5"></i> Yes' : '<i class="bx bx-x text-danger fs-5"></i> No'}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="text-muted mb-1">Status</h6>
                                            <span class="badge bg-${data.is_active ? 'success' : 'warning'}">
                                                <i class="bx bx-${data.is_active ? 'check' : 'pause'} me-1"></i>${data.is_active ? 'Active' : 'Inactive'}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    ${data.description ? `
                                    <div class="mb-3">
                                        <h6 class="text-muted mb-2">Description</h6>
                                        <p class="mb-0">${escapeHtml(data.description)}</p>
                                    </div>
                                    ` : ''}
                                    
                                    <hr>
                                    <div class="row text-muted small">
                                        <div class="col-md-6">
                                            <strong>Created:</strong> ${new Date(data.created_at).toLocaleString()}<br>
                                            <strong>By:</strong> ${data.creator ? data.creator.name : 'System'}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Updated:</strong> ${new Date(data.updated_at).toLocaleString()}<br>
                                            <strong>By:</strong> ${data.updater ? data.updater.name : 'System'}
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" onclick="editResponse(${data.id}); $('#viewResponseModal').modal('hide');">
                                        <i class="bx bx-edit me-1"></i> Edit Response
                                    </button>
                                    <button type="button" class="btn btn-outline-${data.is_active ? 'warning' : 'success'}" onclick="toggleStatus(${data.id}); $('#viewResponseModal').modal('hide');">
                                        <i class="bx bx-${data.is_active ? 'pause' : 'play'} me-1"></i> ${data.is_active ? 'Deactivate' : 'Activate'}
                                    </button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                // Remove existing modal if any
                $('#viewResponseModal').remove();
                $('body').append(modalContent);
                $('#viewResponseModal').modal('show');
            })
            .fail(function(xhr) {
                showAlert('Failed to load response details', 'danger');
            });
    }

    function editResponse(id) {
        $('#autoResponseModal').modal('show');
        $('#autoResponseModalLabel').text('Edit Auto Response');
        
        // Load data with better UX
        showLoading();
        setTimeout(() => {
            loadResponseForEdit(id);
            hideLoading();
        }, 100);
    }

    function loadResponseForEdit(id) {
        // Show loading spinner in modal
        const formContent = $('#autoResponseForm').html();
        $('#autoResponseForm').html('<div class="text-center p-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        
        $.get('{{ route("admin.chatbot.auto-responses.show", ":id") }}'.replace(':id', id))
            .done(function(response) {
                // Restore form content
                $('#autoResponseForm').html(formContent);
                
                const data = response.data;
                $('#response-id').val(data.id);
                $('#keyword').val(data.keyword);
                $('#response').val(data.response);
                $('#priority').val(data.priority);
                $('#additional-keywords').val((data.additional_keywords || []).join(', '));
                $('#match-type').val(data.match_type);
                $('#case-sensitive').prop('checked', data.case_sensitive);
                $('#is-active').prop('checked', data.is_active);
                $('#description').val(data.description);
                
                // Focus on first field for better UX
                setTimeout(() => {
                    $('#keyword').focus().select();
                }, 200);
                
                // Animate form fields
                $('#autoResponseForm .form-group').each(function(index) {
                    $(this).css('opacity', '0').delay(index * 50).animate({opacity: 1}, 200);
                });
            })
            .fail(function(xhr) {
                // Restore form content on error
                $('#autoResponseForm').html(formContent);
                console.error('Error loading response:', xhr);
                showAlert('Failed to load response data', 'danger');
                $('#autoResponseModal').modal('hide');
            });
    }

    function toggleStatus(id) {
        const row = $(`tr[data-id="${id}"]`);
        const toggleBtn = row.find('.btn-toggle');
        const originalBtnContent = toggleBtn.html();
        
        // Show loading state on button
        toggleBtn.html('<i class="bx bx-loader-alt bx-spin"></i>').prop('disabled', true);
        
        // Add loading animation to row
        row.addClass('opacity-50');
        
        console.log(`🔄 Toggling status for response ID: ${id}`);

        $.post('{{ route("admin.chatbot.auto-responses.toggle", ":id") }}'.replace(':id', id), {
            _token: '{{ csrf_token() }}'
        })
        .done(function(response) {
            console.log('✅ Status toggled:', response);
            
            // Show success message
            showAlert(`
                <i class="bx bx-toggle-${response.data.is_active ? 'right' : 'left'} me-2"></i>
                <strong>Status Updated!</strong> Auto response ${response.data.is_active ? 'activated' : 'deactivated'} successfully.
            `, 'success');
            
            // Update the specific row instead of reloading entire table
            updateRowStatus(id, response.data);
            
            // Update stats
            updateStats();
        })
        .fail(function(xhr) {
            console.error('❌ Error toggling status:', xhr);
            
            let errorMessage = 'Failed to toggle status';
            if (xhr.responseJSON?.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.status === 403) {
                errorMessage = 'You do not have permission to change this status';
            } else if (xhr.status === 404) {
                errorMessage = 'Auto response not found';
            }
            
            showAlert(`<i class="bx bx-error-circle me-2"></i><strong>Error!</strong> ${errorMessage}`, 'danger');
        })
        .always(function() {
            // Restore button and row state
            toggleBtn.html(originalBtnContent).prop('disabled', false);
            row.removeClass('opacity-50');
        });
    }

    function updateRowStatus(id, data) {
        const row = $(`tr[data-id="${id}"]`);
        
        // Update status badge
        const statusBadge = data.is_active ? 
            '<span class="badge bg-success"><i class="bx bx-check me-1"></i>Active</span>' : 
            '<span class="badge bg-warning"><i class="bx bx-pause me-1"></i>Inactive</span>';
        
        row.find('td:nth-child(6)').html(statusBadge);
        
        // Update toggle button
        const toggleBtn = row.find('.btn-toggle');
        toggleBtn
            .removeClass('btn-outline-warning btn-outline-success')
            .addClass(data.is_active ? 'btn-outline-warning' : 'btn-outline-success')
            .attr('title', data.is_active ? 'Deactivate' : 'Activate')
            .html(`<i class="bx bx-${data.is_active ? 'pause' : 'play'}"></i>`);
        
        // Add visual feedback
        row.addClass('table-success');
        setTimeout(() => {
            row.removeClass('table-success');
        }, 2000);
    }

    function deleteResponse(id) {
        if (!confirm('Are you sure you want to delete this auto response?')) {
            return;
        }

        $.ajax({
            url: '{{ route("admin.chatbot.auto-responses.destroy", ":id") }}'.replace(':id', id),
            method: 'DELETE',
            data: { _token: '{{ csrf_token() }}' }
        })
        .done(function(response) {
            showAlert(response.message, 'success');
            loadAutoResponses();
            updateStats();
        })
        .fail(function(xhr) {
            console.error('Error deleting response:', xhr);
            showAlert('Failed to delete response', 'danger');
        });
    }

    function resetForm() {
        $('#autoResponseForm')[0].reset();
        $('#response-id').val('');
        $('#is-active').prop('checked', true);
    }

    function updateSelectedIds() {
        selectedIds = [];
        $('input[name="response_ids[]"]:checked').each(function() {
            selectedIds.push($(this).val());
        });
        
        $('#bulk-delete-btn').prop('disabled', selectedIds.length === 0);
        
        // Update select all checkbox state
        const totalCheckboxes = $('input[name="response_ids[]"]').length;
        const checkedCheckboxes = selectedIds.length;
        $('#select-all').prop('indeterminate', checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes);
        $('#select-all').prop('checked', checkedCheckboxes === totalCheckboxes && totalCheckboxes > 0);
    }

    function bulkDeleteResponses() {
        $.post('{{ route("admin.chatbot.auto-responses.bulk-delete") }}', {
            ids: selectedIds,
            _token: '{{ csrf_token() }}'
        })
        .done(function(response) {
            showAlert(response.message, 'success');
            loadAutoResponses();
            updateStats();
            selectedIds = [];
            $('#select-all').prop('checked', false);
            $('#bulk-delete-btn').prop('disabled', true);
        })
        .fail(function(xhr) {
            console.error('Error bulk deleting:', xhr);
            showAlert('Failed to delete selected responses', 'danger');
        });
    }

    function exportAutoResponses() {
        window.open('{{ route("admin.chatbot.auto-responses.export") }}', '_blank');
    }

    function showLoading() {
        $('#loading-overlay').show();
    }

    function hideLoading() {
        $('#loading-overlay').hide();
    }

    function showAlert(message, type) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        $('.container-fluid').prepend(alertHtml);
        
        // Auto dismiss after 5 seconds
        setTimeout(() => {
            $('.alert').fadeOut();
        }, 5000);
    }

    function escapeHtml(text) {
        if (!text) return '';
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.toString().replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Authentication check function
    function checkAuthentication() {
        return new Promise((resolve, reject) => {
            $.get('{{ route("admin.auth.check") }}')
                .done(function(response) {
                    if (response.authenticated) {
                        console.log('✅ Admin authenticated successfully');
                        resolve(true);
                    } else {
                        console.log('❌ Admin not authenticated');
                        reject(false);
                    }
                })
                .fail(function(xhr) {
                    console.log('❌ Authentication check failed:', xhr.status);
                    if (xhr.status === 401 || xhr.status === 403) {
                        reject(false);
                    } else {
                        // Network error, but assume authenticated for now
                        resolve(true);
                    }
                });
        });
    }

    // Enhanced utility functions for better UX
    function initializeTooltips() {
        // Initialize Bootstrap tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();
    }

    function addRowHoverEffects() {
        // Add smooth hover effects to table rows
        $('#responses-table-body tr').hover(
            function() {
                $(this).addClass('table-hover-highlight');
            },
            function() {
                $(this).removeClass('table-hover-highlight');
            }
        );
    }

    function renderEmptyState() {
        const tbody = $('#responses-table-body');
        tbody.html(`
            <tr>
                <td colspan="8" class="text-center py-5">
                    <div class="empty-state">
                        <i class="bx bx-message-dots display-1 text-muted mb-3"></i>
                        <h5 class="text-muted">No Auto Responses Found</h5>
                        <p class="text-muted mb-4">
                            ${$('#search-input').val() || $('#status-filter').val() !== '' ? 
                                'Try adjusting your search criteria or filters.' : 
                                'Get started by creating your first auto response.'}
                        </p>
                        ${!$('#search-input').val() && $('#status-filter').val() === '' ? 
                            '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#autoResponseModal"><i class="bx bx-plus me-1"></i>Create First Auto Response</button>' : 
                            '<button type="button" class="btn btn-outline-primary" onclick="clearFilters()"><i class="bx bx-refresh me-1"></i>Clear Filters</button>'}
                    </div>
                </td>
            </tr>
        `);
    }

    function clearFilters() {
        $('#search-input').val('');
        $('#status-filter').val('');
        currentPage = 1;
        loadAutoResponses();
    }

    // Auto-refresh functionality - stats only
    let autoRefreshInterval;
    
    function startStatsRefresh() {
        autoRefreshInterval = setInterval(() => {
            if (!$('.modal').hasClass('show')) { // Only refresh if no modal is open
                updateStats();
                console.log('🔄 Auto-refreshing stats...');
            }
        }, 30000); // Refresh every 30 seconds
    }

    function stopAutoRefresh() {
        if (autoRefreshInterval) {
            clearInterval(autoRefreshInterval);
        }
    }

    // Global functions for button onclick events
    window.editResponse = editResponse;
    window.toggleStatus = toggleStatus;
    window.deleteResponse = deleteResponse;
    window.viewResponse = viewResponse;
    window.clearFilters = clearFilters;
});
</script>
@endpush 