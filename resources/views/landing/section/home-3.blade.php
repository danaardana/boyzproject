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
        <div class="hero-text-wrap video-alpha">
        <div class="hero-text white-color">
            <div class="container text-center">
            <h2 class="white-color text-uppercase font-400">Welcome to Boy Projects</h2>
            <h1 class="white-color text-uppercase font-700">Jual beli sparepart motor & pemasangan terpercaya</h1>
            <h3 class="white-color font-400">Quality Parts | Expert Service | Trusted Mechanics | Ride Smootht | Performance Upgrade</h3>
            <p><a href="http://shopee.co.id/boyprojectsasli" class="btn btn-color btn-circle popup-youtube mt-30">Show More Products</a></p>
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
                <div class="slide-img" style="background:url({{ asset($extraData['image'] ?? 'landing/images/slides/home-bg-1.jpg') }}) center center / cover scroll no-repeat;"></div>
                <div class="hero-text-wrap video-alpha">
                <div class="hero-text white-color">
                    <div class="container text-center">
                    <h2 class="white-color text-uppercase font-400">{{ $slide->content_key }}</h2>
                    <h1 class="white-color text-uppercase font-700">{{ $slide->content_value }}</h1>
                    <h3 class="white-color font-400">{{ $extraData['description'] ?? '' }}</h3>
                    <p><a href="{{ $extraData['button_link'] ?? '#' }}" class="btn btn-color btn-circle popup-youtube mt-30">{{ $extraData['button_text'] ?? 'Show More Products' }}</a></p>
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