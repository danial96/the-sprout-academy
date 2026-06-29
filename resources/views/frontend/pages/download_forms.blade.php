@extends('frontend.partials.master')

@section('title', 'Download Forms')

@section('content')

    @include('frontend.partials.header_inner', [
        'bgImage' => asset('frontend/assets/home_page_images/hdr-df.png'),
        'title' => 'DOWNLOAD FORMS',
        'subtitle' => 'The Sprout Academy',
        'text' => 'We have provided some helpful forms to get you started with our program.',
        'showButton' => false,
    ])

    {{-- Download Forms Section --}}
    <section class="download-forms-section">
        <div class="container">
            <div class="forms-grid">
                {{-- Form Card 1 --}}
                <div class="form-card">
                    <div class="form-image">
                        <img src="{{ asset('frontend/assets/home_page_images/df1.png') }}" alt="Child Enrollment Record">
                    </div>
                    <a href="{{ asset('frontend/assets/docs/pcbl-child-enrollment-record.pdf') }}" class="form-title" target="_blank">
                        PCLB Child Enrollment Record
                    </a>
                </div>

                {{-- Form Card 2 --}}
                <div class="form-card">
                    <div class="form-image">
                        <img src="{{ asset('frontend/assets/home_page_images/df2.png') }}"
                            alt="Child Health And Development">
                    </div>
                    <a href="{{ asset('frontend/assets/docs/PCLB-Child-Health-Development-Questionnaire.pdf') }}" class="form-title" target="_blank">
                        PCLB Child Health And Development Questionnaire
                    </a>
                </div>

                {{-- Form Card 3 --}}
                <div class="form-card">
                    <div class="form-image">
                        <img src="{{ asset('frontend/assets/home_page_images/df3.png') }}" alt="Report Abuse & Neglect">
                    </div>
                    <a href="{{ asset('frontend/assets/docs/Report-Abuse-Neglect.pdf') }}" class="form-title" target="_blank">
                        Responsibility to Report Abuse & Neglect
                    </a>
                </div>

                {{-- Form Card 4 --}}
                <div class="form-card">
                    <div class="form-image">
                        <img src="{{ asset('frontend/assets/home_page_images/df4.png') }}" alt="Food Experience Permission">
                    </div>
                    <a href="{{ asset('frontend/assets/docs/PCLB-Food-Experience-Permission-Form.pdf') }}" class="form-title" target="_blank">
                        PCLB Food Experience Permission Form
                    </a>
                </div>

                {{-- Form Card 5 --}}
                <div class="form-card">
                    <div class="form-image">
                        <img src="{{ asset('frontend/assets/home_page_images/df5.png') }}" alt="Emergency Medical Release">
                    </div>
                    <a href="{{ asset('frontend/assets/docs/New-fc-0003-emergency-med-release.pdf') }}" class="form-title" target="_blank">
                        PCLB Emergency Medical Release
                    </a>
                </div>

                {{-- Form Card 6 --}}
                <div class="form-card">
                    <div class="form-image">
                        <img src="{{ asset('frontend/assets/home_page_images/df6.png') }}" alt="Infant Toddler Health">
                    </div>
                    <a href="{{ asset('frontend/assets/docs/PCLB-Infant-Toddler-Health-Development-Questionnaire.pdf') }}" class="form-title" target="_blank">
                        PCLB Infant/Toddler Health & Development Questionnaire
                    </a>
                </div>

                {{-- Form Card 7 --}}
                <div class="form-card">
                    <div class="form-image">
                        <img src="{{ asset('frontend/assets/home_page_images/df7.png') }}" alt="DCF Influenza Virus">
                    </div>
                    <a href="{{ asset('frontend/assets/docs/DCF-Flu-Virus-Brochure.pdf') }}" class="form-title" target="_blank">
                        DCF Influenza Virus Brocher
                    </a>
                </div>

                {{-- Form Card 8 --}}
                <div class="form-card">
                    <div class="form-image">
                        <img src="{{ asset('frontend/assets/home_page_images/df8.png') }}" alt="Parent Orientation">
                    </div>
                    <a href="{{ asset('frontend/assets/docs/Parent-Orientation.pdf') }}" class="form-title" target="_blank">
                        Parent Orientation
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection