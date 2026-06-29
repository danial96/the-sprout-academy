@extends('frontend.partials.master')
@section('title', 'Preschool Early Education')
@section('content')
    <!-- Inner Page Header -->
    @include('frontend.partials.header_inner', [
        'bgImage' => asset('frontend/assets/home_page_images/hdr-pr.png'),
        'title' => 'Preschool Early Education',
        'subtitle' => 'everything we do is designed for learning',
        'showButton' => false,
    ])

    <!-- Preschool Intro Section -->
    <section class="preschool-intro-section">
        <div class="container">
            <div class="preschool-intro-grid">
                <!-- Left: Text Content (5 cols) -->
                <div class="preschool-intro-content">
                    <h2 class="preschool-intro-title">THE SPROUT ACADEMY PRESCHOOL PROGRAM</h2>
                    <p>As preschoolers gain more self-esteem, they feel ready to take on the world. Our preschool program
                        enhances that confidence by providing activities to help children become problem solvers and develop
                        a love of lifelong learning.</p>
                    <p>Through independent exploration, structured activities, and hands-on learning, children develop a
                        variety of skills and knowledge in areas like early literacy, mathematics, science, Spanish and
                        social skills.</p>
                    <p>We’re proud of the work we do. In fact, The Sprout Academy creates its programs to align to the
                        highest quality learning standards that progress sequentially across six developmental domains.
                        <strong class="these-include">These include:</strong>
                    </p>
                    <ul class="preschool-intro-list">
                        <li>Cognitive Development</li>
                        <li>Creative Expression</li>
                        <li>Executive Function</li>
                        <li>Language and Literacy Development</li>
                        <li>Physical Development and Wellness</li>
                        <li>Social and Emotional Development</li>
                    </ul>
                    <p class="preschool-intro-note">Add to this a healthy dose of running, jumping and movement to keep them
                        active and you start to see why The Sprout Academy is a true leader in early childhood education.
                    </p>
                </div>

                <!-- Right: Image with blurred background layer (7 cols) -->
                <div class="preschool-intro-figure">
                    <div class="blur-layer" aria-hidden="true"></div>
                    <img src="{{ asset('frontend/assets/home_page_images/pr-img-1.png') }}"
                        alt="Preschooler playing with colorful blocks" class="preschool-intro-image" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    {{-- Your Infant's Early Education Section --}}
    <section class="infant-education-accordion-section">
        <div class="container">
            {{-- Header with Icon, Title, and Subtitle --}}
            <div class="infant-education-header">
                <img src="{{ asset('frontend/assets/home_page_images/123.png') }}" alt="Education Icon"
                    class="infant-education-icon">
                <h2 class="infant-education-title">A GUIDE TO YOUR CHILD’S EARLY EDUCATION</h2>
                <p class="infant-education-subtitle">Discover how our six areas of focus give your child endless
                    opportunities to learn and grow.</p>
            </div>

            {{-- Accordion Section --}}
            @include('frontend.components.accordion-section', [
                'sectionTitle' => '',
                'leftIcon' => null,
                'rightIcon' => null,
                'columns' => 1,
                'accordionItems' => [
                    [
                        'title' => 'COMMUNICATING WITH OTHERS',
                        'expanded' => false,
                        'content' =>
                            'The Sprout Academy helps your infant develop communication skills through daily interactions, songs, and age-appropriate activities that encourage vocalization and early language development.',
                    ],
                    [
                        'title' => 'BUILDING BRAIN POWER',
                        'expanded' => false,
                        'content' =>
                            'We provide stimulating experiences that support cognitive development, including sensory exploration, cause-and-effect activities, and opportunities for your infant to discover and learn about their world.',
                    ],
                    [
                        'title' => 'MAKING NEW FRIENDS',
                        'expanded' => false,
                        'content' =>
                            'Your infant will have opportunities to interact with other children in a safe, supervised environment, helping them develop early social skills and emotional connections.',
                    ],
                    [
                        'title' => 'GROWING A HEALTHY BODY',
                        'expanded' => false,
                        'content' =>
                            'The Sprout Academy helps your infant improve mobility and coordination. We support your baby as he or she rolls from side-to-side and learns to crawl, stand, and walk; support the development of motor skills with blocks and shape boards; and meet your child\'s individual needs for rest and nutrition.',
                    ],
                    [
                        'title' => 'NURTURING CREATIVITY',
                        'expanded' => false,
                        'content' =>
                            'Through art, music, and imaginative play, we encourage your infant\'s natural creativity and curiosity, providing a foundation for creative thinking and self-expression.',
                    ],
                ],
            ])
        </div>
    </section>

    {{-- Meet the Owners Section --}}
    <section class="meet-owners-section" id="preschool-features">
        <div class="container">
            <div class="meet-owners-grid">
                {{-- Left Column - Names & Icons --}}
                <div class="meet-owners-left">

                    <div class="owners-name-wrapper">
                        <h2 class="owners-name">
                            OUR PRESCHOOL
                            PROGRAM FEATURES
                        </h2>
                    </div>

                    {{-- Tree Background Image --}}
                    <div class="owners-tree-bg">
                        <img src="{{ asset('frontend/assets/home_page_images/tree-layer.png') }}" alt="Tree">
                    </div>
                </div>

                {{-- Right Column - Description Text --}}
                <div class="meet-owners-right">
                    <ul class="preschool-features-list">
                        <li>Themed units that encourage your child’s curiosity, increase confidence, and support
                            self-directed activities</li>
                        <li>Hands-on experiences designed to boost problem solving and scientific thinking skills</li>
                        <li>Daily small- and whole-group activities</li>
                        <li>Observation-based assessments that track your child’s progress toward developmental milestones
                            and school readiness </li>
                        <li>Portfolios that document growth and development through your child’s work</li>
                        <li>Regular teacher-family communication, including ways you can continue the learning in your own
                            home  </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Parents Love Us Section -->
    <section class="why-parents-section section" aria-labelledby="why-parents-heading">
        <div class="container">
            <!-- Video Showcase at Top -->
            <div class="main-video-wrapper">
                <div class="video-showcase-main">
                    <video id="main-video" class="main-video-player"
                        poster="{{ asset('frontend/assets/home_page_images/pr-img-2.png') }}" controls playsinline>
                        <source src="{{ asset('frontend/assets/home_page_images/Curriculum_1.mp4') }}" type="video/mp4">
                        <source src="{{ asset('frontend/assets/home_page_images/Curriculum_1.webm') }}" type="video/webm">
                        Your browser does not support the video tag.
                    </video>
                    <button class="video-play-btn-main" id="play-video-btn"
                        aria-label="Play video about our learning approach">
                        <span class="visually-hidden">Play video</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Preschool Intro Section -->
    <section class="preschool-intro-section" id="preschool-features-part2">
        <div class="container">
            <div class="preschool-intro-grid">
                <!-- Right: Image with blurred background layer (7 cols) -->
                <div class="preschool-intro-figure">
                    <div class="blur-layer" aria-hidden="true"></div>
                    <img src="{{ asset('frontend/assets/home_page_images/Preschool-3-5-yrs.png') }}"
                        alt="Preschooler playing with colorful blocks" class="preschool-intro-image" loading="lazy">
                </div>
                <!-- Left: Text Content (5 cols) -->
                <div class="preschool-intro-content">
                    <h2 class="preschool-intro-title">THE SPROUT ACADEMY PRESCHOOL PROGRAM</h2>
                    <p>Prekindergarten is a time when children are making connections between what they know and what they
                        are learning. As they leave the world of preschool and head towards kindergarten, children are
                        learning to participate in routines, demonstrate ability to make decisions,
                        and plan ahead. </p>
                    <p>Daily activities at The Sprout Academy are designed to help children continue to make decisions on
                        their own and in the classroom. We prepare them for the next stage of their education while giving
                        them a place to feel comfortable and safe to explore their interests.</p>
                    <p>The Sprout Academy creates its programs to align to the highest quality learning standards that
                        progress sequentially across six developmental domains.
                        <strong class="these-include">These include:</strong>
                    </p>
                    <ul class="preschool-intro-list">
                        <li>Cognitive Development</li>
                        <li>Creative Expression</li>
                        <li>Executive Function</li>
                        <li>Language and Literacy Development</li>
                        <li>Physical Development and Wellness</li>
                        <li>Social and Emotional Development</li>
                    </ul>
                    <p class="preschool-intro-note">You see, our holistic approach in the classroom engages young minds with
                        the early learning fundamentals they’ll need as they continue on to kindergarten, with a rich blend
                        of skills, interests and a love of learning.
                    </p>
                </div>


            </div>
        </div>
    </section>
    

    {{-- The Sprout Academy Cares Section --}}
    <section class="sprout-cares-section" id="preschool-features-part3">
        <div class="container">
            <div class="sprout-cares-grid">
                {{-- Right Column - Framed Image --}}
                <div class="sprout-cares-image-wrapper">
                    <div class="sprout-cares-image-frame">
                        <img src="{{ asset('frontend/assets/home_page_images/pr-img-4.png') }}"
                            alt="Children enjoying learning activities at The Sprout Academy" class="sprout-cares-image"
                            loading="lazy">
                    </div>
                </div>
                {{-- Left Column - Text Content --}}
                <div class="sprout-cares-content">
                    {{-- Top Icon --}}
                    <div class="sprout-cares-icon-top">
                        <img src="{{ asset('frontend/assets/home_page_images/lock.png') }}" alt="Education Icon">
                    </div>

                    {{-- Headline --}}
                    <h2 class="sprout-cares-title">
                        OUR PREKINDERGARTEN PROGRAM FEATURES
                    </h2>

                    {{-- FAQ List --}}
                    <ul class="sprout-cares-faq">
                        <li>Activities and lessons that help prepare your child for kindergarten and school success</li>
                        <li>Small-group lessons focused on mathematics, Spanish and literacy</li>
                        <li>Whole-group activities that help your child build an awareness of others and a sense of
                            community</li>
                        <li>Hands-on experiences that encourage independent, creative learning</li>
                        <li>Classroom activities and design features that help your child build literacy and numeracy skills
                        </li>
                        <li>Regular teacher-family communication, including ways to connect your child’s learning at home
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    @include('frontend.components.footer-cta', [
        'bgImage' => asset('frontend/assets/home_page_images/cta-banner.png'),
        'fancytitle' => 'Inquire About Openings',
        'title' => 'FIND THE SPROUT ACADEMY LOCATION NEAREST YOU',
        'buttonText' => 'Enroll',
        'buttonLink' => route('frontend.enroll'),
    ])

@endsection
