<?php $seoPage='index.php'; $seoBreadcrumbs=['Home'=>'index.php']; include "header.php"; ?>
<?php
$heroSlides = isset($siteConfig['hero']['slides']) && is_array($siteConfig['hero']['slides']) ? $siteConfig['hero']['slides'] : [];
?>
<header class="hero hero-carousel-wrap">
  <div id="heroCarousel" class="carousel slide carousel-fade hero-carousel" data-bs-ride="carousel" data-bs-interval="5000">
<?php if (count($heroSlides) > 1): ?>
    <div class="carousel-indicators">
<?php foreach ($heroSlides as $hi => $hslide): ?>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?php echo $hi; ?>"<?php echo $hi === 0 ? ' class="active" aria-current="true"' : ''; ?> aria-label="Slide <?php echo $hi + 1; ?>"></button>
<?php endforeach; ?>
    </div>
<?php endif; ?>
    <div class="carousel-inner">
<?php foreach ($heroSlides as $hi => $hslide):
    $hImage = isset($hslide['image']) ? $hslide['image'] : '';
    $hAlt = isset($hslide['image_alt']) ? $hslide['image_alt'] : '';
    $hTag = isset($hslide['tag']) ? $hslide['tag'] : '';
    $hDesc = isset($hslide['description']) ? $hslide['description'] : '';
    $hLines = preg_split('/\r\n|\r|\n/', trim((string) (isset($hslide['title']) ? $hslide['title'] : '')));
    $hLines = array_values(array_filter($hLines, 'strlen'));
    $hAccent = count($hLines) > 1 ? array_pop($hLines) : '';
    $hTitleHtml = implode('<br>', array_map('seo_escape', $hLines));
    if ($hAccent !== '') {
        $hTitleHtml .= ($hTitleHtml !== '' ? '<br>' : '') . '<span>' . seo_escape($hAccent) . '</span>';
    }
?>
      <div class="carousel-item<?php echo $hi === 0 ? ' active' : ''; ?>">
        <img class="hero-slide-image" src="<?php echo seo_escape($hImage); ?>" alt="<?php echo seo_escape($hAlt); ?>">
        <div class="hero-overlay"></div>
        <div class="container hero-content-wrap">
          <div class="hero-content">
<?php if ($hTag !== ''): ?>
            <div class="hero-tag mb-4"><i class="bi bi-stars"></i> <?php echo seo_escape($hTag); ?></div>
<?php endif; ?>
<?php if ($hi === 0): ?>
            <h1><?php echo $hTitleHtml; ?></h1>
<?php else: ?>
            <h2><?php echo $hTitleHtml; ?></h2>
<?php endif; ?>
            <p><?php echo seo_escape($hDesc); ?></p>
            <div class="hero-actions"><?php if (!empty($hslide['button_label']) && !empty($hslide['button_link'])): ?><a href="<?php echo seo_escape($hslide['button_link']); ?>" class="btn btn-primary btn-lg"><?php echo seo_escape($hslide['button_label']); ?> <i class="bi bi-arrow-right ms-1"></i></a><?php endif; ?><?php if (!empty($hslide['button2_label']) && !empty($hslide['button2_link'])): ?><a href="<?php echo seo_escape($hslide['button2_link']); ?>" class="btn btn-outline-primary btn-lg"><?php echo seo_escape($hslide['button2_label']); ?></a><?php endif; ?></div>
          </div>
        </div>
<?php if (!empty($hslide['sticker_title']) || !empty($hslide['sticker_text'])): ?>
        <div class="hero-sticker"><?php if (!empty($hslide['sticker_title'])): ?><strong><?php echo seo_escape($hslide['sticker_title']); ?></strong><?php endif; ?><?php echo !empty($hslide['sticker_text']) ? seo_escape($hslide['sticker_text']) : ''; ?></div>
<?php endif; ?>
      </div>
<?php endforeach; ?>
    </div>
<?php if (count($heroSlides) > 1): ?>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
<?php endif; ?>
  </div>
</header>
<div class="stats-wrap"><div class="container"><div class="row text-center"><div class="col-6 col-md-3 stat-item"><strong>CBSE</strong><span>Affiliated</span></div><div class="col-6 col-md-3 stat-item"><strong>Nursery–12</strong><span>Learning at every stage</span></div><div class="col-6 col-md-3 stat-item"><strong>Holistic</strong><span>Education</span></div><div class="col-6 col-md-3 stat-item"><strong>Modern</strong><span>Learning facilities</span></div></div></div></div>
<section class="section">
  <div class="container">
    <div class="row align-items-center g-4 g-lg-5">
        <div class="col-lg-6 reveal">
          <div class="photo-panel">
            <img src="<?php echo seo_escape(site_image('home_welcome', 'assets/images/local/school-campus.jpg')); ?>" alt="St. Xavier's High School campus" width="600" height="430" loading="lazy">
            <div class="photo-badge"><small>OUR PROMISE</small>Every learner matters.</div>
          </div>
        </div>
      <div class="col-lg-6 reveal">
        <div class="kicker">Welcome</div>
        <h2 class="section-title">Welcome to St. Xavier's High School</h2>
        <p class="lead-copy">St. Xavier's High School, Siwan, is committed to providing a meaningful and enriching educational experience for students from Nursery to Class 12. Our approach combines academic learning with discipline, values, creativity and opportunities for personal growth.</p>
        <p class="lead-copy">We believe every child has unique potential. Through a supportive learning environment, dedicated educators and a broad range of educational activities, we encourage students to develop knowledge, confidence, curiosity and a sense of responsibility.</p>
        <p class="lead-copy">Our aim is to prepare students not only for academic success but also for the opportunities and challenges of the future.</p>
        <a href="about.php" class="btn btn-primary mt-2">Know More About Us <i class="bi bi-arrow-right ms-1"></i></a>
      </div>
    </div>
  </div>
</section>
<section class="section soft-bg">
  <div class="container">
    <div class="text-center mb-5 reveal">
      <div class="kicker">A place to learn and thrive</div>
      <h2 class="section-title">Why Choose St. Xavier's?</h2>
      <p class="lead-copy mx-auto">An education shaped by strong academics, values, guidance and opportunities to grow.</p>
    </div>
    <div class="row g-4">
      <div class="col-md-6 col-lg-4 reveal">
        <div class="feature-card">
          <div class="icon-bubble"><i class="bi bi-book"></i></div>
          <h3>Academic Excellence</h3>
          <p>We encourage students to develop strong academic foundations, independent thinking and a genuine interest in learning.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4 reveal">
        <div class="feature-card">
          <div class="icon-bubble"><i class="bi bi-person-heart"></i></div>
          <h3>CBSE Curriculum</h3>
          <p>Our school follows the CBSE curriculum, supporting structured learning and the academic development of students.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4 reveal">
        <div class="feature-card">
          <div class="icon-bubble"><i class="bi bi-stars"></i></div>
          <h3>Experienced Guidance</h3>
          <p>We believe in the importance of teacher guidance, individual attention and a supportive learning atmosphere.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4 reveal">
        <div class="feature-card">
          <div class="icon-bubble"><i class="bi bi-heart"></i></div>
          <h3>Values and Discipline</h3>
          <p>We encourage respect, responsibility, honesty, discipline and positive conduct.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4 reveal">
        <div class="feature-card">
          <div class="icon-bubble"><i class="bi bi-house-heart"></i></div>
          <h3>All-Round Development</h3>
          <p>Academic learning is complemented by sports, music, dance, art and other creative activities.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4 reveal">
        <div class="feature-card">
          <div class="icon-bubble"><i class="bi bi-people"></i></div>
          <h3>Student Well-being</h3>
          <p>We give importance to campus security, school transport and access to medical first aid.</p>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="section">
  <div class="container">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-5">
      <div class="reveal">
        <div class="kicker">Academic Journey</div>
        <h2 class="section-title mb-2">Learning at Every Stage</h2>
        <p class="lead-copy mb-0">From the foundational years in Nursery to the senior classes up to Class 12, we aim to support students through every stage of their educational journey.</p>
      </div>
      <a href="academics.php" class="btn btn-outline-primary">Explore Academics <i class="bi bi-arrow-up-right ms-1"></i></a>
    </div>
    <div class="row g-4">
      <div class="col-md-4 reveal"><div class="feature-card"><div class="icon-bubble"><i class="bi bi-1-circle"></i></div><h3>Foundational Years</h3><p>Encouraging young learners to explore, communicate and build confidence through age-appropriate learning.</p></div></div>
      <div class="col-md-4 reveal"><div class="feature-card"><div class="icon-bubble"><i class="bi bi-2-circle"></i></div><h3>Middle School</h3><p>Strengthening subject knowledge, analytical thinking and independent learning.</p></div></div>
      <div class="col-md-4 reveal"><div class="feature-card"><div class="icon-bubble"><i class="bi bi-3-circle"></i></div><h3>Secondary and Senior Secondary</h3><p>Supporting deeper subject understanding, academic responsibility and future opportunities.</p></div></div>
    </div>
  </div>
</section>
<?php include __DIR__ . '/includes/toppers-section.php'; ?>
<section class="section soft-bg">
  <div class="container">
    <div class="text-center mb-5 reveal">
      <div class="kicker">Campus &amp; learning</div>
      <h2 class="section-title">Facilities That Support Better Learning</h2>
      <p class="lead-copy mx-auto">Our facilities support classroom learning, practical education, creativity, physical development and student well-being.</p>
    </div>
    <div class="row g-3">
      <div class="col-6 col-md-4 col-lg-3"><div class="info-card"><h3>Computer Lab</h3></div></div>
      <div class="col-6 col-md-4 col-lg-3"><div class="info-card"><h3>Science Laboratory</h3></div></div>
      <div class="col-6 col-md-4 col-lg-3"><div class="info-card"><h3>Library</h3></div></div>
      <div class="col-6 col-md-4 col-lg-3"><div class="info-card"><h3>Sports and Playground</h3></div></div>
      <div class="col-6 col-md-4 col-lg-3"><div class="info-card"><h3>School Transport</h3></div></div>
      <div class="col-6 col-md-4 col-lg-3"><div class="info-card"><h3>CCTV Security</h3></div></div>
      <div class="col-6 col-md-4 col-lg-3"><div class="info-card"><h3>Music and Dance</h3></div></div>
      <div class="col-6 col-md-4 col-lg-3"><div class="info-card"><h3>Art and Craft</h3></div></div>
      <div class="col-6 col-md-4 col-lg-3"><div class="info-card"><h3>Digital Learning</h3></div></div>
      <div class="col-6 col-md-4 col-lg-3"><div class="info-card"><h3>Medical / First Aid</h3></div></div>
    </div>
    <div class="text-center mt-4 reveal"><a href="facilities.php" class="btn btn-outline-primary">Explore All Facilities <i class="bi bi-arrow-right ms-1"></i></a></div>
  </div>
</section>
<section class="section-sm">
  <div class="container">
    <div class="blue-panel p-4 p-lg-5 reveal">
      <div class="row align-items-center g-4 position-relative" style="z-index:1">
        <div class="col-lg-8">
          <div class="kicker text-warning">Beyond the classroom</div>
          <h2 class="section-title">Learning Beyond Academics</h2>
          <p class="mb-0">We believe education is about developing the whole child. Sports, music, dance, art and creative activities provide students with opportunities to discover their interests, build confidence, work together and express themselves.</p>
        </div>
        <div class="col-lg-4 text-lg-end"><a href="gallery.php" class="btn btn-light-pill">View Gallery <i class="bi bi-arrow-up-right ms-1"></i></a></div>
      </div>
    </div>
  </div>
</section>
<section class="section">
  <div class="container">
    <div class="row align-items-end mb-4">
      <div class="col"><div class="kicker">Gallery</div><h2 class="section-title mb-2">Moments at St. Xavier's</h2><p class="lead-copy mb-0">Explore photographs of our campus, classrooms, activities, celebrations, sports and student experiences.</p></div>
      <div class="col-auto"><a href="gallery.php" class="fw-bold text-primary">View Gallery <i class="bi bi-arrow-right"></i></a></div>
    </div>
    <div class="row g-3">
      <div class="col-6 col-md-4 reveal"><a class="activity-tile d-block" href="gallery.php"><img src="<?php echo seo_escape(site_image('home_spotlight_1', 'assets/images/gallery/classroom-02.jpg')); ?>" alt="Students learning together in class" width="400" height="300" loading="lazy"><span>Classroom Activities</span></a></div>
      <div class="col-6 col-md-4 reveal"><a class="activity-tile d-block" href="gallery.php"><img src="<?php echo seo_escape(site_image('home_spotlight_2', 'assets/images/gallery/sports-03.jpg')); ?>" alt="Students taking part in a football game" width="400" height="300" loading="lazy"><span>Sports and Games</span></a></div>
      <div class="col-6 col-md-4 reveal"><a class="activity-tile d-block" href="gallery.php"><img src="<?php echo seo_escape(site_image('home_spotlight_3', 'assets/images/gallery/cultural-05.jpg')); ?>" alt="Students performing at a school cultural event" width="400" height="300" loading="lazy"><span>Student Activities</span></a></div>
    </div>
  </div>
</section>
<section class="section soft-bg">
  <div class="container">
    <div class="cta-band reveal">
      <div class="row align-items-center g-4 position-relative" style="z-index:1">
        <div class="col-lg-8">
          <div class="kicker text-warning">Admissions</div>
          <h2 class="mt-2">Give Your Child a Strong Foundation for the Future</h2>
          <p class="mb-0">Begin your child's educational journey with St. Xavier's High School, Siwan. Contact our admissions team to learn more about admission opportunities from Nursery to Class 12.</p>
        </div>
        <div class="col-lg-4 text-lg-end"><a href="admissions.php" class="btn btn-light-pill">Enquire About Admission <i class="bi bi-arrow-right ms-1"></i></a></div>
      </div>
    </div>
  </div>
</section>
<section class="section">
  <div class="container">
    <div class="text-center mb-5 reveal">
      <div class="kicker">Need a little more information?</div>
      <h2 class="section-title">Frequently asked questions.</h2>
      <p class="lead-copy mx-auto">Quick answers to common questions from families.</p>
    </div>
    <div class="accordion mx-auto reveal" style="max-width:850px" id="homeFaq">
      <div class="accordion-item">
        <h3 class="accordion-header">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#homeFaqApply" aria-expanded="true" aria-controls="homeFaqApply">How can I apply for admission?</button>
        </h3>
        <div id="homeFaqApply" class="accordion-collapse collapse show" data-bs-parent="#homeFaq">
          <div class="accordion-body text-muted-custom">Contact the school office or submit an enquiry through the website to learn about the admission process, eligibility and available seats.</div>
        </div>
      </div>
      <div class="accordion-item">
        <h3 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#homeFaqDates" aria-expanded="false" aria-controls="homeFaqDates">When do admissions open?</button>
        </h3>
        <div id="homeFaqDates" class="accordion-collapse collapse" data-bs-parent="#homeFaq">
          <div class="accordion-body text-muted-custom">Admission dates may vary by academic session and class. Please contact the school office for the latest information.</div>
        </div>
      </div>
      <div class="accordion-item">
        <h3 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#homeFaqDocuments" aria-expanded="false" aria-controls="homeFaqDocuments">What documents may be required for admission?</button>
        </h3>
        <div id="homeFaqDocuments" class="accordion-collapse collapse" data-bs-parent="#homeFaq">
          <div class="accordion-body text-muted-custom">Documents may include the student's aadhar card, birth certificate, previous school's report card, transfer certificate (where applicable) and photographs. Confirm the requirements with the school office.</div>
        </div>
      </div>
    </div>
    <div class="text-center mt-4 reveal">
      <a href="faq.php" class="btn btn-outline-primary">More FAQs <i class="bi bi-arrow-right ms-1"></i></a>
    </div>
  </div>
</section>

<?php include "footer.php"; ?>