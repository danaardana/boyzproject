@php
use App\Models\Section;
use App\Models\SectionContent;

$team = Section::where('name', 'team')->first();
$members = SectionContent::where('section_id', $team->id ?? null)->get();
@endphp

@if($team && $team->is_active)
<section class="white-bg" id="team">
  <div class="container">
    <div class="row">
      <div class="col-sm-8 section-heading">
        <h2 class="text-uppercase wow fadeTop" data-wow-delay="0.1s">{{ $team->title }}</h2>
        <h4 class="text-uppercase wow fadeTop" data-wow-delay="0.2s">{{ $team->description }}</h4>
      </div>
    </div>
    <div class="row mt-50">
      @foreach($members as $member)
      <div class="col-md-3 col-sm-6 col-xs-12 wow fadeTop" data-wow-delay="0.{{ $loop->iteration }}s">
        <div class="team-member-container gallery-image-hover"> 
          <img src="{{ asset($member->extra_data['image'] ?? 'landing/images/team/default.jpg') }}" class="img-responsive" alt="team-member">
          <div class="member-caption">
            <div class="member-description text-center">
              <div class="member-description-wrap">
                <h4 class="member-title">{{ $member->content_key }}</h4>
                <p class="member-subtitle">{{ $member->content_value }}</p>
                <ul class="member-icons">
                  @foreach(json_decode($member->extra_data['social_links'] ?? '[]', true) as $icon => $link)
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