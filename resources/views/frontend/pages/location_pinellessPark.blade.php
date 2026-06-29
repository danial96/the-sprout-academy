@extends('frontend.partials.master')

@section('title', 'Location Seminole')

@section('content')
    <!-- Inner Page Header -->
    @include('frontend.partials.header_inner', [
        'bgImage' => asset('frontend/assets/home_page_images/hdr-pinellspark.png'),
        'title' => 'PINELLAS PARK',
        'subtitle' => 'Explore Our Academy',
        'showButton' => true,
        'buttonText' => 'Register My Child At This Location',
        'buttonLink' => route('enrollment.start', ['location' => 'pinellas-park']),
    ])

    <!-- Locations Virtual Tour Section -->
    <section class="virtual-tour-locations locations-page" id="locations">
        <div class="container">
            <!-- Pinellas Park Location -->
            <div class="vt-location-block" id="pinellas-park">
                <div class="vt-location-info">
                    <h2 class="vt-location-title">
                        Pinellas Park </h2>
                    <div class="vt-contact-list">
                        <div class="vt-contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="vt-contact-details">
                                <span class="vt-contact-label">LOCATION ADDRESS</span>
                                <span class="vt-contact-value">5995 Park Blvd, Pinellas Park, FL 33781</span>
                            </div>
                        </div>
                        <div class="vt-contact-item">
                            <i class="fas fa-phone-alt"></i>
                            <div class="vt-contact-details">
                                <span class="vt-contact-label">PHONE</span>
                                <span class="vt-contact-value">(727) 544-5437</span>
                            </div>
                        </div>
                        <div class="vt-contact-item">
                            <i class="fas fa-fax"></i>
                            <div class="vt-contact-details">
                                <span class="vt-contact-label">FAX</span>
                                <span class="vt-contact-value">(727) 544-5438</span>
                            </div>
                        </div>
                        <div class="vt-contact-item">
                            <i class="fas fa-envelope"></i>
                            <div class="vt-contact-details">
                                <span class="vt-contact-label">EMAIL</span>
                                <span class="vt-contact-value">pinellaspark@sproutacademy.com</span>
                            </div>
                        </div>
                        <div class="vt-contact-item">
                            <i class="fas fa-clock"></i>
                            <div class="vt-contact-details">
                                <span class="vt-contact-label">HOURS OF OPERATION</span>
                                <span class="vt-contact-value">Monday - Friday: 6:30 AM - 6:00 PM</span>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="vt-action-buttons">
                        <a href="#register" class="btn btn-enroll">Register Here</a>
                        <a href="{{ route('frontend.locationPinellasPark') }}" class="btn btn-foundation">More
                            Information</a>
                    </div> -->
                </div>
                @include('frontend.components.google-map', [
                    'address' => '5995 Park Blvd, Pinellas Park, FL 33781',
                ])
            </div>

            @include('frontend.components.location-virtual-tour', [
                'locationSlug'   => 'pinellas-park',
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
            <video class="main-video-player" poster="{{ asset('frontend/assets/home_page_images/locations/pinellas-park/vdo-poster-pinellsperk.png') }}"
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
                        <p class="location-text-description">We are located right off of 66th St. in Pinellas Park directly
                            behind the Jessie’s restaurant. Our location is extremely convenient for our parents and makes
                            for a prime child care destination. Tadalafil cost Walgreens remains a key consideration for
                            many patients managing erectile dysfunction. Comparing the price with quality branded
                            Cialis helps individuals make informed choices. In 2018, generic Cialis became available in the
                            US, impacting pricing dynamics significantly. Our beautiful campus offers everything that you
                            could want for your child within an environment conducive to learning and safety. We are
                            constantly improving upon the entire complex and as it stands it currently offers the highest
                            quality educational facility in the area. We rigorously follow and uphold all the top standards
                            of education.</p>
                        <a href="https://www.facebook.com/SproutPinellasPark/" target="_blank" class="location-text-link">Follow Our Socials:
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </div>
                </div>
            </section>

            <!-- Location Gallery Section -->
            @include('frontend.components.masonry-gallery', [
                'locationName' => 'pinellas-park',
            ])
            
            <!-- View All Images on Facebook Button -->
            <div class="container mt-4 mb-5">
                <div class="text-center">
                    <a href="https://www.facebook.com/SproutPinellasPark/photos" target="_blank" rel="noopener noreferrer" class="btn btn-foundation btn-lg">
                        View All Images on Facebook
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
