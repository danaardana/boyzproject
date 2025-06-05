@extends('layouts.admin')

@section('title', '| Account Verification Required')

@section('content')
<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card overflow-hidden">
                    <div class="bg-primary bg-soft">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-4">
                                    <h5 class="text-primary">Account Verification Required</h5>
                                    <p>Please verify your email address to continue.</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="{{ asset('admin/images/profile-img.png') }}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="p-2">
                            <div class="text-center">
                                <div class="avatar-md mx-auto">
                                    <div class="avatar-title rounded-circle bg-light">
                                        <i class="bx bx-mail-send h1 mb-0 text-primary"></i>
                                    </div>
                                </div>
                                <div class="p-2 mt-4">
                                    <h4>Verify Your Email Address</h4>
                                    <p class="text-muted">We've sent a verification email to <strong>{{ $admin->email ?? 'your email address' }}</strong>. Please click the verification link in the email to activate your account.</p>
                                    
                                    <div class="mt-4">
                                        <p class="text-muted mb-2">Didn't receive the email?</p>
                                        <button type="button" class="btn btn-primary waves-effect waves-light" onclick="resendVerification()">
                                            <i class="bx bx-mail-send me-1"></i>Resend Verification Email
                                        </button>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <a href="{{ route('admin.login') }}" class="btn btn-light waves-effect">
                                            <i class="bx bx-arrow-back me-1"></i>Back to Login
                                        </a>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <p class="text-muted font-size-13">
                                            <i class="bx bx-info-circle me-1"></i>
                                            If you continue to have issues, please contact the system administrator.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-5 text-center">
                    <div>
                        <p>© {{ date('Y') }} {{ config('app.name', 'Boy Projects') }}. Crafted with <i class="mdi mdi-heart text-danger"></i> by {{ config('app.name', 'Boy Projects') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function resendVerification() {
    // You can implement AJAX call to resend verification email
    alert('Verification email will be sent shortly. Please check your inbox.');
}
</script>
@endsection 