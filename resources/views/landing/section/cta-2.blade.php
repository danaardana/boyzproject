@php
    use App\Models\Section;

    $cta = Section::where('name', 'cta')->first();
    
@endphp

@if ($cta && $cta->is_active)    
    <section class="parallax-bg-2 fixed-bg" data-stellar-background-ratio="0.2">
    <div class="overlay-bg-dark"></div>
    <div class="container">
      <div class="row">
        <div class="col-md-6 text-center white-color col-md-offset-3">
          <h2 class="cardo-font font-50px wow fadeTop" data-wow-delay="0.1s">{{ $cta->title }}</h2>
          <h4 class="text-uppercase dark-color wow fadeTop mt-30" data-wow-delay="0.2s">{{ $cta->description }}</h4>
          <p class="font-20px mt-20 line-height-30 wow fadeTop" data-wow-delay="0.3s">{{ $cta->content }}</p>
          <p class="mt-30 wow fadeTop" data-wow-delay="0.4s"><a class="btn btn-color btn-circle" 
            href="{{ $cta->button_link }}" >{{ $cta->button_text }}</a></p>
        </div>
      </div>
    </div>
  </section>
@endif