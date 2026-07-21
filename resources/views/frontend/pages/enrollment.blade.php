@extends('frontend.partials.master')

@section('content')
    @include('frontend.partials.header_inner', [
        'bgImage' => asset('frontend/assets/home_page_images/enroll-bg.png'),
        'title' => 'Spots are Limited!',
        'subtitle' => 'The Sprout Academy',
        'text' => 'Schools fill up quickly. Enroll today!',
        'showButton' => false,
    ])

    <!-- Spots Are Limited / Locations Section -->
    <section class="locations-section section" aria-labelledby="locations-heading">
        <div class="container">

            <div class="locations-grid">
                @forelse ($locations as $location)
                    @php
                        // Static images map based on location slug
                        $locationImages = [
                            'seminole' => 'sch-img-1.png',
                            'st-petersburg' => 'sch-img-2.png',
                            'pinellas-park' => 'sch-img-3.png',
                            'montessori' => 'sch-img-4.png',
                            'largo' => 'sch-img-5.png',
                        ];
                        $imageName = $locationImages[$location->slug] ?? 'sch-img-1.png';
                        $cardImage = $location->home_page_image
                            ? asset('uploads/locations/' . $location->home_page_image)
                            : asset('frontend/assets/home_page_images/' . $imageName);
                    @endphp
                    <div class="location-card">
                        <div class="location-image-wrapper">
                            <img src="{{ $cardImage }}"
                                alt="The Sprout Academy {{ $location->name }} location exterior" class="location-image"
                                loading="lazy">
                        </div>
                        <div class="location-bar">
                            <div class="loc-bar-left">
                                <span class="location-name">{{ strtoupper($location->name) }}</span>
                                @if ($location->show_enroll === null || $location->show_enroll == 1)
                                    <a href="{{ route('enrollment.start', ['location' => $location->slug, 'ref' => 'enroll']) }}"
                                        class="loc-enroll-btn">Enroll Now »</a>
                                @endif
                            </div>
                            <div class="loc-bar-right">
                                <div class="loc-pin-circle"><i class="fas fa-map-marker-alt"></i></div>
                                <span class="loc-address">{{ $location->address }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <p>No locations available at this time.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <div class="testimonials-section-2">
        <section class="testimonials-section-v2 enroll-contact-section" aria-labelledby="enroll-contact-heading">
            <div class="container">
                <div class="text-center" id="enroll-contact-tag-heading">
                @include('frontend.components.section-heading', [
                    'text' => 'Still have questions?',
                    'bgColor' => '#0A2239',
                    'borderColor' => '#fff',
                    'rotation' => 'center',
                    ])
                </div>
                @include('frontend.components.enroll-contact-form', ['locations' => $locations])
            </div>
        </section>
    </div>
@endsection
