@extends('frontend.partials.master')
@section('title', 'Our Programs')
@section('content')
    <!-- Inner Page Header -->
    @include('frontend.partials.header_inner', [
        'bgImage' => asset('frontend/assets/home_page_images/hdr-programs.png'),
        'title' => 'OUR PROGRAM',
        'subtitle' => 'The Sprout Academy',
    ])

    <!-- Our Mission Section -->
    <section class="mission-section" aria-labelledby="mission-heading" id="programs">
        <div class="container">
            <div class="mission-content">
                @include('frontend.components.section-heading', [
                    'text' => 'You Will Love What we offer',
                    'bgColor' => '#6daa44', 
                    'borderColor' => '#6CAA43',
                    'rotation' => 'right',
                ])
                <p class="mission-text">
                    The Sprout Academy develops the whole child by meeting their social, emotional, physical, and
                    intellectual needs so that they can learn and grow every day. Children develop differently at different
                    ages, which is why we offer early education programs designed for specific age groups.
                </p>
            </div>
        </div>
    </section>

    {{-- Daycare Section: Left Image + Right Content --}}
    @include('frontend.components.left_img_full_width_with_content', [
        'image' => asset('frontend/assets/home_page_images/program--img-4.png'),
        'title' => 'Daycare (age 2 & under)',
        'text' =>
            'Infants and toddlers need a safe, nurturing environment to begin exploring the world around them. The Sprout Academy provide all the support and early education that young children need to learn, grow, and form solid educational foundations.',
        'buttonText' => 'Learn More',
        'buttonLink' => route('frontend.infantToddlerEducation'),
        'buttonClass' => 'btn btn-foundation',
    ])

    {{-- Preschool Section: Right Image + Left Content --}}
    @include('frontend.components.right_img_full_width_with_content', [
        'image' => asset('frontend/assets/home_page_images/program--img-2.png'),
        'title' => 'Preschool (3-5 yrs)',
        'text' =>
            'Preschool-age children are gaining independence and developing rapidly. Our preschool early education programs provide a balance between nurturing and exploration of the world around them. We carefully guide children toward the more structured classroom experiences ahead.',
        'buttonText' => 'Learn More',
        'buttonLink' => route('frontend.preschoolEarlyEducation'),
        'buttonClass' => 'btn btn-program-preschool',
    ])

    @include('frontend.components.left_img_full_width_with_content', [
        'image' => asset('frontend/assets/home_page_images/program--img-3.png'),
        'title' => 'School age (5-12yrs)',
        'text' =>
            'As children get older and more independent, they need new challenges. That\'s why we offer enrichment programs before and after school, as well as Summer Camps that address the changing and varied needs of growing school-age children.',
        'buttonText' => 'Learn More',
        'buttonLink' => route('frontend.educationFor512YearOld'),
        'buttonClass' => 'btn btn-secondary',
    ])

    {{-- Curriculum Section --}}
    <section class="curriculum-section" aria-labelledby="curriculum-heading">
        <div class="container">
            {{-- Top Section: Heading with Icons and Text --}}
            <div class="curriculum-header">
                <div class="curriculum-heading-wrapper">
                    <div class="curriculum-heading-content">
                        <img src="{{ asset('frontend/assets/home_page_images/book1.png') }}" alt=""
                            class="curriculum-icon-left" aria-hidden="true">
                        <h2 id="curriculum-heading" class="curriculum-title">CURRICULUM</h2>
                        <img src="{{ asset('frontend/assets/home_page_images/star.png') }}" alt=""
                            class="curriculum-icon-right" aria-hidden="true">
                    </div>
                    <div class="curriculum-text-wrapper">
                        <p class="curriculum-description">
                            The Sprout Academy remains committed to bringing the highest quality early childhood education
                            and care to our children and their families. We update our programs frequently with some of the
                            most innovative thinking in early childhood development and education. From foreign languages to
                            social, emotional, intellectual and physical development, The Sprout Academy continues to lead
                            the industry in advanced academic opportunities for infants and young children.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Bottom Section: Video Player --}}
            <div class="curriculum-video-wrapper">
                <div class="curriculum-video-showcase">
                    <video id="curriculum-video" class="curriculum-video-player"
                        poster="{{ asset('frontend/assets/home_page_images/program--img-1.png') }}" controls playsinline>
                        <source src="{{ asset('frontend/assets/home_page_images/Curriculum_1.mp4') }}" type="video/mp4">
                        <source src="{{ asset('frontend/assets/home_page_images/Curriculum_1.webm') }}" type="video/webm">
                        Your browser does not support the video tag.
                    </video>
                    <button class="curriculum-video-play-btn" id="play-curriculum-video-btn"
                        aria-label="Play curriculum video">
                        <span class="visually-hidden">Play video</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- Development Areas Section --}}
    <section class="development-areas-section" aria-labelledby="development-areas-heading">
        <div class="container">
            <div class="development-cards-grid">
                {{-- Social Card --}}
                <div class="development-card">
                    <div class="development-card-icon">
                        <img src="{{ asset('frontend/assets/home_page_images/chain1.png') }}" alt="Social Development"
                            class="development-icon">
                    </div>
                    <h3 class="development-card-title">SOCIAL</h3>
                    <p class="development-card-text">
                        Your child will learn the importance of communicating with others both verbally and non-verbally.
                        Making new friends and gaining confidence, self-esteem, and negotiating skills are all necessary for
                        a lifetime of healthy relationships.
                    </p>
                </div>

                {{-- Emotional Card --}}
                <div class="development-card">
                    <div class="development-card-icon">
                        <img src="{{ asset('frontend/assets/home_page_images/heart1.png') }}" alt="Emotional Development"
                            class="development-icon">
                    </div>
                    <h3 class="development-card-title">EMOTIONAL</h3>
                    <p class="development-card-text">
                        Your child will feel comfortable in our safe, nurturing environment. Self-expression and gaining an
                        understanding of each child's unique identity is an important part of learning. We will help your
                        child gain the comfort and confidence to forge trusting relationships, <a href="#"
                            class="development-read-more">Read More</a>
                    </p>
                </div>

                {{-- Physical Card --}}
                <div class="development-card">
                    <div class="development-card-icon">
                        <img src="{{ asset('frontend/assets/home_page_images/dancing1.png') }}" alt="Physical Development"
                            class="development-icon">
                    </div>
                    <h3 class="development-card-title">PHYSICAL</h3>
                    <p class="development-card-text">
                        Healthy children are happy children. That's why we focus on the physical health and well-being of
                        your child, so he or she will grow up safe and strong. Motor-skill development, coordination,
                        mobility, and exercise all help ensure your growing child has a healthy body for a lifetime. <a
                            href="#" class="development-read-more">Read More</a>
                    </p>
                </div>

                {{-- Intellectual Card --}}
                <div class="development-card">
                    <div class="development-card-icon">
                        <img src="{{ asset('frontend/assets/home_page_images/bulb1.png') }}" alt="Intellectual Development"
                            class="development-icon">
                    </div>
                    <h3 class="development-card-title">INTELLECTUAL</h3>
                    <p class="development-card-text">
                        Our early education programs help build brain power by supporting the development of judgment,
                        perception, memory, reasoning, critical thinking, and language through a series of age-appropriate
                        cognitive activities. Reading, writing, and math are important and <a href="#"
                            class="development-read-more">Read More</a>
                    </p>
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
