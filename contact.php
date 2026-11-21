<?php
$seoPage='contact.php';
$seoBreadcrumbs=['Home'=>'index.php','Contact'=>'contact.php'];
include "header.php"; ?>
<section class="page-hero">
  <div class="container position-relative">
    <div class="kicker">Contact</div>
    <h1 class="section-title" style="max-width:780px">Get in Touch with St. Xavier's High School</h1>
    <p class="lead-copy mb-0">We would be happy to assist you with enquiries about admissions, academics, school facilities and other information. Contact the school using the details below or submit an enquiry through our online form.</p>
    <nav class="mt-3" aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Contact</li>
      </ol>
    </nav>
  </div>
</section>
<section class="section">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-4">
        <div class="contact-box">
          <i class="bi bi-geo-alt"></i>
          <h3 class="h5 mt-3">School address</h3>
          <p class="text-muted-custom mb-0">
            Baishakhi, Siwan, Bihar
          </p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="contact-box">
          <i class="bi bi-telephone"></i>
          <h3 class="h5 mt-3">Phone</h3>
          <p class="text-muted-custom mb-0">
            <strong>Admin:</strong> <a href="tel:+91-8000800362" class="mr-2">+91-8000800362</a><br />
            <strong>Accounts:</strong><a href="tel:+91-8000800364" class="mr-2">+91-8000800364</a><br />
            <strong>Reception:</strong> <a href="tel:+91-8000800368" class="mr-2">+91-8000800368</a>

          </p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="contact-box">
          <i class="bi bi-envelope"></i>
          <h3 class="h5 mt-3">Email</h3>
          <p class="text-muted-custom mb-0">
            <a href="mailto:stxavierssiwan@gmail.com">stxavierssiwan@gmail.com</a>
          </p>
        </div>
      </div>
    </div>
    <div class="row g-4 mt-3 contact-enquiry-layout">
      <div class="col-lg-6">
        <div class="enquiry-panel">
          <h3 class="h4 mb-2">Contact form</h3>
          <p class="text-muted-custom mb-4">Fields marked * are required.</p>
          <form data-contact-form novalidate><div class="hp-field" aria-hidden="true"><label for="contactWebsite">Website</label><input type="text" id="contactWebsite" name="website" tabindex="-1" autocomplete="off"></div>
            <div class="row g-3">
              <div class="col-md-6"><label class="form-label" for="contactName">Your name *</label><input class="form-control" id="contactName" name="name" autocomplete="name" required placeholder="Your full name"></div>
              <div class="col-md-6"><label class="form-label" for="contactPhone">Phone number *</label><input class="form-control" id="contactPhone" name="phone" type="tel" autocomplete="tel" maxlength="10" pattern="[1-9][0-9]{9}" required placeholder="10-digit mobile number"></div>
              <div class="col-12"><label class="form-label" for="contactEmail">Email address *</label><input class="form-control" id="contactEmail" name="email" type="email" autocomplete="email" required placeholder="you@example.com"></div>
              <div class="col-12"><label class="form-label" for="contactAddress">Address *</label><textarea class="form-control" id="contactAddress" name="address" rows="2" autocomplete="street-address" required placeholder="House / street, locality and PIN code"></textarea></div>
              <div class="col-12"><label class="form-label" for="contactSubject">Subject *</label><input class="form-control" id="contactSubject" name="subject" required placeholder="What would you like to ask?"></div>
              <div class="col-12"><label class="form-label" for="contactMessage">Message *</label><textarea class="form-control" id="contactMessage" name="message" rows="4" required placeholder="Write your message"></textarea></div>
              <div class="col-12">
                <div class="form-check"><input class="form-check-input" type="checkbox" name="agree" id="contactAgree" required><label class="form-check-label" for="contactAgree">I agree to be contacted by the school.</label>
                  <div class="invalid-feedback">Please agree to be contacted.</div>
                </div>
              </div>
              <div class="col-12"><button class="btn btn-primary w-100" type="submit">Send Enquiry <i class="bi bi-arrow-right ms-1"></i></button>
                <div class="mt-3" data-form-status style="min-height:1.5rem;"></div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="mb-4">
          <div class="kicker">Find our campus</div>
          <h2 class="section-title">Visit St. Xavier's High School.</h2>
          <p class="lead-copy mx-auto">Baishakhi, Siwan, Bihar.</p>
        </div>
        <div class="ratio ratio-4x3 rounded-4 overflow-hidden border">
          <iframe title="Map to St. Xavier's High School, Siwan, Bihar" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3579.3181890434976!2d84.39105147541575!3d26.218848877067586!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3992fd5ec451812b%3A0x424eb5c06ee9dab6!2sSt%20Xavier's%20High%20School!5e0!3m2!1sen!2sin!4v1795197183460!5m2!1sen!2sin" allowfullscreen loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="section-sm">
  <div class="container">
    <div class="blue-panel p-4 p-lg-5">
      <div class="row align-items-center g-4 position-relative" style="z-index:1">
        <div class="col-lg-8">
          <div class="kicker text-warning">WhatsApp</div>
          <h2 class="section-title">Have an Admission Enquiry?</h2>
          <p class="mb-0">Connect with our school team on WhatsApp for assistance.</p>
        </div>
        <div class="col-lg-4 text-lg-end"><a href="https://wa.me/918000800362" class="btn btn-light-pill" target="_blank" rel="noopener noreferrer">Chat on WhatsApp <i class="fab fa-whatsapp ms-1"></i></a></div>
      </div>
    </div>
  </div>
</section>
<?php include "footer.php"; ?>

