@php
    use App\Models\Section;
    use App\Models\SectionContent;

    // Ambil section portofolio
    $portfolio = Section::where('name', 'portofolio')->first();

    // Ambil isi portofolio dari section_contents berdasarkan section_id
    $portfolioItems = SectionContent::where('section_id', $portfolio->id ?? null)->get();

    // Ambil daftar kategori unik dari semua item portofolio
    $categories = collect();
    foreach ($portfolioItems as $item) {
        $extraData = json_decode($item->extra_data, true);
        if (!empty($extraData['categories'])) {
            $categories = $categories->merge(explode(',', $extraData['categories']));
        }
    }
    $categories = $categories->unique()->values();
@endphp

@if($portfolio && $portfolio->is_active)
<section class="pt-100 pt-100">
  <div class="container-fluid">
    <div class="row">
      <div class="portfolio-container text-center">
        <!-- Filter Kategori -->
        <ul id="portfolio-filter" class="list-inline filter-transparent">
          <li class="active" data-group="all">All</li>
          @foreach($categories as $category)
            <li data-group="{{ strtolower(trim($category)) }}">{{ ucfirst(trim($category)) }}</li>
          @endforeach
        </ul>

        <!-- Daftar Portfolio -->
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
                <img src="{{ asset($extraData['image'] ?? 'landing/images/portfolio/default.jpg') }}" alt="Portfolio">
                <div class="portfolio-wrap">
                  <div class="portfolio-description">
                    <h3 class="portfolio-title">{{ $item->content_key }}</h3>
                    <a href="#" class="links">{{ implode(', ', $categories) }}</a>
                  </div>
                  <ul class="portfolio-details">
                    <li>
                      <a class="alpha-lightbox" href="{{ asset($extraData['image'] ?? 'landing/images/portfolio/default.jpg') }}">
                        <i class="icofont icofont-search-1"></i>
                      </a>
                    </li>
                    <li>
                      <a href="{{ $extraData['link'] ?? '#' }}">
                        <i class="icofont icofont-link-alt"></i>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
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
