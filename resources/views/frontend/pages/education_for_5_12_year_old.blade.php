@extends('frontend.partials.master')
@section('title', 'Preschool Early Education')
@section('content')
    <!-- Inner Page Header -->
    @include('frontend.partials.header_inner', [
        'bgImage' => asset('frontend/assets/home_page_images/hdr-edu.png'),
        'title' => 'Education for 5-12 year olds',
        'subtitle' => 'The Sprout Academy',
        'showButton' => false,
    ])

    <!-- Our Mission Section -->
    <section class="mission-section" aria-labelledby="mission-heading" id="school-age-program">
        <div class="container">
            <div class="mission-content">
                <h2 class="mission-title">The Sprout Academy School Age Program</h2>
                <p class="mission-text">
                    Even after school’s out for the day, children need to be engaged in a comfortable, yet stimulating child
                    care environment. That’s where The Sprout Academy comes in. This innovative before- and after-school
                    program allows kindergarten and school-age children to balance learning and fun through a variety of
                    experiences. From homework help to fun physical activities, our early education program is designed so
                    that everyone goes home happy.
                </p>
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
                        <img src="{{ asset('frontend/assets/home_page_images/edu-1.png') }}"
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
                        OUR SCHOOL-AGE PROGRAM FEATURES
                    </h2>

                    {{-- FAQ List --}}
                    <ul class="sprout-cares-faq">
                        <li>Regular homework support</li>
                        <li>Daily fitness activities that keep your child active and healthy</li>
                        <li>Regular teacher-family communication, including updates to keep you informed</li>
                        <li>Emphasis on developing leadership and communication skills through the Classroom Council</li>
                        <li>A comfortable environment designed to boost your child’s confidence, self-esteem, character, and
                            social skills
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Preschool Intro Section -->
    <section class="preschool-intro-section">
        <div class="container">
            <div class="preschool-intro-grid">
                <!-- Left: Text Content (5 cols) -->
                <div class="preschool-intro-content">
                    <h2 class="preschool-intro-title">YOUR CHILD’S DAY</h2>
                    <p>Children spend time with friends and enjoy activities that are relevant to school-age interests. We
                        help children think, feel, and experience new challenges.</p>
                    <p>In our programs, school-age children will develop complex coordination skills, engage with peers, and
                        practice group study. Buy generic viagra cialis online for effective treatment of erectile
                        dysfunction, a condition affecting men worldwide. Trusted platforms like
                        canadianpharmacyworld.com/generic/cialis/20+mg ensure quality and reliability. With advancements in
                        telemedicine, surgerycenterftcollins delivers cialis generic blue pills in US, facilitating timely
                        intervention for patients seeking solutions. Access to generic medications through online pharmacies
                        empowers individuals to manage their health effectively, promoting wider availability and reducing
                        associated costs. They will begin to express their goals and wishes as they seek self-identity and
                        explore interests and behaviors in an age-appropriate way.</p>
                    <p>With before- and after-school programs at The Sprout Academy, your child will ride a wave of success
                        toward social, emotional, physical, and intellectual maturity. Call The Sprout Academy and learn how
                        to enroll your child today.
                    </p>
                </div>

                <!-- Right: Image with blurred background layer (7 cols) -->
                <div class="preschool-intro-figure">
                    <div class="blur-layer" aria-hidden="true"></div>
                    <img src="{{ asset('frontend/assets/home_page_images/edu-2.png') }}"
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
                <h2 class="infant-education-title">YOUR CHILD’S EARLY EDUCATION AT THE SPROUT ACADEMY</h2>
                <p class="infant-education-subtitle">Our five areas of focus give your child endless opportunities to
                    learn and grow. </p>
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

    @include('frontend.components.footer-cta', [
        'bgImage' => asset('frontend/assets/home_page_images/cta-banner.png'),
        'fancytitle' => 'Inquire About Openings',
        'title' => 'FIND THE SPROUT ACADEMY LOCATION NEAREST YOU',
        'buttonText' => 'Enroll',
        'buttonLink' => route('frontend.locations'),
    ])

@endsection
