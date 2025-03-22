@php
use App\Models\Section;
use App\Models\SectionContent;

$team = Section::where('name', 'team')->first();
$members = SectionContent::where('section_id', $team->id ?? null)->get();
@endphp

@if($team && $team->is_active)
<section class="white-bg team-style-02" id="team">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 section-heading">
          <h2 class="text-uppercase wow fadeTop" data-wow-delay="0.1s">Meet <span class="font-100">Our Team</span></h2>
          <h4 class="text-uppercase source-font wow fadeTop" data-wow-delay="0.2s">- We Are Stronger -</h4>
        </div>
      </div>
      <div class="row mt-50">   
        @foreach($members as $member)
        @php
            $extraData = json_decode($member->extra_data, true);
        @endphp
        <div class="col-md-3 col-sm-6 col-xs-12 wow fadeTop" data-wow-delay="0.3s">
          <div class="team-member-container gallery-image-hover border-radius-15"> <img src="{{ asset($extraData['image'] ?? 'landing/images/team/default.jpg') }}" class="img-responsive" alt="team-01">
            <div class="member-caption">
              <div class="member-description text-center">
                <div class="member-description-wrap">
                  <h4 class="member-title">{{ $member->content_key }}</h4>
                  <p class="member-subtitle">{{ $member->content_value }}</p>
                  <ul class="member-icons">                  
                      @foreach(($extraData['social_links'] ?? []) as $icon => $link)
                        <li class="social-icon"><a href="{{ $link }}"><i class="{{ $icon }}"></i></a></li>
                      @endforeach
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
  
@endif