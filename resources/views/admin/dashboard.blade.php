@extends('layouts.admin')

@include('admin.partials.navbar')  

@section('content')

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <!-- card -->
                    <div class="card card-h-100">
                        <!-- card body -->
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="">
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Sales</span>
                                    <h4 class="mb-3">
                                        Rp<span class="counter-value" data-target="12.8">0</span>M
                                    </h4>
                                </div>
                            </div>
                            <div class="text-nowrap">
                                <span class="badge bg-success-subtle text-success">+15.2%</span>
                                <span class="ms-1 text-muted font-size-13">From last month</span>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <!-- card -->
                    <div class="card card-h-100">
                        <!-- card body -->
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Orders</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value" data-target="847">0</span>
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <div id="mini-chart2" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                                </div>
                            </div>
                            <div class="text-nowrap">
                                <span class="badge bg-success-subtle text-success">+23 Orders</span>
                                <span class="ms-1 text-muted font-size-13">Since last week</span>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col-->

                <div class="col-xl-3 col-md-6">
                    <!-- card -->
                    <div class="card card-h-100">
                        <!-- card body -->
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Products Sold</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value" data-target="1247">0</span>
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <div id="mini-chart3" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                                </div>
                            </div>
                            <div class="text-nowrap">
                                <span class="badge bg-success-subtle text-success">+5.8%</span>
                                <span class="ms-1 text-muted font-size-13">Since last week</span>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <!-- card -->
                    <div class="card card-h-100">
                        <!-- card body -->
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Average Rating</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value" data-target="4.8">0</span>/5
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <div id="mini-chart4" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                                </div>
                            </div>
                            <div class="text-nowrap">
                                <span class="badge bg-success-subtle text-success">+0.2 points</span>
                                <span class="ms-1 text-muted font-size-13">Since last week</span>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->    
            </div><!-- end row-->

            <div class="row">
                <div class="col-xl-6">
                    <!-- card -->
                    <div class="card card-h-100">
                        <!-- card body -->
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center mb-4">
                                <h5 class="card-title me-2">Top-Selling Categories</h5>
                                <div class="ms-auto">
                                    <div>
                                        <button type="button" class="btn btn-soft-secondary btn-sm">
                                            ALL
                                        </button>
                                        <button type="button" class="btn btn-soft-primary btn-sm">
                                            1M
                                        </button>
                                        <button type="button" class="btn btn-soft-secondary btn-sm">
                                            6M
                                        </button>
                                        <button type="button" class="btn btn-soft-secondary btn-sm">
                                            1Y
                                        </button>
                                </div>
                                </div>
                            </div>

                            <div class="row align-items-center">
                                <div class="col-sm">
                                    <div id="category-chart" data-colors='["#777aca", "#5156be", "#a8aada"]' class="apex-charts"></div>
                                        </div>
                                <div class="col-sm align-self-center">
                                    <div class="mt-4 mt-sm-0">
                                        <div>
                                            <p class="mb-2"><i class="mdi mdi-circle align-middle font-size-10 me-2 text-success"></i> Mounting & Body</p>
                                            <h6>524 units = <span class="text-muted font-size-14 fw-normal">Rp 8,425,000</span></h6>
                                            </div>

                                        <div class="mt-4 pt-2">
                                            <p class="mb-2"><i class="mdi mdi-circle align-middle font-size-10 me-2 text-primary"></i> Lighting</p>
                                            <h6>312 units = <span class="text-muted font-size-14 fw-normal">Rp 3,225,000</span></h6>
                                                </div>

                                        <div class="mt-4 pt-2">
                                            <p class="mb-2"><i class="mdi mdi-circle align-middle font-size-10 me-2 text-info"></i> Installation Service</p>
                                            <h6>89 services = <span class="text-muted font-size-14 fw-normal">Rp 1,125,000</span></h6>
                                                </div>
                                            </div>  
                                            </div>
                                        </div>
                                    </div>
                                        </div>
                    <!-- end card -->
                
                                            </div>
                <!-- end Top-Selling Categories row -->
                <!-- Revenue Chart Row -->
                <div class="col-xl-6">
                    <div class="col-xl-12">
                        <!-- card -->
                        <div class="card card-h-100">
                            <!-- card body -->
                            <div class="card-body">
                                <div class="d-flex flex-wrap align-items-center mb-4">
                                    <h5 class="card-title me-2">Revenue by Platform</h5>
                                    <div class="ms-auto">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle text-reset" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted font-size-12">Sort By:</span> <span class="fw-medium">Monthly<i class="mdi mdi-chevron-down ms-1"></i></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Weekly</a>
                                                <a class="dropdown-item" href="#">Monthly</a>
                                                <a class="dropdown-item" href="#">Yearly</a>
                                                </div>
                                                </div>
                                            </div>  
                                            </div>  

                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                            <div class="text-center">
                                            <div id="revenue-chart" data-colors='["#5156be", "#34c38f", "#f1b44c"]' class="apex-charts"></div>
                                            </div>
                                        </div>
                                    <div class="col-md-6">
                                        <div class="mt-4 mt-md-0">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mt-1">
                                                        <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-primary font-size-10 me-1"></i> Shopee</p>
                                                        <h5 class="font-size-16 mb-0">Rp 8.7M</h5>
                                                        <p class="text-muted mb-0 font-size-12">69.1% of total</p>
                                    </div>
                                </div>
                                                <div class="col-6">
                                                    <div class="mt-1">
                                                        <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-success font-size-10 me-1"></i> Tokopedia</p>
                                                        <h5 class="font-size-16 mb-0">Rp 3.2M</h5>
                                                        <p class="text-muted mb-0 font-size-12">25.4% of total</p>
                                                    </div>
                                                </div>
                                                <div class="col-6 mt-3">
                                                    <div class="mt-1">
                                                        <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-warning font-size-10 me-1"></i> Direct Sales</p>
                                                        <h5 class="font-size-16 mb-0">Rp 0.9M</h5>
                                                        <p class="text-muted mb-0 font-size-12">5.5% of total</p>
                                                    </div>
                                                </div>
                                                <div class="col-6 mt-3">
                                                    <div class="mt-1 text-center">
                                                        <div class="border rounded p-3">
                                                            <h4 class="mb-1 text-primary">Rp 12.8M</h4>
                                                            <p class="text-muted mb-0 font-size-12">Total Revenue</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end revenue row -->
            </div> <!-- end row-->
                    
            <div class="row">
                <!-- Transaction Distribution by Platform row -->
                    <div class="col-xl-4">
                    <div class="row">
                        <div class="col-xl-12">
                            <!-- card -->
                            <div class="card card-h-100">
                                <!-- card body -->
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center mb-4">
                                        <h5 class="card-title me-2">Transaction Distribution by Platform</h5>
                                        <div class="ms-auto">
                                            <select class="form-select form-select-sm">
                                                <option value="MAY" selected="">May</option>
                                                <option value="AP">April</option>
                                                <option value="MA">March</option>
                                                <option value="FE">February</option>
                                                <option value="JA">January</option>
                                                <option value="DE">December</option>
                                            </select>
                                </div>
                                    </div>

                                    <div class="text-center">
                                        <div id="transaction-distribution-chart" data-colors='["#5156be", "#34c38f", "#f1b44c"]' class="apex-charts"></div>
                                        <div class="mt-3">
                                            <p class="text-muted mb-0 font-size-13">
                                                Distribution of transactions across e-commerce platforms and direct sales channels
                                            </p>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        </div>
                        <!-- end col -->
                                                        </div>
                    <!-- end row -->

                                                        </div>
                <!-- end col -->
                <!-- Top Product Reviews row -->
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Top Product Reviews</h4>
                            <div class="flex-shrink-0">
                                <select class="form-select form-select-sm mb-0 my-n1">
                                    <option value="Today" selected="">This Week</option>
                                    <option value="Month">This Month</option>
                                    <option value="Quarter">This Quarter</option>
                                </select>
                                                        </div>
                        </div><!-- end card header -->

                        <div class="card-body px-0">
                            <div class="px-3" data-simplebar style="max-height: 352px;">
                                <ul class="list-unstyled activity-wid mb-0">
                                    
                                    <li class="activity-list activity-border">
                                        <div class="activity-icon avatar-md">
                                            <span class="avatar-title bg-success-subtle text-success rounded-circle">
                                                <i class="mdi mdi-star font-size-24"></i>
                                            </span>
                                                        </div>
                                        <div class="timeline-list-item">
                                            <div class="d-flex">
                                                <div class="flex-grow-1 overflow-hidden me-4">
                                                    <h5 class="font-size-14 mb-1">LED Headlight Kit</h5>
                                                    <p class="text-truncate text-muted font-size-13">"Excellent quality, very bright and easy to install!"</p>
                                                        </div>
                                                <div class="flex-shrink-0 text-end me-3">
                                                    <h6 class="mb-1">⭐ 5.0</h6>
                                                    <div class="font-size-13">Shopee</div>
                                                        </div>
                                                <div class="flex-shrink-0 text-end">
                                                    <div class="dropdown">
                                                        <a class="text-muted dropdown-toggle font-size-24" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                            <i class="mdi mdi-dots-vertical"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="#">View Review</a>
                                                            <a class="dropdown-item" href="#">Contact Customer</a>
                                                            <a class="dropdown-item" href="#">Product Details</a>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                    </li>

                                    <li class="activity-list activity-border">
                                        <div class="activity-icon avatar-md">
                                            <span class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                                <i class="mdi mdi-star font-size-24"></i>
                                            </span>
                                                        </div>
                                        <div class="timeline-list-item">
                                            <div class="d-flex">
                                                <div class="flex-grow-1 overflow-hidden me-4">
                                                    <h5 class="font-size-14 mb-1">Engine Mount</h5>
                                                    <p class="text-truncate text-muted font-size-13">"Perfect fit for my bike, reduced vibration significantly."</p>
                                                        </div>
                                                <div class="flex-shrink-0 text-end me-3">
                                                    <h6 class="mb-1">⭐ 4.8</h6>
                                                    <div class="font-size-13">Shopee</div>
                                                        </div>
                                                <div class="flex-shrink-0 text-end">
                                                    <div class="dropdown">
                                                        <a class="text-muted dropdown-toggle font-size-24" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                            <i class="mdi mdi-dots-vertical"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="#">View Review</a>
                                                            <a class="dropdown-item" href="#">Contact Customer</a>
                                                            <a class="dropdown-item" href="#">Product Details</a>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                    </li>

                                    <li class="activity-list activity-border">
                                        <div class="activity-icon avatar-md">
                                            <span class="avatar-title bg-warning-subtle text-warning rounded-circle">
                                                <i class="mdi mdi-star font-size-24"></i>
                                            </span>
                                                        </div>
                                        <div class="timeline-list-item">
                                            <div class="d-flex">
                                                <div class="flex-grow-1 overflow-hidden me-4">
                                                    <h5 class="font-size-14 mb-1">Brake Pad Set</h5>
                                                    <p class="text-truncate text-muted font-size-13">"Good quality brake pads, professional installation."</p>
                                                        </div>
                                                <div class="flex-shrink-0 text-end me-3">
                                                    <h6 class="mb-1">⭐ 4.5</h6>
                                                    <div class="font-size-13">Tokopedia</div>
                                                        </div>
                                                <div class="flex-shrink-0 text-end">
                                                    <div class="dropdown">
                                                        <a class="text-muted dropdown-toggle font-size-24" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                            <i class="mdi mdi-dots-vertical"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="#">View Review</a>
                                                            <a class="dropdown-item" href="#">Contact Customer</a>
                                                            <a class="dropdown-item" href="#">Product Details</a>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                    </li>

                                    <li class="activity-list activity-border">
                                        <div class="activity-icon avatar-md">
                                            <span class="avatar-title bg-info-subtle text-info rounded-circle">
                                                <i class="mdi mdi-star font-size-24"></i>
                                            </span>
                                                        </div>
                                        <div class="timeline-list-item">
                                            <div class="d-flex">
                                                <div class="flex-grow-1 overflow-hidden me-4">
                                                    <h5 class="font-size-14 mb-1">Turn Signal Light</h5>
                                                    <p class="text-truncate text-muted font-size-13">"Bright and durable, exactly as advertised."</p>
                                                        </div>
                                                <div class="flex-shrink-0 text-end me-3">
                                                    <h6 class="mb-1">⭐ 4.7</h6>
                                                    <div class="font-size-13">Shopee</div>
                                                        </div>
                                                <div class="flex-shrink-0 text-end">
                                                    <div class="dropdown">
                                                        <a class="text-muted dropdown-toggle font-size-24" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                            <i class="mdi mdi-dots-vertical"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="#">View Review</a>
                                                            <a class="dropdown-item" href="#">Contact Customer</a>
                                                            <a class="dropdown-item" href="#">Product Details</a>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                    </li>

                                    <li class="activity-list">
                                        <div class="activity-icon avatar-md">
                                            <span class="avatar-title bg-success-subtle text-success rounded-circle">
                                                <i class="mdi mdi-tools font-size-24"></i>
                                            </span>
                                                        </div>
                                        <div class="timeline-list-item">
                                            <div class="d-flex">
                                                <div class="flex-grow-1 overflow-hidden me-4">
                                                    <h5 class="font-size-14 mb-1">Installation Service</h5>
                                                    <p class="text-truncate text-muted font-size-13">"Fast service, very professional mechanic."</p>
                                                        </div>
                                                <div class="flex-shrink-0 text-end me-3">
                                                    <h6 class="mb-1">⭐ 4.9</h6>
                                                    <div class="font-size-13">Tokopedia</div>
                                                        </div>
                                                <div class="flex-shrink-0 text-end">
                                                    <div class="dropdown">
                                                        <a class="text-muted dropdown-toggle font-size-24" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                            <i class="mdi mdi-dots-vertical"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="#">View Review</a>
                                                            <a class="dropdown-item" href="#">Contact Customer</a>
                                                            <a class="dropdown-item" href="#">Service Details</a>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                    </li>
                                </ul>
                                                        </div>
                                                        </div>
                        <!-- end card body -->
                                                        </div>
                    <!-- end card -->
                                                        </div>
                <!-- end col -->

                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">E-commerce Orders</h4>
                            <div class="flex-shrink-0">
                                <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#orders-all-tab" role="tab">
                                            All 
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#orders-shopee-tab" role="tab">
                                            Shopee 
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#orders-tokopedia-tab" role="tab">
                                            Tokopedia  
                                        </a>
                                    </li>
                                </ul>
                                <!-- end nav tabs -->
                                        </div>
                        </div><!-- end card header -->

                        <div class="card-body px-0">
                            <div class="tab-content">
                                <div class="tab-pane active" id="orders-all-tab" role="tabpanel">
                                        <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                                            <table class="table align-middle table-nowrap table-borderless">
                                                <tbody>
                                                    <tr>
                                                    <td style="width: 50px;">
                                                        <div class="font-size-18 text-success">
                                                            <i class="mdi mdi-shopping"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">LED Headlight Kit</h5>
                                                            <p class="text-muted mb-0 font-size-12">Shopee • Lighting</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">2 units</h5>
                                                            <p class="text-muted mb-0 font-size-12">Quantity</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 450,000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td>
                                                        <div class="font-size-18 text-info">
                                                            <i class="mdi mdi-wrench"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Engine Mount</h5>
                                                            <p class="text-muted mb-0 font-size-12">Shopee • Mounting & Body</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">1 unit</h5>
                                                            <p class="text-muted mb-0 font-size-12">Quantity</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 175,000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td>
                                                        <div class="font-size-18 text-warning">
                                                            <i class="mdi mdi-tools"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Installation Service</h5>
                                                            <p class="text-muted mb-0 font-size-12">Tokopedia • Service</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">1 service</h5>
                                                            <p class="text-muted mb-0 font-size-12">Quantity</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 75,000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td>
                                                        <div class="font-size-18 text-success">
                                                            <i class="mdi mdi-lightbulb-on"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Turn Signal Light</h5>
                                                            <p class="text-muted mb-0 font-size-12">Shopee • Lighting</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">4 units</h5>
                                                            <p class="text-muted mb-0 font-size-12">Quantity</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 120,000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td>
                                                        <div class="font-size-18 text-info">
                                                            <i class="mdi mdi-car-brake-alert"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Brake Pad Set</h5>
                                                            <p class="text-muted mb-0 font-size-12">Tokopedia • Mounting & Body</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">1 set</h5>
                                                            <p class="text-muted mb-0 font-size-12">Quantity</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 85,000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td>
                                                        <div class="font-size-18 text-success">
                                                            <i class="mdi mdi-flash"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Tail Light Assembly</h5>
                                                            <p class="text-muted mb-0 font-size-12">Shopee • Lighting</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">1 unit</h5>
                                                            <p class="text-muted mb-0 font-size-12">Quantity</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 225,000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total</p>
                                                        </div>
                                                    </td>
                                                    </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end tab pane -->
                                <div class="tab-pane" id="orders-shopee-tab" role="tabpanel">
                                    <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                                        <table class="table align-middle table-nowrap table-borderless">
                                            <tbody>
                                                    <tr>
                                                    <td style="width: 50px;">
                                                        <div class="font-size-18 text-success">
                                                            <i class="mdi mdi-shopping"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">LED Headlight Kit</h5>
                                                            <p class="text-muted mb-0 font-size-12">Lighting</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">2 units</h5>
                                                            <p class="text-muted mb-0 font-size-12">Quantity</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 450,000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td>
                                                        <div class="font-size-18 text-info">
                                                            <i class="mdi mdi-wrench"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Engine Mount</h5>
                                                            <p class="text-muted mb-0 font-size-12">Mounting & Body</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">1 unit</h5>
                                                            <p class="text-muted mb-0 font-size-12">Quantity</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 175,000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td>
                                                        <div class="font-size-18 text-success">
                                                            <i class="mdi mdi-lightbulb-on"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Turn Signal Light</h5>
                                                            <p class="text-muted mb-0 font-size-12">Lighting</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">4 units</h5>
                                                            <p class="text-muted mb-0 font-size-12">Quantity</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 120,000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td>
                                                        <div class="font-size-18 text-success">
                                                            <i class="mdi mdi-flash"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Tail Light Assembly</h5>
                                                            <p class="text-muted mb-0 font-size-12">Lighting</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">1 unit</h5>
                                                            <p class="text-muted mb-0 font-size-12">Quantity</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 225,000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td>
                                                        <div class="font-size-18 text-info">
                                                            <i class="mdi mdi-cog"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Clutch Assembly</h5>
                                                            <p class="text-muted mb-0 font-size-12">Mounting & Body</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">1 unit</h5>
                                                            <p class="text-muted mb-0 font-size-12">Quantity</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 320,000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total</p>
                                                        </div>
                                                    </td>
                                                    </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end tab pane -->
                                <div class="tab-pane" id="orders-tokopedia-tab" role="tabpanel">
                                    <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                                        <table class="table align-middle table-nowrap table-borderless">
                                            <tbody>
                                                    <tr>
                                                    <td>
                                                        <div class="font-size-18 text-warning">
                                                            <i class="mdi mdi-tools"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Installation Service</h5>
                                                            <p class="text-muted mb-0 font-size-12">Service</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">1 service</h5>
                                                            <p class="text-muted mb-0 font-size-12">Quantity</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 75,000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td style="width: 50px;">
                                                        <div class="font-size-18 text-info">
                                                            <i class="mdi mdi-car-brake-alert"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Brake Pad Set</h5>
                                                            <p class="text-muted mb-0 font-size-12">Mounting & Body</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">1 set</h5>
                                                            <p class="text-muted mb-0 font-size-12">Quantity</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 85,000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td>
                                                        <div class="font-size-18 text-info">
                                                            <i class="mdi mdi-engine"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Air Filter</h5>
                                                            <p class="text-muted mb-0 font-size-12">Mounting & Body</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">2 units</h5>
                                                            <p class="text-muted mb-0 font-size-12">Quantity</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 65,000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total</p>
                                                        </div>
                                                    </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- end tab pane -->
                                </div>
                                <!-- end tab content -->
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div><!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    @include('admin.partials.footer')
    
</div>

@endsection

@push('scripts')
<!-- apexcharts -->
<script src="{{ asset('admin/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- Plugins js-->
<script src="{{ asset('admin/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('admin/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- dashboard init -->
<script src="{{ asset('admin/js/pages/dashboard.init.js') }}"></script>
@endpush