@php
    use App\Models\Section;
    use App\Models\SectionContent;

    $homeSection = Section::where('name', 'home')->first();
    $slides = $homeSection ? SectionContent::where('section_id', $homeSection->id)->get() : collect();

    // Debug jika masih tidak tampil
    // dd($homeSection, $slides);

@endphp


@if ($homeSection && $homeSection->is_active)
    <section class="pt-0 pb-0" id="home">
        <div class="slider-bg flexslider">
            <ul class="slides">
                @if ($slides->isEmpty())
                    <!--=== SLIDE 1 ===-->
                    <li>
                        <div class="slide-img"
                            style="background:url({{ asset('landing/images/slides/home-bg-1.jpg') }}) center center / cover scroll no-repeat;"
                            data-stellar-background-ratio="0.2"></div>
                        <div class="hero-text-wrap">
                            <div class="hero-text white-color">
                                <div class="container text-left">
                                    <h2 class="cardo-font">Welcome to Boy Projects</h2>
                                    <h3 class="cardo-font">Jual beli sparepart motor & pemasangan terpercayas</h3>
                                    <p class="text-left mt-30"><a class="btn btn-dark btn-circle btn-animate"
                                            href="http://shopee.co.id/boyprojectsasli"><span>Show More Products <i
                                                    class="icofont icofont-arrow-right"></i></span></a> </p>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!--=== SLIDE 2 ===-->
                    <li>
                        <div class="hero-text-wrap gradient-overlay-bg">
                            <div class="hero-text white-color">
                                <div class="container text-left">
                                    <h2 class="cardo-font">Upgrade Your Bike, Hassle-Free!</h2>
                                    <h3 class="cardo-font">Get top-quality spare parts and professional installation!
                                    </h3>
                                    <p class="text-left mt-30"><a class="btn btn-outline-white btn-circle"
                                            href="https://wa.me/08211990442">Contact Us </a> </p>
                                </div>
                            </div>
                        </div>
                        <div class="homepage-hero-module">
                            <div class="video-container">
                                <div class="filter"></div>
                                <div class="poster hidden"> <img src="({{ asset('landing/images/video/startup.png') }})"
                                        alt="video-img"> </div>
                            </div>
                        </div>
                    </li>
                @else
                    @foreach ($slides as $slide)
                        @php
                            $extraData = json_decode($slide->extra_data, true);
                            $hasImage = isset($extraData['image']) && !empty($extraData['image']);
                        @endphp

                        @if ($hasImage)
                            <!--=== SLIDE 1 ===-->
                            <li>
                                <div class="slide-img"
                                    style="background:url({{ asset($extraData['image']) }}) center center / cover scroll no-repeat;"
                                    data-stellar-background-ratio="0.2"></div>
                                <div class="hero-text-wrap">
                                    <div class="hero-text white-color">
                                        <div class="container text-left">
                                            <h2 class="cardo-font">{{ $slide->content_key }}</h2>
                                            <h3 class="cardo-font">{{ $slide->content_value }}</h3>
                                            <p class="text-left mt-30">
                                                <a class="btn btn-dark btn-circle btn-animate"
                                                    href="{{ $extraData['button_link'] ?? '#' }}">
                                                    <span>{{ $extraData['button_text'] ?? 'Show More' }} <i
                                                            class="icofont icofont-arrow-right"></i></span>
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @else
                            <!--=== SLIDE 2 ===-->
                            <li>
                                <div class="hero-text-wrap gradient-overlay-bg">
                                    <div class="hero-text white-color">
                                        <div class="container text-left">
                                            <h2 class="cardo-font">{{ $slide->content_key }}</h2>
                                            <h3 class="cardo-font">{{ $slide->content_value }}</h3>
                                            <p class="text-left mt-30">
                                                <a class="btn btn-outline-white btn-circle"
                                                    href="{{ $extraData['contact_link'] ?? '#' }}">Contact Us</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="homepage-hero-module">
                                    <div class="video-container">
                                        <div class="filter"></div>
                                        <div class="poster hidden">
                                            <img src="{{ asset($extraData['video_placeholder'] ?? 'landing/images/video/default.png') }}"
                                                alt="video-img">
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>
    </section>
@endif
