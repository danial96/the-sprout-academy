{{--
    Directors Section Component - Static Version
    Usage: @include('frontend.components.directors-section')
--}}

<section class="directors-section">
    <div class="container">
        <div class="directors-header">
            <h2 class="directors-title">Directors</h2>
            <img src="{{ asset('frontend/assets/home_page_images/pencil_icon.png') }}" alt="Pencil Icon"
                class="directors-title-icon">
        </div>

        {{-- Location Tabs --}}
        <div class="directors-tabs">
            <button class="director-tab" data-location="seminole">Seminole Director</button>
            <button class="director-tab" data-location="pinellas-park">Pinellas Park Director</button>
            <button class="director-tab active" data-location="st-petersburg">St. Petersburg Director</button>
            <button class="director-tab" data-location="largo">Largo Director</button>
            <button class="director-tab" data-location="montessori">Montessori Director</button>
        </div>

        {{-- Directors Content --}}
        <div class="directors-content">
            {{-- St. Petersburg Director --}}
            <div class="director-card active" id="st-petersburg">
                <div class="director-info-card">
                    <h3 class="director-name">Crystal Jordan</h3>
                    <p class="director-role">St. Petersburg Director</p>

                    <div class="director-details">
                        <div class="director-detail-item">
                            <div class="detail-icon-wrapper">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">LOCATION ADDRESS:</span>
                                <span class="detail-value">5610 54th Ave. N. St Petersburg, FL 33709</span>
                            </div>
                        </div>

                        <div class="director-detail-item">
                            <div class="detail-icon-wrapper">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">PHONE:</span>
                                <span class="detail-value">727-541-6260</span>
                            </div>
                        </div>

                        <div class="director-detail-item">
                            <div class="detail-icon-wrapper">
                                <i class="fas fa-fax"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">FAX:</span>
                                <span class="detail-value">727-851-9975</span>
                            </div>
                        </div>

                        <div class="director-detail-item">
                            <div class="detail-icon-wrapper">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">EMAIL:</span>
                                <span class="detail-value">Crystal@the-sprout-academy.com</span>
                            </div>
                        </div>

                        <div class="director-detail-item">
                            <div class="detail-icon-wrapper">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">HOURS OF OPERATION:</span>
                                <span class="detail-value">Monday-Friday - 6:30 a.m. to 6:00 p.m</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="director-photo-card">
                    <img src="{{ asset('frontend/assets/home_page_images/St.Petersburg-Director.png') }}" alt="Crystal Jordan">
                </div>
            </div>

            {{-- Seminole Director --}}
            <div class="director-card" id="seminole">
                <div class="director-info-card">
                    <h3 class="director-name">Trista Sanders</h3>
                    <p class="director-role">Seminole Director</p>

                    <div class="director-details">
                        <div class="director-detail-item">
                            <div class="detail-icon-wrapper">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">LOCATION ADDRESS:</span>
                                <span class="detail-value">9259 Park Blvd  Seminole, FL 33777</span>
                            </div>
                        </div>

                        <div class="director-detail-item">
                            <div class="detail-icon-wrapper">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">PHONE:</span>
                                <span class="detail-value">727-399-2483</span>
                            </div>
                        </div>

                        <div class="director-detail-item">
                            <div class="detail-icon-wrapper">
                                <i class="fas fa-fax"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">FAX:</span>
                                <span class="detail-value">727-399-2489</span>
                            </div>
                        </div>

                        <div class="director-detail-item">
                            <div class="detail-icon-wrapper">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">EMAIL:</span>
                                <span class="detail-value">Trista@the-sprout-academy.com</span>
                            </div>
                        </div>

                        <div class="director-detail-item">
                            <div class="detail-icon-wrapper">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">HOURS OF OPERATION:</span>
                                <span class="detail-value">Monday-Friday - 7:00 a.m. to 6:00 p.m. (toddlers 7:30 a.m. to 5:30 p.m.)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="director-photo-card">
                    <img src="{{ asset('frontend/assets/home_page_images/Seminole-Director.png') }}" alt="Trista Sanders">
                </div>
            </div>

            {{-- Pinellas Park Director --}}
            <div class="director-card" id="pinellas-park">
                <div class="director-info-card">
                    <h3 class="director-name">Yessica Ortiz-Rodriguez</h3>
                    <p class="director-role">Pinellas Park Director</p>

                    <div class="director-details">
                        <div class="director-detail-item">
                            <div class="detail-icon-wrapper">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">LOCATION ADDRESS:</span>
                                <span class="detail-value">6552 84th Ave. N. Pinellas Park, FL 33781</span>
                            </div>
                        </div>

                        <div class="director-detail-item">
                            <div class="detail-icon-wrapper">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">PHONE:</span>
                                <span class="detail-value">727-545-9944</span>
                            </div>
                        </div>

                        <div class="director-detail-item">
                            <div class="detail-icon-wrapper">
                                <i class="fas fa-fax"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">FAX:</span>
                                <span class="detail-value">727-544-2442</span>
                            </div>
                        </div>

                        <div class="director-detail-item">
                            <div class="detail-icon-wrapper">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">EMAIL:</span>
                                <span class="detail-value">Yessica@the-sprout-academy.com</span>
                            </div>
                        </div>

                        <div class="director-detail-item">
                            <div class="detail-icon-wrapper">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">HOURS OF OPERATION:</span>
                                <span class="detail-value">Monday-Friday - 6:30 a.m. to 6:00 p.m. (toddlers 7:30 a.m. to 5:30 p.m.)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="director-photo-card">
                    <img src="{{ asset('frontend/assets/home_page_images/Pinellas-Park-Director.png') }}" alt="Yessica Ortiz-Rodriguez">
                </div>
            </div>

            {{-- Largo Director --}}
            <div class="director-card" id="largo">
                <div class="director-info-card">
                    <h3 class="director-name">Debbie Snyder</h3>
                    <p class="director-role">Largo Director</p>

                    <div class="director-details">
                        <div class="director-detail-item">
                            <div class="detail-icon-wrapper">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">LOCATION ADDRESS:</span>
                                <span class="detail-value">1807 S Highland Ave Clearwater, FL 33756</span>
                            </div>
                        </div>

                        <div class="director-detail-item">
                            <div class="detail-icon-wrapper">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">PHONE:</span>
                                <span class="detail-value">727-559-1777</span>
                            </div>
                        </div>

                        <div class="director-detail-item">
                            <div class="detail-icon-wrapper">
                                <i class="fas fa-fax"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">FAX:</span>
                                <span class="detail-value">727-648-4451</span>
                            </div>
                        </div>

                        <div class="director-detail-item">
                            <div class="detail-icon-wrapper">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">EMAIL:</span>
                                <span class="detail-value">Debbie@the-sprout-academy.com</span>
                            </div>
                        </div>

                        <div class="director-detail-item">
                            <div class="detail-icon-wrapper">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">HOURS OF OPERATION:</span>
                                <span class="detail-value">Monday-Friday - 7:00 a.m. to 6:00 p.m.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="director-photo-card">
                    <img src="{{ asset('frontend/assets/home_page_images/Largo-Director.png') }}" alt="Debbie Snyder">
                </div>
            </div>

            {{-- Montessori Director --}}
            <div class="director-card" id="montessori">
                <div class="director-info-card">
                    <h3 class="director-name">Cierra Champagne</h3>
                    <p class="director-role">Montessori Director</p>

                    <div class="director-details">
                        <div class="director-detail-item">
                            <div class="detail-icon-wrapper">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">LOCATION ADDRESS:</span>
                                <span class="detail-value">2095 Belleair Road Clearwater, FL 33764</span>
                            </div>
                        </div>

                        <div class="director-detail-item">
                            <div class="detail-icon-wrapper">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">PHONE/FAX:</span>
                                <span class="detail-value">727-535-8512</span>
                            </div>
                        </div>

                        <div class="director-detail-item">
                            <div class="detail-icon-wrapper">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">EMAIL:</span>
                                <span class="detail-value">Cierra@the-sprout-academy.com</span>
                            </div>
                        </div>

                        <div class="director-detail-item">
                            <div class="detail-icon-wrapper">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">HOURS OF OPERATION:</span>
                                <span class="detail-value">Monday-Friday - 7:00 a.m. to 6:00 p.m.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="director-photo-card">
                    <img src="{{ asset('frontend/assets/home_page_images/Montessori-Director.png') }}" alt="Cierra Champagne">
                </div>
            </div>
        </div>
    </div>
</section>
