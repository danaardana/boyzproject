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
                                    <img src="{{ asset('landing/images/logo-white.png') }}" alt="Boy Projects Logo" height="28"> 
                                    <span class="logo-txt">Boy Projects</span>
                                </a>
                            </div>
                            <div class="auth-content my-auto">
                                <div class="text-center">
                                    <h5 class="mb-0">Welcome Back!</h5>
                                    <p class="text-muted mt-2">Sign in to access your admin dashboard.</p>
                                </div>
                                
                                @if(session('status'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="mdi mdi-check-circle me-2"></i>
                                        {{ session('status') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="mdi mdi-alert-circle me-2"></i>
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                
                                <form class="mt-4 pt-2" method="POST" action="{{ route('admin.login.submit') }}" id="loginForm">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="email">
                                            <i class="mdi mdi-email-outline me-1"></i>Email Address
                                        </label>
                                        <input class="form-control @error('email') is-invalid @enderror" 
                                               type="email" 
                                               name="email" 
                                               id="email"
                                               required 
                                               placeholder="Enter your email address" 
                                               value="{{ old('email') }}"
                                               autocomplete="email">
                                        @error('email')
                                            <div class="invalid-feedback d-block">
                                                <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <label class="form-label" for="password">
                                                    <i class="mdi mdi-lock-outline me-1"></i>Password
                                                </label>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="">
                                                    <a href="{{ route('admin.password.request') }}" class="text-muted text-decoration-none">
                                                        <small>Forgot password?</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="input-group auth-pass-inputgroup">
                                            <input class="form-control @error('password') is-invalid @enderror" 
                                                   type="password" 
                                                   name="password" 
                                                   id="password-input" 
                                                   required 
                                                   placeholder="Enter your password" 
                                                   aria-label="Password" 
                                                   aria-describedby="password-addon"
                                                   autocomplete="current-password">
                                            <button class="btn btn-light" type="button" id="password-addon" aria-label="Toggle password visibility">
                                                <i class="mdi mdi-eye-outline" id="password-icon"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback d-block">
                                                <i class="mdi mdi-alert-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       id="remember" 
                                                       name="remember" 
                                                       value="1"
                                                       {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="remember">
                                                    <i class="mdi mdi-account-check-outline me-1"></i>
                                                    Keep me signed in
                                                </label>
                                                <small class="text-muted d-block">
                                                    Recommended for private devices only
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit" id="loginButton">
                                            <span class="login-text">
                                                <i class="mdi mdi-login me-1"></i>Sign In
                                            </span>
                                            <span class="login-loading d-none">
                                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                                Signing in...
                                            </span>
                                        </button>
                                    </div>
                                </form>

                                
                            </div>
                            <div class="mt-4 mt-md-5 text-center">
                                <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> Boy Projects.</p>
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
    const loginForm = document.getElementById('loginForm');
    const loginButton = document.getElementById('loginButton');
    const loginText = document.querySelector('.login-text');
    const loginLoading = document.querySelector('.login-loading');
    const emailInput = document.getElementById('email');
    const rememberCheckbox = document.getElementById('remember');

    // Password visibility toggle
    passwordToggle.addEventListener('click', function() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.classList.remove('mdi-eye-outline');
            passwordIcon.classList.add('mdi-eye-off-outline');
            passwordToggle.setAttribute('aria-label', 'Hide password');
        } else {
            passwordInput.type = 'password';
            passwordIcon.classList.remove('mdi-eye-off-outline');
            passwordIcon.classList.add('mdi-eye-outline');
            passwordToggle.setAttribute('aria-label', 'Show password');
        }
    });

    // Form submission handling
    loginForm.addEventListener('submit', function(e) {
        // Show loading state
        loginButton.disabled = true;
        loginText.classList.add('d-none');
        loginLoading.classList.remove('d-none');
        
        // Store remember me preference
        if (rememberCheckbox.checked) {
            localStorage.setItem('admin_remember_email', emailInput.value);
        } else {
            localStorage.removeItem('admin_remember_email');
        }
    });

    // Load remembered email on page load
    const rememberedEmail = localStorage.getItem('admin_remember_email');
    if (rememberedEmail) {
        emailInput.value = rememberedEmail;
        rememberCheckbox.checked = true;
    }

    // Real-time validation feedback
    emailInput.addEventListener('input', function() {
        this.classList.remove('is-invalid', 'is-valid');
        if (this.value && this.validity.valid) {
            this.classList.add('is-valid');
        }
    });

    passwordInput.addEventListener('input', function() {
        this.classList.remove('is-invalid', 'is-valid');
        if (this.value.length >= 6) {
            this.classList.add('is-valid');
        }
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Alt + R to toggle remember me
        if (e.altKey && e.key === 'r') {
            e.preventDefault();
            rememberCheckbox.checked = !rememberCheckbox.checked;
        }
        // Alt + L to focus login button
        if (e.altKey && e.key === 'l') {
            e.preventDefault();
            loginButton.focus();
        }
    });

    // Auto-focus on first empty field
    if (!emailInput.value) {
        emailInput.focus();
    } else if (!passwordInput.value) {
        passwordInput.focus();
    }

    // Reset loading state if there are validation errors
    @if($errors->any())
        loginButton.disabled = false;
        loginText.classList.remove('d-none');
        loginLoading.classList.add('d-none');
    @endif

    // Enhanced security warnings
    const securityFeatures = document.querySelectorAll('.avatar-title');
    securityFeatures.forEach((feature, index) => {
        setTimeout(() => {
            feature.style.animation = 'pulse 2s infinite';
        }, index * 500);
    });
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .form-control.is-valid {
        border-color: #34c38f !important;
        box-shadow: 0 0 0 0.2rem rgba(52, 195, 143, 0.25) !important;
    }
    
    .form-control.is-invalid {
        border-color: #f46a6a !important;
        box-shadow: 0 0 0 0.2rem rgba(244, 106, 106, 0.25) !important;
    }
    
    .login-loading .spinner-border {
        width: 1rem;
        height: 1rem;
    }
    
    .auth-content {
        transition: all 0.3s ease;
    }
    
    .form-check-input:checked {
        background-color: #556ee6;
        border-color: #556ee6;
    }
    
    .form-check-label {
        cursor: pointer;
    }
    
    .avatar-title {
        transition: transform 0.3s ease;
    }
    
    .avatar-title:hover {
        transform: scale(1.1);
    }
`;
document.head.appendChild(style);
</script>
@endsection 