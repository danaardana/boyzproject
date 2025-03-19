@extends('layouts.landing')

@section('content')
<div class="wrapper">
    <section class="title-error-bg coming-cover-bg" data-stellar-background-ratio="0.2">
        <div class="container">
            <div class="page-title text-center">
                <h1>COMING SOON</h1>
                <div class="countdown-container">
                    <ul class="countdown">
                        <li> <span class="days">305</span><p>days</p></li>
                        <li> <span class="hours">13</span><p>hours</p></li>
                        <li> <span class="minutes">49</span><p>minutes</p></li>
                        <li> <span class="seconds">22</span><p>seconds</p></li>
                    </ul>
                </div>
                <p class="mt-30">
                    <a href="{{ url('/') }}" class="btn btn-color btn-square">
                        <i class="fa fa-chevron-left"></i> Back to Home
                    </a>
                </p>
            </div>
        </div>
    </section>
</div>
@endsection
