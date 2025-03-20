@php
use App\Models\Section;
use App\Models\SectionContent;

$services = Section::where('name', 'services')->first();
$service_items = SectionContent::where('section_id', $services->id ?? null)->get();
@endphp

@if($services && $services->is_active)
<section id="services">
  <div class="container">
    <div class="row">
      <div class="col-sm-8 section-heading">
        <h2 class="text-uppercase wow fadeTop" data-wow-delay="0.1s">{{ $services->title }}</h2>
        <h4 class="text-uppercase wow fadeTop" data-wow-delay="0.2s">{{ $services->description }}</h4>
      </div>
    </div>
    <div class="row mt-50">
    @foreach($service_items as $item)
      @php
          $extraData = json_decode($item->extra_data, true);
      @endphp
      <div class="col-md-3 feature-box text-center col-sm-6 wow fadeTop" data-wow-delay="0.{{ $loop->iteration }}s">
          <i class="icofont {{ $extraData['icon'] ?? 'icofont-gear' }} font-40px dark-icon white-bg-icon circle-icon fade-icon"></i>
          <h4 class="upper-case">{{ $item->content_key }}</h4>
          <p>{{ $item->content_value }}</p>
      </div>
    @endforeach

    </div>
  </div>
</section>
@endif