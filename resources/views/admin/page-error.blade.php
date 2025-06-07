

@extends('layouts.admin')

@include('admin.partials.navbar')  

@section("title", "| Error")



@section('content')

@php
    // Get error code from various sources
    $errorCode = $errorCode ?? request()->get('code') ?? request()->route('code') ?? '404';
@endphp

<div class="my-5 pt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mb-5">
                    @if($errorCode === 'db_error')
                        <h1 class="display-1 fw-semibold text-warning">DB</h1>
                        <h4 class="text-uppercase">Database Connection Lost</h4>
                        <div class="mt-5 text-center">
                            <a class="btn btn-warning waves-effect waves-light me-2" href="javascript:location.reload()">
                                Try Again
                            </a>
                            <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.dashboard') }}">Back to Dashboard</a>
                        </div>
                    @else
                        <h1 class="display-1 fw-semibold">{{ $errorCode === '404' ? '4' : $errorCode }}<span class="text-primary mx-2">{{ $errorCode === '404' ? '0' : '' }}</span>{{ $errorCode === '404' ? '4' : '' }}</h1>
                        <h4 class="text-uppercase">
                            @if($errorCode === '404')
                                Sorry, page not found
                            @elseif($errorCode === '500')
                                Internal Server Error
                            @elseif($errorCode === '403')
                                Access Forbidden
                            @else
                                Something went wrong
                            @endif
                        </h4>
                        <div class="mt-5 text-center">
                            <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.dashboard') }}">Back to Dashboard</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10 col-xl-8">
                <div>
                    <img src="{{ asset('admin/images/error-img.png') }}" alt="" class="img-fluid">
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>

@include('admin.partials.footer')



@endsection