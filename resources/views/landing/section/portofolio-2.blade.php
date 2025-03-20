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
<section class="pt-0 pb-0">
    <div class="container-fluid">
      <div class="row">
        <div class="portfolio-container text-center">

          <ul id="portfolio-grid" class="four-column">            
          @foreach($portfolioItems as $item)
            @php
                $extraData = json_decode($item->extra_data, true);
                $categories = isset($extraData['categories']) ? explode(',', $extraData['categories']) : [];
                $dataGroups = json_encode(array_merge(['all'], $categories));
            @endphp
            <li class="portfolio-item wow fadeIn wow fadeIn" data-wow-delay="0.1s" data-groups='{{ $dataGroups }}'>
              <div class="portfolio gallery-image-hover">
                <div class="dark-overlay"></div>
                <img src="{{ asset($extraData['image'] ?? 'landing/images/portfolio/default.jpg') }}" alt="">
                <div class="portfolio-wrap">
                  <div class="portfolio-description">
                    <h3 class="portfolio-title">{{ $item->content_key }}</h3>
                    <a href="{{ $extraData['link'] ?? '#' }}" class="links">{{ implode(', ', $categories) }}</a> </div>
                  <!--=== /.project-info ===-->
                  <ul class="portfolio-details">
                    <li><a class="alpha-lightbox" href="{{ asset($extraData['image'] ?? 'landing/images/portfolio/default.jpg') }}"><i class="icofont icofont-search-1"></i></a></li>
                    <li><a href="{{ $extraData['link'] ?? '#' }}l"><i class="icofont icofont-link-alt"></i></a></li>
                  </ul>
                </div>
              </div>
              <!--=== /.portfolio ===-->
            </li>            
          @endforeach
          </ul>
        </div>
      </div>
    </div>
  </section>
@endif
