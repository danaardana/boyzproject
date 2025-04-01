@php
    use App\Models\Section;

    $cta = Section::where('name', 'cta')->first();
    
@endphp

@if ($cta && $cta->is_active)    
  <section class="pt-50 pb-50 default-bg">
    <div class="container">
      <div class="row">
        <div class="col-md-5">
          <div class="cta-heading-left">
            <p class="subtitle mt-20">{{ $cta->description }}</p>
            <h3>{{ $cta->title }}</h3>
          </div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-6">
          <div class="cta-heading-right">
            <p class="mt-20 content-text">{{ $cta->content }}</p>
            <p class="mt-50"><a class="btn btn-rounded btn-white" href="{{ $cta->button_link }}" >{{ $cta->button_text }}</a></p>
          </div>
        </div>
      </div>
    </div>
  </section>
@endif