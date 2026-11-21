ST. XAVIER'S HIGH SCHOOL, SIWAN — WEBSITE PREVIEW
======================================================

PROJECT
- Multi-page responsive website
- HTML5 + Bootstrap 5.3 + custom CSS + vanilla JavaScript
- Pages: Home, About, Academics, Admissions, Facilities, Leadership Messages, FAQs, Gallery, Blog, Blog Detail, Contact
- Responsive navigation, reveal-on-scroll effects, gallery filters, standalone FAQ accordion
- Admission and contact forms open a WhatsApp message after the verified number is configured.

PREVIEW
1. Extract the ZIP file.
2. Start PHP's local server from this folder:
   php -S localhost:8000
   (On Windows, use the full path to php.exe if PHP is not on PATH.)
3. Open http://localhost:8000/ in Chrome/Edge.
4. The website's stylesheets, scripts, fonts, icons and photographs are stored locally. Internet is needed for external social/WhatsApp links and to load the embedded Google Maps on the Contact page.

HOSTING
Upload the complete contents of this folder to a PHP-enabled hosting public_html (or document root).
Keep the assets folder structure unchanged.
Set index.php as the default homepage.

STORAGE & SECURITY
- Saved content, leads and admin credentials are stored in a "sxhs-data" folder OUTSIDE the web root,
  created automatically next to the site folder (or one level higher when the site sits directly in public_html).
- Existing files from ./data are migrated automatically on first load.
- Set the SXHS_DATA_DIR environment variable to force a specific writable path if the host blocks the default.
- If no external path is writable, the site falls back to ./data (protected by .htaccess).
- The data folder must stay writable by PHP. Back it up before upgrades.
- Public enquiry forms include a honeypot field and per-IP throttling (3 submissions per 10 minutes).

IMPORTANT — BEFORE GOING LIVE
1. Open assets/js/site.js and fill SCHOOL_CONFIG:
   phone: "countrycode+number digits only"
   email: "official school email"
   address: "full verified postal address"
   whatsapp: "countrycode+number digits only"
2. Replace all Unsplash demo photos with school-approved campus/student photographs.
   The Facilities and Leadership Messages pages use images already stored in assets/images.
   Confirm the facility descriptions and leadership message drafts with the school before publishing.
3. Confirm school name, official address, phone, email, affiliation, classes, admission dates,
   fee details, staff names and all claims with school administration.
4. Add official logo, favicon, privacy policy and terms as required.
5. Connect any enquiry form to an approved backend/CRM if you need submissions stored.
   Current WhatsApp enquiry opens a pre-filled message only after a verified number is added.
6. Confirm the supplied school map pin and campus address with the school.
7. Add real notices, events, mandatory disclosure and downloadable documents after verification.

The current site link could not be fetched during creation, so this package avoids inventing
school credentials and uses editable placeholders where official details must be confirmed.

LOGO & BLOG UPDATE
- Official supplied logo is stored at assets/images/school-logo.png.
- Blog listing: blog.php
- Blog article detail template: blog-detail.php
- Replace sample blog content, titles, dates and images with approved school updates.
- To add more articles, duplicate the blog-detail.php layout and link each blog card to its article page.

SOCIAL MEDIA & WHATSAPP
- Facebook, Instagram and LinkedIn icons/links are included in the footer on all pages.
- A floating WhatsApp button is included on all pages and opens the supplied admission enquiry message.
- DM Sans, Manrope, Bootstrap Icons 1.11.3 and Font Awesome 6.7.2 are loaded locally; keep their font files with the supplied assets.
