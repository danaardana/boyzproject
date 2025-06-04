@extends('admin.layouts.auth')

@section('title', '| Login')

@section('content')
<div class="auth-page">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-xxl-3 col-lg-4 col-md-5">
                <div class="auth-full-page-content d-flex p-sm-5 p-4">
                    <div class="w-100">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-4 mb-md-5 text-center">
                                <a href="{{ route('landing-page') }}" class="d-block auth-logo">
                                    <img src="{{ asset('landing/images/logo-white.png') }}" alt="" height="28"> <span class="logo-txt">Boy Projects</span>
                                </a>
                            </div>
                            <div class="auth-content my-auto">
                                <div class="text-center">
                                    <h5 class="mb-0">Admin Page</h5>
                                    <p class="text-muted mt-2">Sign in to continue.</p>
                                </div>
                                
                                @if(session('status'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('status') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                
                                <form class="mt-4 pt-2" method="POST" action="{{ route('admin.login.submit') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="username">E-mail</label>
                                        <input class="form-control" type="email" name="email" required placeholder="Email" value="{{ old('email') }}">
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <label class="form-label" for="password">Password</label>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="">
                                                    <a href="{{ route('admin.password.request') }}" class="text-muted">Forgot password?</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="input-group auth-pass-inputgroup">
                                            <input class="form-control" type="password" name="password" id="password-input" required placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                                            <button class="btn btn-light ms-0" type="button" id="password-addon">
                                                <i class="mdi mdi-eye-outline" id="password-icon"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                                <label class="form-check-label" for="remember-check">
                                                    Remember me
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log In</button>
                                    </div>
                                </form>
                            </div>
                            <div class="mt-4 mt-md-5 text-center">
                                <p class="mb-0">© <script>
                                        document.write(new Date().getFullYear())
                                    </script> Boy Projects.</p>
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
                                                $extraData = is_string($subsection->extra_data) ? json_decode($subsection->extra_data) : (object)$subsection->extra_data;
                                            @endphp
                                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                <div class="testi-contain text-white">
                                                    <i class="bx bxs-quote-alt-left text-success display-6"></i>
                                                    <h4 class="mt-4 fw-medium lh-base text-white">
                                                        "{{ $subsection->content_value }}"
                                                    </h4>
                                                    <div class="mt-4 pt-3 pb-5">
                                                        <div class="d-flex align-items-start">
                                                            @if(isset($extraData->image))
                                                                <img src="{{ asset($extraData->image) }}" class="avatar-md img-fluid rounded-circle" alt="...">
                                                            @endif
                                                            <div class="flex-grow-1 ms-3 mb-4">
                                                                <h5 class="font-size-18 text-white">{{ $subsection->content_key }}</h5>
                                                                @if(isset($extraData->position))
                                                                    <p class="mb-0 text-white-50">{{ $extraData->position }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password-input');
    const passwordToggle = document.getElementById('password-addon');
    const passwordIcon = document.getElementById('password-icon');

    passwordToggle.addEventListener('click', function() {
        // Toggle password visibility
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.classList.remove('mdi-eye-outline');
            passwordIcon.classList.add('mdi-eye-off-outline');
        } else {
            passwordInput.type = 'password';
            passwordIcon.classList.remove('mdi-eye-off-outline');
            passwordIcon.classList.add('mdi-eye-outline');
        }
    });
});
</script>
@endsection 