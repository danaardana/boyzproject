@php
use App\Models\Section;
use App\Models\SectionContent;

$testimonials = Section::where('name', 'testimonials')->first();
$reviews = SectionContent::where('section_id', $testimonials->id ?? null)->get();
@endphp

@if($testimonials && $testimonials->is_active)
<section class="parallax-bg-18 fixed-bg" data-stellar-background-ratio="0.2" id="testimonials">
  <div class="overlay-bg"></div>
  <div class="container">
    <div class="row">
      <div class="col-sm-8 section-heading white-color text-center mx-auto">
        <h2 class="wow fadeTop" data-wow-delay="0.1s">{{ $testimonials->title }}</h2>
        <h4 class="text-uppercase wow fadeTop" data-wow-delay="0.2s">{{ $testimonials->description }}</h4>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="slick testimonial" style="display: flex; align-items: center; padding: 30px; background: #fff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        @foreach($reviews as $review)
          @php
              $extraData = json_decode($review->extra_data, true);
          @endphp
          <div class="testimonial-item text-center p-4 shadow-lg rounded bg-white">
              <!-- Avatar -->
              <img class="img-responsive mx-auto d-block rounded-circle"
                   src="{{ asset($extraData['image'] ?? 'landing/images/team/avatar-1.jpg') }}" 
                   alt="testimonial-avatar" 
                   style="width: 80px; height: 80px; margin-bottom: 10px;"/>
              
              <!-- Nama -->
              <h5 class="font-weight-bold mb-1">
                  {{ Str::limit($review->content_key, 30, '...') }}
              </h5>
              
              <!-- Produk -->
              <p class="text-muted" style="font-size: 12px;">
                  {{ $extraData['variation'] ?? '' }}
              </p>
              
              <!-- Testimoni -->
              <h4 class="mt-2 text-dark">
                  {{ $review->content_value }}
              </h4>
          </div>
        @endforeach
        </div>
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
