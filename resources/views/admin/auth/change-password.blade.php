@extends('admin.layouts.auth')

@section('title', '| Change Password')

@section('content')
<h4 class="text-muted text-center font-size-18"><b>Change Password</b></h4>

<div class="p-3">
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form class="form-horizontal mt-3" method="POST" action="{{ route('admin.password.change.submit') }}">
        @csrf

        <div class="form-group mb-3 row">
            <div class="col-12">
                <label class="form-label">Current Password</label>
                <div class="input-group auth-pass-inputgroup">
                    <input class="form-control" type="password" name="current_password" id="current-password-input" required placeholder="Current Password">
                    <button class="btn btn-light ms-0" type="button" id="current-password-toggle">
                        <i class="mdi mdi-eye-outline" id="current-password-icon"></i>
                    </button>
                </div>
                @error('current_password')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group mb-3 row">
            <div class="col-12">
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
        </div>

        <div class="form-group mb-3 row">
            <div class="col-12">
                <label class="form-label">Confirm New Password</label>
                <div class="input-group auth-pass-inputgroup">
                    <input class="form-control" type="password" name="password_confirmation" id="confirm-password-input" required placeholder="Confirm New Password">
                    <button class="btn btn-light ms-0" type="button" id="confirm-password-toggle">
                        <i class="mdi mdi-eye-outline" id="confirm-password-icon"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="form-group mb-3 text-center row mt-3 pt-1">
            <div class="col-12">
                <button class="btn btn-info w-100 waves-effect waves-light" type="submit">Change Password</button>
            </div>
        </div>

        <div class="form-group mb-0 row mt-2">
            <div class="col-12 mt-3">
                <a href="{{ route('admin.dashboard') }}" class="text-muted"><i class="mdi mdi-arrow-left"></i> Back to Dashboard</a>
            </div>
        </div>
    </form>
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

    // Setup toggles for all password fields
    setupPasswordToggle('current-password-input', 'current-password-toggle', 'current-password-icon');
    setupPasswordToggle('new-password-input', 'new-password-toggle', 'new-password-icon');
    setupPasswordToggle('confirm-password-input', 'confirm-password-toggle', 'confirm-password-icon');
});
</script>
@endsection 