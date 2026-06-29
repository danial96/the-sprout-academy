@extends('frontend.partials.master')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Home')

@section('meta_description',
    'The Sprout Academy develops the whole child by meeting social, emotional, physical, and
    intellectual needs through learning and growing every day.')

@section('content')

    <!-- Hero Section -->
    <section class="hero-section" aria-label="Hero banner">
        <video class="hero-video" autoplay muted loop playsinline
            poster="{{ asset('frontend/assets/home_page_images/vdo-img1.png') }}">
            <source src="{{ asset('frontend/assets/home_page_images/vdo-1.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="container">
            <div class="hero-content">
                @include('frontend.components.green-badge', ['text' => 'WE GUIDE'])
                <h1 class="hero-title">CHILDREN IN THE <br> RIGHT DIRECTION</h1>
                {{-- <a href="#tour" class="btn btn-secondary btn-lg">Schedule a Tour</a> --}}
                <a href="{{ route('frontend.virtualTour') }}" class="btn btn-foundation btn-lg">Schedule a Tour</a>
            </div>
        </div>
    </section>

    <!-- Our Mission Section -->
    <section class="mission-section" aria-labelledby="mission-heading">
        <div class="container">
            <div class="mission-content">
                @include('frontend.components.section-heading', [
                    'text' => 'Our Mission',
                    'bgColor' => '#6daa44',
                    'borderColor' => '#6CAA43',
                    'rotation' => 'right',
                ])
                <p class="mission-text">
                    The Sprout Academy develops the whole child by meeting social, emotional, physical, and intellectual
                    needs through learning and growing every day.
                </p>
            </div>
        </div>
    </section>

    <!-- Three Easy Steps Section -->
    <section class="steps-section section" aria-labelledby="steps-heading">
        <div class="container">
            <div class="text-center">
                @include('frontend.components.section-heading', [
                    'text' => 'We Keep It Simple',
                    'bgColor' => '#6daa44',
                    'borderColor' => '#6CAA43',
                    'rotation' => 'left',
                ])
            </div>

            <h2 id="steps-heading" class="section-title">THREE EASY STEPS</h2>
            <div class="steps-container">
                <!-- Step 1 -->
                <div class="step-item">
                    <div class="step-icon blue" aria-hidden="true">
                        <img src="{{ asset('frontend/assets/home_page_images/3-step-icon-1.png') }}" alt="Choose Location"
                            loading="lazy">
                    </div>
                    <h3 class="step-title">Schedule a Tour</h3>
                    <p class="step-description">Visit our school, meet our teachers, &
                        see the Sprout difference.</p>
                </div>

                <!-- Step 2 -->
                <div class="step-item">
                    <div class="step-icon orange" aria-hidden="true">
                        <img src="{{ asset('frontend/assets/home_page_images/3-step-icon-2.png') }}" alt="Schedule a Tour"
                            loading="lazy">
                    </div>
                    <h3 class="step-title">Enroll Your Child</h3>
                    <p class="step-description">Complete a simple enrollment process on site
                        with guidance every step of the way.</p>
                </div>

                <!-- Step 3 -->
                <div class="step-item">
                    <div class="step-icon green" aria-hidden="true">
                        <img src="{{ asset('frontend/assets/home_page_images/3-step-icon-3.png') }}" alt="Relax"
                            loading="lazy">
                    </div>
                    <h3 class="step-title">Watch Them Grow</h3>
                    <p class="step-description">Your child learns, plays, and thrives in a
                        caring, joyful environment.</p>
                </div>
            </div>

            <div class="steps-cta">
                <p class="steps-cta-text">So, what are you waiting for?</p>
                <a href="{{ route('frontend.virtualTour') }}" class="btn btn-tour-outline btn-lg">Schedule a Tour
                    &raquo;</a>
            </div>
        </div>
    </section>

    <!-- Accreditation Section -->
    <section class="accreditation-section" aria-labelledby="accreditation-heading">
        <div class="container">
            <div class="text-center">
                @include('frontend.components.section-heading', [
                    'text' => "We're one of the best",
                    'bgColor' => '#0A2239',
                    'borderColor' => '#0A2239',
                    'rotation' => 'right',
                ])
            </div>
            <h2 id="accreditation-heading" class="accreditation-title section-title">ACCREDITED, AWARDED, & LICENSED</h2>

            <div class="accreditation-grid-wrapper">
            <div id="accreditationGridSlider" class="accreditation-grid" role="list" aria-label="Accreditation logos">
                <div class="accreditation-card" role="listitem">
                    <img src="{{ asset('frontend/assets/home_page_images/certif1.png') }}" alt="Florida VPK Accreditation"
                        loading="lazy">
                </div>
                <div class="accreditation-card" role="listitem">
                    <img src="{{ asset('frontend/assets/home_page_images/certif2.png') }}"
                        alt="Florida Health Certification" loading="lazy">
                </div>
                <div class="accreditation-card" role="listitem">
                    <img src="{{ asset('frontend/assets/home_page_images/certif3.png') }}" alt="APPLE Accreditation"
                        loading="lazy">
                </div>
                <div class="accreditation-card" role="listitem">
                    <img src="{{ asset('frontend/assets/home_page_images/certif4.png') }}" alt="USDA Certification"
                        loading="lazy">
                </div>
                <div class="accreditation-card" role="listitem">
                    <img src="{{ asset('frontend/assets/home_page_images/certif5.png') }}"
                        alt="Early Learning Coalition of Pinellas County" loading="lazy">
                </div>
                <div class="accreditation-card" role="listitem">
                    <img src="{{ asset('frontend/assets/home_page_images/certif1.png') }}" alt="Florida VPK Accreditation"
                        loading="lazy">
                </div>
                <div class="accreditation-card" role="listitem">
                    <img src="{{ asset('frontend/assets/home_page_images/certif2.png') }}"
                        alt="Florida Health Certification" loading="lazy">
                </div>
            </div>
            </div>
        </div>
    </section>

    <!-- Why Parents Love Us Section -->
    <section class="why-parents-section section" aria-labelledby="why-parents-heading">
        <div class="container">
            <!-- Title Below Video -->
            <div class="text-center mt-5 mb-5">
                <h2 id="why-parents-heading" class="section-title">WANT TO SEE WHY PARENTS LOVE US?</h2>
            </div>
            <!-- Video Showcase at Top -->
            <div class="main-video-wrapper">
                <div class="video-showcase-main">
                    <video id="main-video" class="main-video-player"
                        poster="{{ asset('frontend/assets/home_page_images/singlevideo.png') }}" controls playsinline>
                        <source src="{{ asset('frontend/assets/home_page_images/vdo-1.mp4') }}" type="video/mp4">
                        <source src="{{ asset('frontend/assets/home_page_images/vdo-1.webm') }}" type="video/webm">
                        Your browser does not support the video tag.
                    </video>
                    <button class="video-play-btn-main" id="play-video-btn"
                        aria-label="Play video about our learning approach">
                        <span class="visually-hidden">Play video</span>
                    </button>
                </div>
            </div>


            <!-- Why Choose Us Content -->
            <div class="row align-items-center">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    {{-- <span class="section-label">Why the sprout academy?</span> --}}
                    @include('frontend.components.section-heading', [
                        'text' => 'Why the sprout academy?',
                        'bgColor' => '#6daa44',
                        'borderColor' => '#6CAA43',
                        'rotation' => 'left',
                    ])
                    <h3 class="why-choose-title">Keeping Your Child Safe is Our Top Priority</h3>
                    <a href="{{ route('frontend.virtualTour') }}" class="btn btn-foundation btn-lg mt-3">Schedule a Tour
                        &raquo;</a>
                </div>
                <div class="col-lg-7">
                    <p class="why-choose-text-right mb-3">
                        From the time you drop off to the moment you return, we’ll keep them safe, sound, and smiling.
                        Finding quality childcare that balances education, safety, and fun can be challenging for parents.
                        Many facilities promise engaging activities but often neglect the simple safeties, which can be
                        stressful for busy families.
                    </p>
                    <p class="why-choose-text-right">
                        At The Sprout Academy, we've solved this problem. Our innovative approach provides hands-on learning
                        experiences that engage children's natural curiosity while maintaining a clean, organized and
                        extremely safe environment. We guarantee your child will explore, learn, and grow while being safe
                        all along the way. Our goal now (and forever) is to prioritize safety first
                    </p>
                </div>
            </div>

        </div>

        <!-- Full Width Marquee Video Gallery -->
        <div class="marquee-gallery-wrapper">
            <div class="marquee-gallery-slider">
                <div class="marquee-slide">
                    <img src="{{ asset('frontend/assets/home_page_images/vdo-img1.png') }}"
                        alt="Child enjoying classroom activities" loading="lazy">
                </div>
                <div class="marquee-slide">
                    <img src="{{ asset('frontend/assets/home_page_images/vdo-img2.png') }}"
                        alt="Happy child at learning table" loading="lazy">
                </div>
                <div class="marquee-slide">
                    <img src="{{ asset('frontend/assets/home_page_images/vdo-img1.png') }}"
                        alt="Child building with colorful blocks" loading="lazy">
                </div>
                <div class="marquee-slide">
                    <img src="{{ asset('frontend/assets/home_page_images/vdo-img2.png') }}" alt="Happy child learning"
                        loading="lazy">
                </div>
                <div class="marquee-slide">
                    <img src="{{ asset('frontend/assets/home_page_images/vdo-img1.png') }}" alt="Child in classroom"
                        loading="lazy">
                </div>
                <div class="marquee-slide">
                    <img src="{{ asset('frontend/assets/home_page_images/vdo-img2.png') }}" alt="Happy child at table"
                        loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- From Our Founders Section -->
    <section class="founders-section" aria-labelledby="founders-heading">
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
                            'text' => 'A Word',
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
                    <p class="founders-signature">- Justin & Rachel</p>
                    <div class="founders-icon-wrapper">
                        <img src="{{ asset('frontend/assets/home_page_images/tree-layer.png') }}"
                            alt="Justin and Rachel, founders of The Sprout Academy" loading="lazy" class="founders-icon">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    @include('frontend.components.testimonials-slider')

    <!-- Sprout Store Section -->
    <section class="sprout-store-section" aria-labelledby="sprout-store-heading">
        <div class="container">
            <div class="sprout-store-wrapper">
                <div class="sprout-store-content-wrapper">
                    <!-- Left Content -->
                    <div class="sprout-store-content">
                        @include('frontend.components.section-heading', [
                            'text' => 'Sprout Store',
                            'bgColor' => 'var(--color-primary-orange)',
                            'borderColor' => '#000000',
                            'rotation' => 'right',
                        ])
                        <h2 id="sprout-store-heading" class="sprout-store-headline">
                            INSPIRE. LEARN.<br>
                            WEAR WITH PRIDE.
                        </h2>
                        <p class="sprout-store-tagline">Where school spirit meets everyday style.</p>
                        <a href="https://thesproutstore.com/" target="_blank" rel="noopener noreferrer"
                            class="btn btn-sprout-store">Shop Now</a>
                    </div>
                    <!-- Right Merchandise (Visual Elements) -->
                    <div class="sprout-store-merchandise">
                        <img src="{{ asset('frontend/assets/home_page_images/store-girl1.png') }}"
                            alt="Sprout Store merchandise - t-shirt, cap, backpack, slides, and face mask"
                            class="sprout-store-products-img" loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Spots Are Limited / Locations Section -->
    <section class="locations-section section" aria-labelledby="locations-heading">
        <div class="container">
            <div class="locations-header">
                <h2 id="locations-heading" class="section-title">SPOTS ARE LIMITED!</h2>
                <p class="locations-subtitle">Enroll Today & Secure Your Child's Spot</p>
            </div>

            <div class="locations-grid">

                @forelse ($locations as $index => $location)
                    @php
                        // Static images map based on location slug
                        $locationImages = [
                            'seminole' => 'sch-img-1.png',
                            'st-petersburg' => 'sch-img-2.png',
                            'pinellas-park' => 'sch-img-3.png',
                            'montessori' => 'sch-img-4.png',
                            'largo' => 'sch-img-5.png',
                        ];
                        $imageName = $locationImages[$location->slug] ?? 'sch-img-1.png';
                    @endphp
                    <div class="location-card">
                        <div class="location-image-wrapper">
                            <img src="{{ asset('frontend/assets/home_page_images/' . $imageName) }}"
                                alt="The Sprout Academy {{ $location->name }} location exterior" class="location-image"
                                loading="lazy">
                        </div>
                        <div class="location-bar">
                            <span class="location-name">{{ strtoupper($location->name) }}</span>
                            <button class="location-toggle" aria-label="Toggle location details">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                        <div class="location-overlay">
                            <div class="location-overlay-content">
                                <h3 class="location-overlay-title">{{ strtoupper($location->name) }}</h3>
                                <p class="location-overlay-address">{{ $location->address }}</p>
                                <div class="location-overlay-buttons">
                                    <a href="{{ route('frontend.virtualTour') }}" class="btn btn-secondary">Schedule a
                                        Tour</a>
                                    <a href="{{ route('frontend.enroll') }}" class="btn btn-enroll-overlay">Enroll</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <p>No locations available at this time.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Sproutvine NEWS Section (before footer) -->
    @include('frontend.components.sproutvine-news')

@endsection

@push('scripts')
    <script>
        (function () {
            var grid = document.getElementById('accreditationGridSlider');
            if (!grid) return;

            var mq = window.matchMedia('(max-width: 767.98px)');
            var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
            var cards = grid.querySelectorAll('.accreditation-card');
            var delay = 4000;
            var intervalId = null;
            var resumeTimer = null;
            var currentIndex = 0;
            var listenersAttached = false;
            var section = grid.closest('.accreditation-section');

            /** Scroll only the horizontal track — never use scrollIntoView (it scrolls the whole page vertically). */
            function scrollCardToCenter(card) {
                var gridRect = grid.getBoundingClientRect();
                var cardRect = card.getBoundingClientRect();
                var nextLeft =
                    grid.scrollLeft +
                    (cardRect.left - gridRect.left) -
                    (gridRect.width - cardRect.width) / 2;
                var maxScroll = Math.max(0, grid.scrollWidth - grid.clientWidth);
                nextLeft = Math.max(0, Math.min(nextLeft, maxScroll));
                grid.scrollTo({
                    left: nextLeft,
                    behavior: reduceMotion.matches ? 'auto' : 'smooth',
                });
            }

            function syncIndexFromScroll() {
                if (!cards.length) return;
                var rect = grid.getBoundingClientRect();
                var mid = rect.left + rect.width / 2;
                var best = 0;
                var bestDist = Infinity;
                for (var i = 0; i < cards.length; i++) {
                    var r = cards[i].getBoundingClientRect();
                    var c = r.left + r.width / 2;
                    var d = Math.abs(c - mid);
                    if (d < bestDist) {
                        bestDist = d;
                        best = i;
                    }
                }
                currentIndex = best;
            }

            function goNext() {
                if (cards.length < 2) return;
                if (section) {
                    var sr = section.getBoundingClientRect();
                    if (sr.bottom < 0 || sr.top > window.innerHeight) {
                        return;
                    }
                }
                currentIndex = (currentIndex + 1) % cards.length;
                scrollCardToCenter(cards[currentIndex]);
            }

            function startAutoplay() {
                stopAutoplay();
                if (!mq.matches || reduceMotion.matches || cards.length < 2) return;
                intervalId = window.setInterval(goNext, delay);
            }

            function stopAutoplay() {
                if (intervalId) {
                    window.clearInterval(intervalId);
                    intervalId = null;
                }
            }

            function scheduleResume() {
                window.clearTimeout(resumeTimer);
                resumeTimer = window.setTimeout(function () {
                    syncIndexFromScroll();
                    startAutoplay();
                }, 5000);
            }

            function onUserInteract() {
                stopAutoplay();
                window.clearTimeout(resumeTimer);
                scheduleResume();
            }

            function bind() {
                if (!mq.matches || cards.length < 2 || listenersAttached) return;
                listenersAttached = true;
                currentIndex = 0;
                startAutoplay();
                grid.addEventListener('touchstart', onUserInteract, { passive: true });
                grid.addEventListener('wheel', onUserInteract, { passive: true });
            }

            function unbind() {
                if (!listenersAttached) return;
                listenersAttached = false;
                stopAutoplay();
                window.clearTimeout(resumeTimer);
                grid.removeEventListener('touchstart', onUserInteract);
                grid.removeEventListener('wheel', onUserInteract);
            }

            mq.addEventListener('change', function (e) {
                if (e.matches) bind();
                else unbind();
            });

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', bind);
            } else {
                bind();
            }
        })();
    </script>
    <script>
        if (typeof jQuery !== 'undefined' && typeof jQuery.fn.slick !== 'undefined') {
            $(document).ready(function() {

                // Video Play Button Functionality
                const playBtn = document.getElementById('play-video-btn');
                const video = document.getElementById('main-video');
                const videoContainer = document.querySelector('.video-showcase-main');

                if (playBtn && video) {
                    // Play button click
                    playBtn.addEventListener('click', function() {
                        video.play();
                        videoContainer.classList.add('playing');
                        video.setAttribute('controls', 'controls');
                    });

                    // When video ends, show play button again
                    video.addEventListener('ended', function() {
                        videoContainer.classList.remove('playing');
                        video.removeAttribute('controls');
                    });

                    // If user pauses the video
                    video.addEventListener('pause', function() {
                        if (!video.ended) {
                            // Keep controls visible even when paused
                            videoContainer.classList.add('playing');
                        }
                    });

                    // When video starts playing
                    video.addEventListener('play', function() {
                        videoContainer.classList.add('playing');
                    });
                }

                // Initialize Marquee Video Gallery - Continuous Slow Scroll (3 full + 4th ~30% visible)
                if ($('.marquee-gallery-slider').length > 0) {
                    $('.marquee-gallery-slider').slick({
                        infinite: true,
                        slidesToShow: 3.5,
                        slidesToScroll: 1,
                        autoplay: true,
                        autoplaySpeed: 0, // Continuous movement without pause
                        speed: 5000, // 5 seconds for smooth slow transition
                        cssEase: 'linear', // Linear for constant speed
                        arrows: false,
                        dots: false,
                        pauseOnHover: false, // Don't pause on hover for continuous effect
                        draggable: true,
                        swipe: true,
                        responsive: [{
                                breakpoint: 1200,
                                settings: {
                                    slidesToShow: 2.5,
                                    slidesToScroll: 1,
                                    speed: 5000
                                }
                            },
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1,
                                    speed: 4000
                                }
                            }
                        ]
                    });
                    console.log('Marquee Video Gallery - Continuous Scroll Initialized');
                }

            });
        } else {
            console.error('jQuery or Slick not loaded');
        }
    </script>
@endpush
