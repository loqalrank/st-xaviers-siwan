<?php
/**
 * ============================================================
 *  SITE CONFIGURATION  —  single source of truth
 * ============================================================
 *  Edit this one file to control:
 *
 *  1. 'pages'   -> SEO title / description / OG image per page
 *  2. 'toppers' -> "Our School Toppers" section (home + academics)
 *  3. 'blog'    -> blog posts, tags, meta title & description
 *
 *  Meta title/description for every static page comes from
 *  'pages' below. Pages no longer hardcode their SEO values.
 * ============================================================
 */

$siteConfigData = [

    /* ---------------------------------------------------------
     * 1. PAGE META  (key = page filename used as $seoPage)
     * ------------------------------------------------------- */
    'pages' => [
        'index.php' => [
            'title'       => "St. Xavier's High School, Siwan | CBSE Nursery to 12",
            'description' => "St. Xavier's High School, Siwan: CBSE education from Nursery to Class 12 with academic excellence, strong values, digital learning and all-round development.",
            'image'       => 'assets/images/hero-learning-with-purpose.jpg',
        ],
        'about.php' => [
            'title'       => "About St. Xavier's High School, Siwan | Our Vision & Mission",
            'description' => "Learn about St. Xavier's High School, Siwan, our educational philosophy, vision, mission and commitment to academic and personal development.",
            'image'       => 'assets/images/local/campus.jpg',
        ],
        'academics.php' => [
            'title'       => "Academics | CBSE School in Siwan | St. Xavier's",
            'description' => "Explore the academic approach at St. Xavier's High School, Siwan, offering CBSE education from Nursery to Class 12.",
            'image'       => 'assets/images/gallery/academic-01.jpg',
        ],
        'admissions.php' => [
            'title'       => "Admissions Open | St. Xavier's High School, Siwan",
            'description' => "Enquire about admissions at St. Xavier's High School, Siwan. CBSE education from Nursery to Class 12. Contact us for admission procedures and details.",
            'image'       => 'assets/images/gallery/campus-01.jpg',
        ],
        'facilities.php' => [
            'title'       => "School Facilities in Siwan | St. Xavier's High School",
            'description' => "Explore the academic, sports, infrastructure, safety and student development facilities at St. Xavier's High School, Siwan.",
            'image'       => 'assets/images/gallery/classroom-02.jpg',
        ],
        'gallery.php' => [
            'title'       => "School Gallery | St. Xavier's High School, Siwan",
            'description' => "Explore campus photographs, classroom activities, sports, celebrations and creative learning moments at St. Xavier's High School, Siwan.",
            'image'       => 'assets/images/gallery/campus-02.jpg',
        ],
        'blog.php' => [
            'title'       => "School News, Results & Updates | St. Xavier High School Siwan",
            'description' => "Latest news, CBSE results and school updates from St. Xavier High School, Siwan, Bihar.",
            'image'       => 'assets/images/local/school-campus.jpg',
        ],
        'blog-detail.php' => [
            'title'       => "School News & Results | St. Xavier High School Siwan",
            'description' => "Read the latest news and CBSE results from St. Xavier High School, Siwan, Bihar.",
            'image'       => 'assets/images/local/school-campus.jpg',
        ],
        'messages.php' => [
            'title'       => "Leadership Messages | St. Xavier's High School, Siwan",
            'description' => "Read messages from the Director and Principal of St. Xavier's High School, Siwan.",
            'image'       => 'assets/images/local/teacher.jpg',
        ],
        'faq.php' => [
            'title'       => "FAQs | St. Xavier's High School, Siwan",
            'description' => "Answers to common questions about admissions, fees, campus visits and school facilities.",
            'image'       => 'assets/images/gallery/classroom-03.jpg',
        ],
        'contact.php' => [
            'title'       => "Contact St. Xavier's High School, Siwan | Admission Enquiry",
            'description' => "Contact St. Xavier's High School, Shambhupatti, Siwan, Bihar. Call the school or submit an online enquiry for admission and general information.",
            'image'       => 'assets/images/local/school-campus.jpg',
        ],
        'mandatory-disclosure.php' => [
            'title'       => "Mandatory Public Disclosure | St. Xavier's High School, Siwan",
            'description' => "Access mandatory public disclosure information, affiliation details, certificates and school documents for St. Xavier's High School, Siwan.",
            'image'       => 'assets/images/local/campus.jpg',
        ],
    ],

    /* ---------------------------------------------------------
     * 2. TOPPERS SECTION  (home page + academics page)
     * ------------------------------------------------------- */
    'toppers' => [
        'enabled'  => true,
        'year'     => '2023“24',
        'kicker'   => 'Proud Achievers',
        'title'    => 'Our School Toppers',
        'subtitle' => "St. Xavier's High School, Siwan — celebrating the dedication and hard work of our students who achieved outstanding board results.",

        'toppers' => [
            [
                'name'  => 'Anshika Verma',
                'class' => 'Class X',
                'score' => '95%',
                'image' => 'assets/images/toppers/01_Anshika_Verma.png',
                'note'  => 'School Topper',
            ],
            [
                'name'  => 'Navya Agrawal',
                'class' => 'Class X',
                'score' => '92%',
                'image' => 'assets/images/toppers/02_Navya_Agrawal.png',
                'note'  => 'Second Position',
            ],
            [
                'name'  => 'Siddhi Kumari',
                'class' => 'Class X',
                'score' => '91%',
                'image' => 'assets/images/toppers/03_Siddhi_Kumari.png',
                'note'  => 'Third Position',
            ],
            [
                'name'  => 'Om Gaurav',
                'class' => 'Class XII',
                'score' => '90%',
                'image' => 'assets/images/toppers/04_Om_Gaurav.png',
                'note'  => 'School Topper',
            ],
            [
                'name'  => 'Shristi Anand',
                'class' => 'Class XII',
                'score' => '86%',
                'image' => 'assets/images/toppers/05_Shristi_Anand.png',
                'note'  => 'Second Position',
            ],
            [
                'name'  => 'Ankit Raj Singh',
                'class' => 'Class XII',
                'score' => '85%',
                'image' => 'assets/images/toppers/06_Ankit_Raj_Singh.png',
                'note'  => 'Third Position',
            ],
        ],
    ],

    /* ---------------------------------------------------------
     * 3. BLOG  (posts + tags; meta title/description per post)
     *    URL is built from 'title' automatically.
     * ------------------------------------------------------- */
    'blog' => [
        'posts' => [
            [
                'title'            => 'St. Xavier High School Siwan Achieves 100% Success in CBSE Class 10 Results',
                'meta_title'       => 'St. Xavier High School Siwan CBSE Class 10 Result: 100% Pass',
                'meta_description' => 'St. Xavier High School, Shambhupatti, Siwan, achieves a 100% pass rate in CBSE Class 10 results. Ayush Raj tops the school with 97.4% marks.',
                'category'         => 'Education & School News',
                'date'             => '2026-11-19',
                'read_time'        => '3 min read',
                'image'            => 'assets/images/local/school-campus.jpg',
                'image_alt'        => 'St. Xavier High School, Siwan campus',
                'excerpt'          => 'St. Xavier High School, Shambhupatti, Siwan, has achieved a remarkable 100% pass rate in the CBSE Class 10 examination. All 40 students successfully passed the examination, with Ayush Raj securing the top position with 97.4% marks.',
                'tags'             => [
                    'St. Xavier High School',
                    'St Xavier School Siwan',
                    'Siwan News',
                    'CBSE Class 10 Result',
                    'CBSE Board Result',
                    'Class 10 Topper',
                    'Ayush Raj',
                    'School Topper',
                    'Bihar Education News',
                    'Siwan Education News',
                    '100% Result',
                ],
                'content' => <<<'HTML'
<p class="lead-copy"><strong>Siwan:</strong> St. Xavier High School, located in Shambhupatti in the Siwan Municipal Corporation area, has achieved an outstanding milestone in the CBSE Class 10 examination by recording a 100% pass result this year. All 40 students who appeared for the examination successfully passed, bringing pride and happiness to the school.</p>
<p class="lead-copy">The school's Principal, Pinky Murjani, shared the achievement and appreciated the hard work and dedication of the students, teachers, and school management in delivering this excellent academic performance.</p>

<h2 class="h3 mt-5">Ayush Raj Tops the School with 97.4% Marks</h2>
<p class="lead-copy">Ayush Raj emerged as the school topper by securing an impressive 97.4% marks in the CBSE Class 10 examination.</p>
<p class="lead-copy">Prajjwal Kumar and Mayank Agarwal jointly secured the second position with 95.2% marks. Aastha Priya also delivered an excellent performance, scoring 94.6% marks.</p>
<p class="lead-copy">The students demonstrated their academic excellence through consistent preparation and dedication throughout the academic year.</p>

<h2 class="h3 mt-5">Students Deliver Excellent Academic Performance</h2>
<p class="lead-copy">According to the school principal, a significant number of students secured more than 75% marks in the examination.</p>
<p class="lead-copy">The school attributed this achievement to disciplined learning, regular academic guidance, dedicated teachers, and timely completion of the syllabus.</p>
<p class="lead-copy">The school's focus on maintaining an effective learning environment and supporting students throughout their preparation contributed to this successful result.</p>

<h2 class="h3 mt-5">Celebration and Pride at St. Xavier High School</h2>
<p class="lead-copy">The 100% pass result has created an atmosphere of excitement and celebration among students, teachers, parents, and the school management.</p>
<p class="lead-copy">The school congratulated all successful students and wished them continued success in their future academic journeys.</p>
<p class="lead-copy">This achievement marks another proud moment for St. Xavier High School and adds to the growing reputation of Siwan as an emerging centre of quality education in Bihar.</p>
HTML,
            ],
            [
                'title'            => "St. Xavier's Schools in Siwan Achieve Excellent CBSE Results, Students Shine in Class 10 and 12",
                'meta_title'       => "St. Xavier's School Siwan CBSE Result “ Class 10 & 12",
                'meta_description' => "St. Xavier's schools in Siwan celebrate excellent CBSE results. Vibhutipur school records 98% success in Class 12, while Shambhupatti school achieves 100% results in Classes 10 and 12.",
                'category'         => 'Education & School News',
                'date'             => '2026-11-19',
                'read_time'        => '4 min read',
                'image'            => 'assets/images/local/school-campus.jpg',
                'image_alt'        => "St. Xavier's schools in Siwan",
                'excerpt'          => "St. Xavier's schools in Siwan have delivered outstanding CBSE examination results. St. Xavier's Public School, Vibhutipur, recorded 98% success in Class 12, while St. Xavier High School, Shambhupatti, achieved 100% results in Classes 10 and 12.",
                'tags'             => [
                    "St. Xavier's School",
                    'St Xavier Public School',
                    'St Xavier High School',
                    'Siwan',
                    'Vibhutipur',
                    'Shambhupatti',
                    'CBSE Result',
                    'CBSE Class 10',
                    'CBSE Class 12',
                    'School Toppers',
                    'Bihar Education News',
                    'Academic Excellence',
                ],
                'content' => <<<'HTML'
<p class="lead-copy"><strong>Siwan, Bihar:</strong> St. Xavier's schools in Siwan district have once again demonstrated their commitment to academic excellence through outstanding performances in the CBSE board examinations. Students from both St. Xavier's Public School, Vibhutipur, and St. Xavier High School, Shambhupatti, have achieved remarkable results in Classes 10 and 12.</p>
<p class="lead-copy">The impressive performances have brought pride and happiness to students, parents, teachers, and the school management.</p>

<h2 class="h3 mt-5">St. Xavier's Public School, Vibhutipur Records 98% Success in Class 12</h2>
<p class="lead-copy">St. Xavier's Public School, located at Dah Chowk, Bajidpur Bampiya, Vibhutipur, has recorded an impressive 98% success rate in the CBSE Class 12 examination.</p>
<p class="lead-copy">Tanya Raj emerged as the school topper with an outstanding 92.8% marks.</p>
<p class="lead-copy">Other students also delivered excellent performances:</p>

<h3 class="h4 mt-4">Class 12 Top Performers</h3>
<div class="table-responsive">
<table class="table table-bordered align-middle">
<thead><tr><th scope="col">Student Name</th><th scope="col" class="text-end">Percentage</th></tr></thead>
<tbody>
<tr><td>Tanya Raj</td><td class="text-end">92.8%</td></tr>
<tr><td>Abhijeet Singh</td><td class="text-end">92.6%</td></tr>
<tr><td>Alok Kumar</td><td class="text-end">91.8%</td></tr>
<tr><td>Vicky Kumar</td><td class="text-end">91.2%</td></tr>
<tr><td>Mukund Kumar Jha</td><td class="text-end">90.8%</td></tr>
<tr><td>Muskan Jha</td><td class="text-end">90.6%</td></tr>
<tr><td>Nikhil Kumar</td><td class="text-end">89.8%</td></tr>
<tr><td>Kartik Kumar</td><td class="text-end">89.6%</td></tr>
<tr><td>Swati Swaraj</td><td class="text-end">88.8%</td></tr>
<tr><td>Preeti Kumari</td><td class="text-end">87.0%</td></tr>
<tr><td>Akanksha</td><td class="text-end">86.4%</td></tr>
<tr><td>Nitish Naveen</td><td class="text-end">85.8%</td></tr>
</tbody>
</table>
</div>

<p class="lead-copy">The results reflect the hard work, dedication, and consistent efforts of the students throughout the academic year.</p>
<p class="lead-copy">The school's Managing Director, Vijay Kumar Chaudhary, and Principal, Ujjwal Kumar Gautam, congratulated all successful students and appreciated their achievements.</p>

<h2 class="h3 mt-5">St. Xavier High School, Shambhupatti Achieves 100% Results in Classes 10 and 12</h2>
<p class="lead-copy">In another remarkable achievement, St. Xavier High School, located in Shambhupatti, Siwan, has recorded a 100% pass result in both CBSE Class 10 and Class 12 examinations.</p>
<p class="lead-copy">According to the school principal, all students who appeared for the examinations successfully passed.</p>
<p class="lead-copy">Anshika Verma secured the first position with an outstanding 95% marks. Navya Agarwal achieved 92%, while Siddhi Kumari secured 91%. Om Gaurav also delivered an excellent performance with 90% marks.</p>

<h3 class="h4 mt-4">Class 10 and 12 Academic Performance</h3>
<p class="lead-copy">The school reported that 21 students secured marks between 80% and 90%, while nine students achieved marks between 70% and 80%.</p>
<p class="lead-copy">This excellent performance reflects the school's emphasis on academic discipline, quality education, and continuous student development.</p>

<h2 class="h3 mt-5">A Proud Moment for Students, Parents and Teachers</h2>
<p class="lead-copy">The outstanding CBSE results from both school campuses highlight the importance of dedicated teaching, disciplined learning, and consistent academic preparation.</p>
<p class="lead-copy">The school management congratulated the successful students and appreciated the contribution of teachers and parents in supporting their academic journeys.</p>
<p class="lead-copy">These achievements mark another proud moment for St. Xavier's schools and the education community of Siwan, Bihar.</p>
<p class="lead-copy"><strong>Congratulations to all the successful students!</strong> May they continue to achieve greater heights in their future academic and professional journeys.</p>
HTML,
            ],
        ],
    ],

    /* ---------------------------------------------------------
     * 4. GALLERY  (categories + images)
     *    'key' is used by the filter buttons; item 'category'
     *    must match one of these keys.
     * ------------------------------------------------------- */
    'gallery' => [
        'categories' => [
            'campus'       => 'School Campus',
            'classroom'    => 'Classroom Activities',
            'academic'     => 'Academic Activities',
            'sports'       => 'Sports and Games',
            'cultural'     => 'Cultural Events',
            'celebrations' => 'Celebrations and Events',
        ],
        'items' => [],
    ],

    /* ---------------------------------------------------------
     * 5. FAQ  (categories + questions)
     *    'category' must match one of the keys in 'categories'.
     *    'answer'       -> plain text (used for FAQPage schema)
     *    'answer_html'  -> optional; shown on the page if present
     * ------------------------------------------------------- */
    'faq' => [
        'categories' => [
            'about'      => 'About the School',
            'admissions' => 'Admissions',
            'academics'  => 'Academics and Learning',
            'fees'       => 'Fees and Facilities',
            'contact'    => 'Contact and Enquiries',
        ],
        'items' => [
            [
                'category' => 'about',
                'question' => 'Where is St. Xavier’s High School located?',
                'answer'   => "St. Xavier's High School is located at Baishakhi, Siwan, Bihar. For directions and assistance, please contact the school office.",
                'answer_html' => <<<'HTML'
St. Xavier's High School is located at:<br>Baishakhi, Siwan, Bihar.<br><br>For directions and assistance, <a href="contact.php">please contact the school office</a>.
HTML,
            ],
            [
                'category' => 'about',
                'question' => 'Which education board is St. Xavier’s High School affiliated with?',
                'answer'   => "St. Xavier's High School, Siwan, is affiliated with the Central Board of Secondary Education (CBSE) up to 10+2 Level.",
            ],
            [
                'category' => 'admissions',
                'question' => 'How can I get admission for my child?',
                'answer'   => 'Parents can apply for admission by filling out the online enquiry form, contacting the school office via phone or WhatsApp, or visiting the school campus in person for guidance regarding the admission process and required documents. Please confirm the final checklist with the admission office.',
            ],
            [
                'category' => 'admissions',
                'question' => 'Which classes are open for admission?',
                'answer'   => "St. Xavier's High School offers education from Nursery to Class 12. Admission to individual classes is subject to seat availability and the school's admission guidelines.",
            ],
            [
                'category' => 'admissions',
                'question' => 'What is the minimum age required for Nursery admission?',
                'answer'   => "As per NEP 2020 guidelines, the minimum age for Nursery admission is 3 years. The applicable age criteria will be determined according to the school's admission policy and government guidelines.",
            ],
            [
                'category' => 'admissions',
                'question' => 'What documents are required for admission?',
                'answer'   => "Documents may include the child's birth certificate, passport-size photographs, previous academic records (where applicable), transfer certificate (where applicable) and parent or guardian identification. Please confirm the final checklist with the admission office.",
            ],
            [
                'category' => 'admissions',
                'question' => 'Is there any admission test?',
                'answer'   => 'For Nursery (Nur) admission, no written admission test is conducted. For admission to all other classes, students are required to appear for an entrance assessment to evaluate their academic knowledge and understanding.',
            ],
            [
                'category' => 'academics',
                'question' => 'What is the student-teacher ratio?',
                'answer'   => 'We maintain a student-teacher ratio of 30:1 to ensure individual attention, effective classroom interaction, personalised learning, and proper academic support for every student.',
            ],
            [
                'category' => 'academics',
                'question' => 'Does the school provide smart classes?',
                'answer'   => 'Yes, our school provides smart classroom facilities with digital learning tools and audio-visual teaching methods to make lessons more interactive, engaging, and effective. These facilities help students understand concepts better and enhance their overall learning experience.',
            ],
            [
                'category' => 'academics',
                'question' => 'Are extra classes available for students who need additional academic support?',
                'answer'   => 'Yes, we provide extra classes, revision sessions, and individual academic guidance for students who need additional support to strengthen their understanding and improve their academic performance.',
            ],
            [
                'category' => 'academics',
                'question' => 'Does the school organise Olympiads and other competitions?',
                'answer'   => 'Yes, our school regularly organises and encourages students to participate in various Olympiads, academic competitions, quizzes, cultural events, sports activities, and other inter-school competitions to develop their knowledge, confidence, creativity, and competitive spirit.',
            ],
            [
                'category' => 'academics',
                'question' => "How does the school evaluate students' academic performance?",
                'answer'   => "Students' academic performance is evaluated through regular assessments, periodic tests, assignments, projects, classroom activities, quizzes, and term examinations. We also monitor students' overall learning progress, skills, and participation, and share their progress with parents through report cards and Parent-Teacher Meetings (PTMs).",
            ],
            [
                'category' => 'fees',
                'question' => 'Does the school have a computer laboratory?',
                'answer'   => "Yes. The school has a computer laboratory to support students' computer education and technology-related learning.",
            ],
            [
                'category' => 'fees',
                'question' => 'Is there a well-equipped science laboratory?',
                'answer'   => 'Yes. The school has a science laboratory to support practical learning, scientific exploration and subject-related activities.',
            ],
            [
                'category' => 'fees',
                'question' => 'Does the school have a library?',
                'answer'   => "Yes. The school has a library that supports students' reading habits, knowledge development and independent learning.",
            ],
            [
                'category' => 'fees',
                'question' => 'Are indoor and outdoor sports facilities available?',
                'answer'   => 'The school provides sports and playground facilities to encourage physical fitness, teamwork and participation in sports activities. Please contact the school for details about specific indoor and outdoor sports facilities.',
            ],
            [
                'category' => 'fees',
                'question' => 'Does the school provide CCTV surveillance?',
                'answer'   => "Yes. CCTV security is among the school's facilities and supports campus monitoring and security.",
            ],
            [
                'category' => 'fees',
                'question' => 'Are extracurricular activities organised?',
                'answer'   => 'Yes. Students have opportunities to participate in activities such as music, dance, art and craft, along with sports and other school activities.',
            ],
            [
                'category' => 'fees',
                'question' => 'Does the school provide transport facilities?',
                'answer'   => 'Yes. School transport facilities are available. Parents can contact the school office for route availability, timings and transport-related information.',
                'answer_html' => <<<'HTML'
Yes. School transport facilities are available. Parents can <a href="contact.php">contact the school office</a> for route availability, timings and transport-related information.
HTML,
            ],
            [
                'category' => 'contact',
                'question' => 'How can I contact the school office?',
                'answer'   => 'Parents and visitors can contact the school through the following details: Phone: +91-8000800362, Phone: +91-8000800364, Phone/WhatsApp: +91-8000800368, Email: stxavierssiwan@gmail.com',
                'answer_html' => <<<'HTML'
Parents and visitors can contact the school through the following details:<br><strong>Phone:</strong> +91-8000800362<br><strong>Phone:</strong> +91-8000800364<br><strong>Phone / WhatsApp:</strong> +91-8000800368<br><strong>Email:</strong> stxavierssiwan@gmail.com
HTML,
            ],
        ],
    ],

    /* ---------------------------------------------------------
     * 6. HERO CAROUSEL  (homepage slides)
     * ------------------------------------------------------- */
    'hero' => [
        'slides' => [
            [
                'image'         => 'assets/images/hero-learning-with-purpose.jpg',
                'image_alt'     => "St. Xavier's High School - Learning with purpose",
                'tag'           => 'Learning with purpose',
                'title'         => "Building Knowledge.\nInspiring Excellence.\nShaping Futures.",
                'description'   => "Welcome to St. Xavier's High School, Siwan — where learning goes beyond textbooks. We strive to nurture knowledge, confidence, creativity and strong values, helping students grow into responsible and capable individuals.",
                'button_label'  => 'Explore Our School',
                'button_link'   => 'about.php',
                'button2_label' => 'Admission Enquiry',
                'button2_link'  => 'admissions.php',
                'sticker_title' => 'Learn boldly.',
                'sticker_text'  => 'Grow confidently.',
            ],
            [
                'image'        => 'assets/images/hero-meaningful-learning.jpg',
                'image_alt'    => "St. Xavier's High School - Meaningful learning",
                'tag'          => 'Meaningful learning',
                'title'        => "Learning Today for a\nBetter Tomorrow",
                'description'  => 'Encourage curiosity, develop confidence and discover new possibilities through meaningful learning experiences.',
                'button_label' => 'View Gallery',
                'button_link'  => 'gallery.php',
            ],
            [
                'image'        => 'assets/images/hero-beyond-classroom.jpg',
                'image_alt'    => "St. Xavier's High School - Beyond the classroom",
                'tag'          => 'Beyond the classroom',
                'title'        => "Beyond Classrooms,\nTowards Excellence",
                'description'  => 'Nurturing creativity, leadership, teamwork and the individual talents of every student.',
                'button_label' => 'Explore Academics',
                'button_link'  => 'academics.php',
            ],
            [
                'image'        => 'assets/images/hero-values-for-life.jpg',
                'image_alt'    => "St. Xavier's High School - Values for life",
                'tag'          => 'Values for life',
                'title'        => "Strong Values.\nBright Futures.",
                'description'  => 'Building responsible, confident and compassionate individuals through education and character development.',
                'button_label' => 'Admission Enquiry',
                'button_link'  => 'admissions.php',
            ],
        ],
    ],

    /* ---------------------------------------------------------
     * 7. ADMISSION POPUP
     *    Set 'enabled' => false to hide the popup site-wide.
     *    'auto_open' => true shows it on every page load.
     *    'auto_close_seconds' => 0 keeps it open until closed manually.
     * ------------------------------------------------------- */
    'admission_popup' => [
        'enabled'            => true,
        'auto_open'          => true,
        'auto_close_seconds' => 30,
        'pages'              => [
            'index.php',
            'about.php',
            'academics.php',
            'admissions.php',
            'facilities.php',
            'gallery.php',
            'blog.php',
            'blog-detail.php',
            'contact.php',
            'faq.php',
            'messages.php',
            'mandatory-disclosure.php',
        ],
        'image'              => 'assets/images/hero-students.jpg',
        'logo'               => 'assets/images/school-logo.png',
        'eyebrow'            => 'Admissions Open',
        'year'               => '2026–27',
        'title'              => 'School',
        'title_accent'       => 'Admission',
        'subline'            => 'A strong CBSE foundation with values, discipline and all-round development.',
        'cta_label'          => 'Call Now',
    ],

    /* ---------------------------------------------------------
     * 8. MANDATORY DISCLOSURE  (PDF documents grouped by section)
     * ------------------------------------------------------- */
    'mandatory_disclosure' => [
        'documents' => [],
    ],
    /* ---------------------------------------------------------
     * 9. SITE IMAGES  (section images managed from the admin panel)
     * ------------------------------------------------------- */
    'site_images' => [
        'home_welcome'     => ['label' => 'Home - Welcome photo', 'path' => 'assets/images/local/school-campus.jpg'],
        'home_spotlight_1' => ['label' => 'Home - Gallery card: Classroom', 'path' => 'assets/images/gallery/classroom-02.jpg'],
        'home_spotlight_2' => ['label' => 'Home - Gallery card: Sports', 'path' => 'assets/images/gallery/sports-03.jpg'],
        'home_spotlight_3' => ['label' => 'Home - Gallery card: Activities', 'path' => 'assets/images/gallery/cultural-05.jpg'],
        'about_hero'       => ['label' => 'About Us - Main image', 'path' => 'assets/images/local/school-campus.jpg'],
        'academics_hero'   => ['label' => 'Academics - Main image', 'path' => 'assets/images/local/classroom.jpg'],
        'facilities_hero'  => ['label' => 'Facilities - Hero image', 'path' => 'assets/images/gallery/classroom-02.jpg'],
        'messages_hero'    => ['label' => 'Messages - Main image', 'path' => 'assets/images/hero-students.jpg'],
    ],
];

require_once __DIR__ . '/content-store.php';

$siteConfigData = content_store_overlay($siteConfigData);

if (function_exists('site_images_register')) {
    site_images_register(isset($siteConfigData['site_images']) && is_array($siteConfigData['site_images']) ? $siteConfigData['site_images'] : []);
}

return $siteConfigData;

