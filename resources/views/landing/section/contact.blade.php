<section class="contact-us white-bg" id="contact">
  <div class="container">
    <div class="clearfix">
      <div class="bg-flex-right col-md-6 map-section">
        <div id="myMap"></div>
      </div>
      <div class="col-about-left col-md-6 text-left">
        <h2 class="text-uppercase font-700 wow fadeTop" data-wow-delay="0.1s">Contact Us</h2>
        <h4 class="text-uppercase wow fadeTop" data-wow-delay="0.2s">- Stay in Touch -</h4>
        <form name="contact-form" id="contact-form" action="php/contact.php" method="POST" class="mt-50">
          <div class="messages"></div>
          <div class="form-group wow fadeTop" data-wow-delay="0.1s">
            <label class="sr-only" for="name">Name</label>
            <input type="text" name="name" class="form-control" id="name" required="required" placeholder="Your Name" data-error="Your Name is Required">
            <div class="help-block with-errors mt-20"></div>
          </div>
          <div class="form-group wow fadeTop" data-wow-delay="0.2s">
            <label class="sr-only" for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Your Email" required="required" data-error="Please Enter Valid Email">
            <div class="help-block with-errors mt-20"></div>
          </div>
          <div class="form-group wow fadeTop" data-wow-delay="0.3s">
            <label class="sr-only" for="message">Message</label>
            <textarea name="message" class="form-control" id="message" rows="7" placeholder="Your Message" required data-error="Please, Leave us a message"></textarea>
            <div class="help-block with-errors mt-20"></div>
          </div>
          <button type="submit" name="submit" class="btn btn-color btn-circle wow fadeTop" data-wow-delay="0.4s">Book Now</button>
        </form>
      </div>
    </div>
  </div>
</section>