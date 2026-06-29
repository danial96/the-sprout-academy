@extends('frontend.partials.master')

@section('title', 'Location Seminole')

@section('content')
    <!-- Inner Page Header -->
    @include('frontend.partials.header_inner', [
        'bgImage' => asset('frontend/assets/home_page_images/hdr-seminole.png'),
        'title' => 'CLEARWATER',
        'subtitle' => 'Explore Our Academy',
        'showButton' => true,
        'buttonText' => 'Register My Child At This Location',
        'buttonLink' => route('enrollment.start', ['location' => 'clearwater']),
    ])

    <!-- Locations Virtual Tour Section -->
    <section class="virtual-tour-locations locations-page" id="locations">
        <div class="container">
            <!-- Clearwater Location -->
            <div class="vt-location-block" id="clearwater">

                <div class="vt-location-info">
                    <h2 class="vt-location-title">CLEARWATER</h2>
                    <div class="vt-contact-list">
                        <div class="vt-contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="vt-contact-details">
                                <span class="vt-contact-label">LOCATION ADDRESS</span>
                                <span class="vt-contact-value">2750 State Road 580, Clearwater, FL 33761</span>
                            </div>
                        </div>
                        <div class="vt-contact-item">
                            <i class="fas fa-phone-alt"></i>
                            <div class="vt-contact-details">
                                <span class="vt-contact-label">PHONE</span>
                                <span class="vt-contact-value">(727) 726-0777</span>
                            </div>
                        </div>
                        <div class="vt-contact-item">
                            <i class="fas fa-fax"></i>
                            <div class="vt-contact-details">
                                <span class="vt-contact-label">FAX</span>
                                <span class="vt-contact-value">(727) 726-0778</span>
                            </div>
                        </div>
                        <div class="vt-contact-item">
                            <i class="fas fa-envelope"></i>
                            <div class="vt-contact-details">
                                <span class="vt-contact-label">EMAIL</span>
                                <span class="vt-contact-value">clearwater@sproutacademy.com</span>
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
                    <div class="vt-action-buttons">
                        <a href="#register" class="btn btn-enroll">Register Here</a>
                    </div>
                </div>
                @include('frontend.components.google-map', [
                    'address' => '2750 State Road 580, Clearwater, FL 33761',
                ])
            </div>

            @include('frontend.components.location-virtual-tour', [
                'locationSlug'   => 'clearwater',
                'panoramaImages' => $panoramaImages ?? [],
            ])

            @include('frontend.components.location-why-choose')

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
                        <a href="#" class="location-text-link">Follow Our Socials:
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </div>
                </div>
            </section>

            <!-- Location Gallery Section -->
            @include('frontend.components.masonry-gallery', [
                'locationName' => 'seminole',
            ])
        </div>
    </section>
@endsection
