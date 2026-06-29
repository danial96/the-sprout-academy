@extends('frontend.partials.master')

@section('title', 'Thank You - ' . $locationData['name'])

@section('content')
    <!-- Thank You Section -->
    <section class="thank-you-section">
        <div class="container">
            <div class="thank-you-content">
                <!-- Success Icon -->
                <div class="thank-you-icon">
                    <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="40" cy="40" r="40" fill="#6daa44"/>
                        <path d="M25 40L35 50L55 30" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>

                <!-- Thank You Message -->
                <h2 class="thank-you-title">THANK YOU!</h2>
                <h3 class="thank-you-subtitle">
                    FOR ENROLLING YOUR CHILD AT <span class="thank-you-academy">SPROUT ACADEMY</span>
                </h3>

                <!-- Instructions -->
                <div class="thank-you-message">
                    <p>We Have Received Your Request. Please Visit The School Location As Soon As Possible (ASAP) To Complete The Registration Process.</p>
                    <p>Thank You For Trusting Us With Your Child's Education. We Hope Their Learning And Development Will Be Everything You Expect.</p>
                </div>

                <!-- Contact Info -->
                <div class="thank-you-contact">
                    <p>If You Have Any Queries, You Can Contact Us At This Number:</p>
                    <div class="thank-you-phone">
                        <span class="thank-you-phone-icon" aria-hidden="true">
                            <img src="{{ asset('frontend/assets/home_page_images/phone-icon-white.png') }}"
                                alt="Phone" class="thank-you-phone-icon-image">
                        </span>
                        <span>PHONE: {{ $locationData['phone'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


