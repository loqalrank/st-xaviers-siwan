<?php
$seoPage = 'facilities.php';
$seoBreadcrumbs = [
    'Home' => 'https://www.stxavierssiwan.com/',
    'Facilities' => 'https://www.stxavierssiwan.com/facilities.php',
];

$facilityGroups = [
    [
        'title' => 'Academic Facilities',
        'icon' => 'book-open',
        'description' => 'Classroom teaching, academic guidance and learning resources to support students throughout their studies.',
        'items' => [
            ['label' => 'Experienced and Highly Qualified Teachers'],
            ['label' => 'Smart Classrooms'],
            ['label' => 'Science Laboratory'],
            ['label' => 'Computer Laboratory'],
            ['label' => 'Well-Stocked Library'],
            ['label' => 'Digital Learning Resources'],
            ['label' => 'English-Speaking Environment'],
            ['label' => 'Audio-Visual Teaching Methods'],
            ['label' => 'Activity-Based Learning'],
            ['label' => 'Preparatory Classes'],
            ['label' => 'Regular Tests and Academic Assessments'],
            ['label' => 'Special Attention to Academically Weak Students'],
            ['label' => 'Individual Learning Support'],
            ['label' => 'Subject-Wise Academic Guidance'],
            ['label' => 'Homework and Study Support'],
        ],
    ],
    [
        'title' => 'Sports & Physical Education',
        'icon' => 'running',
        'description' => 'Physical education, games and fitness activities that encourage movement, teamwork and participation.',
        'items' => [
            ['label' => 'Indoor Games'],
            ['label' => 'Outdoor Games'],
            ['label' => 'Dedicated Sports Activities'],
            ['label' => 'Yoga Classes'],
            ['label' => 'Martial Arts Training'],
            ['label' => 'Physical Education Programmes'],
            ['label' => 'Fitness and Exercise Activities'],
            ['label' => 'Annual Sports Events'],
            ['label' => 'Team Building Activities'],
        ],
    ],
    [
        'title' => 'Student Development',
        'icon' => 'user-graduate',
        'description' => 'Activities that help learners practise communication, leadership, creativity, discipline and good values.',
        'items' => [
            ['label' => 'Personality Development Programmes'],
            ['label' => 'Communication Skills Development'],
            ['label' => 'Leadership Development Activities'],
            ['label' => 'Moral Values and Character Building'],
            ['label' => 'Moral Education'],
            ['label' => 'Discipline and Life Skills'],
            ['label' => 'Confidence-Building Activities'],
            ['label' => 'Public Speaking Activities'],
            ['label' => 'Creative Learning Activities'],
            ['label' => 'Co-Curricular Activities'],
        ],
    ],
    [
        'title' => 'Campus & Infrastructure',
        'icon' => 'school',
        'description' => 'Spaces and everyday amenities intended to support a comfortable, clean and child-friendly school day.',
        'items' => [
            ['label' => 'Spacious Classrooms'],
            ['label' => 'Campus Spread Over More Than 2 Acres'],
            ['label' => 'Dedicated Activity Area for Kids'],
            ['label' => 'Well-Maintained School Campus'],
            ['label' => 'Clean and Hygienic Environment'],
            ['label' => 'Proper Classroom Ventilation'],
            ['label' => 'Separate Washrooms for Boys and Girls'],
            ['label' => 'Clean Washrooms'],
            ['label' => 'Pure Drinking Water Facility'],
            ['label' => 'Safe and Child-Friendly Campus'],
            ['label' => 'Dedicated Play Area'],
        ],
    ],
    [
        'title' => 'Safety, Security & Medical Facilities',
        'icon' => 'shield-alt',
        'description' => 'Supervision and safety arrangements for students during the school day and at campus entry and exit.',
        'items' => [
            ['label' => 'CCTV Surveillance'],
            ['label' => 'Secure School Campus'],
            ['label' => 'First Aid Facilities'],
            ['label' => 'Medical Assistance'],
            ['label' => 'Student Safety Monitoring'],
            ['label' => 'Safe Entry and Exit Management'],
            ['label' => 'Emergency Response Arrangements'],
            ['label' => 'Child Safety Awareness'],
            ['label' => 'Staff Supervision During School Hours'],
        ],
    ],
    [
        'title' => 'Transportation',
        'icon' => 'bus',
        'description' => 'School travel arrangements and route information for families to discuss with the school office.',
        'items' => [
            ['label' => 'School Bus Transportation'],
            ['label' => 'Transport Services for Students'],
            ['label' => 'Safe Pick-Up and Drop-Off'],
            ['label' => 'Trained Drivers'],
            ['label' => 'Student Transportation Supervision'],
            ['label' => 'Defined Bus Routes'],
        ],
    ],
    [
        'title' => 'Cultural & Co-Curricular Activities',
        'icon' => 'palette',
        'description' => 'Cultural, creative and educational events that give students opportunities to participate and express themselves.',
        'items' => [
            ['label' => 'Cultural Programmes'],
            ['label' => 'National Festival Celebrations'],
            ['label' => 'Annual Day Celebrations'],
            ['label' => 'Independence Day Celebrations'],
            ['label' => 'Republic Day Celebrations'],
            ['label' => 'Dance and Music Activities'],
            ['label' => 'Art and Craft Activities'],
            ['label' => 'Drawing and Painting Competitions'],
            ['label' => 'Quiz Competitions'],
            ['label' => 'Debate and Speech Competitions'],
            ['label' => 'Creative and Educational Events'],
        ],
    ],
    [
        'title' => 'Health, Hygiene & Wellness',
        'icon' => 'heartbeat',
        'description' => 'Daily hygiene practices and wellness activities that contribute to a clean and healthy learning environment.',
        'items' => [
            ['label' => 'Clean Drinking Water'],
            ['label' => 'Hygienic Washrooms'],
            ['label' => 'Regular Campus Cleaning'],
            ['label' => 'First Aid and Medical Assistance'],
            ['label' => 'Health and Hygiene Awareness'],
            ['label' => 'Personal Hygiene Education'],
            ['label' => 'Clean Classroom Environment'],
            ['label' => 'Health and Fitness Activities'],
        ],
    ],
    [
        'title' => 'Parent Engagement & Student Assessment',
        'icon' => 'handshake',
        'description' => 'Regular communication and progress monitoring to help parents stay connected with their child’s learning.',
        'items' => [
            ['label' => 'Regular Parent-Teacher Meetings (PTMs)'],
            ['label' => 'Parent Communication'],
            ['label' => 'Student Progress Reports'],
            ['label' => 'Regular Academic Assessments'],
            ['label' => 'Individual Student Performance Monitoring'],
            ['label' => 'Academic Counselling'],
            ['label' => 'Parent Feedback and Interaction'],
        ],
    ],
];

$schoolStrengths = [
    ['icon' => 'graduation-cap', 'label' => 'Focus on Academic Excellence'],
    ['icon' => 'user-friends', 'label' => 'Holistic Student Development'],
    ['icon' => 'shield-alt', 'label' => 'Safe and Supportive Environment'],
    ['icon' => 'compass', 'label' => 'Focus on Discipline and Values'],
    ['icon' => 'lightbulb', 'label' => 'Learning Beyond the Classroom'],
    ['icon' => 'hands-helping', 'label' => 'Parent-School Partnership'],
];

include 'header.php';
?>

<main class="facilities-page">
    <section class="page-hero facilities-hero" aria-labelledby="facilities-page-title">
        <div class="container">
            <div class="row align-items-center g-4 g-lg-5">
                <div class="col-lg-6 facilities-hero-copy">
                    <div class="kicker">A place to learn and grow</div>
                    <h1 id="facilities-page-title" class="section-title">Our School Facilities</h1>
                    <p class="lead-copy mb-3">Providing a safe, supportive and enriching environment for academic excellence and all-round development.</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Facilities</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6">
                    <img class="facilities-hero-image" src="<?php echo seo_escape(site_image('facilities_hero', 'assets/images/gallery/classroom-02.jpg')); ?>" alt="Students learning together in a classroom" width="535" height="300" fetchpriority="high">
                </div>
            </div>
        </div>
    </section>

    <section class="section facilities-intro" aria-labelledby="facilities-intro-title">
        <div class="container">
            <div class="row align-items-center g-4 g-lg-5">
                <div class="col-lg-8">
                    <div class="kicker">Learning in every direction</div>
                    <h2 id="facilities-intro-title" class="section-title">Facilities That Inspire Excellence</h2>
                    <p class="lead-copy mb-0">At St. Xavier's High School, Siwan, we believe that quality education goes beyond textbooks and classrooms. We provide a supportive learning environment with academic resources, modern infrastructure, sports, extracurricular activities and student development opportunities to nurture confident, responsible and well-rounded individuals.</p>
                </div>
                <div class="col-lg-4">
                    <div class="facilities-intro-link">
                        <span class="facilities-intro-icon" aria-hidden="true"><i class="fas fa-book-reader"></i></span>
                        <div>
                            <h3>Explore learning at St. Xavier’s</h3>
                            <a href="academics.php">View our academic approach <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section facilities-list-section" aria-labelledby="facilities-list-title">
        <div class="container">
            <div class="facilities-section-heading">
                <div>
                    <div class="kicker">Learning, well-being and campus life</div>
                    <h2 id="facilities-list-title" class="section-title">Explore Our Facilities</h2>
                    <p class="lead-copy mb-0">Discover the resources, activities and support described for students and families.</p>
                </div>
                <p class="facilities-confirmation-key"></p>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 facilities-grid">
                <?php foreach ($facilityGroups as $index => $facility) : ?>
                    <div class="col">
                        <article class="facilities-card">
                            <div class="facilities-card-heading">
                                <span class="facilities-card-icon" aria-hidden="true"><i class="fas fa-<?php echo seo_escape($facility['icon']); ?>"></i></span>
                                <span class="facilities-card-number" aria-hidden="true"><?php echo str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT); ?></span>
                            </div>
                            <h3><?php echo seo_escape($facility['title']); ?></h3>
                            <p class="facilities-card-description"><?php echo seo_escape($facility['description']); ?></p>
                            <ul class="facilities-item-list">
                                <?php foreach ($facility['items'] as $item) : ?>
                                    <li>
                                        <i class="fas fa-check" aria-hidden="true"></i>
                                        <span><?php echo seo_escape($item['label']); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section facilities-strengths" aria-labelledby="facilities-strengths-title">
        <div class="container">
            <div class="text-center facilities-strengths-heading">
                <div class="kicker">The St. Xavier’s experience</div>
                <h2 id="facilities-strengths-title" class="section-title">Why Choose Our School?</h2>
            </div>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3">
                <?php foreach ($schoolStrengths as $strength) : ?>
                    <div class="col">
                        <div class="facilities-strength">
                            <span aria-hidden="true"><i class="fas fa-<?php echo seo_escape($strength['icon']); ?>"></i></span>
                            <h3><?php echo seo_escape($strength['label']); ?></h3>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section-sm facilities-cta-section" aria-labelledby="facilities-cta-title">
        <div class="container">
            <div class="facilities-cta">
                <div class="row align-items-center g-4 position-relative">
                    <div class="col-lg-8">
                        <div class="kicker text-warning">Your child’s next step</div>
                        <h2 id="facilities-cta-title" class="section-title">Give Your Child the Right Environment to Grow</h2>
                        <p class="mb-0">Explore the learning opportunities and facilities available at St. Xavier's High School, Siwan.</p>
                    </div>
                    <div class="col-lg-4">
                        <div class="facilities-cta-actions">
                            <a class="btn btn-light-pill" href="admissions.php">Explore Admissions <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i></a>
                            <a class="btn facilities-contact-button" href="contact.php">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>
