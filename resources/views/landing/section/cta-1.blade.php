@php
    use App\Models\Section;

    $cta = Section::where('name', 'cta')->first();

@endphp


@if($cta && $cta->is_active)
<section class="pt-50 pb-50 dark-bg cta-block">
<div class="container">
    <div class="row">
    <div class="col-md-5">
        <div class="cta-heading-left">
        <p class="subtitle mt-20">{{ $cta->description }}</p>
        <h3>{{ $cta->title }}</h3>
        </div>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-6">
        <div class="cta-heading-right">
        <p class="mt-30 pull-right"><a href="{{ $cta->button_link }}" class="btn btn-circle btn-outline">{{ $cta->button_text }}</a></p>
        </div>
    </div>
    </div>
    <hr>
    <div class="row">
    <div class="col-md-12">
        <div class="cta-heading-right">
        <p class="mt-20 content-text">{{ $cta->content }}</p>
        </div>
    </div>
    </div>
</div>
</section>
@endif