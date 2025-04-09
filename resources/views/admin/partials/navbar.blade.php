<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('landing/images/favicon.ico') }}" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('landing/images/favicon.ico') }}" alt="" height="24"> <span class="logo-txt">Boy Projects</span>
                    </span>
                </a>

                <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('landing/images/favicon.ico') }}" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('landing/images/favicon.ico') }}" alt="" height="24"> <span class="logo-txt">Boy Projects</span>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- App Search-->
            <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="<?php echo $language["Search"]; ?>">
                    <button class="btn btn-primary" type="button"><i class="bx bx-search-alt align-middle"></i></button>
                </div>
            </form>
        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item" id="page-header-search-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="search" class="icon-lg"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">
        
                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="<?php echo $language["Search"]; ?>" aria-label="Search Result">

                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-none d-sm-inline-block">
            <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <?php if ($lang == 'en') { ?>
                        <img class="me-2" src="{{ asset('admin/images/flags/us.jpg') }}" alt="English" height="16"> 
                    <?php } ?>
                    <?php if ($lang == 'id') { ?>
                        <img class="me-2" src="{{ asset('admin/images/flags/id.jpg') }}" alt="Bahasa" height="16"> 
                    <?php } ?>
                </button>
                <div class="dropdown-menu dropdown-menu-end">

                    <!-- item-->
                    <a href="?lang=en" class="dropdown-item notify-item language">
                        <img src="{{ asset('admin/images/flags/us.jpg') }}" alt="English" class="me-1" height="12"> <span class="align-middle"> English </span>
                    </a>
                    
                    <!-- item-->
                    <a href="?lang=id" class="dropdown-item notify-item language">
                        <img src="{{ asset('admin/images/flags/id.jpg') }}" alt="Bahasa" class="me-1" height="12"> <span class="align-middle"> Bahasa </span>
                    </a>
                </div>
            </div>

            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item" id="mode-setting-btn">
                    <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                    <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon position-relative" id="page-header-notifications-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="bell" class="icon-lg"></i>
                    <span class="badge bg-danger rounded-pill">5</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> <?php echo $language["Notifications"]; ?> </h6>
                            </div>
                            <div class="col-auto">
                                <a href="#!" class="small text-reset text-decoration-underline"> <?php echo $language["Unread"]; ?> (3)</a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <img src="{{ asset('admin/images/users/avatar-3.jpg') }}" class="rounded-circle avatar-sm" alt="user-pic">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?php echo $language["James_Lemire"]; ?></h6>
                                    <div class="font-size-13 text-muted">
                                        <p class="mb-1"><?php echo $language["It_will_seem_like_simplified_English"]; ?>.</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span><?php echo $language["1_hours_ago"]; ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 avatar-sm me-3">
                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                        <i class="bx bx-cart"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?php echo $language["Your_order_is_placed"]; ?></h6>
                                    <div class="font-size-13 text-muted">
                                        <p class="mb-1"><?php echo $language["If_several_languages_coalesce_the_grammar"]; ?></p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span><?php echo $language["3_min_ago"]; ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 avatar-sm me-3">
                                    <span class="avatar-title bg-success rounded-circle font-size-16">
                                        <i class="bx bx-badge-check"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?php echo $language["Your_item_is_shipped"]; ?></h6>
                                    <div class="font-size-13 text-muted">
                                        <p class="mb-1"><?php echo $language["If_several_languages_coalesce_the_grammar"]; ?></p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span><?php echo $language["3_min_ago"]; ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <img src="{{ asset('admin/images/users/avatar-6.jpg') }}" class="rounded-circle avatar-sm" alt="user-pic">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?php echo $language["Salena_Layfield"]; ?></h6>
                                    <div class="font-size-13 text-muted">
                                        <p class="mb-1"><?php echo $language["As_a_skeptical_Cambridge_friend_of_mine_occidental"]; ?>.</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span><?php echo $language["1_hours_ago"]; ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                            <i class="mdi mdi-arrow-right-circle me-1"></i> <span><?php echo $language["View_More"]; ?></span> 
                        </a>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item right-bar-toggle me-2">
                    <i data-feather="settings" class="icon-lg"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item bg-light-subtle border-start border-end" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ asset('admin/images/users/avatar-1.jpg') }}"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium"><?php echo $language["Shawn_L"]; ?>.</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="apps-contacts-profile.php"><i class="mdi mdi mdi-face-man font-size-16 align-middle me-1"></i> <?php echo $language["Profile"]; ?></a>
                    <a class="dropdown-item" href="auth-lock-screen.php"><i class="mdi mdi-lock font-size-16 align-middle me-1"></i> <?php echo $language["Lock_screen"]; ?> </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i> <?php echo $language["Logout"]; ?></a>
                </div>
            </div>

        </div>
    </div>
</header>

<!-- ========== Left Sidebar Start ========== -->
<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu"><?php echo $language["Menu"]; ?></li>

                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard"><?php echo $language["Dashboard"]; ?></span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard"><?php echo $language["Summarize"]; ?></span>
                    </a>
                </li>

                
                <li class="menu-title" data-key="t-menu"><?php echo $language["Products_&_Services"]; ?></li>

                <li>
                    <a href="#">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard"><?php echo $language["Products"]; ?></span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard"><?php echo $language["Services"]; ?></span>
                    </a>
                </li>

                <li class="menu-title" data-key="t-menu"><?php echo $language["Orders_&_Queue"]; ?></li>

                <li>
                    <a href="#">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard"><?php echo $language["Incoming_Orders"]; ?></span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard"><?php echo $language["Service_Queue"]; ?></span>
                    </a>
                </li>

                <li class="menu-title" data-key="t-menu"><?php echo $language["User_Management"]; ?></li>

                <li>
                    <a href="#">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard"><?php echo $language["User_List"]; ?></span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard"><?php echo $language["Roles_&_Permissions"]; ?></span>
                    </a>
                </li>

                <li class="menu-title" data-key="t-menu"><?php echo $language["Website_Content"]; ?></li>

                <li>
                    <a href="javascript: void(0);">
                        <i data-feather="box"></i>
                        <span class="badge rounded-pill badge-soft-danger  text-danger float-end">7</span>
                        <span data-key="t-forms"><?php echo $language["Landing_Page_Editor"]; ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="#" data-key=""><?php echo $language["Add"]; ?></a></li>
                        <li><a href="#" data-key=""><?php echo $language["Manage"]; ?></a></li>
                        <li><a href="#" data-key=""><?php echo $language["Preview"]; ?></a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('admin.tables', ['type' => 'portofolio']) }}">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard"><?php echo $language["Portfolio"]; ?></span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.tables', ['type' => 'testimonials
']) }}">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard"><?php echo $language["Testimonials"]; ?></span>
                    </a>
                </li>

                <li class="menu-title" data-key="t-menu"><?php echo $language["Social_Media_&_Promotions"]; ?></li>

                <li>
                    <a href="{{ route('admin.tables', ['type' => 'instagram']) }}">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard"><?php echo $language["Instagram_Feeds"]; ?></span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.tables', ['type' => 'tiktok']) }}">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard"><?php echo $language["TikTok_Feeds"]; ?></span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard"><?php echo $language["Promotions_&_Discounts"]; ?></span>
                    </a>
                </li>



            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->