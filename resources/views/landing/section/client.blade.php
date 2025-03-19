@php
    use App\Models\Section;
    use App\Models\SectionContent;

    $clientsSection = Section::where('name', 'client')->first();
    $clients = SectionContent::where('section_id', $clientsSection->id ?? null)->get();
@endphp

@if($clientsSection && $clientsSection->is_active)
<section class="pt-50 pb-50 white-bg" id="client">
    <div class="container">
        <div class="row">
            <div id="client-slider" class="owl-carousel">
                @foreach($clients as $client)
                    @php
                        $extraData = json_decode($client->extra_data, true);
                    @endphp
                    <div class="client-logo"> 
                        <img class="img-responsive" src="{{ asset($extraData['image'] ?? 'landing/images/clients/default.png') }}" alt="{{ $client->content_key }}"/> 
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
