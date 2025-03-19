@php
use App\Models\Section;

$who = Section::where('name', 'who')->first();
@endphp

@if($who && $who->is_active)
<section class="first-ico-box" id="about">
  <div class="dn-bg-lines">
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-8 section-heading">
        <h2 class="text-uppercase wow fadeTop" data-wow-delay="0.1s">{{ $who->title }}</h2>
        <h4 class="text-uppercase wow fadeTop" data-wow-delay="0.2s">{{ $who->description }}</h4>
        <div class="mt-30 wow fadeTop" data-wow-delay="0.3s">
          <p>{{ $who->content }}</p>
        </div>
      </div>
    </div>
  </div>
</section>
@endif