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
                        <h4 class="mb-sm-0 font-size-18">Smart Responses Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.chatbot') }}">Chatbot</a></li>
                                <li class="breadcrumb-item active">Smart Responses</li>
                            </ol>
                            <div class="mt-2">
                                <a href="{{ route('admin.chatbot') }}" class="btn btn-outline-success btn-sm">
                                    <i class="bx bx-message-dots me-1"></i>Auto Responses
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ML Model Status Cards -->
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card card-h-100">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">ML Model Status</span>
                                    <h4 class="mb-3">
                                        <span class="badge bg-success" id="ml-status">Active</span>
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <i class="bx bx-brain text-primary display-6"></i>
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
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Motor Types</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value" id="motor-count">0</span>
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <i class="bx bx-car text-success display-6"></i>
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
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Response Templates</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value" id="response-count">0</span>
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <i class="bx bx-message-dots text-info display-6"></i>
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
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Predictions Today</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value" id="predictions-today">0</span>
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <i class="bx bx-trending-up text-warning display-6"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ML Model Test Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title">
                                        <i class="bx bx-test-tube me-2"></i>Smart Response Testing
                                    </h4>
                                    <p class="card-title-desc mb-0">Test how the chatbot understands and responds to customer messages</p>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-outline-info" id="ml-info-btn" data-bs-toggle="tooltip" title="View ML Model Information">
                                        <i class="bx bx-info-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="ml-test-message" placeholder="Enter a message to test ML prediction...">
                                        <button class="btn btn-primary" type="button" id="ml-test-btn">
                                            <i class="bx bx-brain me-1"></i> Test ML Prediction
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="btn-group w-100" role="group">
                                        <button class="btn btn-outline-secondary" type="button" id="test-examples-btn">
                                            <i class="bx bx-list-ul me-1"></i> Examples
                                        </button>
                                        <button class="btn btn-outline-warning" type="button" id="test-python-btn">
                                            <i class="bx bx-check-circle me-1"></i> Test Python
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div id="ml-test-result" class="mt-4" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card border-left-primary">
                                            <div class="card-body">
                                                <h6 class="card-title text-primary">
                                                    <i class="bx bx-message me-1"></i>ML Response
                                                </h6>
                                                <div id="ml-response-content"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card border-left-info">
                                            <div class="card-body">
                                                <h6 class="card-title text-info">
                                                    <i class="bx bx-analysis me-1"></i>Detection Details
                                                </h6>
                                                <div id="ml-detection-details"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Motor Compatibility Management -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title">
                                        <i class="bx bx-car me-2"></i>Product Compatibility Management
                                    </h4>
                                    <p class="card-title-desc mb-0">Manage available products and their motor compatibility for smart chatbot responses</p>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-success" id="refresh-motors-btn">
                                        <i class="bx bx-refresh me-1"></i> Refresh from Database
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="bx bx-info-circle me-2"></i>
                                <strong>Info:</strong> Product compatibility data is automatically synced from your Products database. 
                                To add new products or motor types, manage them in the Products section under 'motor_type' options.
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="motors-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Product Name</th>
                                            <th>Motor Type</th>
                                            <th>Category</th>
                                            <th>Stock</th>
                                            <th>Availability</th>
                                        </tr>
                                    </thead>
                                    <tbody id="motors-table-body">
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <p class="mt-2 mb-0">Loading motor compatibility data...</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ML Response Dictionary Management -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title">
                                        <i class="bx bx-message-dots me-2"></i>ML Response Dictionary
                                    </h4>
                                    <p class="card-title-desc mb-0">Response templates used by ML model (synced from Chatbot Auto Responses)</p>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-success" id="refresh-responses-btn">
                                        <i class="bx bx-refresh me-1"></i> Refresh from Database
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning">
                                <i class="bx bx-warning me-2"></i>
                                <strong>Note:</strong> To modify these responses, edit them in the 
                                <a href="{{ route('admin.chatbot') }}" class="alert-link">Chatbot Auto Responses</a> section. 
                                Changes will be automatically reflected in the ML model.
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="response-search" placeholder="Search responses...">
                                        <button class="btn btn-outline-secondary" type="button" id="response-search-btn">
                                            <i class="bx bx-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-select" id="response-category-filter">
                                        <option value="">All Categories</option>
                                        <option value="harga">Harga (Price)</option>
                                        <option value="stok">Stok (Stock)</option>
                                        <option value="kategori">Kategori (Category)</option>
                                        <option value="general">General</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="responses-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Keyword</th>
                                            <th>Response Preview</th>
                                            <th>Category</th>
                                            <th>Usage Count</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="responses-table-body">
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <p class="mt-2 mb-0">Loading response dictionary...</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ML Model Info Modal -->
<div class="modal fade" id="mlInfoModal" tabindex="-1" aria-labelledby="mlInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mlInfoModalLabel">
                    <i class="bx bx-brain me-2"></i>ML Model Information
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Model Details</h6>
                        <ul class="list-unstyled">
                            <li><strong>Version:</strong> v2.0 (Multi-label Classification)</li>
                            <li><strong>Algorithm:</strong> OneVsRestClassifier + MultinomialNB</li>
                            <li><strong>Features:</strong> TF-IDF Vectorization</li>
                            <li><strong>Training Data:</strong> Sub-intent patterns</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-info">Capabilities</h6>
                        <ul class="list-unstyled">
                            <li>✅ Multi-intent detection</li>
                            <li>✅ Motor type recognition</li>
                            <li>✅ Contextual responses</li>
                            <li>✅ Confidence scoring</li>
                            <li>✅ Pattern enhancement</li>
                        </ul>
                    </div>
                </div>
                <hr>
                <h6 class="text-success">Supported Intent Categories</h6>
                <div class="row">
                    <div class="col-md-4">
                        <strong>HARGA (Price)</strong>
                        <ul class="small">
                            <li>harga_produk</li>
                            <li>harga_promo</li>
                            <li>harga_grosir</li>
                            <li>harga_ongkir</li>
                            <li>harga_instalasi</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <strong>STOK_PRODUK (Stock)</strong>
                        <ul class="small">
                            <li>stok_tersedia</li>
                            <li>stok_habis</li>
                            <li>stok_booking</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <strong>CATEGORIES</strong>
                        <ul class="small">
                            <li>kategori_lighting</li>
                            <li>kategori_mounting_body</li>
                            <li>motor_compatibility</li>
                            <li>general_inquiry</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="{{ route('admin.chatbot') }}" class="btn btn-primary">
                    <i class="bx bx-cog me-1"></i>Manage Auto Responses
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Response Detail Modal -->
<div class="modal fade" id="responseDetailModal" tabindex="-1" aria-labelledby="responseDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="responseDetailModalLabel">Response Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="response-detail-content">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="edit-response-btn">
                    <i class="bx bx-edit me-1"></i>Edit Response
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Response Modal -->
<div class="modal fade" id="editResponseModal" tabindex="-1" aria-labelledby="editResponseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editResponseModalLabel">
                    <i class="bx bx-edit me-2"></i>Edit Response
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editResponseForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit-keyword" class="form-label">Keyword</label>
                                <input type="text" class="form-control" id="edit-keyword" readonly>
                                <div class="form-text">Keywords cannot be modified here</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit-category" class="form-label">Category</label>
                                <select class="form-select" id="edit-category">
                                    <option value="main_intent">Main Intent</option>
                                    <option value="sub_intent">Sub Intent</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit-response-text" class="form-label">Response Text</label>
                        <textarea class="form-control" id="edit-response-text" rows="6" placeholder="Enter the response text..."></textarea>
                        <div class="form-text">
                            <span id="char-count">0</span> characters
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit-is-active" checked>
                                <label class="form-check-label" for="edit-is-active">
                                    Active Response
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit-usage-count" class="form-label">Usage Count</label>
                                <input type="number" class="form-control" id="edit-usage-count" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="bx bx-info-circle me-2"></i>
                        <strong>Note:</strong> Changes will be reflected in the ML model after saving. For advanced editing options, use the 
                        <a href="{{ route('admin.chatbot.ml') }}" class="alert-link">ML Response Management</a> section.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.border-left-primary {
    border-left: 4px solid #007bff !important;
}

.border-left-info {
    border-left: 4px solid #17a2b8 !important;
}

.card-h-100 {
    height: calc(100% - 30px);
}

.counter-value {
    font-weight: 600;
}

.table-responsive {
    max-height: 400px;
    overflow-y: auto;
}

.spinner-border {
    width: 1.5rem;
    height: 1.5rem;
}

.response-preview {
    max-width: 300px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.motor-badge {
    background: #e9ecef;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    margin: 0.125rem;
    display: inline-block;
}

.intent-badge {
    background: #28a745;
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    margin: 0.125rem;
    display: inline-block;
}

.confidence-bar {
    height: 8px;
    border-radius: 4px;
    background: #e9ecef;
    position: relative;
    margin-top: 0.25rem;
}

.confidence-fill {
    height: 100%;
    border-radius: 4px;
    transition: width 0.3s ease;
}

.confidence-high {
    background: #28a745;
}

.confidence-medium {
    background: #ffc107;
}

.confidence-low {
    background: #dc3545;
}

.ml-response-item {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 0.75rem;
    margin-bottom: 0.5rem;
}

.loading-spinner {
    display: none;
}

.loading .loading-spinner {
    display: inline-block;
}

.alert-link {
    text-decoration: none;
}

.alert-link:hover {
    text-decoration: underline;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Load initial data
    loadProductCompatibility();
    loadResponseDictionary();

    // ML Info button
    $('#ml-info-btn').on('click', function() {
        $('#mlInfoModal').modal('show');
    });

    // ML Test functionality
    $('#ml-test-btn').on('click', function() {
        testMLPrediction();
    });

    $('#ml-test-message').on('keypress', function(e) {
        if (e.which === 13) {
            testMLPrediction();
        }
    });

    // Test examples button
    $('#test-examples-btn').on('click', function() {
        showTestExamples();
    });

    // Test Python installation button
    $('#test-python-btn').on('click', function() {
        testPythonInstallation();
    });

    // Refresh buttons
    $('#refresh-motors-btn').on('click', function() {
        loadProductCompatibility();
    });

    $('#refresh-responses-btn').on('click', function() {
        loadResponseDictionary();
    });

    // Search functionality
    $('#response-search-btn').on('click', function() {
        filterResponses();
    });

    $('#response-search').on('keypress', function(e) {
        if (e.which === 13) {
            filterResponses();
        }
    });

    $('#response-category-filter').on('change', function() {
        filterResponses();
    });

    // Edit response modal handlers
    $('#edit-response-text').on('input', updateCharCount);
    
    // Edit response button in detail modal
    $('#edit-response-btn').on('click', function() {
        const keyword = $(this).data('keyword');
        const response = $(this).data('response');
        $('#responseDetailModal').modal('hide');
        setTimeout(() => {
            showEditResponseModal(keyword, response);
        }, 300);
    });

    // Edit response form submission
    $('#editResponseForm').on('submit', function(e) {
        e.preventDefault();
        saveResponseChanges();
    });

    function testMLPrediction() {
        const message = $('#ml-test-message').val().trim();
        if (!message) {
            showAlert('Please enter a message to test', 'warning');
            return;
        }

        const $btn = $('#ml-test-btn');
        const originalText = $btn.html();
        $btn.html('<div class="spinner-border spinner-border-sm me-1" role="status"></div> Testing...').prop('disabled', true);

        $.ajax({
            url: '{{ route("admin.chatbot.ml.predict") }}',
            method: 'POST',
            data: {
                message: message,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    displayMLResult(response.prediction, message);
                } else {
                    showAlert('ML Test failed: ' + (response.error || response.message), 'danger');
                }
            },
            error: function(xhr) {
                const errorMsg = xhr.responseJSON?.message || 'An error occurred while testing ML prediction';
                showAlert('Error: ' + errorMsg, 'danger');
            },
            complete: function() {
                $btn.html(originalText).prop('disabled', false);
            }
        });
    }

    function displayMLResult(prediction, originalMessage) {
        const resultDiv = $('#ml-test-result');
        const responseContent = $('#ml-response-content');
        const detectionDetails = $('#ml-detection-details');

        // Display responses
        let responseHtml = '';
        if (prediction.responses && prediction.responses.length > 0) {
            prediction.responses.forEach((response, index) => {
                responseHtml += `
                    <div class="ml-response-item">
                        <strong>Response ${index + 1}:</strong><br>
                        ${response}
                    </div>
                `;
            });
        } else {
            responseHtml = '<div class="text-muted">No responses generated from detected intents</div>';
        }
        responseContent.html(responseHtml);

        // Display detection details
        let detailsHtml = '';
        
        // Show raw ML output details
        if (prediction.raw_ml_output) {
            const rawOutput = prediction.raw_ml_output;
            
            if (rawOutput.confidence !== undefined) {
                const confidencePercent = (rawOutput.confidence * 100).toFixed(1);
                const confidenceClass = rawOutput.confidence > 0.7 ? 'confidence-high' : 
                                       rawOutput.confidence > 0.3 ? 'confidence-medium' : 'confidence-low';
                detailsHtml += `
                    <div class="mb-3">
                        <strong>ML Confidence:</strong> ${confidencePercent}%
                        <div class="confidence-bar">
                            <div class="confidence-fill ${confidenceClass}" style="width: ${confidencePercent}%"></div>
                        </div>
                    </div>
                `;
            }

            if (rawOutput.intents && rawOutput.intents.length > 0) {
                detailsHtml += '<div class="mb-3"><strong>Detected Intents:</strong><br>';
                rawOutput.intents.forEach(intent => {
                    detailsHtml += `<span class="intent-badge">${intent}</span>`;
                });
                detailsHtml += '</div>';
            }

            if (rawOutput.detected_motors && rawOutput.detected_motors.length > 0) {
                detailsHtml += '<div class="mb-3"><strong>Detected Motors:</strong><br>';
                rawOutput.detected_motors.forEach(motor => {
                    detailsHtml += `<span class="motor-badge">${motor}</span>`;
                });
                detailsHtml += '</div>';
            }

            if (rawOutput.enhanced_labels && rawOutput.enhanced_labels.length > 0) {
                detailsHtml += '<div class="mb-3"><strong>Enhanced Labels:</strong><br>';
                detailsHtml += `<small class="text-info">${rawOutput.enhanced_labels.join(', ')}</small></div>`;
            }

            if (rawOutput.top_confidences && rawOutput.top_confidences.length > 0) {
                detailsHtml += '<div class="mb-3"><strong>Top Confidences:</strong><br>';
                rawOutput.top_confidences.forEach(([intent, conf]) => {
                    detailsHtml += `<small class="text-muted">${intent}: ${conf}</small><br>`;
                });
                detailsHtml += '</div>';
            }
        }

        // Show comprehensive result comparison
        if (prediction.comprehensive_result) {
            const compResult = prediction.comprehensive_result;
            detailsHtml += `
                <div class="mb-3">
                    <strong>Comprehensive Result Type:</strong> 
                    <span class="badge bg-secondary">${compResult.type}</span>
                </div>
            `;
            
            if (compResult.matched_keyword) {
                detailsHtml += `
                    <div class="mb-3">
                        <strong>Matched Auto Response:</strong> 
                        <span class="text-warning">${compResult.matched_keyword}</span>
                    </div>
                `;
            }
        }

        detectionDetails.html(detailsHtml);
        resultDiv.show();
    }

    function showTestExamples() {
        const examples = [
            "Berapa harga mounting carbon dan ada promo gak?",
            "Lampu LED projector untuk Beat masih ada stok?",
            "Body kit Aerox ready stock berapa harga?",
            "Biaya pasang lampu DRL di rumah weekend berapa ya?",
            "Mounting phone holder waterproof harga grosir berapa?"
        ];

        let exampleHtml = '<div class="list-group">';
        examples.forEach((example, index) => {
            exampleHtml += `
                <a href="#" class="list-group-item list-group-item-action example-item" data-example="${example}">
                    <strong>Example ${index + 1}:</strong> ${example}
                </a>
            `;
        });
        exampleHtml += '</div>';

        showModal('Test Examples', exampleHtml);

        // Handle example selection
        $(document).on('click', '.example-item', function(e) {
            e.preventDefault();
            const example = $(this).data('example');
            $('#ml-test-message').val(example);
            $('.modal').modal('hide');
        });
    }

    function testPythonInstallation() {
        const $btn = $('#test-python-btn');
        const originalText = $btn.html();
        $btn.html('<div class="spinner-border spinner-border-sm me-1" role="status"></div> Testing...').prop('disabled', true);

        $.ajax({
            url: '{{ route("admin.chatbot.ml.test-python") }}',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    const pythonInfo = response.python_info;
                    const modalContent = `
                        <div class="alert alert-success">
                            <i class="bx bx-check-circle me-2"></i>
                            <strong>Python Installation Test Successful!</strong>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-success">Python Details</h6>
                                <ul class="list-unstyled">
                                    <li><strong>Version:</strong> ${pythonInfo.python_version.split(' ')[0]}</li>
                                    <li><strong>Executable:</strong> <small>${pythonInfo.python_executable}</small></li>
                                    <li><strong>Status:</strong> <span class="badge bg-success">Working</span></li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-info">Configuration</h6>
                                <ul class="list-unstyled">
                                    <li><strong>Path Used:</strong> <small>${response.python_path}</small></li>
                                    <li><strong>ML Models:</strong> <span class="badge bg-primary">Ready</span></li>
                                    <li><strong>Dependencies:</strong> <span class="badge bg-success">Available</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="alert alert-info">
                            <i class="bx bx-info-circle me-2"></i>
                            <strong>All systems ready!</strong> The ML prediction functionality should work correctly.
                        </div>
                    `;
                    
                    showModal('Python Installation Test Results', modalContent);
                    showAlert('Python installation test passed successfully!', 'success');
                } else {
                    const modalContent = `
                        <div class="alert alert-danger">
                            <i class="bx bx-x-circle me-2"></i>
                            <strong>Python Installation Test Failed!</strong>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-danger">Error Details</h6>
                            <p class="text-muted">${response.error}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-warning">Python Path Attempted</h6>
                            <code>${response.python_path || 'Unknown'}</code>
                        </div>
                        <div class="alert alert-warning">
                            <i class="bx bx-warning me-2"></i>
                            <strong>Troubleshooting Tips:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Ensure Python 3.x is installed on the system</li>
                                <li>Add Python to the system PATH environment variable</li>
                                <li>Restart the web server after installing Python</li>
                                <li>Check if the web server has permission to execute Python</li>
                                <li>Consider using a virtual environment with proper paths</li>
                            </ul>
                        </div>
                    `;
                    
                    showModal('Python Installation Test Results', modalContent);
                    showAlert('Python installation test failed: ' + response.error, 'danger');
                }
            },
            error: function(xhr) {
                const errorMsg = xhr.responseJSON?.message || 'An error occurred while testing Python installation';
                showAlert('Error: ' + errorMsg, 'danger');
                
                const modalContent = `
                    <div class="alert alert-danger">
                        <i class="bx bx-x-circle me-2"></i>
                        <strong>Connection Error!</strong>
                    </div>
                    <p>Could not connect to the Python test endpoint. This may indicate:</p>
                    <ul>
                        <li>Server configuration issues</li>
                        <li>Route not properly configured</li>
                        <li>Web server permissions</li>
                    </ul>
                    <p class="text-muted">${errorMsg}</p>
                `;
                
                showModal('Python Test Error', modalContent);
            },
            complete: function() {
                $btn.html(originalText).prop('disabled', false);
            }
        });
    }

    function loadProductCompatibility() {
        $.ajax({
            url: '{{ route("admin.chatbot.ml.product-compatibility") }}',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    displayProductCompatibility(response.products);
                    $('#motor-count').text(response.count);
                } else {
                    showAlert('Failed to load product compatibility: ' + response.message, 'danger');
                }
            },
            error: function(xhr) {
                const errorMsg = xhr.responseJSON?.message || 'Failed to load product compatibility';
                showAlert('Error: ' + errorMsg, 'danger');
            }
        });
    }

    function displayProductCompatibility(products) {
        const tbody = $('#motors-table-body');
        let html = '';

        if (products.length === 0) {
            html = `
                <tr>
                    <td colspan="6" class="text-center py-4">
                        <i class="bx bx-package display-4 text-muted"></i>
                        <p class="text-muted mt-2">No products with motor compatibility found</p>
                    </td>
                </tr>
            `;
        } else {
            products.forEach((product, index) => {
                const availabilityBadge = product.is_available ? 
                    '<span class="badge bg-success">Available</span>' : 
                    '<span class="badge bg-danger">Unavailable</span>';
                
                const stockDisplay = product.stock > 0 ? 
                    `<span class="text-success">${product.stock}</span>` : 
                    '<span class="text-danger">0</span>';

                html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td><strong>${product.name}</strong></td>
                        <td>
                            <span class="badge bg-info">${product.motor_type}</span>
                        </td>
                        <td>
                            <span class="badge bg-secondary">${product.category}</span>
                        </td>
                        <td>${stockDisplay}</td>
                        <td>${availabilityBadge}</td>
                    </tr>
                `;
            });
        }

        tbody.html(html);
    }

    function loadResponseDictionary() {
        $.ajax({
            url: '{{ route("admin.chatbot.ml.response-dict") }}',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    displayResponseDictionary(response.response_dict);
                    $('#response-count').text(response.count);
                } else {
                    showAlert('Failed to load response dictionary: ' + response.message, 'danger');
                }
            },
            error: function(xhr) {
                const errorMsg = xhr.responseJSON?.message || 'Failed to load response dictionary';
                showAlert('Error: ' + errorMsg, 'danger');
            }
        });
    }

    function displayResponseDictionary(responseDict) {
        const tbody = $('#responses-table-body');
        let html = '';

        const entries = Object.entries(responseDict);
        if (entries.length === 0) {
            html = `
                <tr>
                    <td colspan="6" class="text-center py-4">
                        <i class="bx bx-message-dots display-4 text-muted"></i>
                        <p class="text-muted mt-2">No response templates found</p>
                    </td>
                </tr>
            `;
        } else {
            entries.forEach(([keyword, response], index) => {
                const category = detectCategory(keyword);
                const preview = response.length > 100 ? response.substring(0, 100) + '...' : response;
                const displayKeyword = formatKeyword(keyword);
                
                html += `
                    <tr data-keyword="${keyword.toLowerCase()}" data-category="${category}">
                        <td>${index + 1}</td>
                        <td><strong>${displayKeyword}</strong></td>
                        <td class="response-preview" title="${response}">${preview}</td>
                        <td><span class="badge bg-info">${category}</span></td>
                        <td><span class="text-muted">-</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary view-response-btn me-1" 
                                    data-keyword="${keyword}" data-response="${response}">
                                <i class="bx bx-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-success edit-response-btn" 
                                    data-keyword="${keyword}" data-response="${response}">
                                <i class="bx bx-edit"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
        }

        tbody.html(html);

        // Handle view response button
        $('.view-response-btn').on('click', function() {
            const keyword = $(this).data('keyword');
            const response = $(this).data('response');
            showResponseDetail(keyword, response);
        });

        // Handle edit response button
        $('.edit-response-btn').on('click', function() {
            const keyword = $(this).data('keyword');
            const response = $(this).data('response');
            showEditResponseModal(keyword, response);
        });
    }

    function formatKeyword(keyword) {
        // Remove underscores and capitalize each word
        return keyword.replace(/_/g, ' ')
                     .split(' ')
                     .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
                     .join(' ');
    }

    function detectCategory(keyword) {
        keyword = keyword.toLowerCase();
        if (keyword.includes('harga') || keyword.includes('price')) return 'harga';
        if (keyword.includes('stok') || keyword.includes('stock')) return 'stok';
        if (keyword.includes('kategori') || keyword.includes('category')) return 'kategori';
        return 'general';
    }

    function filterResponses() {
        const searchTerm = $('#response-search').val().toLowerCase();
        const categoryFilter = $('#response-category-filter').val();

        $('#responses-table-body tr').each(function() {
            const $row = $(this);
            const keyword = $row.data('keyword') || '';
            const category = $row.data('category') || '';
            const responseText = $row.find('.response-preview').text().toLowerCase();

            const matchesSearch = !searchTerm || 
                                keyword.includes(searchTerm) || 
                                responseText.includes(searchTerm);
            const matchesCategory = !categoryFilter || category === categoryFilter;

            if (matchesSearch && matchesCategory) {
                $row.show();
            } else {
                $row.hide();
            }
        });
    }

    function showResponseDetail(keyword, response) {
        const displayKeyword = formatKeyword(keyword);
        const content = `
            <div class="row">
                <div class="col-12">
                    <h6 class="text-primary">Keyword</h6>
                    <p><strong>${displayKeyword}</strong> <small class="text-muted">(${keyword})</small></p>
                    
                    <h6 class="text-primary">Full Response</h6>
                    <div class="bg-light p-3 rounded border" style="white-space: pre-wrap;">${response}</div>
                    
                    <h6 class="text-primary mt-3">Category</h6>
                    <span class="badge bg-info">${detectCategory(keyword)}</span>
                    
                    <h6 class="text-primary mt-3">Response Length</h6>
                    <p>${response.length} characters</p>
                </div>
            </div>
        `;

        $('#response-detail-content').html(content);
        $('#edit-response-btn').data('keyword', keyword).data('response', response);
        $('#responseDetailModal').modal('show');
    }

    function showEditResponseModal(keyword, response) {
        const displayKeyword = formatKeyword(keyword);
        
        // Populate the form
        $('#edit-keyword').val(displayKeyword);
        $('#edit-response-text').val(response);
        $('#edit-category').val(keyword.includes('_') ? 'sub_intent' : 'main_intent');
        $('#edit-is-active').prop('checked', true);
        $('#edit-usage-count').val(0); // Default value since we don't have usage data here
        
        // Update character count
        updateCharCount();
        
        // Store original keyword for form submission
        $('#editResponseForm').data('original-keyword', keyword);
        
        $('#editResponseModal').modal('show');
    }

    function updateCharCount() {
        const text = $('#edit-response-text').val();
        $('#char-count').text(text.length);
    }

    function showAlert(message, type = 'info') {
        const alertClass = type === 'danger' ? 'alert-danger' : 
                          type === 'warning' ? 'alert-warning' : 
                          type === 'success' ? 'alert-success' : 'alert-info';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

        // Insert alert at the top of the page content
        $('.page-content .container-fluid').prepend(alertHtml);

        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            $('.alert').fadeOut();
        }, 5000);
    }

    function showModal(title, content) {
        const modalHtml = `
            <div class="modal fade" id="dynamicModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">${title}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">${content}</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Remove existing dynamic modal
        $('#dynamicModal').remove();
        
        // Add new modal and show
        $('body').append(modalHtml);
        $('#dynamicModal').modal('show');

        // Clean up when modal is hidden
        $('#dynamicModal').on('hidden.bs.modal', function() {
            $(this).remove();
        });
    }
});
</script>
@endpush 