@php
    $testimonials = [
        [
            'headline' => 'They Make Learning So Much Fun',
            'text' =>
                '"The Sprout Academy has got the best staff and the kids learn so much, so quickly. They make        learning so much fun that the kids don’t even realize they’re learning. I recommend The Sprout Academy to everyone"',
            'author' => 'Theresa C',
        ],
        [
            'headline' => 'The Sprout Academy is the best',
            'text' =>
                '"The Sprout Academy is the best. My son still talks about his time there. He just graduated Kindergarten but he will never forget his time at Sprout!"',
            'author' => 'Brandi B',
        ],
        [
            'headline' => 'A School Built on Care and Quality',
            'text' =>
                '"Justin and Rachel, owners of Sprout Academy, have created a school where education, care, and child development truly come first."',
            'author' => 'Carlos. C',
        ],
        [
            'headline' => 'Strong Leadership. Strong Education',
            'text' =>
                '"Under the guidance of owners Justin and Rachel, Sprout Academy delivers an exceptional learning experience for young children."',
            'author' => 'Jason .J',
        ],
        [
            'headline' => 'I DRIVE A HALF HOUR OUT OF MY WAY',
            'text' =>
                '"The Sprout Academy is the best. My son still talks about his time there. He just graduated Kindergarten but he will never forget his time at Sprout!"',
            'author' => 'THERESA C',
        ],
    ];
@endphp

<section class="testimonials-section" aria-label="Customer testimonials">
    <div class="container">
        <div class="testimonial-slider">
            @foreach ($testimonials as $testimonial)
                <div class="testimonial-slide">
                    <div class="testimonial-card">
                        <div class="testimonial-quote-badge" aria-hidden="true"></div>

                        <h3 class="testimonial-headline">{{ $testimonial['headline'] }}</h3>

                        <p class="testimonial-text">{{ $testimonial['text'] }}</p>

                        <div class="testimonial-footer">
                            <p class="testimonial-author">- {{ $testimonial['author'] }}</p>
                            <div class="testimonial-rating" aria-label="5 out of 5 stars">★★★★★</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@push('scripts')
    <script>
        // Initialize Testimonial Slider (3 items, center active)
        if ($('.testimonial-slider').length > 0) {
            $('.testimonial-slider').slick({
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 1,
                centerMode: true,
                centerPadding: '0px',
                variableWidth: false,
                autoplay: true,
                autoplaySpeed: 3000,
                speed: 600,
                arrows: false,
                dots: false,
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
            console.log('Testimonial Slider Initialized');
        }
    </script>
@endpush
