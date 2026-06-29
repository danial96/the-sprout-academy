@extends('frontend.partials.master')
@section('title', 'Meet the Team')
@section('content')

    {{-- Header Section --}}
    @include('frontend.partials.header_inner', [
        'bgImage' => asset('frontend/assets/home_page_images/hdr-owner.png'),
        'title' => 'MEET THE TEAM',
        'subtitle' => 'Caring & Passionate',
        'text' => 'For our teachers, it’s more than a job—it’s inspiring and awakening wonder in every child.',
        'showButton' => false,
    ])

     {{-- Meet the Owners Section --}}
     <section class="meet-owners-section">
        <div class="container">
            <div class="meet-owners-grid">
                {{-- Left Column - Names & Icons --}}
                <div class="meet-owners-left">
                    <div class="meet-owners-badge">
                        @include('frontend.components.section-heading', [
                            'text' => 'Meet The Owners',
                            'bgColor' => '#6daa44',
                            'borderColor' => '#6CAA43',
                            'rotation' => 'left',
                        ])
                    </div>

                    <div class="owners-name-wrapper">
                        <h2 class="owners-name">
                            JUSTIN AND<br>
                            RACHEL BARSANTI
                        </h2>
                    </div>

                    {{-- Tree Background Image --}}
                    <div class="owners-tree-bg">
                        <img src="{{ asset('frontend/assets/home_page_images/tree-layer.png') }}" alt="Tree">
                    </div>
                </div>

                {{-- Right Column - Description Text --}}
                <div class="meet-owners-right">
                    <p class="owners-description">
                        Our names are Justin and Rachel Barsanti. We currently own the Sprout Academy centers. Our centers
                        are Gold Seal, Apple Accredited centers with the highest quality of educational performance and
                        cleanliness the state recognizes. We currently reside in Seminole, FL with our three small children
                        - Andrew, Brandon, and Claire and have been in this community the vast majority of our lives. Rachel
                        has been in the child care industry for 20 years working in almost every capacity and as a mom
                        herself fully understands the task of raising a child. Justin has a BSBA and MBA from the University
                        of Florida (Go Gators!) and has worked in human resources. All three of our children attend or have
                        attended The Sprout Academy and grew up around our staff. We are extremely passionate about what we
                        do and creating a wonderful, safe, learning atmosphere for children in our community.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- From Our Founders Section -->
    {{-- <section class="founders-section mt-7" aria-labelledby="founders-heading">
        <div class="founders-grid-wrapper">
            <!-- Left Column - Image -->
            <div class="founders-image-column">
                <img src="{{ asset('frontend/assets/home_page_images/founder-img.png') }}"
                    alt="Justin and Rachel, founders of The Sprout Academy" loading="lazy" class="founders-image">
            </div>

            <!-- Right Column - Content -->
            <div class="founders-content-column">
                <div class="founders-content-inner">
                    <div class="">
                        @include('frontend.components.section-heading', [
                            'text' => 'Founders of The Sprout Academy',
                            'bgColor' => '#6daa44',
                            'borderColor' => '#6CAA43',
                            'rotation' => 'left',
                        ])
                    </div>
                    <h2 id="founders-heading" class="founders-title">From Our Founders</h2>
                    <p class="founders-text">
                        "All three of our children attend or have attended The Sprout Academy and grew up around our staff.
                        We are extremely passionate about what we do and creating a wonderful, safe, learning atmosphere for
                        children in our community. "
                    </p>
                    <!-- <p class="founders-signature">- Justin & Rachel</p> -->
                    <div class="founders-icon-wrapper">
                    <a href="{{ route('frontend.meetTheOwner') }}" class="btn btn-sprout-store owner-btn">More Information</a>
                        <img src="{{ asset('frontend/assets/home_page_images/tree-layer.png') }}"
                            alt="Justin and Rachel, founders of The Sprout Academy" loading="lazy" class="founders-icon">
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <section class="owners-family-frame">
        <div class="container">
            <img src="{{ asset('frontend/assets/home_page_images/owner-family-pic.png') }}" alt="Family Frame">
        </div>
    </section>

    {{-- Team Members Section --}}
    <section class="team-members-section">
        <div class="container">
            <div class="team-members-grid">
                {{-- Team Member Card - Alicia Sanders --}}
                <div class="team-member-card">
                    <div class="team-member-header">
                        <img src="{{ asset('frontend/assets/home_page_images/lock.png') }}" alt="Icon"
                            class="team-role-icon">
                        <h3 class="team-role-title">District Manager</h3>
                    </div>
                    <div class="team-member-content">
                        <div class="team-member-info">
                            <h4 class="team-member-name">Alicia Sanders</h4>
                            <div class="team-contact-item">
                                <div class="contact-icon-wrapper">
                                    <i class="fas fa-solid fa-phone"></i>
                                </div>
                                <div class="contact-details">
                                    <span class="contact-label">PHONE:</span>
                                    <span class="contact-value">727-657-2327</span>
                                </div>
                            </div>
                            <div class="team-contact-item">
                                <div class="contact-icon-wrapper">
                                    <i class="fas fa-solid fa-envelope"></i>
                                </div>
                                <div class="contact-details">
                                    <span class="contact-label">EMAIL:</span>
                                    <span class="contact-value">Alicia@the-sprout-academy.com</span>
                                </div>
                            </div>
                        </div>
                        <div class="team-member-photo">
                            <img src="{{ asset('frontend/assets/home_page_images/team2.png') }}" alt="Alicia Sanders">
                        </div>
                    </div>
                </div>

                {{-- Add more team member cards here with the same structure --}}
            </div>
        </div>
    </section>

    {{-- Directors Section --}}
    @include('frontend.components.directors-section')

      <!-- Testimonials Section V2 (with Gradient Background) -->
      @include('frontend.components.testimonials-slider2')

    {{-- Learning Fun Accordion Section --}}
    <section class="learning-fun-wrapper">
        <div class="container">
            <div class="learning-fun-badge">
                @include('frontend.components.section-heading', [
                    'text' => 'Only the Best',
                    'bgColor' => '#6daa44',
                    'borderColor' => '#6CAA43',
                    'rotation' => 'left',
                ])
            </div>
        </div>
    </section>

    @include('frontend.components.accordion-section', [
        'sectionTitle' => 'WE KNOW HOW TO MAKE LEARNING FUN FOR KIDS',
        'leftIcon' => null,
        'rightIcon' => asset('frontend/assets/home_page_images/star.png'),
        'columns' => 1,
        'accordionItems' => [
            [
                'title' => 'CARING AND PASSIONATE',
                'content' =>
                    'The Sprout Academy child care centers\' early childhood teachers are passionate about your child\'s happiness, growth and safety, and providing a nurturing environment that cultivates self-esteem. This is more than a job for our teachers. It\'s an opportunity for them to share their passion for life while they inspire, engage, and awaken the wonder inside each and every child.',
                'expanded' => false,
            ],
            [
                'title' => 'HIGHLY TRAINED EARLY CHILDHOOD TEACHERS',
                'content' =>
                    'The Sprout Academy child care centers\' early childhood teachers are passionate about your child\'s happiness, growth and safety, and providing a nurturing environment that cultivates self-esteem. Our teachers meet education and experience requirements that exceed state standards, and are trained in CPR and First Aid.',
                'expanded' => false,
            ],
            [
                'title' => 'SMALL CLASS SIZE',
                'content' =>
                    'The Sprout Academy\'s low teacher-to-student ratios allow teachers to focus on the individual learning styles and needs of each child in our day care centers.',
                'expanded' => false,
            ],
            [
                'title' => 'PARTNERING WITH FAMILIES',
                'content' =>
                    'The Sprout Academy\'s early childhood teachers and staff want to form a strong partnership with you to ensure the best possible experience for your child. Teachers provide daily communication with families and seek to understand your unique needs.',
                'expanded' => false,
            ],
        ],
    ])

    @include('frontend.components.footer-cta', [
        'bgImage' => asset('frontend/assets/home_page_images/cta-banner.png'),
        'fancytitle' => 'Inquire About Openings',
        'title' => 'FIND THE SPROUT ACADEMY LOCATION NEAREST YOU',
        'buttonText' => 'Enroll',
        'buttonLink' => route('frontend.enroll'),
    ])


@endsection
