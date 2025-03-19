@php
$counter = \App\Models\Section::where('name', 'counter')->first();
$counters = \App\Models\SectionContent::where('section_id', $counter->id ?? null)->get();
@endphp

@if($counter && $counter->is_active)
<section class="dark-bg pt-80 pb-80" id="counter">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 text-center">
        <p>{{ $counter->description }}</p> <!-- Menggunakan kolom description dari sections -->
      </div>
      @foreach($counters as $item)
      <div class="col-md-3 counter text-center col-sm-6 wow fadeTop" data-wow-delay="0.1s">
        <h2 class="count white-color font-700">{{ $item->content_value }}</h2>
        <h3>{{ $item->content_key }}</h3>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif
