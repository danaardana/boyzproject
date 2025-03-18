@extends('layouts.landing')

@section('content')

    @include('landing.section.who')
    @include('landing.section.about')
    @include('landing.section.services')
    @include('landing.section.portofolio')
    @include('landing.section.counter')
    @include('landing.section.testimonials')
    @include('landing.section.pricing')
    @include('landing.section.cta')

@endsection
