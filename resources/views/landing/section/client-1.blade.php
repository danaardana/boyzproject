@php
use App\Models\Section;
use App\Models\SectionContent;

$clients = Section::where('name', 'client')->first();
$members = SectionContent::where('section_id', $clients->id ?? null)->get();
$categoryCount = $members->count();
@endphp

<section class="pt-50 pb-50" id="client">
  <div class="container">
    <div class="row">
      <div id="client-slider" class="owl-carousel">   
        @foreach($members as $client)
        @php
            $extraData = json_decode($client->extra_data, true);
        @endphp
        <div class="client-logo"> <img class="img-responsive" src="{{ asset($extraData['image'] ?? 'landing/images/categories/default.png') }}" alt="{{ $client->content_key }}"/> </div>
        @endforeach
        <div class="client-logo"> <img class="img-responsive" src="assets/images/clients/1.png" alt="01"/> </div>
        <div class="client-logo"> <img class="img-responsive" src="assets/images/clients/2.png" alt="02"/> </div>
        <div class="client-logo"> <img class="img-responsive" src="assets/images/clients/3.png" alt="03"/> </div>
        <div class="client-logo"> <img class="img-responsive" src="assets/images/clients/4.png" alt="04"/> </div>
        <div class="client-logo"> <img class="img-responsive" src="assets/images/clients/5.png" alt="05"/> </div>
      </div>
    </div>
  </div>
</section>