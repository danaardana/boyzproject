@php
use App\Models\Section;
use App\Models\SectionContent;

$contact = Section::where('name', 'contact')->first();
$contactDetails = SectionContent::where('section_id', $contact->id ?? null)->get()->pluck('content_value', 'content_key');
@endphp

@if($contact && $contact->is_active)
<!-- Insert a meta csrf token in the head (if not already present in your layout) -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<section class="contact-us dark-bg" id="contact">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        
        <!-- Success Message -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: #d4edda; border-color: #c3e6cb; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
          <strong>Success!</strong> {{ session('success') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="float: right; background: none; border: none; font-size: 20px; color: #155724;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif

        <!-- Error Message from session -->
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background-color: #f8d7da; border-color: #f5c6cb; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
          <strong>Error!</strong> {{ session('error') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="float: right; background: none; border: none; font-size: 20px; color: #721c24;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif

        <!-- Validation Error Messages -->
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background-color: #f8d7da; border-color: #f5c6cb; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
          <strong>Please fix the following errors:</strong>
          <ul style="margin: 10px 0 0 20px;">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="float: right; background: none; border: none; font-size: 20px; color: #721c24;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif

        <form name="contact-form" id="contact-form-2" action="{{ route('contact.submit') }}" method="POST">
          @csrf
          <div class="messages"></div>
            <div class="form-group">
              <label class="sr-only" for="name">Name</label>
              <input type="text" name="name" class="form-control" id="name" required="required" placeholder="Masukan Nama" data-error="Your Name is Required" value="{{ old('name') }}">
              <div class="help-block with-errors mt-20"></div>
            </div>
            <div class="form-group">
              <label class="sr-only" for="subject">Phone (Whatsapp)</label>
              <input type="number" name="phone" class="form-control" id="phone" placeholder="Masukkan Nomor WhatsApp Aktif" value="{{ old('phone') }}">
            </div>
            <div class="form-group">
              <label class="sr-only" for="email">Email</label>
              <input type="email" name="email" class="form-control" id="email" placeholder="Masukan Email aktif" required="required" data-error="Please Enter Valid Email" value="{{ old('email') }}">
              <div class="help-block with-errors mt-20"></div>
            </div>
            
            <div class="form-group">
              <label class="sr-only" for="subject">Subject</label>          
              <select class="form-control" name="subject" id="subject">
                <option value="" disabled {{ old('subject') ? '' : 'selected' }}>Pilih subject</option>
                <option value="garansi" {{ old('subject') == 'garansi' ? 'selected' : '' }}>Garansi</option>
                <option value="pemasangan" {{ old('subject') == 'pemasangan' ? 'selected' : '' }}>Pemasangan</option>
                <option value="lain" {{ old('subject') == 'lain' ? 'selected' : '' }}>Lainnya</option>
              </select>
            </div>

            <div class="form-group">
              <label class="sr-only" for="message">Message</label>
              <textarea name="message" class="form-control" id="message-2" rows="7" placeholder="Your Message" required data-error="Please, Leave us a message">{{ old('message') }}</textarea>
              <div class="help-block with-errors mt-20"></div>
            </div>
              <button type="submit" name="submit" class="btn btn-color btn-circle">Send Mail</button>
        </form>
      </div>
      <div class="col-md-4">
        <h3 class="white-color">Address</h3>
        <address>
          {{ $contactDetails['postal_address'] ?? 'No address available' }} <br>
          <abbr title="Phone">Phone:</abbr> {{ $contactDetails['phone'] ?? 'No phone available' }}<br>
          <abbr title="Phone">Whatsapp:</abbr> {{ $contactDetails['phone'] ?? 'No phone available' }}<br>
          <a href="mailto:{{ $contactDetails['email'] ?? '#' }}">{{ $contactDetails['email'] ?? 'No email available' }}</a>
        </address>

        <h3 class="white-color">Work Timings</h3>
        <p>
          <span>{{ $contactDetails['work_time_weekdays'] ?? 'No time available' }}</span> <br>
          <span>{{ $contactDetails['work_time_weekend'] ?? 'No time available' }}</span>
        </p>
      </div>
    </div>
  </div>
</section>
@endif
