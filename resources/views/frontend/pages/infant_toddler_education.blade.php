@extends('frontend.partials.master')
@section('title', 'Infant Toddler Education')
@section('content')
    <!-- Inner Page Header -->
    @include('frontend.partials.header_inner', [
        'bgImage' => asset('frontend/assets/home_page_images/Infant-Toddler-Education-banner.png'),
        'title' => 'Infant & Toddler Education',
        'subtitle' => 'everything we do is designed for learning',
        'showButton' => false,
    ])

    <!-- Our Mission Section -->
    <section class="mission-section" aria-labelledby="mission-heading" id="programs">
        <div class="container">
            <div class="mission-content" id="infant-program-content">
                <h2 class="mission-title">The Sprout Academy Infant Program</h2>
                <p class="mission-text">
                    Infants grow and learn every day. The Sprout Academy provides a safe and nurturing “home away from home”
                    where infants can explore and make new discoveries.Young children learn through play, and our infant
                    care program is designed to provide infants with the skills that serve as building blocks for a lifetime
                    of learning. We appreciate you trusting us with your infant’s care and education, and we’re committed to
                    making this first transition away from home easy and natural for you and your child.
                </p>
            </div>
        </div>
    </section>

    {{-- The Sprout Academy Cares Section --}}
    <section class="sprout-cares-section" id="infant-program-features">
        <div class="container">
            <div class="sprout-cares-grid">

                {{-- left Column - Framed Image --}}
                <div class="sprout-cares-image-wrapper">
                    <div class="sprout-cares-image-frame">
                        <img src="{{ asset('frontend/assets/home_page_images/td-2.png') }}"
                            alt="Children enjoying learning activities at The Sprout Academy" class="sprout-cares-image"
                            loading="lazy">
                    </div>
                </div>
                {{-- right Column - Text Content --}}
                <div class="sprout-cares-content">
                    {{-- Headline --}}
                    <h2 class="sprout-cares-title">
                        OUR INFANT CARE PROGRAM FEATURES
                    </h2>

                    {{-- FAQ List --}}
                    <ul class="sprout-cares-faq">
                        <li>Nurturing, personal care that builds your infant’s self-esteem</li>
                        <li>Regular teacher-child interactions that spark curiosity and socialization</li>
                        <li>Playtime and experiences that help boost cognitive and motor skills</li>
                        <li>Age-appropriate materials and equipment that support learning and development</li>
                        <li>Regular teacher-family communication, including daily updates to keep you informed</li>
                        <li>A safe daycare environment where your infant has the freedom to move and explore</li>
                        <li>Safe Sleep Guidelines that meet those of the American Academy of Pediatrics</li>
                    </ul>
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
                <h2 class="infant-education-title">YOUR INFANT'S EARLY EDUCATION AT THE SPROUT ACADEMY</h2>
                <p class="infant-education-subtitle">Our five areas of focus give your baby endless opportunities to learn
                    and grow.</p>
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

    {{-- The Sprout Academy Toddler Program Section --}}
    <section class="toddler-program-section"
        style="background-image: url('{{ asset('frontend/assets/home_page_images/td-3.png') }}');">
        <div class="toddler-program-wrapper">
            {{-- Left Column - Teal Overlay Box --}}
            <div class="toddler-program-overlay">
                <h2 class="toddler-program-title">THE SPROUT ACADEMY TODDLER PROGRAM</h2>
                <p class="toddler-program-text">
                    Infants grow and learn every day. The Sprout Academy provides a safe and nurturing "home away from home"
                    where infants can explore and make new discoveries. Young children learn through play, and our infant
                    care program is designed to provide infants with the skills that serve as building blocks for a lifetime
                    of learning. We appreciate you trusting us with your infant's care and education, and we're committed to
                    making this first transition away from home easy and natural for you and your child.
                </p>
            </div>

            {{-- Right Column - Blank/Empty --}}
            <div class="toddler-program-image-wrapper">
                {{-- Empty column --}}
            </div>
        </div>
    </section>

    {{-- The Sprout Academy Cares Section --}}
    <section class="sprout-cares-section" id="toddler-program-features">
        <div class="container">
            <div class="sprout-cares-grid">
                {{-- right Column - Text Content --}}
                <div class="sprout-cares-content">
                    {{-- Headline --}}
                    <h2 class="sprout-cares-title">
                        OUR TODDLER CARE PROGRAM FEATURES
                    </h2>

                    {{-- FAQ List --}}
                    <ul class="sprout-cares-faq">
                        <li>A perfect balance of nurturing, playtime, and learning each day</li>
                        <li>Daily group activities that help boost your child’s social skills</li>
                        <li>Regular teacher-family communication, including daily updates to keep you informed</li>
                        <li>Learning areas focused on dramatic play, mathematics, creative arts, language, and sensory
                            exploration</li>
                        <li>Age-appropriate activities and materials that develop confidence, self-esteem, and a love of
                            learning</li>
                    </ul>
                </div>

                {{-- left Column - Framed Image --}}
                <div class="sprout-cares-image-wrapper">
                    <div class="sprout-cares-image-frame">
                        <img src="{{ asset('frontend/assets/home_page_images/td-1.png') }}"
                            alt="Children enjoying learning activities at The Sprout Academy" class="sprout-cares-image"
                            loading="lazy">
                    </div>
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
                <h2 class="infant-education-title">YOUR TODDLER’S EARLY EDUCATION AT THE SPROUT ACADEMY</h2>
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
        'buttonLink' => route('frontend.enroll'),
    ])

@endsection
