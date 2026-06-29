@extends('frontend.partials.master')
@section('title', 'Tuition Costs')
@section('content')
    {{-- Header Section --}}
    @include('frontend.partials.header_inner', [
        'bgImage' => asset('frontend/assets/home_page_images/hdr-tcs.png'),
        'title' => 'TUITION COSTS',
        'subtitle' => 'The Sprout Academy',
        'text' => 'Things to know about The Sprout Academy Tuition & Rates.',
        'showButton' => false,
    ])

    {{-- The Sprout Academy Cares Section --}}
    <section class="sprout-cares-section">
        <div class="container">
            <div class="sprout-cares-grid">
                {{-- Left Column - Text Content --}}
                <div class="sprout-cares-content">
                    {{-- Top Icon --}}
                    <div class="sprout-cares-icon-top">
                        <img src="{{ asset('frontend/assets/home_page_images/lock.png') }}" alt="Education Icon">
                    </div>

                    {{-- Headline --}}
                    <h2 class="sprout-cares-title">
                    The Sprout Academy Cares for Your Child Like You Would
                    </h2>

                    {{-- Description --}}
                    <p class="sprout-cares-description">
                        The Sprout Academy offers the best early childhood education. We place value over cost. Our
                        resources are focused on creating an exceptional experience for your child every single day—making
                        happy, engaged children excited about each new discovery.
                    </p>

                    {{-- FAQ List --}}
                    <ul class="sprout-cares-faq">
                        <li>Where are you located?</li>
                        <li>Which centers in your area have openings?</li>
                        <li>How many days a week do you need care?</li>
                        <li>How old are your children?</li>
                    </ul>
                </div>

                {{-- Right Column - Framed Image --}}
                <div class="sprout-cares-image-wrapper">
                    <div class="sprout-cares-image-frame">
                        <img src="{{ asset('frontend/assets/home_page_images/tc-img1.png') }}"
                            alt="Children enjoying learning activities at The Sprout Academy" class="sprout-cares-image"
                            loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Choosing a Child Care Provider Section (Image Background with Overlay) --}}
    <section class="info-overlay-section"
        style="background-image: url('{{ asset('frontend/assets/home_page_images/tc-img2.png') }}');">
        <div class="container">
            <div class="info-overlay-content">
                <h2 class="info-overlay-title">CHOOSING A CHILD CARE PROVIDER</h2>

                <p class="info-overlay-text">
                We understand that choosing a child care provider is an emotional decision—and a personal one. There are many factors that you will consider: Where is the center? Is it safe? Are the teachers qualified?
                </p>

                <p class="info-overlay-text">
                There is no one-size-fits-all answer to what the tuition will be for your family. Child care costs will vary based on your situation.
                Here are some of the things that impact the cost of child care:
                </p>

                <p class="info-overlay-text">
                This is a big decision for your family, and we know the best way to get you the information you need is to have you speak directly with the center director in your neighborhood, to hear what your individual needs and cares are, and to line out the options to cover what you’ll need
                </p>

                <p class="info-overlay-text">
                Talk with a local Center Director about tuition and schedule a visit by finding a Sprout Academy center near you.
                Every day at The Sprout Academy children learn how to read, children make social and emotional advances, and children reach important developmental milestones.
                </p>
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
