@extends('admin.layouts.auth')

@section('title', '| Reset Password')

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
                                    <h5 class="mb-0">Reset Password</h5>
                                </div>
                                
                                @if(session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form class="form-horizontal mt-3" method="POST" action="{{ route('admin.password.update') }}">
                                    @csrf
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Email Address</label>
                                        <input class="form-control" type="email" name="email" value="{{ old('email', session('email', '')) }}" required placeholder="Email Address" readonly>
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Security Code</label>
                                        <input class="form-control" type="text" name="security_code" required placeholder="Enter Security Code from Email">
                                        @error('security_code')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">New Password</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input class="form-control" type="password" name="password" id="new-password-input" required placeholder="New Password">
                                            <button class="btn btn-light ms-0" type="button" id="new-password-toggle">
                                                <i class="mdi mdi-eye-outline" id="new-password-icon"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input class="form-control" type="password" name="password_confirmation" id="confirm-password-input" required placeholder="Confirm Password">
                                            <button class="btn btn-light ms-0" type="button" id="confirm-password-toggle">
                                                <i class="mdi mdi-eye-outline" id="confirm-password-icon"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Reset Password</button>
                                    </div>
                                </form>

                                <div class="mt-5 text-center">
                                    <p class="text-muted mb-0">Already have an account ? <a href="{{ route('admin.login') }}" class="text-primary fw-semibold">Back To Login </a> </p>
                                </div>
                            </div>
                            <div class="mt-4 mt-md-5 text-center">
                                <p class="mb-0">© <script>
                                        document.write(new Date().getFullYear())
                                    </script> Boy Projects . </p>
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
    // Function to setup password toggle
    function setupPasswordToggle(inputId, toggleId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const passwordToggle = document.getElementById(toggleId);
        const passwordIcon = document.getElementById(iconId);

        if (passwordInput && passwordToggle && passwordIcon) {
            passwordToggle.addEventListener('click', function() {
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
        }
    }

    // Setup toggles for both password fields
    setupPasswordToggle('new-password-input', 'new-password-toggle', 'new-password-icon');
    setupPasswordToggle('confirm-password-input', 'confirm-password-toggle', 'confirm-password-icon');
});
</script>
@endsection 