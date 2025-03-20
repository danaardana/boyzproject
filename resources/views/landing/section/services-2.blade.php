@php
    use App\Models\Section;
    use App\Models\SectionContent;

    $services = Section::where('name', 'services')->first();
    $service_items = SectionContent::where('section_id', $services->id ?? null)->get();
@endphp

@if ($services && $services->is_active)
    @php
        $text = trim($services->title);
        $length = mb_strlen($text);
        $middle = intval($length / 2);

        // Cari posisi terdekat untuk memotong di tengah tanpa memecah kata
        $breakPoint = strrpos(substr($text, 0, $middle), ' ');

        // Jika tidak ditemukan spasi, pakai titik tengah biasa
        $part1 = substr($text, 0, $breakPoint ?: $middle);
        $part2 = substr($text, $breakPoint ?: $middle);
    @endphp
    <section class="first-ico-box" id="services">
        @php
            $service_items_array = $service_items->toArray(); // Konversi collection ke array
            $totalItems = count($service_items_array);
            $half = ceil($totalItems / 2);

            $service_items1 = array_slice($service_items_array, 0, $half);
            $service_items2 = array_slice($service_items_array, $half);
        @endphp
        @if ($totalItems < 4)
        <div class="container">            
            <div class="row">
                <div class="col-sm-8 section-heading">
                    <h2 class="wow fadeTop text-uppercase" data-wow-delay="0.1s">{{ $part1 }}<span
                            class="font-100">{{ $part2 }}</span></h2>
                    <h4 class="text-uppercase source-font wow fadeTop" data-wow-delay="0.2s">11 {{ $services->description }}
                    </h4>
                </div>
            </div>
            <div class="row mt-50 service-style-one">
                @foreach ($service_items as $item)
                    @php
                        $extraData = json_decode($item->extra_data, true);
                    @endphp
                    <div class="col-md-4 text-center wow fadeTop" data-wow-delay="0.{{ $loop->iteration }}s">
                        <div class="feature-box">
                            <i
                                class="icofont {{ $extraData['icon'] ?? 'icofont-gear' }} font-50px gradient-color"></i>
                            <h3>{{ $item->content_key }}</h3>
                            <p>{{ $item->content_value }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @elseif ($totalItems == 4)
        <div class="container">            
            <div class="row">
                <div class="col-sm-8 section-heading">
                    <h2 class="wow fadeTop text-uppercase" data-wow-delay="0.1s">{{ $part1 }}<span
                            class="font-100">{{ $part2 }}</span></h2>
                    <h4 class="text-uppercase source-font wow fadeTop" data-wow-delay="0.2s">{{ $services->description }}
                    </h4>
                </div>
            </div>
            <div class="row mt-50 service-style-one">
                @foreach ($service_items as $item)
                    @php
                        $extraData = json_decode($item->extra_data, true);
                    @endphp
                    <div class="col-md-3 text-center wow fadeTop" data-wow-delay="0.{{ $loop->iteration }}s">
                        <div class="feature-box">
                            <i
                                class="icofont {{ $extraData['icon'] ?? 'icofont-gear' }} font-50px gradient-color"></i>
                            <h3>{{ $item->content_key }}</h3>
                            <p>{{ $item->content_value }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="container">           
            <div class="row">
                <div class="col-sm-8 section-heading">
                    <h2 class="wow fadeTop text-uppercase" data-wow-delay="0.1s">{{ $part1 }}<span
                            class="font-100">{{ $part2 }}</span></h2>
                    <h4 class="text-uppercase source-font wow fadeTop" data-wow-delay="0.2s">{{ $services->description }}
                    </h4>
                </div>
            </div>
            <div class="row mt-50 service-style-one">
                @foreach ($service_items1 as $item1)
                    @php
                        $extraData = json_decode($item1->extra_data, true);
                    @endphp
                    <div class="col-md-3 text-center wow fadeTop" data-wow-delay="0.{{ $loop->iteration }}s">
                        <div class="feature-box">
                            <i
                                class="icofont {{ $extraData['icon'] ?? 'icofont-gear' }} font-50px gradient-color"></i>
                            <h3>{{ $item1->content_key }}</h3>
                            <p>{{ $item1->content_value }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="container">     

            <div class="row mt-50 service-style-one">
                @foreach ($service_items2 as $item2)
                    @php
                        $extraData = json_decode($item2->extra_data, true);
                    @endphp
                    <div class="col-md-3 text-center wow fadeTop" data-wow-delay="0.{{ $loop->iteration }}s">
                        <div class="feature-box">
                            <i
                                class="icofont {{ $extraData['icon'] ?? 'icofont-gear' }} font-50px gradient-color"></i>
                            <h3>{{ $item2->content_key }}</h3>
                            <p>{{ $item2->content_value }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        </div>
    </section>
@endif
