@php
    use App\Models\Section;
    use App\Models\SectionContent;

    $homeSection = Section::where('name', 'home')->first();
    $slides = $homeSection ? SectionContent::where('section_id', $homeSection->id)->get() : collect();

    // Debug jika masih tidak tampil
    // dd($homeSection, $slides);
@endphp


@if($homeSection && $homeSection->is_active)
<section class="pt-0 pb-0" id="home">
    <div class="slider-bg flexslider">
      <ul class="slides">
        
        @if($slides->isEmpty())
        <li>
          <div class="slide-img" style="background:url({{ asset('landing/images/slides/home-bg-1.jpg') }}) center center / cover scroll no-repeat;"></div>
          <div class="hero-text-wrap">
            <div class="hero-text white-color">
              <div class="container text-left">
                <h3 class="white-color font-400">Welcome to Boy Projects</h3>
                <h2 class="white-color font-700">Jual beli sparepart motor & pemasangan terpercaya
                  <div class="animate-caption capitalize mt-50">
                    <h2 class="white-color mt-30 text-left"><span class="rotate">Quality Parts | Expert Service | Trusted Mechanics | Ride Smootht | Performance Upgrade</span></h2>
                  </div>
                </h2>
              </div>
            </div>
          </div>
        </li>
        @else
            @foreach($slides as $slide)
                @php
                    $extraData = json_decode($slide->extra_data, true);
                @endphp
                <li>
                <div class="slide-img" style="background:url({{ asset('landing/images/slides/home-bg-1.jpg') }}) center center / cover scroll no-repeat;"></div>
                <div class="hero-text-wrap">
                    <div class="hero-text white-color">
                    <div class="container text-left">
                        <h3 class="white-color font-400">{{ $slide->content_key }}</h3>
                        <h2 class="white-color font-700">{{ $slide->content_value }}
                        <div class="animate-caption capitalize mt-50">
                            <h2 class="white-color mt-30 text-left"><span class="rotate">Quality Parts | Expert Service | Trusted Mechanics | Ride Smootht | Performance Upgrade</span></h2>
                        </div>
                        </h2>
                    </div>
                    </div>
                </div>
                </li>                
            @endforeach
        @endif
      </ul>
    </div>
  </section>
@endif