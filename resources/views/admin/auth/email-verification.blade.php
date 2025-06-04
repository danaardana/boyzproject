<?php
// include language configuration file based on selected language
$lang = "us";
if (isset($_GET['lang'])) {
   $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
}
if( isset( $_SESSION['lang'] ) ) {
    $lang = $_SESSION['lang'];
}else {
    $lang = "us";
}
require_once ("./admin/lang/" . $lang . ".php");

?>

@extends('layouts.admin')

@section("title", "| Email Verification ")

@section('content')

<div class="auth-page">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-xxl-3 col-lg-4 col-md-5">
                <div class="auth-full-page-content d-flex p-sm-5 p-4">
                    <div class="w-100">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-4 mb-md-5 text-center">
                                <a href="index.php" class="d-block auth-logo">
                                    <img src="{{ asset('landing/images/logo-white.png') }}" alt="" height="28"> <span class="logo-txt">Boy Projects</span>
                                </a>
                            </div>
                            <div class="auth-content my-auto">
                                <div class="text-center">
                                    <div class="avatar-lg mx-auto">
                                        <div class="avatar-title rounded-circle bg-light">
                                            <i class="bx bxs-envelope h2 mb-0 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="p-2 mt-4">
                                        <h4>{{ $language['Verify_your_email'] }}</h4>
                                        <p>{{ $language['Verify_text_1'] }} <span class="fw-bold">{{ $admin->email }}</span>{{ $language['Verify_text_2'] }} </p>
                                        <form method="POST" action="{{ route('verify.email.submit') }}">
                                            @csrf
                                            <div class="mt-4">
                                            <input type="hidden" name="email" value="{{ $admin->email }}">
                                            <button type="submit" class="btn btn-primary w-10">{{ $language['Verify_now']  }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="mt-5 text-center">
                                    <p class="text-muted mb-0">{{ $language['Didnt_receive'] }} <a href="#"
                                            class="text-primary fw-semibold"> {{ $language['Resend']  }} </a> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end auth full page content -->
            </div>
            <!-- end col -->
            <div class="col-xxl-9 col-lg-8 col-md-7">
                <div class="auth-bg pt-md-5 p-4 d-flex">
                    <div class="bg-overlay bg-primary"></div>
                    <ul class="bg-bubbles">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                    <!-- end bubble effect -->
                    <div class="row justify-content-center align-items-center">
                        <div class="col-xl-7">
                            <div class="p-0 p-sm-4 px-xl-0">
                                <div id="reviewcarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators carousel-indicators-rounded justify-content-start ms-0 mb-0">
                                    @for ($i = 0; $i < $totalSectionContents; $i++)
                                        <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="{{ $i }}"
                                            @if ($i === 0) class="active" aria-current="true" @endif
                                            aria-label="Slide {{ $i + 1 }}">
                                        </button>
                                    @endfor
                                    </div>
                                    <!-- end carouselIndicators -->
                                    <div class="carousel-inner">
                                        @foreach ($SectionContents as $subsection)
                                        @php
                                            $extraData = json_decode($subsection->extra_data);
                                        @endphp
                                        <div class="carousel-item {{ $loop->last ? 'active' : '' }}">
                                            <div class="testi-contain text-white">
                                                <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                <h4 class="mt-4 fw-medium lh-base text-white">“{{ $subsection->content_value }}”
                                                </h4>
                                                <div class="mt-4 pt-3 pb-5">
                                                    <div class="d-flex align-items-start">
                                                        <div class="flex-shrink-0">
                                                            <img class="rounded-circle avatar-md" alt="{{ $extraData->image }}" 
                                                            src="{{ asset($extraData->image) }}">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3 mb-4">
                                                            <h5 class="font-size-18 text-white">{{ $subsection->content_key }}
                                                            </h5>
                                                            <p class="mb-0 text-white-50">Shopee</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <!-- end carousel-inner -->
                                </div>
                                <!-- end review carousel -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container fluid -->
</div>

@endsection

@push("scripts")

<!-- Required datatable js -->
<script src="{{ asset('admin/layouts/vendor-scripts.php') }}"></script>

@endpush