@php
use App\Models\Section;

$sections = Section::where('is_active', true)
    ->orderBy('show_order', 'asc')
    ->get()
    ->map(function ($section, $index) {
        $section->show_order = $index + 1;
        return $section;
    });
@endphp


<nav class="navbar-scrollspy navbar navbar-default navbar-fixed white bootsnav on no-full navbar-transparent" data-minus-value-desktop="70" data-minus-value-mobile="55" data-speed="1000">
    <div class="container">
      <!--=== Start Atribute Navigation ===-->
      <div class="attr-nav">
        <ul class="social-media-dark social-top">
          <li><a href="https://wa.me/08211990442" class="icofont icofont-whatsapp"></a></li>
          <li><a href="https://linktr.ee/boyprojects" class="icofont icofont-linkedin"></a></li>
          @if(Auth::guard('admin')->check())
            <li>
              <a href="{{ route('admin.dashboard') }}" class="icofont icofont-dashboard" title="Admin Dashboard"></a>
            </li>
            <li>
              <a href="{{ route('admin.logout') }}" class="icofont icofont-logout" title="Logout"></a>
            </li>
          @else
            <li><a href="{{ route('admin.login') }}" class="icofont icofont-user" title="Admin Login"></a></li>
          @endif
        </ul>
      </div>
      <!--=== End Atribute Navigation ===-->

      <!--=== Start Header Navigation ===-->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu"> <i class="icofont icofont-navigation-menu"></i> </button>
        <div class="logo"><a href="{{ url('/') }}"> <img class="logo logo-display" src="{{ asset('landing/images/logo-white.png') }}" alt=""> <img class="logo logo-scrolled" src="{{ asset('landing/images/logo-black.png') }}" alt=""> </a> </div>
      </div>
      <!--=== End Header Navigation ===-->

        <!--=== Collect the nav links, forms, and other content for toggling ===-->
        <div class="navbar-collapse collapse" id="navbar-menu" aria-expanded="false">
          <ul class="nav navbar-nav navbar-right nav-scrollspy-onepage" data-in="fadeInLeft">
              @php
                  $maxVisibleItems = 6; // Jumlah maksimal menu sebelum masuk ke dropdown
                  $visibleSections = $sections->take($maxVisibleItems); // Ambil 6 menu pertama
                  $dropdownSections = $sections->slice($maxVisibleItems); // Sisanya masuk ke dropdown
              @endphp

              @foreach($visibleSections as $section)
                @if($section->name !== 'cta') 
                  <li class="scroll"><a href="#{{ $section->name }}">{{ strtoupper($section->name) }}</a></li>
                  @endif
              @endforeach

              @if($dropdownSections->isNotEmpty())
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Other</a>
                  <ul class="dropdown-menu">
                    @foreach($dropdownSections as $section)
                    @if($section->name !== 'cta') 
                      <li><a href="#{{ $section->name }}">{{ strtoupper($section->name) }}</a></li>
                      @endif
                    @endforeach
                  </ul>
                </li>
              @endif
          </ul>
        </div>
        <!--=== /.navbar-collapse ===-->

    </div>
</nav>
