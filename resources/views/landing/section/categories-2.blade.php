@php
use App\Models\Section;
use App\Models\SectionContent;

$categories = Section::where('name', 'categories')->first();
$members = SectionContent::where('section_id', $categories->id ?? null)->get();
$categoryCount = $members->count();
@endphp

@if($categories && $categories->is_active)
<section class="pt-100 pt-100" id="categories" >
  <div class="container-fluid">
    <div class="row">
      <div class="portfolio-container text-center">
        <ul id="portfolio-grid" class="two-column hover-two">      
          @foreach($members as $category)
          @php
              $extraData = json_decode($category->extra_data, true);
          @endphp
          <li class="portfolio-item gutter-space">
            <div class="portfolio">
              <div class="dark-overlay"></div>
              <img src="{{ asset($extraData['image'] ?? 'landing/images/categories/default.png') }}" alt="">
              <div class="portfolio-wrap">
                <div class="portfolio-description">
                  <h3 class="portfolio-title">{{ $category->content_key }}</h3>
                <ul class="portfolio-details">
                  <li><a class="alpha-lightbox" href="{{ asset($extraData['image'] ?? 'landing/images/categories/default.png') }}"><i class="icofont icofont-search-1"></i></a></li>
                  <li class="social-icon"><a href="{{$extraData['link'] ?? '#' }}"></a></li>
                </ul>
              </div>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var portfolioGrid = document.getElementById('portfolio-grid');
        var categoryCount = {{ $categoryCount }};

        if (categoryCount === 2) {
            portfolioGrid.className = 'two-column hover-two';
        } else if (categoryCount === 3) {
            portfolioGrid.className = 'three-column hover-three';
        } else {
            portfolioGrid.className = 'four-column hover-four';
        }
    });
</script>