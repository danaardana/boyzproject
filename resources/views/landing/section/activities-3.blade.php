@php
use App\Models\Section;
use App\Models\SectionContent;

$activities = Section::where('name', 'activities')->first();
$services = SectionContent::where('section_id', $activities->id ?? null)->get();
@endphp

@if($activities && $activities->is_active)
@php
    $title = $activities->description ?? '';
    $mid = strlen($title) / 2;
    $firstPart = substr($title, 0, strrpos(substr($title, 0, $mid), ' '));
    $secondPart = trim(substr($title, strlen($firstPart)));
@endphp
<section class="first-ico-box dark-bg" id="activities">
  <div class="container">
      <div class="row">
        <div class="col-sm-8">
          <div class="section-heading text-left">
            <h2 class="wow fadeTop gradient-color josefin-font" data-wow-delay="0.1s">{{ $activities->title }}</h2>
            <h4 class="text-uppercase wow fadeTop" data-wow-delay="0.2s"> {{ $firstPart }}<br>{{ $secondPart }}</h4>
            <p class="mt-30 wow fadeTop" data-wow-delay="0.3s">{{ $activities->content }}</p>
          </div>
        </div>
      </div>
      <div class="row mt-50">
        @foreach($services as $service)
            @php
                $extraData = json_decode($service->extra_data, true);
            @endphp
            <div class="col-md-3 feature-box text-left radius-icon wow fadeTop" data-wow-delay="0.1s"> <i class="icofont {{ $extraData['icon'] ?? 'icofont-gear' }} font-50px gradient-color"></i>
            <h4 class="text-uppercase white-color josefin-font">{{ $service->content_key }}</h4>
            <p>{{ $service->content_value }}</p>
            </div>
        @endforeach
      </div>
    </div>
</section>
@endif
