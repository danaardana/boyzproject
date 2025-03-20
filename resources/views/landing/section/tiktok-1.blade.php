@php
    use App\Models\Section;
    use App\Models\SectionContent;

    $tiktokSection = Section::where('name', 'tiktok')->first();
    $tiktokPosts = SectionContent::where('section_id', $tiktokSection->id ?? null)->get();
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
            <div class="col-md-12 remove-padding">
                <div class="owl-carousel blog-slider">
                    @foreach($tiktokPosts as $post)
                        @php
                            $extraData = json_decode($post->extra_data, true);
                        @endphp
                        <div class="post">
                            <div class="post-img">
                                <blockquote class="tiktok-embed"
                                            cite="{{ $extraData['embed_url'] ?? '#' }}"
                                            data-video-id="{{ $extraData['video_id'] ?? '' }}"
                                            style="max-width: 100%; min-width: 325px;">
                                    <section> <a href="{{ $extraData['embed_url'] ?? '#' }}">TikTok Post</a> </section>
                                </blockquote>
                                <script async src="https://www.tiktok.com/embed.js"></script>
                            </div>
                        </div>
                    @endforeach

                    <!-- TikTok Embed -->
                    <div class="post">
                        <div class="post-img">
                        <blockquote class="tiktok-embed" cite="https://www.tiktok.com/@boyprojects/video/7482575523772779831" 
                            data-video-id="7482575523772779831" style="max-width: 605px;min-width: 325px;">
                            <section> <a target="_blank" href="https://www.tiktok.com/@boyprojects/video/7482575523772779831"> Watch on TikTok</a> </section>
                        </blockquote>
                        <script async src="https://www.tiktok.com/embed.js"></script>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endif
