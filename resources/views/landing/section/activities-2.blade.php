@php
use App\Models\Section;
use App\Models\SectionContent;

$activities = Section::where('name', 'activities')->first();
$services = SectionContent::where('section_id', $activities->id ?? null)->get();
@endphp

@if($activities && $activities->is_active)
<section class="first-ico-box" id="activities">
  <div class="dn-bg-lines">
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
  </div>
  <div class="left_parallax">
    <div class="vertical-text">
      <h3 data-lax-preset="driftRight" data-lax-optimize=true class="lax chunkyText font-700 dark-color">Authentic</h3>
    </div>
  </div>
  <div class="right_parallax">
    <h3 data-lax-preset="driftLeft" data-lax-optimize=true class="lax chunkyText font-700 red-color">Trusted.</h3>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-8 section-heading">
        <h2 class="wow fadeTop" data-wow-delay="0.1s">{{ $activities->title }}</h2>
        <h4 class="text-uppercase wow fadeTop" data-wow-delay="0.2s">{{ $activities->description }}</h4>
        <p class="mt-30 wow fadeTop" data-wow-delay="0.3s">{{ $activities->content }}</p>
      </div>
    </div>
    <div class="row mt-50">
      @foreach($services as $service)
        @php
            $extraData = json_decode($service->extra_data, true);
        @endphp
        <div class="col-md-4 feature-box text-center radius-icon wow fadeTop" data-wow-delay="0.1s"> <i class="icofont {{ $extraData['icon'] ?? 'icofont-gear' }} font-50px default-icon"></i>
          <h4 class="text-uppercase">{{ $service->content_key }}</h4>
          <p>{{ $service->content_value }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif