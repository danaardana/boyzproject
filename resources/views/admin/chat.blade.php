@extends('layouts.admin')

@include('admin.partials.navbar')  

@section("title", "| Chat ")

@push('styles')
<style>
    /* Enhanced Chat List Styling - No Avatars */
    .chat-leftsidebar {
        width: 350px !important;
        max-height: calc(100vh - 180px) !important;
        min-height: 600px !important;
    }
    
    .chat-message-list {
        max-height: calc(100vh - 280px) !important;
        min-height: 500px !important;
        overflow-y: auto !important;
    }
    
    .chat-list {
        padding-bottom: 20px !important;
    }
    
    .chat-list li a {
        padding: 18px 16px !important;
        border-radius: 8px;
        transition: all 0.3s ease;
        margin-bottom: 4px;
        display: block;
    }
    
    .chat-list li a:hover {
        background-color: #f8f9fa;
        transform: translateX(2px);
    }
    
    .chat-list li.active a {
        background-color: #e3f2fd;
        border-left: 4px solid #2196f3;
    }
    
    .chat-list li.unread a {
        background-color: #fff3cd;
        border-left: 4px solid #ffc107;
    }
    
    .chat-list h5 {
        font-size: 16px !important;
        font-weight: 600;
        margin-bottom: 4px !important;
    }
    
    .chat-list p {
        font-size: 14px !important;
        color: #6c757d;
        margin-bottom: 0;
        line-height: 1.4;
    }
    
    .chat-list .font-size-12 {
        font-size: 13px !important;
        color: #8a909d;
        font-weight: 500;
    }
    
    .chat-list .unread-message .badge {
        font-size: 11px;
        padding: 4px 8px;
        position: absolute;
        top: 10px;
        right: 10px;
    }
    
    .chat-list .d-flex {
        position: relative;
    }
    
    /* Custom scrollbar for chat list */
    .chat-message-list::-webkit-scrollbar {
        width: 6px;
    }
    
    .chat-message-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .chat-message-list::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    .chat-message-list::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }
    
    /* Filter button styling */
    .chat-filters .btn {
        font-size: 12px !important;
        padding: 4px 8px !important;
        border-radius: 6px !important;
    }
    
    .chat-filters .dropdown-menu {
        min-width: 180px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border: 1px solid #e3e6f0;
    }
    
    .chat-filters .dropdown-item {
        font-size: 13px;
        padding: 8px 16px;
    }
    
    .chat-filters .dropdown-item:hover {
        background-color: #f8f9fa;
    }
    
    .chat-filters .dropdown-item.active {
        background-color: #e3f2fd;
        color: #2196f3;
    }
    
    .chat-filters .dropdown-header {
        font-size: 11px;
        font-weight: 600;
        color: #6c757d;
        padding: 8px 16px 4px;
    }
</style>
@endpush

@section('content')

<div class="main-content">

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Chat</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                            <li class="breadcrumb-item active">Chat</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="d-lg-flex">
            <div class="chat-leftsidebar card">

                <div class="p-3">
                    <div class="search-box position-relative">
                        <input type="text" class="form-control rounded border" placeholder="Search...">
                        <i class="bx bx-search search-icon"></i>
                    </div>
                </div>

                <div class="chat-leftsidebar-nav">
                    <div class="tab-content">
                        <div class="tab-pane show active" i>
                            <div class="chat-message-list" data-simplebar>
                                <div class="pt-3">
                                    <div class="px-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h5 class="font-size-14 mb-0">Recent</h5>
                                            <div class="chat-filters">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bx bx-filter-alt me-1"></i>Filter
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="#" data-filter="all"><i class="bx bx-list-ul me-2"></i>All Messages</a></li>
                                                        <li><a class="dropdown-item" href="#" data-filter="unread"><i class="bx bx-bell me-2"></i>Unread Only</a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><h6 class="dropdown-header">Sort By</h6></li>
                                                        <li><a class="dropdown-item" href="#" data-sort="newest"><i class="bx bx-time me-2"></i>Newest First</a></li>
                                                        <li><a class="dropdown-item" href="#" data-sort="oldest"><i class="bx bx-history me-2"></i>Oldest First</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="list-unstyled chat-list">
                                        <li class="active">
                                            <a href="#">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="text-truncate font-size-16 mb-1">Jennie Sherlock</h5>
                                                        <p class="text-truncate mb-0 font-size-13">Hey! there I'm available</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="font-size-12">02 min</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="unread">
                                            <a href="#">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="text-truncate font-size-16 mb-1">Stacie Dube</h5>
                                                        <p class="text-truncate mb-0 font-size-13">I've finished it! See you so</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="font-size-12">10 min</div>
                                                    </div>
                                                    <div class="unread-message">
                                                        <span class="badge bg-danger rounded-pill">1</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="text-truncate font-size-16 mb-1">Katie Olson</h5>
                                                        <p class="text-truncate mb-0 font-size-13">This theme is awesome!</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="font-size-12">22 min</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="text-truncate font-size-16 mb-1">Marshall Wilson</h5>
                                                        <p class="text-truncate mb-0 font-size-13">Nice to meet you</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="font-size-12">01 Hr</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="text-truncate font-size-16 mb-1">James Lee</h5>
                                                        <p class="text-truncate mb-0 font-size-13">Wow that's great</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="font-size-12">04 Hrs</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="text-truncate font-size-16 mb-1">Ronald Tucker</h5>
                                                        <p class="text-truncate mb-0 font-size-13">Nice to meet you</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="font-size-12">22/04</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="text-truncate font-size-16 mb-1">Dennis Stewart</h5>
                                                        <p class="text-truncate mb-0 font-size-13">Nice to meet you</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="font-size-12">22/04</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="text-truncate font-size-16 mb-1">Katie Olson</h5>
                                                        <p class="text-truncate mb-0 font-size-13">This theme is awesome!</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="font-size-12">22 min</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="text-truncate font-size-16 mb-1">Marshall Wilson</h5>
                                                        <p class="text-truncate mb-0 font-size-13">Nice to meet you</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="font-size-12">01 Hr</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="text-truncate font-size-16 mb-1">Sarah Johnson</h5>
                                                        <p class="text-truncate mb-0 font-size-13">Can you help me with my order?</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="font-size-12">2 Hrs</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="text-truncate font-size-16 mb-1">Michael Brown</h5>
                                                        <p class="text-truncate mb-0 font-size-13">Looking for motorcycle parts</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="font-size-12">3 Hrs</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="text-truncate font-size-16 mb-1">Lisa Chen</h5>
                                                        <p class="text-truncate mb-0 font-size-13">Thanks for the quick response!</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="font-size-12">4 Hrs</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="text-truncate font-size-16 mb-1">David Smith</h5>
                                                        <p class="text-truncate mb-0 font-size-13">When will my order arrive?</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="font-size-12">5 Hrs</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="text-truncate font-size-16 mb-1">Emma Wilson</h5>
                                                        <p class="text-truncate mb-0 font-size-13">Great service! Very satisfied</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="font-size-12">Yesterday</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="text-truncate font-size-16 mb-1">Alex Martinez</h5>
                                                        <p class="text-truncate mb-0 font-size-13">Need help with installation</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="font-size-12">Yesterday</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="text-truncate font-size-16 mb-1">Jennifer Davis</h5>
                                                        <p class="text-truncate mb-0 font-size-13">Product quality is excellent</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="font-size-12">2 days</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="text-truncate font-size-16 mb-1">Robert Garcia</h5>
                                                        <p class="text-truncate mb-0 font-size-13">Question about warranty</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="font-size-12">2 days</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="text-truncate font-size-16 mb-1">Amanda Lee</h5>
                                                        <p class="text-truncate mb-0 font-size-13">Shipping cost inquiry</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="font-size-12">3 days</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- end chat-leftsidebar -->

            <div class="w-100 user-chat mt-4 mt-sm-0 ms-lg-1">
                <div class="card">
                    <div class="p-3 px-lg-4 border-bottom">
                        <div class="row">
                            <div class="col-xl-4 col-7">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="font-size-14 mb-1 text-truncate"><a href="#" class="text-dark">Jennie Sherlock</a></h5>
                                        <p class="text-muted text-truncate mb-0">Online</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8 col-5">
                                <ul class="list-inline user-chat-nav text-end mb-0">
                                    <li class="list-inline-item">
                                        <div class="dropdown">
                                            <button class="btn nav-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-search"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-md p-2">
                                                <form class="px-2">
                                                    <div>
                                                        <input type="text" class="form-control border bg-light-subtle" placeholder="Search...">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="list-inline-item">
                                        <div class="dropdown">
                                            <button class="btn nav-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Profile</a>
                                                <a class="dropdown-item" href="#">Archive</a>
                                                <a class="dropdown-item" href="#">Muted</a>
                                                <a class="dropdown-item" href="#">Delete</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>                                                                                                                                                                                                                                                                                        
                            </div>
                        </div>
                    </div>

                    <div class="chat-conversation p-3 px-2" data-simplebar>
                        <ul class="list-unstyled mb-0">
                            <li class="chat-day-title"> 
                                <span class="title">Today</span>
                            </li>
                            <li>
                                <div class="conversation-list">
                                    <div class="ctext-wrap">
                                        <div class="ctext-wrap-content">
                                            <h5 class="conversation-name"><a href="#" class="user-name">Jennie Sherlock</a> <span class="time">10:00</span></h5>
                                            <p class="mb-0">Good morning !</p>
                                        </div>
                                        <div class="dropdown align-self-start">
                                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Copy</a>
                                                <a class="dropdown-item" href="#">Save</a>
                                                <a class="dropdown-item" href="#">Forward</a>
                                                <a class="dropdown-item" href="#">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </li>

                            <li class="right">
                                <div class="conversation-list">
                                    <div class="ctext-wrap">
                                        <div class="ctext-wrap-content">
                                            <h5 class="conversation-name"><a href="#" class="user-name">Shawn</a> <span class="time">10:02</span></h5>
                                            <p class="mb-0">Good morning</p>
                                        </div>
                                        <div class="dropdown align-self-start">
                                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Copy</a>
                                                <a class="dropdown-item" href="#">Save</a>
                                                <a class="dropdown-item" href="#">Forward</a>
                                                <a class="dropdown-item" href="#">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </li>

                            <li>
                                <div class="conversation-list">
                                    <div class="ctext-wrap">
                                        <div class="ctext-wrap-content">
                                            <h5 class="conversation-name"><a href="#" class="user-name">Jennie Sherlock</a> <span class="time">10:04</span></h5>
                                            <p class="mb-0">
                                                Hello!
                                            </p>
                                        </div>
                                        <div class="dropdown align-self-start">
                                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Copy</a>
                                                <a class="dropdown-item" href="#">Save</a>
                                                <a class="dropdown-item" href="#">Forward</a>
                                                <a class="dropdown-item" href="#">Delete</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="ctext-wrap">
                                        <div class="ctext-wrap-content">
                                            <h5 class="conversation-name"><a href="#" class="user-name">Jennie Sherlock</a> <span class="time">10:04</span></h5>
                                            <p class="mb-0">
                                                What about our next meeting?
                                            </p>
                                        </div>
                                        <div class="dropdown align-self-start">
                                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Copy</a>
                                                <a class="dropdown-item" href="#">Save</a>
                                                <a class="dropdown-item" href="#">Forward</a>
                                                <a class="dropdown-item" href="#">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </li>

                            <li>
                                <div class="conversation-list">
                                    <div class="ctext-wrap">
                                        <div class="ctext-wrap-content">
                                            <h5 class="conversation-name"><a href="#" class="user-name">Jennie Sherlock</a> <span class="time">10:06</span></h5>
                                            <p class="mb-0">
                                                Next meeting tomorrow 10.00AM
                                            </p>
                                        </div>
                                        <div class="dropdown align-self-start">
                                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Copy</a>
                                                <a class="dropdown-item" href="#">Save</a>
                                                <a class="dropdown-item" href="#">Forward</a>
                                                <a class="dropdown-item" href="#">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </li>

                            <li class="right">
                                <div class="conversation-list">
                                    <div class="ctext-wrap">
                                        <div class="ctext-wrap-content">
                                            <h5 class="conversation-name"><a href="#" class="user-name">Shawn</a> <span class="time">10:08</span></h5>
                                            <p class="mb-0">
                                                Wow that's great
                                            </p>
                                        </div>
                                        <div class="dropdown align-self-start">
                                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Copy</a>
                                                <a class="dropdown-item" href="#">Save</a>
                                                <a class="dropdown-item" href="#">Forward</a>
                                                <a class="dropdown-item" href="#">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </li>

                            <li>
                                <div class="conversation-list">
                                    <div class="ctext-wrap">
                                        <div class="ctext-wrap-content">
                                            <h5 class="conversation-name"><a href="#" class="user-name">Jennie Sherlock</a> <span class="time">10:09</span></h5>
                                            <p class="mb-0">
                                                img-1.jpg & img-2.jpg images for a New Projects
                                            </p>

                                            <ul class="list-inline message-img mt-3  mb-0">
                                                <li class="list-inline-item message-img-list">
                                                    <a class="d-inline-block m-1" href="">
                                                        <img src="assets/images/small/img-1.jpg" alt="" class="rounded img-thumbnail">
                                                    </a>                                                                  
                                                </li>

                                                <li class="list-inline-item message-img-list">
                                                    <a class="d-inline-block m-1" href="">
                                                        <img src="assets/images/small/img-2.jpg" alt="" class="rounded img-thumbnail">
                                                    </a>                                                                 
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="dropdown align-self-start">
                                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Copy</a>
                                                <a class="dropdown-item" href="#">Save</a>
                                                <a class="dropdown-item" href="#">Forward</a>
                                                <a class="dropdown-item" href="#">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="p-3 border-top">
                        <div class="row">
                            <div class="col">
                                <div class="position-relative">
                                    <input type="text" class="form-control border bg-light-subtle" placeholder="Enter Message...">
                                </div>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary chat-send w-md waves-effect waves-light"><span class="d-none d-sm-inline-block me-2">Send</span> <i class="mdi mdi-send float-end"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end user chat -->
        </div>
        <!-- End d-lg-flex  -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

    @include('admin.partials.footer')
    
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let currentFilter = 'all';
    let currentSort = 'newest';
    
    // Filter functionality
    $('.chat-filters [data-filter]').on('click', function(e) {
        e.preventDefault();
        
        // Remove active class from all filter items
        $('.chat-filters [data-filter]').removeClass('active');
        // Add active class to clicked item
        $(this).addClass('active');
        
        currentFilter = $(this).data('filter');
        applyFilters();
        
        // Update button text to show current filter
        let filterText = currentFilter === 'all' ? 'All Messages' : 'Unread Only';
        $('.chat-filters .dropdown-toggle').html('<i class="bx bx-filter-alt me-1"></i>' + filterText);
    });
    
    // Sort functionality
    $('.chat-filters [data-sort]').on('click', function(e) {
        e.preventDefault();
        
        // Remove active class from all sort items
        $('.chat-filters [data-sort]').removeClass('active');
        // Add active class to clicked item
        $(this).addClass('active');
        
        currentSort = $(this).data('sort');
        applyFilters();
    });
    
    function applyFilters() {
        let chatItems = $('.chat-list li');
        
        // Filter logic
        chatItems.each(function() {
            let isUnread = $(this).hasClass('unread');
            let shouldShow = true;
            
            if (currentFilter === 'unread' && !isUnread) {
                shouldShow = false;
            }
            
            if (shouldShow) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        
        // Sort logic
        let visibleItems = $('.chat-list li:visible');
        let sortedItems = visibleItems.sort(function(a, b) {
            let timeA = $(a).find('.font-size-12').text().trim();
            let timeB = $(b).find('.font-size-12').text().trim();
            
            // Convert time strings to comparable values
            let valueA = getTimeValue(timeA);
            let valueB = getTimeValue(timeB);
            
            if (currentSort === 'newest') {
                return valueA - valueB; // Newer (smaller values) first
            } else {
                return valueB - valueA; // Older (larger values) first
            }
        });
        
        // Reorder the items
        $('.chat-list').append(sortedItems);
    }
    
    function getTimeValue(timeString) {
        // Convert time strings to numeric values for sorting
        // Smaller values = more recent
        if (timeString.includes('min')) {
            return parseInt(timeString);
        } else if (timeString.includes('Hr')) {
            return parseInt(timeString) * 60;
        } else if (timeString.includes('Yesterday')) {
            return 1440; // 24 hours in minutes
        } else if (timeString.includes('days')) {
            let days = parseInt(timeString);
            return days * 1440;
        } else if (timeString.includes('/')) {
            return 10000; // Old date format, make it very old
        }
        return 9999; // Default for unknown formats
    }
    
    // Initialize with default active states
    $('.chat-filters [data-filter="all"]').addClass('active');
    $('.chat-filters [data-sort="newest"]').addClass('active');
});
</script>
@endpush
