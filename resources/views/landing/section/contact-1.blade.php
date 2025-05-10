@php
use App\Models\Section;
use App\Models\SectionContent;

$contact = Section::where('name', 'contact')->first();
$contactDetails = SectionContent::where('section_id', $contact->id ?? null)->get()->pluck('content_value', 'content_key');
@endphp

@if($contact && $contact->is_active)
<section class="contact-us dark-bg" id="contact">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <form name="contact-form" id="contact-form-2" action="{{ route('contact.submit') }}" method="POST">
          @csrf
          <div class="messages"></div>
            <div class="form-group">
              <label class="sr-only" for="name">Name</label>
              <input type="text" name="name" class="form-control" id="name" required="required" placeholder="Masukan Nama" data-error="Your Name is Required">
              <div class="help-block with-errors mt-20"></div>
            </div>
            <div class="form-group">
              <label class="sr-only" for="subject">Phone (Whatsapp)</label>
              <input type="number" name="phone" class="form-control" id="phone" placeholder="Masukkan Nomor WhatsApp Aktif">
            </div>
            <div class="form-group">
              <label class="sr-only" for="email">Email</label>
              <input type="email" name="email" class="form-control" id="email" placeholder="Masukan Email aktif" required="required" data-error="Please Enter Valid Email">
              <div class="help-block with-errors mt-20"></div>
            </div>
            
            <div class="form-group">
              <label class="sr-only" for="subject">Subject</label>          
              <select class="form-control" name="subject" id="subject">
                <option value="" disabled selected>Pilih subject</option>
                <option value="garansi">Garansi</option>
                <option value="pemasangan">Pemasangan</option>
                <option value="lain">Lainnya</option>
              </select>
            </div>


            <div class="form-group">
              <label class="sr-only" for="message">Message</label>
              <textarea name="message" class="form-control" id="message-2" rows="7" placeholder="Your Message" required data-error="Please, Leave us a message"></textarea>
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
