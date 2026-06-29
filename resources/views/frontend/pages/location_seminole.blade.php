@extends('frontend.partials.master')

@section('title', 'Location Seminole')

@section('content')
    <!-- Inner Page Header -->
    @include('frontend.partials.header_inner', [
        'bgImage' => asset('frontend/assets/home_page_images/hdr-seminole.png'),
        'title' => 'SEMINOLE',
        'subtitle' => 'Explore Our Academy',
        'showButton' => true,
        'buttonText' => 'Register My Child At This Location',
        'buttonLink' => route('enrollment.start', ['location' => 'seminole']),
    ])

    <!-- Locations Virtual Tour Section -->
    <section class="virtual-tour-locations locations-page" id="locations">
        <div class="container">
            <!-- Seminole Location -->
            <div class="vt-location-block" id="seminole">
                <div class="vt-location-info">
                    <h2 class="vt-location-title">The Sprout Academy Seminole</h2>
                    <div class="vt-contact-list">
                        <div class="vt-contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="vt-contact-details">
                                <span class="vt-contact-label">LOCATION ADDRESS</span>
                                <span class="vt-contact-value">7985 113th St N, Seminole, FL 33772</span>
                            </div>
                        </div>
                        <div class="vt-contact-item">
                            <i class="fas fa-phone-alt"></i>
                            <div class="vt-contact-details">
                                <span class="vt-contact-label">PHONE</span>
                                <span class="vt-contact-value">(727) 953-5544</span>
                            </div>
                        </div>
                        <div class="vt-contact-item">
                            <i class="fas fa-fax"></i>
                            <div class="vt-contact-details">
                                <span class="vt-contact-label">FAX</span>
                                <span class="vt-contact-value">(727) 953-5545</span>
                            </div>
                        </div>
                        <div class="vt-contact-item">
                            <i class="fas fa-envelope"></i>
                            <div class="vt-contact-details">
                                <span class="vt-contact-label">EMAIL</span>
                                <span class="vt-contact-value">seminole@sproutacademy.com</span>
                            </div>
                        </div>
                        <div class="vt-contact-item">
                            <i class="fas fa-clock"></i>
                            <div class="vt-contact-details">
                                <span class="vt-contact-label">HOURS OF OPERATION</span>
                                <span class="vt-contact-value">Monday-Friday – 7:00 a.m. to 6:00 p.m <label>(toddlers 7:30
                                        a.m. to 5:30 p.m.)</label></span>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="vt-action-buttons">
                        <a href="#register" class="btn btn-enroll">Register Here</a>

                    </div> -->
                </div>
                @include('frontend.components.google-map', [
                    'address' => '7985 113th St N, Seminole, FL 33772',
                ])
            </div>

            @include('frontend.components.location-virtual-tour', [
                'locationSlug'   => 'seminole',
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
            <video class="main-video-player" poster="{{ asset('frontend/assets/home_page_images/locations/seminole/vdo-poster-seminole.png') }}"
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
                        <p class="location-text-description">We are located right off Park Blvd, a major artery in Pinellas
                            County. Our location is extremely convenient for our parents and makes for a prime child care
                            destination. Our beautiful campus offers everything that you could want for your child within an
                            environment conducive to learning and safety. We are constantly improving upon the entire
                            complex and as it stands it currently offers the highest quality educational facility in the
                            area. We rigorously follow and uphold all the top standards of the Apple accreditation, Gold
                            Seal Florida Quality Care, and the The Sprout Academy policies.</p>
                        <a href="https://www.facebook.com/SproutSeminole/" target="_blank" class="location-text-link">Follow Our Socials:
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </div>
                </div>
            </section>

            <!-- Location Gallery Section -->
            @include('frontend.components.masonry-gallery', [
                'locationName' => 'seminole',
            ])
            
            <!-- View All Images on Facebook Button -->
            <div class="container mt-4 mb-5">
                <div class="text-center">
                    <a href="https://www.facebook.com/SproutSeminole/photos" target="_blank" rel="noopener noreferrer" class="btn btn-foundation btn-lg">
                        View All Images on Facebook
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
