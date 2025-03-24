@php
    use App\Models\Section;
    use App\Models\SectionContent;

    $tiktokSection = Section::where('name', 'tiktok')->first();
    $tiktokPosts = SectionContent::where('section_id', $tiktokSection->id ?? null)
    ->limit(3) // Alternatif lain untuk membatasi hasil query
    ->get();
@endphp


@if($tiktokSection && $tiktokSection->is_active)
<section id="tiktok">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 section-heading">
                <h2 class="text-uppercase wow fadeTop" data-wow-delay="0.1s">{{ $tiktokSection->title }}</h2>
                <hr class="blue-bg">
                <h4 class="text-uppercase default-color wow fadeTop" data-wow-delay="0.2s">{{ $tiktokSection->description }}</h4>
            </div>
        </div>
        <div class="row mt-50">
            @php
                $tiktokCount = count($tiktokPosts);
                $defaultPost = [
                    'embed_url' => '#',
                    'image' => asset('landing/images/sns.png'),
                    'username' => '@boyprojects',
                    'profile_url' => 'https://www.tiktok.com/@boyprojects?_t=8holwJrP1zM&_r=1',
                ];
            @endphp

            @foreach($tiktokPosts as $post)
                @php
                    $extraData = json_decode($post->extra_data, true);
                @endphp
                <div class="col-md-4 col-sm-6 col-xs-12 wow fadeTo">
                    <div class="post">
                        <div class="post-img">
                            <blockquote class="tiktok-embed"
                                        cite="{{ $extraData['embed_url'] ?? '#' }}"
                                        data-video-id="{{ $extraData['video_id'] ?? '' }}"
                                        style="max-width: 100%; min-width: 325px;">
                                <section> <a href="{{ $extraData['embed_url'] ?? '#' }}">TikTok Post</a> </section>
                            </blockquote>
                        </div>
                    </div>
                </div>
            @endforeach

            @for($i = $tiktokCount; $i < 3; $i++)
                <div class="col-md-4 col-sm-6 col-xs-12 wow fadeTo">
                    <div class="post">
                        <div class="post-img">
                            <img class="img-responsive" src="{{ $defaultPost['image'] }}" alt=""/>
                        </div>
                        <div class="post-info">
                            <h3><a href="{{ $defaultPost['profile_url'] }}">Watch More</a></h3>
                            <h6>{{ $defaultPost['username'] }}</h6>
                            <a class="readmore dark-color" href="{{ $defaultPost['profile_url'] }}">
                                <span>Follow Me</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endfor

        </div>
    </div>
</section>
@endif


@section('scripts')

@endsection

