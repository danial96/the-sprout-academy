<!-- Newsletter Section -->
<section class="footer-newsletter">
    <div class="container">
        <div class="text-center">
            @include('frontend.components.section-heading', [
                'text' => 'Join Our Newsletter',
                'bgColor' => '#6daa44',
                'borderColor' => '#6CAA43',
                'rotation' => 'right',
            ])
        </div>
        <h2 class="newsletter-title">Stay Connected to The Sprout Academy!</h2>
        <form id="newsletterForm" class="newsletter-form needs-validation" method="POST"
            action="{{ route('form.subscribeNewsletter') }}" novalidate>
            @csrf
            <input type="text" class="newsletter-input" name="name" id="newsletterName" placeholder="Your Name"
                required aria-label="Your name">
            <input type="email" class="newsletter-input" name="email" id="newsletterEmail" placeholder="Your Email"
                required aria-label="Your email address">
            <button type="submit" class="btn btn-secondary" id="newsletterSubmitBtn">
                <span class="btn-text">Subscribe Now!</span>
                <span class="btn-spinner" style="display: none;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M21 12a9 9 0 11-6.219-8.56" />
                    </svg>
                </span>
            </button>
        </form>
        <div id="newsletterMessage" class="newsletter-message" style="display: none;"></div>
    </div>
</section>

<!-- Main Footer -->
<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <!-- Column 1: Brand -->
            <div class="footer-col footer-col-brand">
                <a class="footer-brand" href="{{ route('frontend.home') }}">
                    <img src="{{ asset('frontend/assets/home_page_images/footer-logo.png') }}" alt="The Sprout Academy"
                        class="footer-brand-img" loading="lazy">
                </a>
                <p class="footer-description">
                    The Sprout Academy develops the whole child by meeting social, emotional, physical, and intellectual
                    needs through learning and growing every day.
                </p>
                {{-- <div class="footer-social">
                    <a href="#" class="footer-social-link" aria-label="Facebook" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="footer-social-link" aria-label="Instagram" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="footer-social-link" aria-label="LinkedIn" target="_blank" rel="noopener noreferrer"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="footer-social-link" aria-label="YouTube" target="_blank" rel="noopener noreferrer"><i class="fab fa-youtube"></i></a>
                </div> --}}
            </div>

            <!-- Column 2: Company -->
            <div class="footer-col">
                <h3 class="footer-title">Company</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('frontend.theSproutAcademyDifference') }}">About Us</a></li>
                    <li><a href="{{ route('frontend.enroll') }}">Contact Us</a></li>
                    <li><a href="{{ route('form.employmentApplication') }}">Apply To Work With Sprout</a></li>
                </ul>
            </div>

            <!-- Column 3: Programs -->
            <div class="footer-col">
                <h3 class="footer-title">Programs</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('frontend.ourPrograms') }}">Program Overview</a></li>
                    <li><a href="{{ route('frontend.infantToddlerEducation') }}">Infant & Toddler</a></li>
                    <li><a href="{{ route('frontend.preschoolEarlyEducation') }}">Preschool</a></li>
                    <li><a href="{{ route('frontend.educationFor512YearOld') }}">Pre-K, School Age</a></li>
                </ul>
            </div>

            <!-- Column 4: Resources -->
            <div class="footer-col">
                <h3 class="footer-title">Resources</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('frontend.employeeForms') }}">Employee Portal</a></li>
                    <li><a href="{{ route('frontend.parentsForms') }}">Parent Forms</a></li>
                    {{-- <li><a href="{{ route('frontend.downloadForms') }}">Download Forms</a></li> --}}
                    <li><a href="{{ route('frontend.nonDiscriminationPolicy') }}">Non-Discrimination Policy</a></li>
                    <li><a href="{{ route('frontend.corporateResponsibility') }}">Corporate Responsibility</a></li>
                </ul>
            </div>

            <!-- Column 5: Other -->
            <div class="footer-col">
                <h3 class="footer-title">Other</h3>
                <ul class="footer-links">
                    <li><a href="https://thesproutstore.com/" target="_blank" rel="noopener noreferrer">Sprout Store</a></li>
                    <li><a href="https://sproutvine.com/" target="_blank" rel="noopener noreferrer">SproutVine</a></li>
                    <li><a href="https://sproutfoundation.org/" target="_blank" rel="noopener noreferrer">Sprout Foundation</a></li>
                </ul>
            </div>

            <!-- Column 6: Our Locations -->
            <div class="footer-col">
                <h3 class="footer-title">Our Locations</h3>
                <ul class="footer-links footer-locations-list">
                    <li>
                        <img src="{{ asset('frontend/assets/home_page_images/loc-ico.png') }}" alt="" class="footer-location-icon" loading="lazy">
                        <a href="{{ route('frontend.locationSeminole') }}">Seminole</a>
                    </li>
                    <li>
                        <img src="{{ asset('frontend/assets/home_page_images/loc-ico.png') }}" alt="" class="footer-location-icon" loading="lazy">
                        <a href="{{ route('frontend.locationPinellasPark') }}">Pinellas Park</a>
                    </li>
                    <li>
                        <img src="{{ asset('frontend/assets/home_page_images/loc-ico.png') }}" alt="" class="footer-location-icon" loading="lazy">
                        <a href="{{ route('frontend.locationMontessori') }}">Montessori</a>
                    </li>
                    <li>
                        <img src="{{ asset('frontend/assets/home_page_images/loc-ico.png') }}" alt="" class="footer-location-icon" loading="lazy">
                        <a href="{{ route('frontend.locationStPetersburg') }}">St. Pete</a>
                    </li>
                    <li>
                        <img src="{{ asset('frontend/assets/home_page_images/loc-ico.png') }}" alt="" class="footer-location-icon" loading="lazy">
                        <a href="{{ route('frontend.locationLargo') }}">Largo</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p class="mb-0">
                Copyrights &copy; {{ date('Y') }}. The Sprout Academy. All rights reserved.
            </p>
            <p class="mb-0">
                Site by <a href="https://webenixsolutions.com/" target="_blank" rel="noopener noreferrer">Webenix Solutions</a>
            </p>
        </div>
    </div>
</footer>
