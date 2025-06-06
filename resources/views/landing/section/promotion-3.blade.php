@php
use App\Models\Section;
use App\Models\SectionContent;

$promotion = Section::where('name', 'promotion')->first();
$members = SectionContent::where('section_id', $promotion->id ?? null)->get();
@endphp

@if($promotion && $promotion->is_active)
<section class="white-bg promotion-style-02" id="promotion">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 section-heading">
          <h2 class="text-uppercase wow fadeTop" data-wow-delay="0.1s">Meet <span class="font-100">Our promotion</span></h2>
          <h4 class="text-uppercase source-font wow fadeTop" data-wow-delay="0.2s">- We Are Stronger -</h4>
        </div>
      </div>
      <div class="row mt-50">   
        @foreach($members as $promo)
        @php
            $extraData = json_decode($promo->extra_data, true);
        @endphp
        <div class="col-md-3 col-sm-6 col-xs-12 wow fadeTop" data-wow-delay="0.3s">
          <div class="promotion-member-container gallery-image-hover border-radius-15"> <img src="{{ asset($extraData['image'] ?? 'landing/images/promotion/default.jpg') }}" class="img-responsive" alt="promotion-01">
            <div class="member-caption">
              <div class="member-description text-center">
                <div class="member-description-wrap">
                  <h4 class="member-title">{{ $promo->content_key }}</h4>
                  <p class="member-subtitle">{{ $promo->content_value }}</p>
                  <ul class="member-icons">                  
                      @foreach(($extraData['social_links'] ?? []) as $icon => $link)
                        <li class="social-icon"><a href="{{ $link }}"><i class="{{ $icon }}"></i></a></li>
                      @endforeach
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
  
@endif