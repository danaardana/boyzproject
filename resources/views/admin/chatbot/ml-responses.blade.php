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
                        <h4 class="mb-sm-0 font-size-18">ML Response Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.chatbot') }}">Chatbot</a></li>
                                <li class="breadcrumb-item active">ML Responses</li>
                            </ol>
                            <div class="mt-2">
                                <button type="button" class="btn btn-primary btn-sm" id="import-responses-btn">
                                    <i class="bx bx-import me-1"></i>Import from ML Model
                                </button>
                                <a href="{{ route('admin.chatbot') }}" class="btn btn-outline-success btn-sm ms-2">
                                    <i class="bx bx-message-dots me-1"></i>Auto Responses
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card card-h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Responses</span>
                                    <h4 class="mb-3" id="total-responses">-</h4>
                                </div>
                                <div class="flex-shrink-0 text-end">
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-soft-primary rounded-circle fs-3">
                                            <i class="bx bx-message-dots text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Active Responses</span>
                                    <h4 class="mb-3" id="active-responses">-</h4>
                                </div>
                                <div class="flex-shrink-0 text-end">
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-soft-success rounded-circle fs-3">
                                            <i class="bx bx-check-circle text-success"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Main Intents</span>
                                    <h4 class="mb-3" id="main-intents">-</h4>
                                </div>
                                <div class="flex-shrink-0 text-end">
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-soft-info rounded-circle fs-3">
                                            <i class="bx bx-category text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Sub Intents</span>
                                    <h4 class="mb-3" id="sub-intents">-</h4>
                                </div>
                                <div class="flex-shrink-0 text-end">
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-soft-warning rounded-circle fs-3">
                                            <i class="bx bx-subdirectory-right text-warning"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ML Responses Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title">
                                        <i class="bx bx-message-dots me-2"></i>ML Response Dictionary
                                    </h4>
                                    <p class="card-title-desc mb-0">Manage responses used by the ML model for intent detection</p>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-primary" id="add-response-btn">
                                        <i class="bx bx-plus me-1"></i>Add Response
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Filters -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <select class="form-select" id="category-filter">
                                        <option value="">All Categories</option>
                                        <option value="main_intent">Main Intents</option>
                                        <option value="sub_intent">Sub Intents</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" id="status-filter">
                                        <option value="">All Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="search-input" placeholder="Search responses...">
                                        <button class="btn btn-primary" type="button" id="search-btn">
                                            <i class="bx bx-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="responses-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Intent Key</th>
                                            <th>Response</th>
                                            <th>Category</th>
                                            <th>Usage Count</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="responses-table-body">
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <p class="mt-2 mb-0">Loading responses...</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="row mt-3">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" id="responses-info" role="status" aria-live="polite">
                                        Showing 0 to 0 of 0 entries
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <div class="dataTables_paginate paging_simple_numbers" id="responses-pagination">
                                        <!-- Pagination will be inserted here by JavaScript -->
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

<!-- Add/Edit Response Modal -->
<div class="modal fade" id="response-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Add ML Response</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="response-form">
                <div class="modal-body">
                    <input type="hidden" id="response-id">
                    <div class="mb-3">
                        <label for="intent-key" class="form-label">Intent Key</label>
                        <input type="text" class="form-control" id="intent-key" required>
                        <div class="form-text">Unique identifier for this intent (e.g. 'harga', 'stok_produk')</div>
                    </div>
                    <div class="mb-3">
                        <label for="response-text" class="form-label">Response Template</label>
                        <textarea class="form-control" id="response-text" rows="4" required></textarea>
                        <div class="form-text">Use emojis and markdown for better formatting</div>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" required>
                            <option value="main_intent">Main Intent</option>
                            <option value="sub_intent">Sub Intent</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is-active" checked>
                            <label class="form-check-label" for="is-active">Active</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Response</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Import Confirmation Modal -->
<div class="modal fade" id="import-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import ML Responses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>This will import all responses from the ML model (predict_v2.py). Existing responses will be updated.</p>
                <p class="text-warning mb-0">
                    <i class="bx bx-error-circle me-1"></i>
                    Make sure to backup your current responses before proceeding.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirm-import-btn">Import Responses</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ML Response Management JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize variables
    let currentPage = 1;
    let searchQuery = '';
    let categoryFilter = '';
    let statusFilter = '';
    
    // Load initial data
    loadResponses();
    updateStats();
    
    // Event Listeners
    document.getElementById('search-btn').addEventListener('click', function() {
        searchQuery = document.getElementById('search-input').value;
        currentPage = 1;
        loadResponses();
    });
    
    document.getElementById('category-filter').addEventListener('change', function() {
        categoryFilter = this.value;
        currentPage = 1;
        loadResponses();
    });
    
    document.getElementById('status-filter').addEventListener('change', function() {
        statusFilter = this.value;
        currentPage = 1;
        loadResponses();
    });
    
    document.getElementById('add-response-btn').addEventListener('click', function() {
        showResponseModal();
    });
    
    document.getElementById('import-responses-btn').addEventListener('click', function() {
        showImportModal();
    });
    
    document.getElementById('confirm-import-btn').addEventListener('click', function() {
        importResponses();
    });
    
    document.getElementById('response-form').addEventListener('submit', function(e) {
        e.preventDefault();
        saveResponse();
    });
    
    // Functions
    function loadResponses() {
        const url = new URL('{{ route("admin.chatbot.ml-responses") }}');
        url.searchParams.append('page', currentPage);
        if (searchQuery) url.searchParams.append('search', searchQuery);
        if (categoryFilter) url.searchParams.append('category', categoryFilter);
        if (statusFilter) url.searchParams.append('status', statusFilter);
        
        fetch(url)
            .then(response => response.json())
            .then(data => {
                updateTable(data);
                updatePagination(data);
                updateStats();
            })
            .catch(error => {
                console.error('Error loading responses:', error);
                showToast('Error loading responses', 'error');
            });
    }
    
    function updateTable(data) {
        const tbody = document.getElementById('responses-table-body');
        tbody.innerHTML = '';
        
        if (data.data.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-4">
                        No responses found
                    </td>
                </tr>
            `;
            return;
        }
        
        data.data.forEach(response => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${response.intent_key}</td>
                <td>${response.response}</td>
                <td>${response.category === 'main_intent' ? 'Main Intent' : 'Sub Intent'}</td>
                <td>${response.usage_count}</td>
                <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input toggle-status" type="checkbox" 
                               data-id="${response.id}" 
                               ${response.is_active ? 'checked' : ''}>
                    </div>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-info edit-response" 
                            data-id="${response.id}">
                        <i class="bx bx-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger delete-response" 
                            data-id="${response.id}">
                        <i class="bx bx-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });
        
        // Add event listeners to new buttons
        document.querySelectorAll('.toggle-status').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                toggleResponseStatus(this.dataset.id);
            });
        });
        
        document.querySelectorAll('.edit-response').forEach(button => {
            button.addEventListener('click', function() {
                showResponseModal(this.dataset.id);
            });
        });
        
        document.querySelectorAll('.delete-response').forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Are you sure you want to delete this response?')) {
                    deleteResponse(this.dataset.id);
                }
            });
        });
    }
    
    function updatePagination(data) {
        const pagination = document.getElementById('responses-pagination');
        const info = document.getElementById('responses-info');
        
        // Update info text
        const start = (data.current_page - 1) * data.per_page + 1;
        const end = Math.min(start + data.per_page - 1, data.total);
        info.textContent = `Showing ${start} to ${end} of ${data.total} entries`;
        
        // Update pagination buttons
        let html = '<ul class="pagination">';
        
        // Previous button
        html += `
            <li class="page-item ${data.current_page === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${data.current_page - 1}">Previous</a>
            </li>
        `;
        
        // Page numbers
        for (let i = 1; i <= data.last_page; i++) {
            if (i === 1 || i === data.last_page || (i >= data.current_page - 2 && i <= data.current_page + 2)) {
                html += `
                    <li class="page-item ${i === data.current_page ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `;
            } else if (i === data.current_page - 3 || i === data.current_page + 3) {
                html += '<li class="page-item disabled"><a class="page-link">...</a></li>';
            }
        }
        
        // Next button
        html += `
            <li class="page-item ${data.current_page === data.last_page ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${data.current_page + 1}">Next</a>
            </li>
        `;
        
        html += '</ul>';
        pagination.innerHTML = html;
        
        // Add event listeners to pagination buttons
        pagination.querySelectorAll('.page-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const page = parseInt(this.dataset.page);
                if (!isNaN(page)) {
                    currentPage = page;
                    loadResponses();
                }
            });
        });
    }
    
    function updateStats() {
        fetch('{{ route("admin.chatbot.ml-responses") }}?stats=true')
            .then(response => response.json())
            .then(data => {
                document.getElementById('total-responses').textContent = data.total;
                document.getElementById('active-responses').textContent = data.active;
                document.getElementById('main-intents').textContent = data.main_intents;
                document.getElementById('sub-intents').textContent = data.sub_intents;
            })
            .catch(error => {
                console.error('Error loading stats:', error);
            });
    }
    
    function showResponseModal(id = null) {
        const modal = document.getElementById('response-modal');
        const form = document.getElementById('response-form');
        const title = document.getElementById('modal-title');
        
        // Reset form
        form.reset();
        document.getElementById('response-id').value = '';
        
        if (id) {
            // Edit mode
            title.textContent = 'Edit ML Response';
            fetch(`{{ route("admin.chatbot.ml-responses") }}/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('response-id').value = data.id;
                    document.getElementById('intent-key').value = data.intent_key;
                    document.getElementById('intent-key').readOnly = true;
                    document.getElementById('response-text').value = data.response;
                    document.getElementById('category').value = data.category;
                    document.getElementById('is-active').checked = data.is_active;
                })
                .catch(error => {
                    console.error('Error loading response:', error);
                    showToast('Error loading response', 'error');
                });
        } else {
            // Add mode
            title.textContent = 'Add ML Response';
            document.getElementById('intent-key').readOnly = false;
        }
        
        new bootstrap.Modal(modal).show();
    }
    
    function showImportModal() {
        new bootstrap.Modal(document.getElementById('import-modal')).show();
    }
    
    function saveResponse() {
        const id = document.getElementById('response-id').value;
        const data = {
            intent_key: document.getElementById('intent-key').value,
            response: document.getElementById('response-text').value,
            category: document.getElementById('category').value,
            is_active: document.getElementById('is-active').checked
        };
        
        const url = id 
            ? `{{ route("admin.chatbot.ml-responses") }}/${id}`
            : '{{ route("admin.chatbot.ml-responses.store") }}';
        
        const method = id ? 'PUT' : 'POST';
        
        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('response-modal')).hide();
                showToast(data.message, 'success');
                loadResponses();
            } else {
                showToast(data.message || 'Error saving response', 'error');
            }
        })
        .catch(error => {
            console.error('Error saving response:', error);
            showToast('Error saving response', 'error');
        });
    }
    
    function toggleResponseStatus(id) {
        fetch(`{{ route("admin.chatbot.ml-responses") }}/${id}/toggle`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                loadResponses();
            } else {
                showToast(data.message || 'Error updating status', 'error');
            }
        })
        .catch(error => {
            console.error('Error updating status:', error);
            showToast('Error updating status', 'error');
        });
    }
    
    function deleteResponse(id) {
        fetch(`{{ route("admin.chatbot.ml-responses") }}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                loadResponses();
            } else {
                showToast(data.message || 'Error deleting response', 'error');
            }
        })
        .catch(error => {
            console.error('Error deleting response:', error);
            showToast('Error deleting response', 'error');
        });
    }
    
    function importResponses() {
        fetch('{{ route("admin.chatbot.ml-responses.import") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('import-modal')).hide();
                showToast(data.message, 'success');
                loadResponses();
            } else {
                showToast(data.message || 'Error importing responses', 'error');
            }
        })
        .catch(error => {
            console.error('Error importing responses:', error);
            showToast('Error importing responses', 'error');
        });
    }
    
    function showToast(message, type = 'success') {
        // Implement your toast notification here
        console.log(`${type.toUpperCase()}: ${message}`);
    }
});
</script>
@endpush 