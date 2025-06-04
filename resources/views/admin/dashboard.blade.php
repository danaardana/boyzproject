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
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Section Active</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value" data-target="{{ $totalActiveSections }}">{{ $totalActiveSections }}</span> sections
                                    </h4>
                                </div>
                            </div>
                            <div class="text-nowrap">
                                <span class="badge bg-success-subtle text-success">{{ $totalSections }}</span>
                                <span class="ms-1 text-muted font-size-13">Total Sections</span>
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
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Number of Transaction</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value" data-target="6258">0</span>
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <div id="mini-chart2" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                                </div>
                            </div>
                            <div class="text-nowrap">
                                <span class="badge bg-danger-subtle text-danger">-29 Trades</span>
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
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Revenue</span>
                                    <h4 class="mb-3">
                                        Rp<span class="counter-value" data-target="4.32">0</span>M
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <div id="mini-chart3" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                                </div>
                            </div>
                            <div class="text-nowrap">
                                <span class="badge bg-success-subtle text-success">+ Rp 2.8k</span>
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
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Profit Ration</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value" data-target="12.57">0</span>%
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <div id="mini-chart4" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                                </div>
                            </div>
                            <div class="text-nowrap">
                                <span class="badge bg-success-subtle text-success">+2.95%</span>
                                <span class="ms-1 text-muted font-size-13">Since last week</span>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->    
            </div><!-- end row-->

            

            <div class="row">
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Create Product</h4>
                                <div class="flex-shrink-0">
                                    <ul class="nav nav-tabs-custom card-header-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#buy-tab" role="tab">Shopee</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#sell-tab" role="tab">Tokopedia</a>
                                        </li>
                                    </ul>
                                </div>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="buy-tab" role="tabpanel">
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-14"><i class="bx bx-wallet text-primary font-size-16 align-middle me-1"></i></h5>
                                        </div>
                                        <h5 class="font-size-14 mb-4">Create Product</h5>
                                        <div>
                                            <div class="form-group mb-3">
                                                <label>Shipping method :</label>
                                                <select class="form-select">
                                                    <option>Sameday</option>
                                                    <option>Next Day</option>
                                                    <option>Cargo</option>
                                                    <option>Reguler</option>
                                                </select>
                                            </div>

                                            <div>
                                                <label>Stock Amount :</label>
                                                <div class="input-group mb-3">
                                                    <label class="input-group-text">Amount</label>
                                                    <select class="form-select" style="max-width: 90px;">
                                                        <option value="BT" selected>Available</option>
                                                        <option value="ET">Unavailable</option>
                                                    </select>
                                                    <input type="text" class="form-control" placeholder="1">
                                                </div>

                                                <div class="input-group mb-3">
                                                    <label class="input-group-text">Price</label>
                                                    <input type="text" class="form-control" placeholder="Rp 58,245">
                                                    <label class="input-group-text">Rp</label>
                                                </div>
                                            </div>  

                                            <div class="text-center">
                                                <button type="button" class="btn btn-success w-md">Add Product</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end tab pane -->
                                    <div class="tab-pane" id="sell-tab" role="tabpanel">
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-14"><i class="bx bx-wallet text-primary font-size-16 align-middle me-1"></i></h5>
                                        </div>
                                        <h5 class="font-size-14 mb-4"> Create Product</h5>

                                        <div>
                                            <div class="form-group mb-3">
                                                <label>Shipping method :</label>
                                                <select class="form-select">
                                                    <option>Sameday</option>
                                                    <option>Next Day</option>
                                                    <option>Cargo</option>
                                                    <option>Reguler</option>
                                                </select>
                                            </div>

                                            <div>
                                                <label>Stock Amount :</label>
                                                <div class="input-group mb-3">
                                                    <label class="input-group-text">Amount</label>
                                                    <select class="form-select" style="max-width: 90px;">
                                                        <option value="BT" selected>Available</option>
                                                        <option value="ET">Unavailable</option>
                                                    </select>
                                                    <input type="text" class="form-control" placeholder="1">
                                                </div>

                                                <div class="input-group mb-3">
                                                    <label class="input-group-text">Price</label>
                                                    <input type="text" class="form-control" placeholder="Rp 58,245">
                                                    <label class="input-group-text">Rp</label>
                                                </div>
                                            </div>  
                                            </div>  

                                            <div class="text-center">
                                                <button type="button" class="btn btn-danger w-md">Add</button>
                                            </div>
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
                    
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Transactions</h4>
                                <div class="flex-shrink-0">
                                    <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#transactions-all-tab" role="tab">
                                                All 
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#transactions-buy-tab" role="tab">
                                                Shopee 
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#transactions-sell-tab" role="tab">
                                                Tokopedia 
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- end nav tabs -->
                                </div>
                            </div><!-- end card header -->

                            <div class="card-body px-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="transactions-all-tab" role="tabpanel">
                                        <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                                            <table class="table align-middle table-nowrap table-borderless">
                                                <tbody>

                                                    <tr>
                                                    <td>
                                                        <div class="font-size-22 text-danger">
                                                            <i class="bx bx-up-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Honda Revo X</h5>
                                                            <p class="text-muted mb-0 font-size-12">26 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Body & Rangka</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 395.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td style="width: 50px;">
                                                        <div class="font-size-22 text-success">
                                                            <i class="bx bx-down-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Yamaha Gear 125</h5>
                                                            <p class="text-muted mb-0 font-size-12">18 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Lampu Motor</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 375.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td>
                                                        <div class="font-size-22 text-danger">
                                                            <i class="bx bx-up-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Viar Q1</h5>
                                                            <p class="text-muted mb-0 font-size-12">27 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Lampu Motor</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 420.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td style="width: 50px;">
                                                        <div class="font-size-22 text-success">
                                                            <i class="bx bx-down-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">TVS Neo XR</h5>
                                                            <p class="text-muted mb-0 font-size-12">19 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Body & Rangka</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 410.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td style="width: 50px;">
                                                        <div class="font-size-22 text-success">
                                                            <i class="bx bx-down-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Suzuki Smash FI</h5>
                                                            <p class="text-muted mb-0 font-size-12">20 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Lampu Motor</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 350.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>
                                                    

                                                    <tr>
                                                    <td>
                                                        <div class="font-size-22 text-danger">
                                                            <i class="bx bx-up-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Yamaha Jupiter Z1</h5>
                                                            <p class="text-muted mb-0 font-size-12">24 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Body & Rangka</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 460.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td>
                                                        <div class="font-size-22 text-danger">
                                                            <i class="bx bx-up-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Suzuki Address FI</h5>
                                                            <p class="text-muted mb-0 font-size-12">25 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Lampu Motor</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 440.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    

                                                    <tr>
                                                    <td style="width: 50px;">
                                                        <div class="font-size-22 text-success">
                                                            <i class="bx bx-down-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Honda Genio</h5>
                                                            <p class="text-muted mb-0 font-size-12">21 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Body & Rangka</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 430.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td style="width: 50px;">
                                                        <div class="font-size-22 text-success">
                                                            <i class="bx bx-down-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Yamaha Fino 125</h5>
                                                            <p class="text-muted mb-0 font-size-12">22 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Lampu Motor</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 390.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                    <td>
                                                        <div class="font-size-22 text-danger">
                                                            <i class="bx bx-up-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Honda Scoopy</h5>
                                                            <p class="text-muted mb-0 font-size-12">23 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Lampu Motor</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 480.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td style="width: 50px;">
                                                        <div class="font-size-22 text-success">
                                                            <i class="bx bx-down-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Yamaha Mio M3</h5>
                                                            <p class="text-muted mb-0 font-size-12">16 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Lampu Motor</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 320.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td>
                                                        <div class="font-size-22 text-danger">
                                                            <i class="bx bx-up-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Yamaha Vega Force</h5>
                                                            <p class="text-muted mb-0 font-size-12">28 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Body & Rangka</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 470.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td style="width: 50px;">
                                                        <div class="font-size-22 text-success">
                                                            <i class="bx bx-down-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Suzuki Nex II</h5>
                                                            <p class="text-muted mb-0 font-size-12">17 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Body & Rangka</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 290.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td>
                                                        <div class="font-size-22 text-danger">
                                                            <i class="bx bx-up-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">TVS Dazz</h5>
                                                            <p class="text-muted mb-0 font-size-12">29 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Lampu Motor</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 360.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- end tab pane -->
                                    <div class="tab-pane" id="transactions-buy-tab" role="tabpanel">
                                        <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                                            <table class="table align-middle table-nowrap table-borderless">
                                                <tbody>
                                                    <tr>
                                                    <td style="width: 50px;">
                                                        <div class="font-size-22 text-success">
                                                            <i class="bx bx-down-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Yamaha Mio M3</h5>
                                                            <p class="text-muted mb-0 font-size-12">16 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Lampu Motor</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 320.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td style="width: 50px;">
                                                        <div class="font-size-22 text-success">
                                                            <i class="bx bx-down-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Suzuki Nex II</h5>
                                                            <p class="text-muted mb-0 font-size-12">17 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Body & Rangka</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 290.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td style="width: 50px;">
                                                        <div class="font-size-22 text-success">
                                                            <i class="bx bx-down-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Yamaha Gear 125</h5>
                                                            <p class="text-muted mb-0 font-size-12">18 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Lampu Motor</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 375.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td style="width: 50px;">
                                                        <div class="font-size-22 text-success">
                                                            <i class="bx bx-down-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">TVS Neo XR</h5>
                                                            <p class="text-muted mb-0 font-size-12">19 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Body & Rangka</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 410.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td style="width: 50px;">
                                                        <div class="font-size-22 text-success">
                                                            <i class="bx bx-down-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Suzuki Smash FI</h5>
                                                            <p class="text-muted mb-0 font-size-12">20 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Lampu Motor</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 350.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td style="width: 50px;">
                                                        <div class="font-size-22 text-success">
                                                            <i class="bx bx-down-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Honda Genio</h5>
                                                            <p class="text-muted mb-0 font-size-12">21 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Body & Rangka</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 430.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td style="width: 50px;">
                                                        <div class="font-size-22 text-success">
                                                            <i class="bx bx-down-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Yamaha Fino 125</h5>
                                                            <p class="text-muted mb-0 font-size-12">22 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Lampu Motor</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 390.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- end tab pane -->
                                    <div class="tab-pane" id="transactions-sell-tab" role="tabpanel">
                                        <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                                            <table class="table align-middle table-nowrap table-borderless">
                                                <tbody>
                                                    <tr>
                                                    <td>
                                                        <div class="font-size-22 text-danger">
                                                            <i class="bx bx-up-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Honda Scoopy</h5>
                                                            <p class="text-muted mb-0 font-size-12">23 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Lampu Motor</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 480.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td>
                                                        <div class="font-size-22 text-danger">
                                                            <i class="bx bx-up-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Yamaha Jupiter Z1</h5>
                                                            <p class="text-muted mb-0 font-size-12">24 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Body & Rangka</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 460.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td>
                                                        <div class="font-size-22 text-danger">
                                                            <i class="bx bx-up-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Suzuki Address FI</h5>
                                                            <p class="text-muted mb-0 font-size-12">25 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Lampu Motor</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 440.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td>
                                                        <div class="font-size-22 text-danger">
                                                            <i class="bx bx-up-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Honda Revo X</h5>
                                                            <p class="text-muted mb-0 font-size-12">26 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Body & Rangka</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 395.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td>
                                                        <div class="font-size-22 text-danger">
                                                            <i class="bx bx-up-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Viar Q1</h5>
                                                            <p class="text-muted mb-0 font-size-12">27 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Lampu Motor</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 420.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td>
                                                        <div class="font-size-22 text-danger">
                                                            <i class="bx bx-up-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">Yamaha Vega Force</h5>
                                                            <p class="text-muted mb-0 font-size-12">28 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Body & Rangka</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 470.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
                                                        </div>
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td>
                                                        <div class="font-size-22 text-danger">
                                                            <i class="bx bx-up-arrow-circle d-block"></i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-14 mb-1">TVS Dazz</h5>
                                                            <p class="text-muted mb-0 font-size-12">29 Mar, 2021</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 mb-0">Lampu Motor</h5> 
                                                            <p class="text-muted mb-0 font-size-12">Category</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-end">
                                                            <h5 class="font-size-14 text-muted mb-0">Rp 360.000</h5>
                                                            <p class="text-muted mb-0 font-size-12">Total Amount</p>
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

                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Recent Activity</h4>
                                <div class="flex-shrink-0">
                                    <select class="form-select form-select-sm mb-0 my-n1">
                                        <option value="Today" selected="">Today</option>
                                        <option value="Yesterday">Yesterday</option>
                                        <option value="Week">Last Week</option>
                                        <option value="Month">Last Month</option>
                                    </select>
                                </div>
                            </div><!-- end card header -->

                            <div class="card-body px-0">
                                <div class="px-3" data-simplebar style="max-height: 352px;">
                                    <ul class="list-unstyled activity-wid mb-0">
                                    @if($sessions->isEmpty())
                                        <p>No recent activity found.</p>
                                    @else
                                    @foreach($sessions as $session)
                                        <li class="activity-list {{ $loop->last ? '' : 'activity-border' }}">
                                            <div class="activity-icon avatar-md">
                                                <span class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                                @if(strtolower($session->platform) === 'windows')
                                                    <i class="bx bx-desktop font-size-24"></i>
                                                @elseif(strtolower($session->platform) === 'android')
                                                    <i class="bx bxl-android font-size-24"></i>
                                                @elseif(strtolower($session->platform) === 'ios' || strtolower($session->platform) === 'mac' || strtolower($session->platform) === 'apple')
                                                    <i class="bx bx-apple font-size-24"></i>
                                                @else
                                                    <i class="bx bx-question-mark font-size-24"></i> {{-- ikon default --}}
                                                @endif
                                                </span>
                                            </div>
                                            <div class="timeline-list-item">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1 overflow-hidden me-4">
                                                        <h5 class="font-size-14 mb-1">{{ $session->last_activity }}</h5>
                                                        <p class="text-truncate text-muted font-size-13">{{ $session->device }}</p>
                                                    </div>
                                                    <div class="flex-shrink-0 text-end me-3">
                                                        <h6 class="mb-1">{{ $session->platform }}</h6>
                                                        <div class="font-size-13">{{ $session->browser }}</div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </li>
                                        @endforeach
                                    @endif
                                    </ul>
                                </div>    
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
