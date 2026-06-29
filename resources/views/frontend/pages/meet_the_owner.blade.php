@extends('frontend.partials.master')
@section('title', 'Meet the Owner')
@section('content')


    @include('frontend.partials.header_inner', [
        'bgImage' => asset('frontend/assets/home_page_images/hdr-owner.png'),
        'title' => 'MEET THE OWNERS',
        'subtitle' => 'The Sprout Academy',
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

    <section class="owners-family-frame">
        <div class="container">
            <img src="{{ asset('frontend/assets/home_page_images/owner-family-pic.png') }}" alt="Family Frame">
        </div>
    </section>

    <!-- Testimonials Section V2 (with Gradient Background) -->
    @include('frontend.components.testimonials-slider2')

    @include('frontend.components.footer-cta', [
        'bgImage' => asset('frontend/assets/home_page_images/cta-banner.png'),
        'fancytitle' => 'Inquire About Openings',
        'title' => 'FIND THE SPROUT ACADEMY LOCATION NEAREST YOU',
        'buttonText' => 'Enroll',
        'buttonLink' => route('frontend.enroll'),
    ])

@endsection
