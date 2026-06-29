<section class="footer-cta-section">
    <div class="container">
        <section class="footer-cta-section"
            style="background-image: url('{{ $bgImage ?? asset('frontend/assets/home_page_images/cta-banner.png') }}');"
            aria-label="Call to action">
            <div class="container">
                <div class="footer-cta-content">
                    @include('frontend.components.section-heading', [
                        'text' => $fancytitle ?? 'FIND THE SPROUT ACADEMY LOCATION NEAREST YOU',
                        'bgColor' => '#ED9B04',
                        'borderColor' => '#fff',
                        'rotation' => 'right',
                    ])
                    <h2 class="footer-cta-title">
                        {{ $title ?? 'FIND THE SPROUT ACADEMY LOCATION NEAREST YOU' }}
                    </h2>
                    <a href="{{ $buttonLink ?? route('frontend.enroll') }}"
                        class="btn btn-secondary btn-lg footer-cta-btn">
                        {{ $buttonText ?? 'Enroll' }}
                    </a>
                </div>
            </div>
        </section>
    </div>
</section>
