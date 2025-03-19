@extends('layouts.landing')

@section('content')
<div class="wrapper white-bg">
    <section class="vh-height page_404 white-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-10 centerize-col text-center">
                        <div class="four-zero-four-bg">
                            <h1 class="dark-color">404 ERROR</h1>
                        </div>
                        <div class="content-box">
                            <h2 class="cardo-font">Look like you're lost</h2>
                            <p class="cardo-font dark-color lead">The page you are looking for is not available!</p>
                            <p class="mt-30">
                                <a href="{{ url('/') }}" class="btn btn-color btn-square">GO TO HOME</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
