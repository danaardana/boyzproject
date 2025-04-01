@extends('layouts.landing')

@section('content')
    @php
        $sections = \App\Models\Section::where('is_active', 1)
            ->orderBy('show_order')
            ->get();
    @endphp

    @foreach($sections as $section)
        @php
            $layout = $section->layout ?? 1;
            $viewName = "landing.section.{$section->name}-{$layout}";
        @endphp

        @include($viewName, ['section' => $section])
    @endforeach

@endsection
