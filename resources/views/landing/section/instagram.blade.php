@php
    use App\Models\Section;
    use App\Models\SectionContent;
    
    $instagramSection = Section::where('name', 'instagram')->first();
    $instagramPosts = SectionContent::where('section_id', $instagramSection->id ?? null)->get();
@endphp

@if($instagramSection && $instagramSection->is_active)
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-8 section-heading">
                <h2 class="text-uppercase wow fadeTop" data-wow-delay="0.1s">{{ $instagramSection->title }}</h2>
                <hr class="blue-bg">
                <h4 class="text-uppercase default-color wow fadeTop" data-wow-delay="0.2s">{{ $instagramSection->description }}</h4>
            </div>
        </div>
        <div class="row mt-50">
            <div class="col-md-12 remove-padding">
                <div class="owl-carousel blog-slider">
                    @foreach($instagramPosts as $post)
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
