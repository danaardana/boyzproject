@php
use App\Models\Section;
use App\Models\SectionContent;

$portfolio = Section::where('name', 'portfolio')->first();
$portfolio_items = SectionContent::where('section_id', $portfolio->id ?? null)->get();
@endphp

@if($portfolio && $portfolio->is_active)
<section class="pt-0 pb-0 white-bg" id="work">
  <div class="container-fluid">
    <div class="row">
      <div class="portfolio-container text-center">
        <ul id="portfolio-filter" class="list-inline wow fadeTop" data-wow-delay="0.1s">
          <li class="active" data-group="all">All</li>
          @foreach($portfolio_items->unique('content_key') as $category)
          <li data-group="{{ $category->content_key }}">{{ ucfirst($category->content_key) }}</li>
          @endforeach
        </ul>
        <ul id="portfolio-grid" class="three-column hover-two">
          @foreach($portfolio_items as $item)
          <li class="portfolio-item wow fadeIn" data-wow-delay="0.1s" data-groups='["all", "{{ $item->content_key }}"]'>
            <div class="portfolio gallery-image-hover">
              <div class="dark-overlay"></div>
              <img src="{{ asset($item->content_value) }}" alt="">
              <div class="portfolio-wrap">
                <div class="portfolio-description">
                  <h3 class="portfolio-title">{{ $item->extra_data['title'] ?? 'Portfolio Item' }}</h3>
                  <a href="{{ $item->extra_data['link'] ?? '#' }}" class="links">{{ ucfirst($item->content_key) }}</a>
                </div>
                <ul class="portfolio-details">
                  <li><a class="alpha-lightbox" href="{{ asset($item->content_value) }}"><i class="icofont icofont-search-1"></i></a></li>
                  <li><a href="{{ $item->extra_data['link'] ?? '#' }}"><i class="icofont icofont-link-alt"></i></a></li>
                </ul>
              </div>
            </div>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</section>
@endif
