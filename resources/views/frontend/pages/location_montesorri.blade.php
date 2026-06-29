@extends('frontend.partials.master')

@section('title', 'Location Montessori')

@section('content')
    <!-- Inner Page Header -->
    @include('frontend.partials.header_inner', [
        'bgImage' => asset('frontend/assets/home_page_images/hdr-montessori.png'),
        'title' => 'MONTESORRI',
        'subtitle' => 'Explore Our Academy',
        'showButton' => true,
        'buttonText' => 'Register My Child At This Location',
        'buttonLink' => route('enrollment.start', ['location' => 'montessori']),
    ])

    <!-- Locations Virtual Tour Section -->
    <section class="virtual-tour-locations locations-page" id="locations">
        <div class="container">
            <!-- Montessori Location -->
            <div class="vt-location-block" id="montessori">
                @include('frontend.components.google-map', [
                    'address' => '2255 Countryside Blvd, Clearwater, FL 33763',
                ])
                <div class="vt-location-info">
                    <h2 class="vt-location-title">MONTESSORI</h2>
                    <div class="vt-contact-list">
                        <div class="vt-contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="vt-contact-details">
                                <span class="vt-contact-label">LOCATION ADDRESS</span>
                                <span class="vt-contact-value">2255 Countryside Blvd, Clearwater, FL 33763</span>
                            </div>
                        </div>
                        <div class="vt-contact-item">
                            <i class="fas fa-phone-alt"></i>
                            <div class="vt-contact-details">
                                <span class="vt-contact-label">PHONE</span>
                                <span class="vt-contact-value">(727) 799-7687</span>
                            </div>
                        </div>
                        <div class="vt-contact-item">
                            <i class="fas fa-fax"></i>
                            <div class="vt-contact-details">
                                <span class="vt-contact-label">FAX</span>
                                <span class="vt-contact-value">(727) 799-7688</span>
                            </div>
                        </div>
                        <div class="vt-contact-item">
                            <i class="fas fa-envelope"></i>
                            <div class="vt-contact-details">
                                <span class="vt-contact-label">EMAIL</span>
                                <span class="vt-contact-value">montessori@sproutacademy.com</span>
                            </div>
                        </div>
                        <div class="vt-contact-item">
                            <i class="fas fa-clock"></i>
                            <div class="vt-contact-details">
                                <span class="vt-contact-label">HOURS OF OPERATION</span>
                                <span class="vt-contact-value">Monday - Friday: 7:00 AM - 6:00 PM</span>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="vt-action-buttons">
                        <a href="#register" class="btn btn-enroll">Register Here</a>

                    </div> -->
                </div>
            </div>

            @include('frontend.components.location-virtual-tour', [
                'locationSlug'   => 'montessori',
                'panoramaImages' => $panoramaImages ?? [],
            ])

<section class="why-choose-section location-why-choose">
    <div class="container">
        <div class="section-heading-wrapper">
            <img src="{{ asset('frontend/assets/home_page_images/lock.png') }}" alt="Icon" class="section-icon-left">
            <h2 class="section-title-inner">The Sprout Academy</h2>
            <img src="{{ asset('frontend/assets/home_page_images/star.png') }}" alt="Icon" class="section-icon-right">
        </div>

        <div class="video-showcase-main">
            <video class="main-video-player" poster="{{ asset('frontend/assets/home_page_images/locations/montessori/vdo-poster-montessori.png') }}"
                controls preload="metadata">
                <source src="{{ asset('frontend/assets/home_page_images/common-vdo.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <button class="video-play-btn-main" aria-label="Play video">
                <span class="play-icon"></span>
            </button>
        </div>
    </div>
</section>


            <section class="location-text">
                <div class="container">
                    <div class="location-text-content">
                        <p class="location-text-description">We are located directly off of Belleair road in Clearwater in
                            between Starkey and Belcher. At The Sprout Academy – Montessori we believe in the value and
                            uniqueness of each child we serve. Our childcare experience is designed to promote each child’s
                            own individual, social, emotional, physical, and cognitive development. As caregivers and
                            educators, our mission is to provide a safe and developmentally appropriate learning
                            environment, which fosters a child’s natural desire to explore, discover, create, and become a
                            lifelong learner.</p>
                        <a href="https://www.facebook.com/SproutMontessori/" target="_blank" class="location-text-link">Follow Our Socials:
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </div>
                </div>
            </section>

            <!-- Location Gallery Section -->
            @include('frontend.components.masonry-gallery', [
                'locationName' => 'montessori',
            ])
            
            <!-- View All Images on Facebook Button -->
            <div class="container mt-4 mb-5">
                <div class="text-center">
                    <a href="https://www.facebook.com/SproutMontessori/photos" target="_blank" rel="noopener noreferrer" class="btn btn-foundation btn-lg">
                        View All Images on Facebook
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
