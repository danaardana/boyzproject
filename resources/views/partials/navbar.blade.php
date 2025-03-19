@php
use App\Models\Section;
$sections = Section::where('is_active', true)->orderBy('show_order', 'asc')->get();
@endphp

<nav class="navbar-scrollspy navbar navbar-default navbar-fixed white bootsnav on no-full navbar-transparent" data-minus-value-desktop="70" data-minus-value-mobile="55" data-speed="1000">
    <div class="container">
      <!--=== Start Atribute Navigation ===-->
      <div class="attr-nav">
        <ul class="social-media-dark social-top">
          <li><a href="http://shopee.co.id/boyprojectsasli" class="icofont icofont-cart"></a></li>
          <li><a href="https://www.tiktok.com/@boyprojects?_t=8holwJrP1zM&_r=1" class="icofont icofont-tiktok"></a></li>
          <li><a href="https://www.instagram.com/boyprojects?igsh=YjhyNXZmczY0MXF4" class="icofont icofont-instagram"></a></li>
          <li><a href="https://linktr.ee/boyprojects" class="icofont icofont-linkedin"></a></li>
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
          @foreach($sections as $section)
            <li class="scroll"><a href="#{{ $section->name }}">{{ $section->name }}</a></li>
          @endforeach
        </ul>
      </div>
      <!--=== /.navbar-collapse ===-->
    </div>
</nav>
