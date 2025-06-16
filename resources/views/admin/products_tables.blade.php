@extends('layouts.admin')

@include('admin.partials.navbar')  

@section("title", "Products Management")

@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                <li class="breadcrumb-item active">Products</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>      
            <!-- end page title -->
                 
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="card-header">
                                    <h4 class="card-title">Products Management</h4>
                                    <p class="card-title-desc mb-0">Manage your product catalog with options and availability</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                                    <div>
                                        <button type="button" class="btn btn-primary waves-effect" data-bs-toggle="modal"
                                    data-bs-target=".modal-add">
                                            <i class="mdi mdi-plus me-1"></i>Add Product
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body">                                    
                            <!-- Modal for adding product -->
                            <div class="modal fade modal-add" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <form>
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addProductModalLabel">
                                                    <i class="mdi mdi-plus-circle me-2"></i>Add New Product
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">                                    
                                                <div class="row">
                                                    <!-- Basic Information -->
                                                    <div class="col-lg-6">
                                                        <div class="card border">
                                                            <div class="card-header bg-light">
                                                                <h6 class="card-title mb-0">
                                                                    <i class="mdi mdi-information-outline me-1"></i>Basic Information
                                                                </h6>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="mb-3">
                                                                    <label for="product-name" class="form-label">Product Name <span class="text-danger">*</span></label>
                                                                    <input class="form-control" type="text" id="product-name" placeholder="Enter product name" required>
                                                                </div>
                                                                
                                                                <div class="mb-3">
                                                                    <label for="product-category" class="form-label">Category <span class="text-danger">*</span></label>
                                                                    <select class="form-control form-select" id="product-category" required>
                                                                        <option value="">Choose Category</option>
                                                                        <option value="Mounting & Body">Mounting & Body</option>
                                                                        <option value="Lampu">Lampu</option>
                                                                        <option value="Accessories">Accessories</option>
                                                                        <option value="Services">Services</option>
                                                                    </select>
                                                                </div>
                                                                
                                                                <div class="mb-3">
                                                                    <label for="product-description" class="form-label">Description</label>
                                                                    <textarea class="form-control" id="product-description" rows="3" placeholder="Enter product description"></textarea>
                                                                </div>
                                                                
                                                                <div class="mb-3">
                                                                    <label for="product-image" class="form-label">Product Image</label>
                                                                    <input class="form-control" type="file" id="product-image" accept="image/*">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Inventory & Stats -->
                                                    <div class="col-lg-6">
                                                        <div class="card border">
                                                            <div class="card-header bg-light">
                                                                <h6 class="card-title mb-0">
                                                                    <i class="mdi mdi-chart-box-outline me-1"></i>Inventory & Statistics
                                                                </h6>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="product-stock" class="form-label">Stock Quantity</label>
                                                                            <input class="form-control" type="number" id="product-stock" min="0" value="0" placeholder="0">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="product-sold" class="form-label">Units Sold</label>
                                                                            <input class="form-control" type="number" id="product-sold" min="0" value="0" placeholder="0">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="product-ratings-count" class="form-label">Total Ratings</label>
                                                                            <input class="form-control" type="number" id="product-ratings-count" min="0" value="0" placeholder="0">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="product-avg-rating" class="form-label">Average Rating</label>
                                                                            <input class="form-control" type="number" id="product-avg-rating" min="0" max="5" step="0.1" value="0.0" placeholder="0.0">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="mb-3">
                                                                    <div class="form-check form-switch form-switch-lg">
                                                                        <input class="form-check-input" type="checkbox" id="product-active" checked>
                                                                        <label class="form-check-label" for="product-active">
                                                                            <span class="fw-medium">Product Active</span>
                                                                            <small class="text-muted d-block">Enable this product for public display</small>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                    <i class="mdi mdi-close me-1"></i>Cancel
                                                </button>
                                                <button type="button" class="btn btn-primary">
                                                    <i class="mdi mdi-content-save me-1"></i>Save Product
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Manage Options Modal -->
                            <div class="modal fade" id="manageOptionsModal" tabindex="-1" role="dialog" aria-labelledby="manageOptionsModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="manageOptionsModalLabel">
                                                <i class="mdi mdi-tune me-2"></i>Manage Product Options
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="optionsFormContainer">
                                                <!-- Options will be dynamically loaded here -->
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                <i class="mdi mdi-close me-1"></i>Cancel
                                            </button>
                                            <button type="button" class="btn btn-success" id="saveOptionsBtn">
                                                <i class="mdi mdi-content-save me-1"></i>Save All Options
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Add New Option Modal -->
                            <div class="modal fade" id="addOptionModal" tabindex="-1" role="dialog" aria-labelledby="addOptionModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form id="addOptionForm">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addOptionModalLabel">
                                                    <i class="mdi mdi-plus-circle me-2"></i>Add New Option
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Option Settings -->
                                                <div class="card mb-3">
                                                    <div class="card-header bg-light">
                                                        <h6 class="card-title mb-0">
                                                            <i class="mdi mdi-cog me-2"></i>Option Settings
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <div class="mb-3">
                                                                    <label for="add-option-name" class="form-label">Option Name <span class="text-danger">*</span></label>
                                                                    <input class="form-control" type="text" id="add-option-name" placeholder="e.g., size, color" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Required</label>
                                                                    <div class="form-check form-switch mt-2">
                                                                        <input class="form-check-input" type="checkbox" id="add-option-required">
                                                                        <label class="form-check-label" for="add-option-required">
                                                                            Required Option
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Option Values -->
                                                <div class="card">
                                                    <div class="card-header bg-light">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="card-title mb-0">
                                                                <i class="mdi mdi-format-list-bulleted me-2"></i>Option Values
                                                            </h6>
                                                            <button type="button" class="btn btn-outline-secondary btn-sm" id="addValueBtn">
                                                                <i class="mdi mdi-plus me-1"></i>Add Value
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <!-- Column headers -->
                                                        <div class="row mb-2">
                                                            <div class="col-md-4"><small class="text-muted fw-bold">Display Name</small></div>
                                                            <div class="col-md-3"><small class="text-muted fw-bold">Price Adjustment</small></div>
                                                            <div class="col-md-2"><small class="text-muted fw-bold">Availability</small></div>
                                                            <div class="col-md-2"><small class="text-muted fw-bold">Default</small></div>
                                                            <div class="col-md-1"><small class="text-muted fw-bold">Action</small></div>
                                                        </div>

                                                        <!-- Values container -->
                                                        <div id="addOptionValues">
                                                            <div class="text-center py-3 text-muted empty-state">
                                                                <i class="mdi mdi-format-list-bulleted display-6"></i>
                                                                <p class="mb-0">No values added yet. Click "Add Value" to get started.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                    <i class="mdi mdi-close me-1"></i>Cancel
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="mdi mdi-content-save me-1"></i>Create Option
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <h2 class="mb-4">
                                <i class="mdi mdi-package-variant me-2"></i>All Products
                                <small class="text-muted">({{ isset($products) ? $products->count() : 0 }} items)</small>
                            </h2>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover w-100">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Product</th>
                                            <th>Category</th>
                                            <th>Options</th>
                                            <th>Stock</th>
                                            <th>Sold</th>
                                            <th>Ratings</th>
                                            <th>Avg Rating</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($products))
                                            @foreach ($products as $product)
                                                <tr>
                                                    <td>
                                                        <span class="badge badge-soft-secondary">{{ $product->id }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 me-3">
                                                                @if($product->image)
                                                                    <img src="{{ asset('' . $product->image) }}" alt="{{ $product->name }}" class="rounded" width="40" height="40" style="object-fit: cover;">
                                                                @else
                                                                    <div class="avatar-md bg-light rounded d-flex align-items-center justify-content-center">
                                                                        <i class="mdi mdi-image text-muted"></i>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-1">{{ $product->name }}</h6>
                                                                @if($product->description)
                                                                    <p class="text-muted mb-0 small">{{ Str::limit($product->description, 50) }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-soft-info">{{ $product->category }}</span>
                                                    </td>
                                                    <td>
                                                        @if($product->productOptions->count() > 0)
                                                            <button class="btn btn-outline-primary btn-sm expand-options" 
                                                                    data-product-id="{{ $product->id }}" 
                                                                    title="Click to view options">
                                                                <i class="mdi mdi-chevron-right me-1"></i>
                                                                {{ $product->productOptions->count() }} option{{ $product->productOptions->count() > 1 ? 's' : '' }}
                                                            </button>
                                                        @else
                                                            <span class="text-muted small">No options</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="fw-medium">{{ number_format($product->stock) }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-medium">{{ number_format($product->sold) }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-medium">{{ number_format($product->ratings) }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="fw-medium me-1">{{ $product->average_rating }}</span>
                                                            <div class="text-warning">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    @if($i <= floor($product->average_rating))
                                                                        <i class="mdi mdi-star"></i>
                                                                    @elseif($i == ceil($product->average_rating) && $product->average_rating - floor($product->average_rating) >= 0.5)
                                                                        <i class="mdi mdi-star-half-full"></i>
                                                                    @else
                                                                        <i class="mdi mdi-star-outline"></i>
                                                                    @endif
                                                                @endfor
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($product->is_active)
                                                            <span class="badge badge-soft-success">Active</span>
                                                        @else
                                                            <span class="badge badge-soft-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-light btn-sm waves-effect" data-bs-toggle="modal"
                                                            data-bs-target=".modal-{{ $product->id }}" title="Edit Product">
                                                                <i class="mdi mdi-pencil"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-light btn-sm waves-effect text-danger" title="Delete Product">
                                                                <i class="mdi mdi-delete"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                
                                            
                                        
                                                <!-- Edit Modal for each product -->
                                                <div class="modal fade modal-{{ $product->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <form>
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">
                                                                        <i class="mdi mdi-pencil-circle me-2"></i>Edit Product: {{ $product->name }}
                                                                    </h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <div class="card border">
                                                                                <div class="card-header bg-light">
                                                                                    <h6 class="card-title mb-0">Basic Information</h6>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Product Name</label>
                                                                                        <input class="form-control" type="text" value="{{ $product->name }}">
                                                                                    </div>
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Category</label>
                                                                                        <input class="form-control" type="text" value="{{ $product->category }}">
                                                                                    </div>
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Description</label>
                                                                                        <textarea class="form-control" rows="3">{{ $product->description }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="card border">
                                                                                <div class="card-header bg-light">
                                                                                    <h6 class="card-title mb-0">Statistics</h6>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <div class="row">
                                                                                        <div class="col-md-6">
                                                                                            <div class="mb-3">
                                                                                                <label class="form-label">Stock</label>
                                                                                                <input class="form-control" type="number" value="{{ $product->stock }}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <div class="mb-3">
                                                                                                <label class="form-label">Sold</label>
                                                                                                <input class="form-control" type="number" value="{{ $product->sold }}">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6">
                                                                                            <div class="mb-3">
                                                                                                <label class="form-label">Ratings</label>
                                                                                                <input class="form-control" type="number" value="{{ $product->ratings }}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <div class="mb-3">
                                                                                                <label class="form-label">Avg Rating</label>
                                                                                                <input class="form-control" type="number" step="0.1" value="{{ $product->average_rating }}">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-check form-switch">
                                                                                        <input class="form-check-input" type="checkbox" {{ $product->is_active ? 'checked' : '' }}>
                                                                                        <label class="form-check-label">Active Status</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="button" class="btn btn-primary">Update Product</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>


                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="10" class="text-center">No products available</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>                            
                        </div>
                    </div>
                    <!-- end card -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    @include('admin.partials.footer')
    
</div>

@endsection

@push("styles")
<style>
.badge-soft-primary { background-color: rgba(116, 120, 141, 0.1); color: #74788d; }
.badge-soft-success { background-color: rgba(52, 168, 83, 0.1); color: #34a853; }
.badge-soft-danger { background-color: rgba(234, 67, 53, 0.1); color: #ea4335; }
.badge-soft-warning { background-color: rgba(251, 188, 52, 0.1); color: #fbbc34; }
.badge-soft-info { background-color: rgba(52, 168, 226, 0.1); color: #34a8e2; }
.badge-soft-secondary { background-color: rgba(116, 120, 141, 0.1); color: #74788d; }

.card-title-desc { 
    font-size: 0.875rem; 
    color: #6c757d; 
}

/* Table styling for better appearance */
.table th {
    background-color: #f8f9fa;
    border-top: 1px solid #dee2e6;
    vertical-align: middle;
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.02);
}

.options-row {
    background-color: #f8f9fa;
}

.options-row td {
    border-top: none !important;
}

.expand-options {
    transition: all 0.2s ease;
}

.expand-options:hover {
    transform: translateY(-1px);
}

/* Options Management Modal Styling */
#manageOptionsModal .modal-dialog {
    max-width: 1200px;
}

.value-row {
    background-color: #f8f9fa;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #e9ecef;
}

.value-row:hover {
    background-color: #e9ecef;
}

.option-values .value-row + .value-row {
    margin-top: 10px;
}

#optionsAccordion .card-header {
    background-color: #f1f3f4;
}

#optionsAccordion .btn-link {
    color: #495057;
    text-decoration: none;
}

#optionsAccordion .btn-link:hover {
    color: #007bff;
}

.value-row input[type="text"], 
.value-row input[type="number"], 
.value-row select {
    font-size: 0.875rem;
}

.value-row .form-check {
    padding-top: 8px;
}

.value-row .btn-outline-danger {
    border-color: #dc3545;
    color: #dc3545;
}

/* Wizard Styling */
.wizard-progress {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.step-indicator {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

.step {
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    white-space: nowrap;
}

.step-active {
    background-color: #007bff;
    color: white;
}

.step-completed {
    background-color: #28a745;
    color: white;
}

.step-pending {
    background-color: #e9ecef;
    color: #6c757d;
}

.step-divider {
    color: #6c757d;
    font-size: 0.75rem;
}

.wizard-content {
    min-height: 400px;
}

.wizard-navigation {
    background-color: #f8f9fa;
    margin: 0 -20px -20px -20px;
    padding: 15px 20px;
    border-radius: 0 0 8px 8px;
}

#manageOptionsModal .modal-body {
    padding: 20px;
}

@media (max-width: 768px) {
    .step-indicator {
        flex-direction: column;
        align-items: stretch;
    }
    
    .step {
        text-align: center;
        margin-bottom: 5px;
    }
    
    .step-divider {
        display: none;
    }
}
</style>
@endpush

@push("scripts")
<script src="{{ asset('admin/js/app.js') }}"></script>

<script>
$(document).ready(function() {
    console.log('Document ready, initializing normal table...');
    
    // Store the product options data from server
    var productOptionsData = {
        @if(isset($products))
            @foreach($products as $product)
                {{ $product->id }}: {
                    name: "{{ addslashes($product->name) }}",
                    optionsCount: {{ $product->productOptions->count() }},
                    options: [
                        @foreach($product->productOptions as $option)
                        {
                            name: "{{ addslashes($option->name) }}",
                            display_name: "{{ addslashes($option->display_name) }}",
                            is_required: {{ $option->is_required ? 'true' : 'false' }},
                            values: [
                                @foreach($option->productOptionValues as $value)
                                {
                                    value: "{{ addslashes($value->value) }}",
                                    display_value: "{{ addslashes($value->display_value) }}",
                                    price_adjustment: {{ $value->price_adjustment }},
                                    formatted_price: "{{ $value->getFormattedPriceAdjustmentAttribute() }}",
                                    is_available: {{ $value->is_available ? 'true' : 'false' }},
                                    is_default: {{ $value->is_default ? 'true' : 'false' }},
                                    sort_order: {{ $value->sort_order }}
                                }{{ !$loop->last ? ',' : '' }}
                                @endforeach
                            ]
                        }{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    ]
                }{{ !$loop->last ? ',' : '' }}
            @endforeach
        @endif
    };

    // Function to generate options detail HTML
    function generateOptionsHTML(productId, productName) {
        console.log('Generating options HTML for product:', productId);
        
        var productData = productOptionsData[productId];
        var optionsHtml = '<div class="bg-light p-3">';
        optionsHtml += '<h6 class="mb-3"><i class="mdi mdi-tune me-2"></i>Product Options for "' + productName + '"';
        
        if (productData && productData.optionsCount > 0) {
            optionsHtml += '<span class="badge badge-soft-info ms-2">' + productData.optionsCount + ' options</span>';
        }
        optionsHtml += '</h6>';
        
        if (!productData || productData.optionsCount === 0) {
            optionsHtml += '<div class="text-center py-3">';
            optionsHtml += '<i class="mdi mdi-package-variant-closed display-6 text-muted"></i>';
            optionsHtml += '<p class="text-muted mb-0">No options configured for this product.</p>';
            optionsHtml += '<button class="btn btn-primary btn-sm mt-3"><i class="mdi mdi-plus me-1"></i>Add First Option</button>';
            optionsHtml += '</div>';
        } else {
            optionsHtml += '<div class="row">';
            
            productData.options.forEach(function(option, optionIndex) {
                optionsHtml += '<div class="col-md-6 mb-3">';
                optionsHtml += '<div class="card border">';
                optionsHtml += '<div class="card-header bg-white border-bottom">';
                optionsHtml += '<div class="d-flex justify-content-between align-items-center">';
                optionsHtml += '<h6 class="mb-0"><i class="mdi mdi-tag-outline me-1"></i>' + option.display_name + '</h6>';
                optionsHtml += '<div>';
                if (option.is_required) {
                    optionsHtml += '<span class="badge badge-soft-danger">Required</span>';
                } else {
                    optionsHtml += '<span class="badge badge-soft-secondary">Optional</span>';
                }
                optionsHtml += '<span class="badge badge-soft-primary ms-1">' + option.values.length + ' values</span>';
                optionsHtml += '</div></div></div>';
                
                optionsHtml += '<div class="card-body p-2">';
                optionsHtml += '<div class="table-responsive">';
                optionsHtml += '<table class="table table-sm table-borderless mb-0">';
                optionsHtml += '<thead><tr class="text-muted" style="font-size: 0.75rem;">';
                optionsHtml += '<th>Display Name</th><th>Price</th><th>Status</th>';
                optionsHtml += '</tr></thead><tbody>';
                
                option.values.forEach(function(value) {
                    optionsHtml += '<tr style="font-size: 0.8rem;">';
                    
                    // Display column
                    optionsHtml += '<td>';
                    optionsHtml += '<strong class="small">' + value.display_value + '</strong>';
                    if (value.is_default) {
                        optionsHtml += '<span class="badge badge-soft-success ms-1" style="font-size: 0.65rem;">Default</span>';
                    }
                    optionsHtml += '</td>';
                    
                    // Price column
                    optionsHtml += '<td>';
                    if (value.price_adjustment != 0) {
                        var priceClass = value.price_adjustment > 0 ? 'text-success' : 'text-danger';
                        optionsHtml += '<span class="fw-medium small ' + priceClass + '">' + value.formatted_price + '</span>';
                    } else {
                        optionsHtml += '<span class="text-muted small">No change</span>';
                    }
                    optionsHtml += '</td>';
                    
                    // Status column
                    optionsHtml += '<td>';
                    if (value.is_available) {
                        optionsHtml += '<span class="badge badge-soft-success" style="font-size: 0.65rem;"><i class="mdi mdi-check"></i> Available</span>';
                    } else {
                        optionsHtml += '<span class="badge badge-soft-danger" style="font-size: 0.65rem;"><i class="mdi mdi-close"></i> Unavailable</span>';
                    }
                    optionsHtml += '</td>';
                    
                    optionsHtml += '</tr>';
                });
                
                optionsHtml += '</tbody></table></div></div></div></div>';
            });
            
            optionsHtml += '</div>';
            
            // Action buttons
            optionsHtml += '<div class="d-flex gap-2 mt-3">';
            optionsHtml += '<button class="btn btn-primary btn-sm manage-options-btn" data-product-id="' + productId + '" data-bs-toggle="modal" data-bs-target="#manageOptionsModal"><i class="mdi mdi-pencil me-1"></i>Manage Options</button>';
            optionsHtml += '<button class="btn btn-outline-secondary btn-sm add-option-btn" data-product-id="' + productId + '"><i class="mdi mdi-plus me-1"></i>Add Option</button>';
            optionsHtml += '</div>';
        }
        
        optionsHtml += '</div>';
        return optionsHtml;
    }

    // Handle expand/collapse options using regular DOM manipulation
    $(document).on('click', '.expand-options', function(e) {
        e.preventDefault();
        console.log('Expand button clicked!');
        
        var button = $(this);
        var tr = button.closest('tr');
        var productId = button.data('product-id');
        var productName = tr.find('h6').first().text() || tr.find('.flex-grow-1 h6').text() || 'Unknown Product';
        var icon = button.find('i');
        var existingOptionsRow = tr.next('.options-row');

        console.log('Product ID:', productId);
        console.log('Product Name:', productName);

        if (existingOptionsRow.length && existingOptionsRow.is(':visible')) {
            // Collapse
            console.log('Collapsing row');
            existingOptionsRow.hide();
            tr.removeClass('shown');
            icon.removeClass('mdi-chevron-down').addClass('mdi-chevron-right');
            button.removeClass('btn-primary').addClass('btn-outline-primary');
        } else {
            // First hide any other open rows
            $('.options-row').hide();
            $('.expand-options').removeClass('btn-primary').addClass('btn-outline-primary');
            $('.expand-options i').removeClass('mdi-chevron-down').addClass('mdi-chevron-right');
            $('tr').removeClass('shown');
            
            // Expand this row
            console.log('Expanding row');
            var optionsHtml = generateOptionsHTML(productId, productName);
            
            if (existingOptionsRow.length) {
                existingOptionsRow.find('td').html(optionsHtml);
                existingOptionsRow.show();
            } else {
                var newRow = '<tr class="options-row"><td colspan="10" class="p-0">' + optionsHtml + '</td></tr>';
                tr.after(newRow);
            }
            
            tr.addClass('shown');
            icon.removeClass('mdi-chevron-right').addClass('mdi-chevron-down');
            button.removeClass('btn-outline-primary').addClass('btn-primary');
        }
    });
    
         console.log('Normal table initialized. Buttons found:', $('.expand-options').length);

    // Handle manage options button click
    $(document).on('click', '.manage-options-btn', function() {
        var productId = $(this).data('product-id');
        var productData = productOptionsData[productId];
        loadOptionsForm(productId, productData);
    });

    // Handle add option button click
    $(document).on('click', '.add-option-btn', function() {
        var productId = $(this).data('product-id');
        openAddOptionModal(productId);
    });

    // Open add option modal
    function openAddOptionModal(productId) {
        // Clear the form
        $('#addOptionForm')[0].reset();
        $('#addOptionValues').html('<div class="text-center py-3 text-muted empty-state"><i class="mdi mdi-format-list-bulleted display-6"></i><p class="mb-0">No values added yet. Click "Add Value" to get started.</p></div>');
        
        // Store product ID
        $('#addOptionModal').data('product-id', productId);
        
        // Show modal
        $('#addOptionModal').modal('show');
    }

    // Handle add value button in add option modal
    $('#addValueBtn').on('click', function() {
        addValueToNewOptionModal();
    });

    // Add value to new option modal
    function addValueToNewOptionModal() {
        var valueIndex = Date.now();
        var html = '<div class="row mb-2 value-row" data-value-index="' + valueIndex + '">';
        html += '<div class="col-md-4">';
        html += '<input type="text" class="form-control value-display" placeholder="Display name (e.g., Small, Red)" required>';
        html += '</div>';
        html += '<div class="col-md-3">';
        html += '<input type="number" class="form-control value-price" value="0" step="0.01" placeholder="Price adjustment">';
        html += '</div>';
        html += '<div class="col-md-2">';
        html += '<select class="form-control value-available">';
        html += '<option value="1">Available</option>';
        html += '<option value="0">Unavailable</option>';
        html += '</select>';
        html += '</div>';
        html += '<div class="col-md-2">';
        html += '<div class="form-check">';
        html += '<input class="form-check-input value-default" type="radio" name="default-add-option">';
        html += '<label class="form-check-label">Default</label>';
        html += '</div>';
        html += '</div>';
        html += '<div class="col-md-1">';
        html += '<button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteValue(this)" title="Delete Value">';
        html += '<i class="mdi mdi-delete"></i>';
        html += '</button>';
        html += '</div>';
        html += '</div>';
        
        var container = $('#addOptionValues');
        // Remove empty state if exists
        container.find('.empty-state').remove();
        container.append(html);
    }

    // Handle add option form submission
    $('#addOptionForm').on('submit', function(e) {
        e.preventDefault();
        
        var productId = $('#addOptionModal').data('product-id');
        var optionName = $('#add-option-name').val().trim();
        var displayName = $('#add-option-display-name').val().trim();
        var isRequired = $('#add-option-required').is(':checked');
        
        if (!optionName || !displayName) {
            alert('Please fill in both option name and display name.');
            return;
        }
        
        // Collect values
        var values = [];
        $('#addOptionValues .value-row').each(function() {
            var displayValue = $(this).find('.value-display').val().trim();
            if (displayValue) {
                values.push({
                    value: displayValue.toLowerCase().replace(/\s+/g, '_'), // Auto-generate internal value
                    display_value: displayValue,
                    price_adjustment: parseFloat($(this).find('.value-price').val()) || 0,
                    is_available: $(this).find('.value-available').val() === '1',
                    is_default: $(this).find('.value-default').is(':checked'),
                    sort_order: 0
                });
            }
        });
        
        if (values.length === 0) {
            alert('Please add at least one option value.');
            return;
        }
        
        // Create new option
        var newOption = {
            name: optionName,
            display_name: displayName,
            is_required: isRequired,
            values: values
        };
        
        // Add to product options data
        if (!productOptionsData[productId]) {
            productOptionsData[productId] = {
                name: 'Product ' + productId,
                optionsCount: 0,
                options: []
            };
        }
        
        productOptionsData[productId].options.push(newOption);
        productOptionsData[productId].optionsCount++;
        
        console.log('Added new option:', newOption);
        alert('Option added successfully! (This is a demo - implement server-side saving)');
        
        // Close modal
        $('#addOptionModal').modal('hide');
        
        // Refresh the expanded options view if it's open
        var openOptionsRow = $('.options-row:visible');
        if (openOptionsRow.length > 0) {
            var expandButton = $('.expand-options.btn-primary');
            if (expandButton.length > 0) {
                // Re-trigger the expand to refresh the view
                expandButton.click();
                expandButton.click();
            }
        }
    });

    // Load options form as wizard
    function loadOptionsForm(productId, productData) {
        var container = $('#optionsFormContainer');
        
        // Initialize wizard data
        window.optionsWizard = {
            productId: productId,
            currentStep: 0,
            totalSteps: 0,
            options: productData ? productData.options || [] : []
        };
        
        // Calculate total steps (each option + add new option page)
        window.optionsWizard.totalSteps = window.optionsWizard.options.length + 1;
        
        if (window.optionsWizard.totalSteps === 1) {
            // No options, show add page directly
            showWizardStep(0);
        } else {
            // Show first option
            showWizardStep(0);
        }
        
        // Store current product ID for saving
        $('#manageOptionsModal').data('product-id', productId);
    }

    // Show specific wizard step
    function showWizardStep(stepIndex) {
        var container = $('#optionsFormContainer');
        var wizard = window.optionsWizard;
        var formHtml = '';
        
        // Update current step
        wizard.currentStep = stepIndex;
        
        // Create wizard progress indicator
        formHtml += '<div class="wizard-progress mb-4">';
        formHtml += '<div class="d-flex justify-content-between align-items-center">';
        formHtml += '<div class="step-indicator">';
        
        for (var i = 0; i < wizard.totalSteps; i++) {
            var isActive = i === stepIndex;
            var isCompleted = i < stepIndex;
            var stepClass = isActive ? 'step-active' : (isCompleted ? 'step-completed' : 'step-pending');
            
            if (i < wizard.options.length) {
                var optionName = wizard.options[i].display_name || 'Option ' + (i + 1);
                formHtml += '<span class="step ' + stepClass + '">' + (i + 1) + '. ' + optionName + '</span>';
            } else {
                formHtml += '<span class="step ' + stepClass + '">' + (i + 1) + '. Add New</span>';
            }
            
            if (i < wizard.totalSteps - 1) {
                formHtml += '<i class="mdi mdi-chevron-right step-divider"></i>';
            }
        }
        
        formHtml += '</div>';
        formHtml += '<div class="step-counter"><small class="text-muted">Step ' + (stepIndex + 1) + ' of ' + wizard.totalSteps + '</small></div>';
        formHtml += '</div>';
        formHtml += '</div>';
        
        // Create wizard content
        if (stepIndex < wizard.options.length) {
            // Edit existing option
            formHtml += createOptionEditForm(wizard.options[stepIndex], stepIndex);
        } else {
            // Add new option form
            formHtml += createAddOptionForm();
        }
        
        // Create wizard navigation
        formHtml += '<div class="wizard-navigation mt-4 pt-3 border-top">';
        formHtml += '<div class="d-flex justify-content-between">';
        
        // Previous button
        if (stepIndex > 0) {
            formHtml += '<button type="button" class="btn btn-outline-secondary" onclick="navigateWizard(' + (stepIndex - 1) + ')">';
            formHtml += '<i class="mdi mdi-chevron-left me-1"></i>Previous';
            formHtml += '</button>';
        } else {
            formHtml += '<div></div>'; // Spacer
        }
        
        // Next/Finish button
        if (stepIndex < wizard.totalSteps - 1) {
            formHtml += '<button type="button" class="btn btn-primary" onclick="navigateWizard(' + (stepIndex + 1) + ')">';
            formHtml += 'Next<i class="mdi mdi-chevron-right ms-1"></i>';
            formHtml += '</button>';
        } else {
            formHtml += '<button type="button" class="btn btn-success" onclick="finishWizard()">';
            formHtml += '<i class="mdi mdi-check me-1"></i>Finish';
            formHtml += '</button>';
        }
        
        formHtml += '</div>';
        formHtml += '</div>';
        
        container.html(formHtml);
    }

    // Create option edit form
    function createOptionEditForm(option, optionIndex) {
        var formHtml = '<div class="wizard-content">';
        formHtml += '<div class="text-center mb-4">';
        formHtml += '<h5><i class="mdi mdi-tag-outline me-2"></i>Edit Option: ' + (option.display_name || 'Unnamed Option') + '</h5>';
        formHtml += '<p class="text-muted">Configure this option and its values</p>';
        formHtml += '</div>';
        
        formHtml += '<div class="card">';
        formHtml += '<div class="card-header bg-light">';
        formHtml += '<h6 class="mb-0"><i class="mdi mdi-cog me-2"></i>Option Settings</h6>';
        formHtml += '</div>';
        formHtml += '<div class="card-body">';
        
        // Option details form
        formHtml += '<div class="row mb-3">';
        formHtml += '<div class="col-md-4">';
        formHtml += '<label class="form-label">Option Name <span class="text-danger">*</span></label>';
        formHtml += '<input type="text" class="form-control option-name" value="' + (option.name || '') + '" placeholder="e.g., size, color">';
        formHtml += '</div>';
        formHtml += '<div class="col-md-4">';
        formHtml += '<label class="form-label">Display Name <span class="text-danger">*</span></label>';
        formHtml += '<input type="text" class="form-control option-display-name" value="' + (option.display_name || '') + '" placeholder="e.g., Size, Color">';
        formHtml += '</div>';
        formHtml += '<div class="col-md-4">';
        formHtml += '<label class="form-label">Required</label>';
        formHtml += '<div class="form-check form-switch mt-2">';
        formHtml += '<input class="form-check-input option-required" type="checkbox" ' + (option.is_required ? 'checked' : '') + '>';
        formHtml += '<label class="form-check-label">Required Option</label>';
        formHtml += '</div>';
        formHtml += '</div>';
        formHtml += '</div>';
        
        formHtml += '</div>';
        formHtml += '</div>';
        
        // Option values
        formHtml += '<div class="card mt-3">';
        formHtml += '<div class="card-header bg-light">';
        formHtml += '<div class="d-flex justify-content-between align-items-center">';
        formHtml += '<h6 class="mb-0"><i class="mdi mdi-format-list-bulleted me-2"></i>Option Values</h6>';
        formHtml += '<button type="button" class="btn btn-outline-secondary btn-sm" onclick="addNewValueWizard(' + optionIndex + ')"><i class="mdi mdi-plus me-1"></i>Add Value</button>';
        formHtml += '</div>';
        formHtml += '</div>';
        formHtml += '<div class="card-body">';
        
        // Add column headers
        formHtml += '<div class="row mb-2">';
        formHtml += '<div class="col-md-4"><small class="text-muted fw-bold">Display Name</small></div>';
        formHtml += '<div class="col-md-3"><small class="text-muted fw-bold">Price Adjustment</small></div>';
        formHtml += '<div class="col-md-2"><small class="text-muted fw-bold">Availability</small></div>';
        formHtml += '<div class="col-md-2"><small class="text-muted fw-bold">Default</small></div>';
        formHtml += '<div class="col-md-1"><small class="text-muted fw-bold">Action</small></div>';
        formHtml += '</div>';
        
        formHtml += '<div class="option-values" data-option-index="' + optionIndex + '">';
        
        if (option.values && option.values.length > 0) {
            option.values.forEach(function(value, valueIndex) {
                formHtml += createValueFormRow(value, optionIndex, valueIndex);
            });
        } else {
            formHtml += '<div class="text-center py-3 text-muted">';
            formHtml += '<i class="mdi mdi-format-list-bulleted display-6"></i>';
            formHtml += '<p class="mb-0">No values added yet. Click "Add Value" to get started.</p>';
            formHtml += '</div>';
        }
        
        formHtml += '</div>';
        formHtml += '</div>';
        formHtml += '</div>';
        
        // Delete option button
        formHtml += '<div class="text-center mt-3">';
        formHtml += '<button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteOptionWizard(' + optionIndex + ')">';
        formHtml += '<i class="mdi mdi-delete me-1"></i>Delete This Option';
        formHtml += '</button>';
        formHtml += '</div>';
        
        formHtml += '</div>';
        return formHtml;
    }

    // Create add option form
    function createAddOptionForm() {
        var formHtml = '<div class="wizard-content">';
        formHtml += '<div class="text-center mb-4">';
        formHtml += '<h5><i class="mdi mdi-plus-circle me-2"></i>Add New Option</h5>';
        formHtml += '<p class="text-muted">Create a new option with its values</p>';
        formHtml += '</div>';
        
        // Option Settings
        formHtml += '<div class="card mb-3">';
        formHtml += '<div class="card-header bg-light">';
        formHtml += '<h6 class="card-title mb-0">';
        formHtml += '<i class="mdi mdi-cog me-2"></i>Option Settings';
        formHtml += '</h6>';
        formHtml += '</div>';
        formHtml += '<div class="card-body">';
        formHtml += '<div class="row">';
        formHtml += '<div class="col-md-8">';
        formHtml += '<div class="mb-3">';
        formHtml += '<label class="form-label">Option Name <span class="text-danger">*</span></label>';
        formHtml += '<input class="form-control wizard-option-name" type="text" placeholder="e.g., Size, Color, Material" required>';
        formHtml += '</div>';
        formHtml += '</div>';
        formHtml += '<div class="col-md-4">';
        formHtml += '<div class="mb-3">';
        formHtml += '<label class="form-label">Required</label>';
        formHtml += '<div class="form-check form-switch mt-2">';
        formHtml += '<input class="form-check-input wizard-option-required" type="checkbox">';
        formHtml += '<label class="form-check-label">';
        formHtml += 'Required Option';
        formHtml += '</label>';
        formHtml += '</div>';
        formHtml += '</div>';
        formHtml += '</div>';
        formHtml += '</div>';
        formHtml += '</div>';
        formHtml += '</div>';
        
        // Option Values
        formHtml += '<div class="card">';
        formHtml += '<div class="card-header bg-light">';
        formHtml += '<div class="d-flex justify-content-between align-items-center">';
        formHtml += '<h6 class="card-title mb-0">';
        formHtml += '<i class="mdi mdi-format-list-bulleted me-2"></i>Option Values';
        formHtml += '</h6>';
        formHtml += '<button type="button" class="btn btn-outline-secondary btn-sm" onclick="addNewValueToNewOption()">';
        formHtml += '<i class="mdi mdi-plus me-1"></i>Add Value';
        formHtml += '</button>';
        formHtml += '</div>';
        formHtml += '</div>';
        formHtml += '<div class="card-body">';
        
        // Column headers
        formHtml += '<div class="row mb-2">';
        formHtml += '<div class="col-md-4"><small class="text-muted fw-bold">Display Name</small></div>';
        formHtml += '<div class="col-md-3"><small class="text-muted fw-bold">Price Adjustment</small></div>';
        formHtml += '<div class="col-md-2"><small class="text-muted fw-bold">Availability</small></div>';
        formHtml += '<div class="col-md-2"><small class="text-muted fw-bold">Default</small></div>';
        formHtml += '<div class="col-md-1"><small class="text-muted fw-bold">Action</small></div>';
        formHtml += '</div>';
        
        // Values container
        formHtml += '<div class="new-option-values">';
        formHtml += '<div class="text-center py-3 text-muted empty-state">';
        formHtml += '<i class="mdi mdi-format-list-bulleted display-6"></i>';
        formHtml += '<p class="mb-0">No values added yet. Click "Add Value" to get started.</p>';
        formHtml += '</div>';
        formHtml += '</div>';
        
        formHtml += '</div>';
        formHtml += '</div>';
        
        formHtml += '</div>';
        return formHtml;
    }

    // Navigate wizard
    window.navigateWizard = function(stepIndex) {
        showWizardStep(stepIndex);
    };

    // Finish wizard
    window.finishWizard = function() {
        // Check if we're on the add new option page and have values
        var optionName = $('.wizard-option-name').val().trim();
        var isRequired = $('.wizard-option-required').is(':checked');
        
        var newOptionValues = [];
        $('.new-option-values .value-row').each(function() {
            var displayValue = $(this).find('.value-display').val().trim();
            if (displayValue) {
                newOptionValues.push({
                    value: displayValue.toLowerCase().replace(/\s+/g, '_'), // Auto-generate internal value
                    display_value: displayValue,
                    price_adjustment: parseFloat($(this).find('.value-price').val()) || 0,
                    is_available: $(this).find('.value-available').val() === '1',
                    is_default: $(this).find('.value-default').is(':checked'),
                    sort_order: 0
                });
            }
        });
        
        if (optionName && newOptionValues.length > 0) {
            // Create a new option with these values
            var newOption = {
                name: optionName.toLowerCase().replace(/\s+/g, '_'),
                display_name: optionName,
                is_required: isRequired,
                values: newOptionValues
            };
            
            window.optionsWizard.options.push(newOption);
            console.log('Added new option:', newOption);
        } else if (optionName && newOptionValues.length === 0) {
            alert('Please add at least one value for the new option.');
            return;
        } else if (!optionName && newOptionValues.length > 0) {
            alert('Please enter an option name.');
            return;
        }
        
        console.log('Wizard finished with', window.optionsWizard.options.length, 'options');
        alert('Options saved successfully! (This is a demo - implement server-side saving)');
        $('#manageOptionsModal').modal('hide');
    };

    // Add new value in wizard
    window.addNewValueWizard = function(optionIndex) {
        var newValue = {
            display_value: '',
            price_adjustment: 0,
            is_available: true,
            is_default: false,
            sort_order: 0
        };
        
        var html = createValueFormRow(newValue, optionIndex, Date.now());
        var container = $('.option-values[data-option-index="' + optionIndex + '"]');
        
        // Remove empty state if exists
        container.find('.text-center.py-3').remove();
        container.append(html);
    };

    // Delete option in wizard
    window.deleteOptionWizard = function(optionIndex) {
        if (confirm('Are you sure you want to delete this option and all its values?')) {
            window.optionsWizard.options.splice(optionIndex, 1);
            window.optionsWizard.totalSteps--;
            
            if (window.optionsWizard.currentStep >= window.optionsWizard.totalSteps) {
                window.optionsWizard.currentStep = window.optionsWizard.totalSteps - 1;
            }
            
            showWizardStep(window.optionsWizard.currentStep);
        }
    };

    // Add new value to new option page
    window.addNewValueToNewOption = function() {
        var valueIndex = Date.now();
        var html = '<div class="row mb-2 value-row" data-value-index="' + valueIndex + '">';
        html += '<div class="col-md-4">';
        html += '<input type="text" class="form-control value-display" placeholder="Display name (e.g., Small, Red)" required>';
        html += '</div>';
        html += '<div class="col-md-3">';
        html += '<input type="number" class="form-control value-price" value="0" step="0.01" placeholder="Price adjustment">';
        html += '</div>';
        html += '<div class="col-md-2">';
        html += '<select class="form-control value-available">';
        html += '<option value="1">Available</option>';
        html += '<option value="0">Unavailable</option>';
        html += '</select>';
        html += '</div>';
        html += '<div class="col-md-2">';
        html += '<div class="form-check">';
        html += '<input class="form-check-input value-default" type="radio" name="default-wizard-new-option">';
        html += '<label class="form-check-label">Default</label>';
        html += '</div>';
        html += '</div>';
        html += '<div class="col-md-1">';
        html += '<button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteValue(this)" title="Delete Value">';
        html += '<i class="mdi mdi-delete"></i>';
        html += '</button>';
        html += '</div>';
        html += '</div>';
        
        var container = $('.new-option-values');
        // Remove empty state if exists
        container.find('.empty-state').remove();
        container.append(html);
    };



    // Create value form row
    function createValueFormRow(value, optionIndex, valueIndex) {
        var html = '<div class="row mb-2 value-row" data-value-index="' + valueIndex + '">';
        html += '<div class="col-md-4">';
        html += '<input type="text" class="form-control value-display" value="' + value.display_value + '" placeholder="Display name (e.g., Small, Red)">';
        html += '</div>';
        html += '<div class="col-md-3">';
        html += '<input type="number" class="form-control value-price" value="' + value.price_adjustment + '" step="0.01" placeholder="Price adjustment">';
        html += '</div>';
        html += '<div class="col-md-2">';
        html += '<select class="form-control value-available">';
        html += '<option value="1" ' + (value.is_available ? 'selected' : '') + '>Available</option>';
        html += '<option value="0" ' + (!value.is_available ? 'selected' : '') + '>Unavailable</option>';
        html += '</select>';
        html += '</div>';
        html += '<div class="col-md-2">';
        html += '<div class="form-check">';
        html += '<input class="form-check-input value-default" type="radio" name="default-option-' + optionIndex + '" ' + (value.is_default ? 'checked' : '') + '>';
        html += '<label class="form-check-label">Default</label>';
        html += '</div>';
        html += '</div>';
        html += '<div class="col-md-1">';
        html += '<button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteValue(this)" title="Delete Value">';
        html += '<i class="mdi mdi-delete"></i>';
        html += '</button>';
        html += '</div>';
        html += '</div>';
        return html;
    }



    // Add new value
    window.addNewValue = function(optionIndex) {
        var newValue = {
            value: '',
            display_value: '',
            price_adjustment: 0,
            is_available: true,
            is_default: false,
            sort_order: 0
        };
        
        var html = createValueFormRow(newValue, optionIndex, Date.now());
        $('.option-values[data-option-index="' + optionIndex + '"]').append(html);
    };

    // Delete option
    window.deleteOption = function(optionIndex) {
        if (confirm('Are you sure you want to delete this option and all its values?')) {
            $('#collapse-option-' + optionIndex).closest('.card').remove();
        }
    };

    // Delete value
    window.deleteValue = function(button) {
        if (confirm('Are you sure you want to delete this value?')) {
            $(button).closest('.value-row').remove();
        }
    };

    // Save all options
    $('#saveOptionsBtn').on('click', function() {
        var productId = $('#manageOptionsModal').data('product-id');
        console.log('Saving options for product:', productId);
        
        // Here you would collect all form data and send to server
        // For now, just show success message
        alert('Options saved successfully! (This is a demo - implement server-side saving)');
        $('#manageOptionsModal').modal('hide');
    });
});
</script>
@endpush 