@php
use App\Models\Section;
use App\Models\SectionContent;

$pricing = Section::where('name', 'pricing')->first();
$plans = SectionContent::where('section_id', $pricing->id ?? null)->get();
@endphp

@if($pricing && $pricing->is_active)
<section id="pricing">
  <div class="container">
    <div class="row">
      <div class="col-sm-8 section-heading">
        <h2 class="text-uppercase wow fadeTop" data-wow-delay="0.1s">{{ $pricing->title }}</h2>
        <h4 class="text-uppercase wow fadeTop" data-wow-delay="0.2s">{{ $pricing->description }}</h4>
      </div>
    </div>
    <div class="row mt-50">
    @foreach($plans as $plan)
    @php
        // Decode content_value untuk mendapatkan semua data
        $contentData = json_decode($plan->content_value, true) ?? [];
        // Ambil fitur-fitur dari content_value
        $features = $contentData['features'] ?? [];
    @endphp
    <div class="col-md-3 pricing-table col-sm-6 wow fadeTop" data-wow-delay="0.{{ $loop->iteration }}s">
        <div class="pricing-box">
            <i class="icofont {{ $contentData['icon'] ?? 'icofont-ui-price-tag' }}"></i>
            <h4>{{ $plan->content_key }}</h4>
            <h2><sup>$</sup><span>{{ $contentData['price'] ?? '0.00' }}</span></h2>
            <ul>
                @foreach($features as $feature)
                    <li>{{ $feature }}</li>
                @endforeach
            </ul>
            <div class="pricing-box-bottom">
                <a href="#" class="btn btn-color btn-rounded"><span>Purchase Now</span></a>
            </div>
        </div>
    </div>
@endforeach

    </div>
  </div>
</section>
@endif
