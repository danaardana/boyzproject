@extends('layouts.landing')

@section('content')

    @include('landing.section.home')
    @include('landing.section.about')
    @include('landing.section.activities')
    @include('landing.section.services')
    @include('landing.section.team')
    @include('landing.section.portofolio')
    @include('landing.section.counter')
    @include('landing.section.testimonials')
    @include('landing.section.pricing')
    @include('landing.section.cta')

@endsection
