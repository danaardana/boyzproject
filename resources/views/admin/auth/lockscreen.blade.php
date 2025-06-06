@extends('layouts.admin')

@section("title", "| Lockscreen ")

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
                                    <img src="{{ asset('landing/images/logo-white.png') }}" alt="" height="28"> 
                                    <span class="logo-txt">Boy Projects</span>
                                </a>
                            </div>
                            <div class="auth-content my-auto">
                                <div class="text-center">
                                    <h5 class="mb-0">{{ __('auth.Lock Screen') }}</h5>
                                    <p class="text-muted mt-2">{{ __('auth.Enter your password to unlock the screen!') }}</p>
                                </div>
                                <div class="user-thumb text-center mb-4 mt-4 pt-2">
                                    <div class="avatar-lg mx-auto">
                                        @if(isset($admin) && $admin->avatar_path)
                                            <img class="avatar-title rounded-circle" src="{{ asset('storage/' . $admin->avatar_path) }}" alt="{{ $admin->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div class="avatar-title rounded-circle bg-light">
                                                <i class="bx bx-user h2 mb-0 text-primary"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <h5 class="font-size-15 mt-3">
                                        {{ isset($admin) ? $admin->name : (auth('admin')->user()->name ?? 'Admin') }}
                                    </h5>
                                    @if(isset($admin) && $admin->email)
                                        <p class="text-muted font-size-13">{{ $admin->email }}</p>
                                    @endif
                                </div>
                                <form class="mt-4" action="{{ route('admin.unlock') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="userpassword">{{ __('auth.Password') }}</label>
                                        <input class="form-control @error('password') is-invalid @enderror" 
                                               type="password" 
                                               name="password" 
                                               id="userpassword"
                                               required 
                                               placeholder="{{ __('auth.Enter your password') }}"
                                               autocomplete="current-password">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-4">
                                        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">
                                            <i class="mdi mdi-lock-open-outline me-1"></i>
                                            {{ __('auth.Unlock') }}
                                        </button>
                                    </div>
                                </form>

                                <div class="mt-5 text-center">
                                    <p class="text-muted mb-0">
                                        <a href="{{ route('admin.logout') }}" 
                                           class="text-muted fw-medium" 
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="mdi mdi-logout me-1"></i> 
                                            {{ __('auth.Not you? Sign out') }}
                                        </a>
                                    </p>
                                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                                
                                @if(isset($admin))
                                    <div class="mt-3 text-center">
                                        <small class="text-muted">
                                            {{ __('auth.Last activity') }}: {{ $admin->updated_at->diffForHumans() }}
                                        </small>
                                    </div>
                                @endif
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
                                @if(isset($SectionContents) && $SectionContents->count() > 0)
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
                                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                    <div class="testi-contain text-white">
                                                        <i class="bx bxs-quote-alt-left text-success display-6"></i>
                                                        <h4 class="mt-4 fw-medium lh-base text-white">
                                                            "{{ $subsection->content_value }}"
                                                        </h4>
                                                        <div class="mt-4 pt-3 pb-5">
                                                            <div class="d-flex align-items-start">
                                                                <div class="flex-shrink-0">
                                                                    @if(isset($extraData->image) && $extraData->image)
                                                                        <img class="rounded-circle avatar-md" 
                                                                             alt="{{ $subsection->content_key }}" 
                                                                             src="{{ asset($extraData->image) }}"
                                                                             onerror="this.src='{{ asset('admin/images/users/avatar-1.jpg') }}'">
                                                                    @else
                                                                        <div class="avatar-md rounded-circle bg-light d-flex align-items-center justify-content-center">
                                                                            <i class="bx bx-user text-primary"></i>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="flex-grow-1 ms-3 mb-4">
                                                                    <h5 class="font-size-18 text-white">
                                                                        {{ $subsection->content_key }}
                                                                    </h5>
                                                                    <p class="mb-0 text-white-50">
                                                                        {{ isset($extraData->company) ? $extraData->company : 'Customer' }}
                                                                    </p>
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
                                @else
                                    <!-- Fallback content when no testimonials -->
                                    <div class="text-center text-white">
                                        <div class="mb-4">
                                            <i class="bx bx-shield-check display-1 text-success"></i>
                                        </div>
                                        <h4 class="text-white mb-3">{{ __('auth.Secure Access') }}</h4>
                                        <p class="text-white-50 mb-0">
                                            {{ __('auth.Your session has been locked for security. Please enter your password to continue.') }}
                                        </p>
                                        <div class="mt-4">
                                            <small class="text-white-50">
                                                {{ __('auth.Session locked at') }}: {{ now()->format('M d, Y H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                @endif
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Focus on password input when page loads
    const passwordInput = document.getElementById('userpassword');
    if (passwordInput) {
        passwordInput.focus();
    }
    
    // Add loading state to unlock button
    const form = document.querySelector('form[action="{{ route('admin.unlock') }}"]');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    form.addEventListener('submit', function() {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="mdi mdi-loading mdi-spin me-1"></i>{{ __("auth.Unlocking...") }}';
    });
    
    // Auto-submit on Enter key
    passwordInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            form.submit();
        }
    });
    
    // Clear any existing timeouts and start session monitoring
    if (typeof sessionTimeout !== 'undefined') {
        sessionTimeout.stop();
    }
});
</script>
@endpush
