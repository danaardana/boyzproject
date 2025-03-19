@php
use App\Models\Section;
use App\Models\SectionContent;

$testimonials = Section::where('name', 'testimonials')->first();
$reviews = SectionContent::where('section_id', $testimonials->id ?? null)->get();
@endphp

@if($testimonials && $testimonials->is_active)
<section class="parallax-bg-18 fixed-bg" data-stellar-background-ratio="0.2">
  <div class="overlay-bg"></div>
  <div class="container">
    <div class="row">
      <div class="col-sm-8 section-heading white-color">
        <h2 class="wow fadeTop" data-wow-delay="0.1s">{{ $testimonials->title }}</h2>
        <h4 class="text-uppercase wow fadeTop" data-wow-delay="0.2s">{{ $testimonials->description }}</h4>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="slick testimonial">
          @foreach($reviews as $review)
          <div class="testimonial-item">
            <div class="testimonial-content"> 
              <img class="img-responsive img-circle" src="{{ asset($review->extra_data['image'] ?? 'assets/images/team/avatar-default.jpg') }}" alt="testimonial-avatar"/>
              <h5>{{ $review->content_key }}</h5>
              <p>{{ $review->extra_data['variation'] ?? '' }}</p>
              <h4>{{ $review->content_value }}</h4>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>
@endif