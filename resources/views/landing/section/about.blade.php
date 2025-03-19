@php
use App\Models\Section;
use App\Models\SectionContent;

$about = Section::where('name', 'about')->first();
$services = SectionContent::where('section_id', $about->id ?? null)->get();
@endphp

@if($about && $about->is_active)
<section class="white-bg">
  <div class="col-md-6 col-sm-4 bg-flex bg-flex-left">
    <div class="bg-flex-holder bg-flex-cover" style="background-image: url({{ asset($about->image) }});"></div>
  </div>
  <div class="container">
    <div class="col-md-5 col-sm-7 col-md-offset-7 col-sm-offset-5">
      <h1 class="font-700 wow fadeTop" data-wow-delay="0.1s">{{ $about->title }}</h1>
      <h4 class="mt-10 line-height-26 wow fadeTop" data-wow-delay="0.2s">{{ $about->description }}</h4>
      <div class="left-service-box pt-40 pb-20 row">
        @foreach($services as $service)
        <div class="col-md-12 feature-box text-left mb-50 col-sm-6 wow fadeTop" data-wow-delay="0.1s">
          <div class="pull-left"><i class="icofont {{ $service->content_key }} font-60px default-icon"></i></div>
          <div class="pull-right">
            <h5 class="mt-0 upper-case">{{ $service->content_key }}</h5>
            <p>{{ $service->content_value }}</p>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
@endif