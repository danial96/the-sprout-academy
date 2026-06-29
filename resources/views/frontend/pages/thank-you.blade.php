@extends('frontend.partials.master')

@section('title', 'Thank You')

@section('content')
    <section class="thank-you-section">
        <div class="container">
            <div class="thank-you-content">
                <div class="thank-you-icon">
                    <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="30" cy="30" r="30" fill="#007b9a" />
                        <path d="M20 30L26 36L40 22" stroke="white" stroke-width="4" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
                <h1 class="thank-you-title">THANK YOU!</h1>
                <p class="thank-you-message">Our Team Will Look Forward To Reviewing Your Details</p>
            </div>
        </div>
    </section>
@endsection
