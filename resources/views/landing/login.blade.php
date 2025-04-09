@extends('layouts.landing')

@section('content')
<section class="title-hero-bg login-cover-bg" data-stellar-background-ratio="0.2">
    <div class="table-display">
        <div class="login v-align text-center">
            <div class="signup-box">
                <div id="signup-content" class="tab-content">
                    <div id="login" class="tab-pane fade in active">
                        <!--=== Form ===-->
                        <form method="POST" action="{{ route('landing.login') }}" class="form login_type text-center">
                            @csrf
                            <!--=== Email ===-->
                            <input type="email" name="email" class="form-control mb-20" placeholder="Email" required>
                            <!--=== Password ===-->
                            <div class="password-wrapper">
                                <input type="password" name="password" id="password" class="form-control mb-20" placeholder="Password" required>
                                <span class="toggle-password" onclick="togglePassword()">👁</span>
                            </div>
                            <!--=== Remember Me ===-->
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> Remember Me
                                </label>
                            </div>
                            <!--=== Submit ===-->
                            <button type="submit" class="btn btn-color btn-circle full-width">LOGIN</button>
                            <!--=== Error Messages ===-->
                            @if ($errors->any())
                                <div class="alert alert-danger mt-10">
                                    @foreach ($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif
                        </form>
                        <!--=== Signup Text ===-->
                        <h6 class="mt-20 gray-light"> FORGET AN ACCOUNT? </h6>
                        <!--=== Signup Button ===-->
                        <a href="#">FORGET <i class="fa fa-angle-double-right"></i> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
