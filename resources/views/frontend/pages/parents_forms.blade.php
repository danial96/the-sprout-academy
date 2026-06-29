@extends('frontend.partials.master')

@section('title', 'Parents Forms')

@section('content')
    {{-- Hero: orange pill, PARENTS FORMS title, subtitle --}}
    <section class="inner-page-header parents-forms-hero"
        style="background-image: url('{{ asset('frontend/assets/home_page_images/parent-page-bg.png') }}');"
        aria-label="Parents Forms">
        <div class="parents-forms-hero-overlay"></div>
        <div class="container">
            <div class="inner-header-content parents-forms-hero-content">
                @include('frontend.components.section-heading', [
                    'text' => 'The Sprout Academy',
                    'bgColor' => '#ed9b04',
                    'borderColor' => '#fff',
                    'rotation' => 'right',
                ])
                <h1 class="inner-header-title">PARENTS FORMS</h1>
                <p class="inner-header-text">We have provided some helpful forms to get you started with our program.</p>
            </div>
        </div>
    </section>

    {{-- Two cards: Enrollment Packet, Parent Handbook --}}
    <section class="parents-forms-cards-section">
        <div class="container">
            <div class="parents-forms-grid">
                <a href="{{ asset('frontend/assets/docs/Sprout-Employee-Handbook-3.1.docx') }}" class="parents-form-card"
                target="_blank" rel="noopener noreferrer" download="Sprout-Employee-Handbook-3.1.docx">
                <div class="parents-form-card-image">
                    <img src="{{ asset('frontend/assets/home_page_images/parent-page-img2.png') }}"
                        alt="Employee Handbook" loading="lazy">
                </div>
                    <h3 class="parents-form-card-title">Enrollment Packet</h3>
                </a>
                <a href="{{ asset('frontend/assets/docs/Sprout-Parent-Handbook-2020-v6.docx') }}" class="parents-form-card"
                    target="_blank" rel="noopener noreferrer" download="Sprout-Parent-Handbook-2020-v6.docx">
                    <div class="parents-form-card-image">
                        <img src="{{ asset('frontend/assets/home_page_images/parent-page-img2.png') }}"
                            alt="Parent Handbook" loading="lazy">
                    </div>
                    <h3 class="parents-form-card-title">Parent Handbook</h3>
                </a>
            </div>
        </div>
    </section>
@endsection
