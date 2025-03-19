@php
use App\Models\Section;
use App\Models\SectionContent;

$activities = Section::where('name', 'activities')->first();
$services = SectionContent::where('section_id', $activities->id ?? null)->get();
@endphp

@if($activities && $activities->is_active)
<section class="white-bg" id="activities">
  <div class="col-md-6 col-sm-4 bg-flex bg-flex-left">
    <div class="bg-flex-holder bg-flex-cover" style="background-image: url({{ asset($activities->image) }});"></div>
  </div>
  <div class="container">
    <div class="col-md-5 col-sm-7 col-md-offset-7 col-sm-offset-5">
      <h1 class="font-700 wow fadeTop" data-wow-delay="0.1s">{{ $activities->title }}</h1>
      <h4 class="mt-10 line-height-26 wow fadeTop" data-wow-delay="0.2s">{{ $activities->description }}</h4>
      <div class="left-service-box pt-40 pb-20 row">
        @foreach($services as $service)
        @php
            $extraData = json_decode($service->extra_data, true);
        @endphp
        <div class="col-md-12 feature-box text-left mb-50 col-sm-6 wow fadeTop" data-wow-delay="0.1s">
            <div class="pull-left"><i class="icofont {{ $extraData['icon'] ?? 'icofont-gear' }} font-60px default-icon"></i></div>
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