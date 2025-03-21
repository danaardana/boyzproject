@php
use App\Models\Section;

$about = Section::where('name', 'about')->first();
@endphp

@if($about && $about->is_active)
<section class="white-bg" id="about">
  <div class="col-md-6 col-sm-4 bg-flex bg-flex-right">
    <div class="bg-flex-holder bg-flex-cover" style="background-image: url('{{ asset( $about->image ) }}')"></div>
  </div>
  <div class="container">
    <div class="col-md-5 col-sm-7">
      <h2 class="text-uppercase wow fadeTop" data-wow-delay="0.1s">{{ $about->title }}</h2>
      <h4 class="mt-10 line-height-26 wow fadeTop" data-wow-delay="0.2s">{{ $about->description }}</h4>
      <div class="wow fadeTop" data-wow-delay="0.3s">
        <p class="mt-20">{{ $about->content }}</p>
      </div>
    </div>
  </div>
</section>
@endif