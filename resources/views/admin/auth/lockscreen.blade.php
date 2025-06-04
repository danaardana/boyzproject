@extends('admin.layouts.auth')

@section('title', '| Lock Screen')

@section('content')
<h4 class="text-muted text-center font-size-18"><b>Locked</b></h4>

<div class="p-3">
    <form class="form-horizontal mt-3" method="POST" action="{{ route('admin.unlock') }}">
        @csrf

        <div class="user-thumb text-center mb-4">
            <img src="{{ asset('admin/images/users/avatar-1.jpg') }}" class="rounded-circle img-thumbnail avatar-md" alt="thumbnail">
            <h6 class="font-size-16 mt-3">{{ auth('admin')->user()->name }}</h6>
        </div>

        <div class="form-group mb-3 row">
            <div class="col-12">
                <input class="form-control" type="password" name="password" required placeholder="Password">
                @error('password')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group mb-3 text-center row mt-3 pt-1">
            <div class="col-12">
                <button class="btn btn-info w-100 waves-effect waves-light" type="submit">Unlock</button>
            </div>
        </div>

        <div class="form-group mb-0 row mt-2">
            <div class="col-12 mt-3">
                <a href="{{ route('admin.logout') }}" class="text-muted" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="mdi mdi-logout"></i> Not you? Sign out</a>
            </div>
        </div>
    </form>

    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</div>
@endsection 