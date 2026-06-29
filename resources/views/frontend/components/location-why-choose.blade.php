<section class="why-choose-section location-why-choose">
    <div class="container">
        <div class="section-heading-wrapper">
            <img src="{{ asset('frontend/assets/home_page_images/lock.png') }}" alt="Icon" class="section-icon-left">
            <h2 class="section-title-inner">The Sprout Academy</h2>
            <img src="{{ asset('frontend/assets/home_page_images/star.png') }}" alt="Icon" class="section-icon-right">
        </div>

        <div class="video-showcase-main">
            <video class="main-video-player" poster="{{ asset('frontend/assets/home_page_images/sprt-aca-img-1.png') }}"
                controls preload="metadata">
                <source src="{{ asset('frontend/assets/home_page_images/vdo-2.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <button class="video-play-btn-main" aria-label="Play video">
                <span class="play-icon"></span>
            </button>
        </div>
    </div>
</section>
