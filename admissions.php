<?php
$seoPage='admissions.php';
$seoBreadcrumbs=['Home'=>'index.php','Admissions'=>'admissions.php'];
include "header.php"; ?>
<section class="section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5">
                <div class="kicker">Admissions</div>
                <h1 class="section-title">Admissions at St. Xavier's High School</h1>
                <p class="lead-copy">Choosing the right school is an important decision for every family. At St. Xavier's High School, Siwan, we aim to provide a supportive educational environment where students can build knowledge, develop confidence and discover their potential.</p>
                <p class="lead-copy">We welcome admission enquiries for classes from Nursery to Class 12, subject to availability and the school's admission guidelines.</p>
                <div class="notice-row">
                    <div class="notice-icon"><i class="bi bi-chat-dots"></i></div>
                    <div><strong>Ask your questions</strong>
                        <p>Get clarity on the admission process and school experience.</p>
                    </div>
                </div>
                <div class="notice-row">
                    <div class="notice-icon"><i class="bi bi-clipboard-check"></i></div>
                    <div><strong>Confirm requirements</strong>
                        <p>Check current documents, eligibility and important dates with the office.</p>
                    </div>
                </div>
                <div class="notice-row">
                    <div class="notice-icon"><i class="bi bi-calendar2-check"></i></div>
                    <div><strong>Plan a visit</strong>
                        <p>Contact the school to ask about arranging a campus visit.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="enquiry-panel">
                    <h3 class="h3 mb-2">Admission enquiry form</h3>
                    <p class="text-muted-custom mb-4">Fields marked * are required.</p>
                    <form data-enquiry-form novalidate><div class="hp-field" aria-hidden="true"><label for="admissionWebsite">Website</label><input type="text" id="admissionWebsite" name="website" tabindex="-1" autocomplete="off"></div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="admissionParent">Parent / Guardian name *</label>
                                <input class="form-control" id="admissionParent" name="parent" autocomplete="name" required placeholder="Your full name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="admissionPhone">Phone number *</label>
                                <input class="form-control" id="admissionPhone" name="phone" type="tel" autocomplete="tel" maxlength="10" required pattern="[1-9][0-9]{9}" placeholder="10-digit phone number">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="admissionEmail">Email address *</label>
                                <input class="form-control" id="admissionEmail" name="email" type="email" autocomplete="email" required placeholder="you@example.com">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="admissionStudent">Student name *</label>
                                <input class="form-control" id="admissionStudent" name="student" autocomplete="off" placeholder="Student's full name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="admissionClass">Class applying for *</label>
                                <select class="form-select" id="admissionClass" name="class" required>
                                    <option value="">Select class</option>
                                    <option>Nursery</option>
                                    <option>LKG</option>
                                    <option>UKG</option>
                                    <option>Class I</option>
                                    <option>Class II</option>
                                    <option>Class III</option>
                                    <option>Class IV</option>
                                    <option>Class V</option>
                                    <option>Class VI</option>
                                    <option>Class VII</option>
                                    <option>Class VIII</option>
                                    <option>Class IX</option>
                                    <option>Class XI</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="admissionAddress">Address *</label>
                                <textarea class="form-control" id="admissionAddress" name="address" rows="2" autocomplete="street-address" required placeholder="House / street, locality and PIN code"></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="admissionMessage">Message</label>
                                <textarea class="form-control" id="admissionMessage" rows="4" name="message" placeholder="Tell us what you would like to know"></textarea>
                            </div>
                            <div class="col-12">
                                <div class="form-check"><input class="form-check-input" id="admissionAgree" type="checkbox" name="agree" required><label class="form-check-label" for="admissionAgree">I agree to be contacted by the school.</label>
                                    <div class="invalid-feedback">Please agree to be contacted.</div>
                                </div>
                            </div>
                            <div class="col-12"><button class="btn btn-primary w-100" type="submit">Submit Enquiry <i class="bi bi-arrow-right ms-1"></i></button>
                                <div class="mt-3" data-form-status style="min-height:1.5rem;"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="kicker">Admission Process</div>
            <h2 class="section-title">Your next steps.</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4"><div class="info-card"><h3>1. Submit an Enquiry</h3><p>Contact the school through the website enquiry form, phone or WhatsApp.</p></div></div>
            <div class="col-md-6 col-lg-4"><div class="info-card"><h3>2. Connect with the School</h3><p>Speak with the admissions team to understand the available classes and admission requirements.</p></div></div>
            <div class="col-md-6 col-lg-4"><div class="info-card"><h3>3. Obtain the Application Form</h3><p>Collect or request the admission application form from the school.</p></div></div>
            <div class="col-md-6 col-lg-4"><div class="info-card"><h3>4. Submit Required Documents</h3><p>Provide the documents requested by the school.</p></div></div>
            <div class="col-md-6 col-lg-4"><div class="info-card"><h3>5. Assessment / Interaction</h3><p>Complete any assessment or interaction required under the school's admission policy.</p></div></div>
            <div class="col-md-6 col-lg-4"><div class="info-card"><h3>6. Admission Confirmation</h3><p>Complete the remaining formalities and receive confirmation from the school.</p></div></div>
        </div>
    </div>
</section>
<section class="section soft-bg">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-5">
                <div class="kicker">Documents Required</div>
                <h2 class="section-title">Prepare for your enquiry.</h2>
                <p class="lead-copy">The school should confirm the final document checklist. It may include:</p>
            </div>
            <div class="col-lg-7">
                <div class="info-card">
                    <ul class="mb-0">
                        <li>Birth certificate</li>
                        <li>Aadhar card or other government-issued identification</li>
                        <li>Previous school report card, where applicable</li>
                        <li>Transfer certificate, where applicable</li>
                        <li>Passport-size photographs</li>
                        <li>Parent or guardian identification</li>
                        <li>Any additional documents required by the school</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section soft-bg">
    <div class="container">
        <div class="text-center mb-4">
            <div class="kicker">Before you apply</div>
            <h2 class="section-title">A few helpful reminders.</h2>
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="info-card">
                    <h3>Admission dates</h3>
                    <p>Confirm the current application window directly with the school.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card">
                    <h3>Eligibility</h3>
                    <p>Ask the office about age criteria and class-specific requirements.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card">
                    <h3>Fee & documents</h3>
                    <p>Request the latest fee schedule and official document checklist.</p>
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
                    <div class="kicker text-warning">WhatsApp Enquiry</div>
                    <h2 class="section-title">Have an Admission Enquiry?</h2>
                    <p class="mb-0">Connect with our school team on WhatsApp for assistance.</p>
                </div>
                <div class="col-lg-4 text-lg-end"><a href="https://wa.me/918000800362" class="btn btn-light-pill" target="_blank" rel="noopener noreferrer">Contact on WhatsApp <i class="fab fa-whatsapp ms-1"></i></a></div>
            </div>
        </div>
    </div>
</section>
<?php include "footer.php"; ?>

