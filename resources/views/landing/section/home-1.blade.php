@php
    use App\Models\Section;
    use App\Models\SectionContent;

    $homeSection = Section::where('name', 'home')->first();
    $slides = $homeSection ? SectionContent::where('section_id', $homeSection->id)->get() : collect();

    // Debug jika masih tidak tampil
    // dd($homeSection, $slides);
@endphp

<!--=== Flex Slider Start ======-->
<section class="pt-0 pb-0" id="home">
    <div class="slider-bg flexslider">
        <ul class="slides">
            @if($slides->isEmpty())
                <!-- Default Slide jika tidak ada data -->
                <li>
                    <div class="slide-img" style="background:url({{ asset('landing/images/slides/home-bg-1.jpg') }}) center center / cover scroll no-repeat;"></div>
                    <div class="hero-text-wrap">
                        <div class="hero-text white-color">
                            <div class="container text-center">
                                <h2 class="font-400">Welcome</h2>
                                <h1 class="text-uppercase font-700 font-80px">Welcome to Boy Projects</h1>
                                <h3 class="font-400">Jual beli sparepart motor & pemasangan terpercaya</h3>
                                <p class="text-center mt-30">
                                    <a class="btn btn-color btn-circle btn-animate" href="http://shopee.co.id/boyprojectsasli">
                                        <span>Learn More <i class="icofont icofont-arrow-right"></i></span>
                                    </a>
                                    <a class="btn btn-outline-white btn-circle" href="https://wa.me/08211990442">Contact Us</a>
                                </p>
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
                        <div class="hero-text-wrap">
                            <div class="hero-text white-color">
                                <div class="container text-center">
                                    <h2 class="font-400">{{ $slide->content_key }}</h2>
                                    <h1 class="text-uppercase font-700 font-80px">{{ $slide->content_value }}</h1>
                                    <h3 class="font-400">{{ $extraData['description'] ?? '' }}</h3>
                                    <p class="text-center mt-30">
                                        <a class="btn btn-color btn-circle btn-animate" href="{{ $extraData['button_link'] ?? '#' }}">
                                            <span>{{ $extraData['button_text'] ?? 'Learn More' }} <i class="icofont icofont-arrow-right"></i></span>
                                        </a>
                                        <a class="btn btn-outline-white btn-circle" href="{{ $extraData['contact_link'] ?? '#' }}">Contact Us</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</section>
<!--=== Flex Slider End ======-->
