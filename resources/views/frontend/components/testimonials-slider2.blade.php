@php
    $testimonials = [
        [
            'text' =>
                '"The Sprout Academy has got the best staff and the kids learn so much, so quickly. They make        learning so much fun that the kids don’t even realize they’re learning. I recommend The Sprout Academy to everyone"',
            'author' => 'Theresa C',
        ],
        [
            'text' =>
                '"The Sprout Academy is the best. My son still talks about his time there. He just graduated Kindergarten but he will never forget his time at Sprout!"',
            'author' => 'Brandi B',
        ],
        [
            'text' =>
                '"Justin and Rachel, owners of Sprout Academy, have created a school where education, care, and child development truly come first."',
            'author' => 'Carlos. C',
        ],
        [
            'text' =>
                '"Under the guidance of owners Justin and Rachel, Sprout Academy delivers an exceptional learning experience for young children."',
            'author' => 'Jason .J',
        ],
        [
            'text' =>
                '"The Sprout Academy is the best. My son still talks about his time there. He just graduated Kindergarten but he will never forget his time at Sprout!"',
            'author' => 'Theresa C',
        ],
    ];
@endphp

<div class="testimonials-section-2">
    <section class="testimonials-section-v2" aria-label="Customer testimonials">
        <div class="container">
            {{-- Section Title --}}
            <h2 class="testimonials-v2-title">What Parents Are Saying</h2>

            <div class="testimonial-slider-v2">
                @foreach ($testimonials as $testimonial)
                    <div class="testimonial-slide-v2">
                        <div class="testimonial-card-v2">
                            <div class="testimonial-quote-icon-v2">
                                <img src="{{ asset('frontend/assets/home_page_images/qoute.png') }}" alt="Quote">
                            </div>

                            <p class="testimonial-text-v2">{{ $testimonial['text'] }}</p>

                            <div class="testimonial-footer-v2">
                                <p class="testimonial-author-v2">{{ $testimonial['author'] }}</p>
                                <div class="testimonial-rating-v2" aria-label="5 out of 5 stars">★★★★★</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>

@push('scripts')
    <script>
        // Initialize Testimonial Slider V2 (3 items, center active)
        if ($('.testimonial-slider-v2').length > 0) {
            $('.testimonial-slider-v2').slick({
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 1,
                centerMode: true,
                centerPadding: '0px',
                variableWidth: false,
                autoplay: false,
                autoplaySpeed: 3000,
                speed: 600,
                arrows: false,
                dots: true,
                pauseOnHover: false,
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            centerMode: true,
                            centerPadding: '0px'
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            centerMode: true,
                            centerPadding: '40px'
                        }
                    }
                ]
            });
            console.log('Testimonial Slider V2 Initialized');
        }
    </script>
@endpush
