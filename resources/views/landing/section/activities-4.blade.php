@php
use App\Models\Section;
use App\Models\SectionContent;

$activities = Section::where('name', 'activities')->first();
$services = SectionContent::where('section_id', $activities->id ?? null)->get();
@endphp

@if($activities && $activities->is_active)
<section id="activiyties" id="activities">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 section-heading">
          <h2 class="text-uppercase wow fadeTop" data-wow-delay="0.1s">{{ $activities->title }}</h2>
          <h4 class="text-uppercase text-uppercase wow fadeTop" data-wow-delay="0.2s">{{ $activities->description }}</h4>
        </div>
      </div>
      <div class="row mt-40">
        <div class="col-md-8 col-md-offset-2">
          <div class="icon-tabs">
            <!--=== Nav tabs ===-->
            <ul class="nav nav-tabs text-center" role="tablist">                    
                @foreach($services as $index => $service)
                    @php
                        $extraData = json_decode($service->extra_data, true);
                    @endphp
                    <li role="presentation" class="{{ $index === 0 ? 'active' : '' }}">
                        <a href="#{{ $service->content_id }}" role="tab" data-toggle="tab">
                            <i class="icofont {{ $extraData['icon'] ?? 'icofont-gear' }}"></i> {{ $service->content_key }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <!--=== Tab panes ===-->
            <div class="tab-content text-center">            
                @foreach($services as $index => $service)
                    @php
                        $extraData = json_decode($service->extra_data, true);
                    @endphp
                    <div role="tabpanel" class="tab-pane fade {{ $index === 0 ? 'active' : '' }}" id="{{ $service->content_id }}">
                        <p>{{ $service->content_value }}</p>
                    </div>              
                @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  @endif