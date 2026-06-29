@extends('frontend.partials.master')

@section('title', 'We Care for Your Child')

@section('content')
    {{-- Header Section --}}
    @include('frontend.partials.header_inner', [
        'bgImage' => asset('frontend/assets/home_page_images/hdr-care-page.png'),
        'title' => 'Safety, & Nutrition',
        'subtitle' => 'Child Care',
        'text' => 'Your child’s safety and care is our top priority.',
        'showButton' => false,
    ])

    {{-- Why Choose Section --}}
    <section class="why-choose-section">
        <div class="container">
            <div class="section-heading-wrapper we_care_page">
                <img src="{{ asset('frontend/assets/home_page_images/lock.png') }}" alt="Icon" class="section-icon-left">
                <h2 class="section-title-inner">We Care for Your Child The Way
                    You Would</h2>
                <img src="{{ asset('frontend/assets/home_page_images/star.png') }}" alt="Icon" class="section-icon-right">
            </div>

            {{-- Video Player --}}
            <div class="video-showcase-main">
                <video class="main-video-player" poster="{{ asset('frontend/assets/home_page_images/singlevideo.png') }}"
                    controls preload="metadata">
                    <source src="{{ asset('frontend/assets/home_page_images/vdo-3.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <button class="video-play-btn-main" aria-label="Play video">
                    <span class="play-icon"></span>
                </button>
            </div>
        </div>
    </section>

    {{-- Three Info Cards Section --}}
    <section class="info-cards-section">
        <div class="container">
            <div class="info-cards-grid">
                {{-- Card 1: Safety --}}
                <div class="info-card">
                    <div class="info-icon-wrapper">
                        <div class="info-icon-blob teal">
                            <img src="{{ asset('frontend/assets/home_page_images/icon11.png') }}" alt="Safety Icon"
                                class="info-icon">
                        </div>
                    </div>
                    <h3 class="info-card-title">SAFETY: OUR TOP PRIORITY</h3>
                    <p class="info-card-text">
                        Education and development are important, but we know that nothing matters more than the safety,
                        security, & health of your child.
                        {{-- <a href="#" class="info-read-more">Read More</a> --}}
                    </p>
                </div>

                {{-- Card 2: Peace of Mind --}}
                <div class="info-card">
                    <div class="info-icon-wrapper">
                        <div class="info-icon-blob orange">
                            <img src="{{ asset('frontend/assets/home_page_images/icon12.png') }}" alt="Peace of Mind Icon"
                                class="info-icon">
                        </div>
                    </div>
                    <h3 class="info-card-title">YOUR PEACE-OF-MIND</h3>
                    <p class="info-card-text">
                        From first aid training for emergency situations to sanitation and ensuring a clean and healthy
                        environment for children, we have vast experience ensuring that every child is happy.
                        {{-- <a href="#" class="info-read-more">Read More</a> --}}
                    </p>
                </div>

                {{-- Card 3: Transparency --}}
                <div class="info-card">
                    <div class="info-icon-wrapper">
                        <div class="info-icon-blob green">
                            <img src="{{ asset('frontend/assets/home_page_images/icon13.png') }}" alt="Transparency Icon"
                                class="info-icon">
                        </div>
                    </div>
                    <h3 class="info-card-title">OUR TRANSPARENCY</h3>
                    <p class="info-card-text">
                        We invite you to learn more about ways we care for your child. Ask the local center director at your
                        location about our leadership in child care safety health and security.
                        {{-- <a href="#" class="info-read-more">Read More</a> --}}
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Health & Safety Assurance Accordion Section --}}
    @include('frontend.components.accordion-section', [
        'sectionTitle' => 'HEALTH & SAFETY ASSURANCE',
        'leftIcon' => asset('frontend/assets/home_page_images/pencil_icon.png'),
        'rightIcon' => asset('frontend/assets/home_page_images/star.png'),
        'accordionItems' => [
            [
                'title' => 'TRANSPORTATION',
                'expanded' => false,
                'content' => [
                    'Safe and reliable transportation services for your child.',
                    'Licensed and trained drivers with clean driving records.',
                    'Regular vehicle maintenance and safety inspections.',
                    'Age-appropriate car seats and safety restraints.',
                ],
            ],
            [
                'title' => 'PLAYGROUNDS',
                'expanded' => false,
                'content' => [
                    'Age-appropriate playground equipment with safety surfacing.',
                    'Regular inspections and maintenance of all play structures.',
                    'Fenced play areas with secure gates.',
                    'Shaded areas to protect children from sun exposure.',
                ],
            ],
            [
                'title' => 'MEDICATIONS',
                'expanded' => false,
                'content' => [
                    'Secure storage of all medications in locked cabinets.',
                    'Trained staff to administer medications as prescribed.',
                    'Detailed medication logs and parent communication.',
                    'Emergency medication protocols in place.',
                ],
            ],
            [
                'title' => 'WELLNESS',
                'expanded' => false,
                'content' => [
                    'Daily health checks for all children upon arrival.',
                    'Nutritious meals and snacks following USDA guidelines.',
                    'Regular hand washing and hygiene practices.',
                    'Illness policies to protect all children and staff.',
                ],
            ],
            [
                'title' => 'SECURITY',
                'expanded' => false,
                'content' => [
                    'Some of our centers are secured so that only authorized staff & families may enter.',
                    'Safe, secure perimeters ensure that children can enjoy outdoor play safely.',
                    'We use safety gates, window guards (except fire escapes) and cap electrical outlets.',
                    'Our centers include smoke detectors and fire extinguishers.',
                    'Radiators and heaters are covered to prevent your child from touching something hot.',
                ],
            ],
            [
                'title' => 'QUALIFICATIONS',
                'expanded' => false,
                'content' => [
                    'All staff members undergo comprehensive background checks.',
                    'Teachers hold degrees or certifications in early childhood education.',
                    'Ongoing professional development and training programs.',
                    'CPR and First Aid certified staff members.',
                ],
            ],
            [
                'title' => 'AUTHORIZATION',
                'expanded' => false,
                'content' => [
                    'Only authorized individuals may pick up your child.',
                    'Photo ID verification required for all pickups.',
                    'Secure check-in and check-out procedures.',
                    'Emergency contact authorization protocols.',
                ],
            ],
            [
                'title' => 'EMERGENCIES',
                'expanded' => false,
                'content' => [
                    'Comprehensive emergency response plans in place.',
                    'Regular fire drills and emergency evacuation practices.',
                    'Direct communication with local emergency services.',
                    'Staff trained in emergency procedures and first aid.',
                ],
            ],
            [
                'title' => 'FEEDING',
                'expanded' => false,
                'content' => [
                    'Nutritious meals prepared following USDA guidelines.',
                    'Accommodation for food allergies and dietary restrictions.',
                    'Clean and sanitized feeding areas and equipment.',
                    'Age-appropriate portion sizes and meal schedules.',
                ],
            ],
            [
                'title' => 'SANITATION',
                'expanded' => false,
                'content' => [
                    'Daily cleaning and sanitizing of all surfaces and toys.',
                    'EPA-approved, child-safe cleaning products.',
                    'Proper diapering and toileting procedures.',
                    'Regular deep cleaning and maintenance schedules.',
                ],
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
