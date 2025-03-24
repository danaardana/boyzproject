@php
    use App\Models\Section;
    use App\Models\SectionContent;
    
    $instagramSection = Section::where('name', 'instagram')->first();
    $instagramPosts = SectionContent::where('section_id', $instagramSection->id ?? null)
    ->limit(3) // Alternatif lain untuk membatasi hasil query
    ->get();
@endphp

@if($instagramSection && $instagramSection->is_active)
<section id="instagram">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 section-heading">
                <h2 class="text-uppercase wow fadeTop" data-wow-delay="0.1s">{{ $instagramSection->title }}</h2>
                <hr class="blue-bg">
                <h4 class="text-uppercase default-color wow fadeTop" data-wow-delay="0.2s">{{ $instagramSection->description }}</h4>
            </div>
        </div>
        <div class="row mt-50">
            @php
                $instagramCount = count($instagramPosts);
                $defaultPost = [
                    'embed_url' => '#',
                    'image' => asset('landing/images/sns.png'),
                    'username' => '@boyprojects',
                    'profile_url' => 'https://www.tiktok.com/@boyprojects?_t=8holwJrP1zM&_r=1',
                ];
            @endphp

            @foreach($instagramPosts as $post)
                <div class="col-md-4 col-sm-6 col-xs-12 wow fadeTo">
                    @php
                        $extraData = json_decode($post->extra_data, true);
                    @endphp
                    <div class="post">
                        <div class="post-img">
                            <blockquote class="instagram-media"
                                        data-instgrm-permalink="{{ $extraData['embed_url'] ?? '#' }}"
                                        data-instgrm-version="14">
                            </blockquote>
                            <script async src="https://www.instagram.com/embed.js"></script>
                        </div>
                    </div>
                </div>
            @endforeach

            @for($i = $instagramCount; $i < 3; $i++)
                <div class="col-md-4 col-sm-6 col-xs-12 wow fadeTo">
                    <div class="post">
                        <div class="post-img">
                            <img class="img-responsive" src="{{ $defaultPost['image'] }}" alt=""/>
                        </div>
                        <div class="post-info">
                            <h3><a href="{{ $defaultPost['profile_url'] }}">Explore</a></h3>
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
