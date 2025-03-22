@php
use App\Models\Section;
use App\Models\SectionContent;

$testimonials = Section::where('name', 'testimonials')->first();
$reviews = SectionContent::where('section_id', $testimonials->id ?? null)->get();
@endphp

@if($testimonials && $testimonials->is_active)
<section class="parallax-bg-19" id="testimonials">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 section-heading">
          <h2 class="wow fadeTop josefin-font" data-wow-delay="0.1s">{{ $testimonials->title }}</h2>
          <h4 class="text-uppercase wow fadeTop" data-wow-delay="0.2s">{{ $testimonials->description }}</h4>
        </div>
      </div>
      <div class="row">
          <div class="slick testimonial-carousel testimonial-style-01">
          @foreach($reviews as $review)
          @php
              $extraData = json_decode($review->extra_data, true);
          @endphp
            <div class="col-md-6 col-sm-6 col-xs-12">
              <!--=== Slide ===-->
              <div class="testimonial-item">
                <div class="testimonial-content">
                  <div class="content-wrap">
                    <div class="info">
                      <div class="image">
                        <img class="img-responsive img-circle" src="{{ asset($extraData['image'] ?? 'default.jpg') }}" alt="avatar"/>
                      </div>
                      <div class="cite">
                        <h6 class="name">{{ Str::limit($review->content_key, 30, '...') }}</h6>
                        <span class="position">{{ $extraData['variation'] ?? '' }}</span>
                      </div>
                    </div>
                    <div class="content">
                      <div class="text">
                        <i class="icofont icofont-quote-left font-20px default-color mt-20 mr-10"></i>
                        <span> {{ $review->content_value }} </span>
                        <i class="icofont icofont-quote-right font-20px default-color mt-20 mr-10"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>            
        @endforeach
        </div>
      </div>
    </div>
  </section>
@endif

@push('scripts')
<!-- Slick Slider Script -->
<script>
  $(document).ready(function(){
      $('.slick.testimonial').slick({
          slidesToShow: 1,  // Hanya satu per slide
          slidesToScroll: 1,
          autoplay: true,
          autoplaySpeed: 4000,
          arrows: false,
          dots: true,
          adaptiveHeight: true
      });
  });
</script>
@endpush
