@php
    use App\Models\Section;
    use App\Models\SectionContent;

    $portfolio = Section::where('name', 'portofolio')->first();
    $portfolioItems = SectionContent::where('section_id', $portfolio->id ?? null)->get();


@endphp

@if($portfolio && $portfolio->is_active)
<section class="pt-100 pt-100">
    <div class="container">
      <div class="row">
        <div class="portfolio-container text-center">
          <ul id="portfolio-filter" class="list-inline filter-transparent">
            <li class="active" data-group="all">All</li>
            <li data-group="design">Design</li>
            <li data-group="web">Web</li>
            <li data-group="branding">Branding</li>
            <li data-group="print">Print</li>
          </ul>
          <ul id="portfolio-grid" class="four-column hover-two">            
          @foreach($portfolioItems as $item)
            @php
                $extraData = json_decode($item->extra_data, true);
                $categories = isset($extraData['categories']) ? explode(',', $extraData['categories']) : [];
                $dataGroups = json_encode(array_merge(['all'], $categories));
            @endphp
            <li class="portfolio-item" data-groups='{{ $dataGroups }}'>
              <div class="portfolio">
                <div class="dark-overlay"></div>
                <img src="{{ asset($extraData['image'] ?? 'landing/images/portfolio/default.jpg') }}" alt="">
                <div class="portfolio-wrap">
                  <div class="portfolio-description">
                    <h3 class="portfolio-title">{{ $item->content_key }}s</h3>
                    <a href="{{ $extraData['link'] ?? '#' }}" class="links">{{ implode(', ', $categories) }}</a> </div>
                  <!--=== /.project-info ===-->
                  <ul class="portfolio-details">
                    <li><a class="alpha-lightbox" href="{{ asset($extraData['image'] ?? 'landing/images/portfolio/default.jpg') }}"><i class="icofont icofont-search-1"></i></a></li>
                    <li><a href="{{ $extraData['link'] ?? '#' }}"><i class="icofont icofont-link-alt"></i></a></li>
                  </ul>
                </div>
              </div>
              <!--=== /.portfolio ===-->
            </li>   
            @endforeach
          </ul>
        </div>
      </div>
      <div class="row mt-100">
        <p class="text-center"><a class="btn btn-color btn-circle">Start a Project</a></p>
      </div>
    </div>
  </section>
  @endif