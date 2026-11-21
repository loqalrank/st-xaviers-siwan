<?php
$seoPage='about.php';
$seoBreadcrumbs=['Home'=>'index.php','About Us'=>'about.php'];
include "header.php"; ?>
<section class="page-hero"><div class="container position-relative"><div class="kicker">About our school</div><h1 class="section-title" style="max-width:780px">About St. Xavier's High School</h1><nav class="mt-3" aria-label="breadcrumb"><ol class="breadcrumb mb-0"><li class="breadcrumb-item"><a href="index.php">Home</a></li><li class="breadcrumb-item active" aria-current="page">About Us</li></ol></nav></div></section>
<section class="section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 reveal"><img class="w-100 rounded-4" style="height:430px;object-fit:cover" src="<?php echo seo_escape(site_image('about_hero', 'assets/images/local/school-campus.jpg')); ?>" alt="School campus" width="600" height="430" loading="lazy"></div>
            <div class="col-lg-6 reveal">
                <div class="kicker">Our introduction</div>
                <h2 class="section-title">Learn, grow and discover your potential.</h2>
                <p class="lead-copy">St. Xavier's High School, Siwan, is dedicated to creating an educational environment where students can learn, grow and discover their potential. Offering education from Nursery to Class 12 under the CBSE curriculum, the school aims to combine academic development with discipline, moral values and co-curricular learning.</p>
                <p class="lead-copy">We believe that education should prepare students for life. Our approach encourages curiosity, independent thinking, creativity, confidence and respect for others.</p>
            </div>
        </div>
    </div>
</section>
<section class="section soft-bg">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5 reveal">
                <div class="info-card">
                    <div class="kicker">Our Vision</div>
                    <h2 class="h3">Knowledgeable, confident and responsible individuals.</h2>
                    <p>To nurture individuals who are prepared to contribute positively to society and meet the challenges of an evolving world.</p>
                </div>
            </div>
            <div class="col-lg-7 reveal">
                <div class="info-card">
                    <div class="kicker">Our Mission</div>
                    <h2 class="h3">Supporting every student's growth.</h2>
                    <ul class="mb-0">
                        <li>To provide quality education through a structured academic environment.</li>
                        <li>To encourage curiosity, creativity and independent thinking.</li>
                        <li>To develop discipline, integrity and respect for others.</li>
                        <li>To support students' intellectual, physical, emotional and social growth.</li>
                        <li>To create opportunities for learning beyond the classroom.</li>
                        <li>To prepare students to become responsible and capable citizens.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-7 reveal">
                <div class="kicker">Our Educational Philosophy</div>
                <h2 class="section-title">Every student has the potential to succeed.</h2>
                <p class="lead-copy">We believe every student has the potential to achieve meaningful success. Education should develop not only academic knowledge but also character, confidence, communication, creativity and responsibility.</p>
                <p class="lead-copy mb-0">Our focus is to provide students with opportunities to explore their interests, strengthen their abilities and develop a lifelong love of learning.</p>
            </div>
            <div class="col-lg-5 reveal">
                <div class="info-card">
                    <div class="kicker">Our Core Values</div>
                    <h2 class="h3">Values that guide our community.</h2>
                    <p class="mb-0">Knowledge · Discipline · Integrity · Respect · Responsibility · Creativity · Excellence · Compassion</p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include "footer.php"; ?>