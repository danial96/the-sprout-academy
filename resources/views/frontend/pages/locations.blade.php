@extends('frontend.partials.master')
@section('title', 'Locations')

@section('content')
    <!-- Inner Page Header -->
    @include('frontend.partials.header_inner', [
        'bgImage' => asset('frontend/assets/home_page_images/hdr-locations.png'),
        'title' => 'LOCATIONS',
        'subtitle' => 'Explore Our Academy',
    ])
    <!-- Locations Virtual Tour Section -->
    <section class="virtual-tour-locations locations-page" id="locations">
        <div class="container">
            @forelse ($locations as $index => $location)
                <div class="vt-location-block" id="{{ $location->slug }}">
                    @if ($index % 2 == 1)
                        {{-- Map first for odd indices (Clearwater, Montessori pattern) --}}
                        @include('frontend.components.google-map', [
                            'address' => $location->google_maps_address,
                        ])
                    @endif

                    <div class="vt-location-info">
                        <h2 class="vt-location-title">{{ $location->name }}</h2>
                        <div class="vt-contact-list">
                            <div class="vt-contact-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <div class="vt-contact-details">
                                    <span class="vt-contact-label">LOCATION ADDRESS</span>
                                    <span class="vt-contact-value">{{ $location->address }}</span>
                                </div>
                            </div>
                            @if ($location->phone)
                                <div class="vt-contact-item">
                                    <i class="fas fa-phone-alt"></i>
                                    <div class="vt-contact-details">
                                        <span class="vt-contact-label">PHONE</span>
                                        <span class="vt-contact-value">{{ $location->phone }}</span>
                                    </div>
                                </div>
                            @endif
                            @if ($location->fax)
                                <div class="vt-contact-item">
                                    <i class="fas fa-fax"></i>
                                    <div class="vt-contact-details">
                                        <span class="vt-contact-label">FAX</span>
                                        <span class="vt-contact-value">{{ $location->fax }}</span>
                                    </div>
                                </div>
                            @endif
                            @if ($location->email)
                                <div class="vt-contact-item">
                                    <i class="fas fa-envelope"></i>
                                    <div class="vt-contact-details">
                                        <span class="vt-contact-label">EMAIL</span>
                                        <span class="vt-contact-value">{{ $location->email }}</span>
                                    </div>
                                </div>
                            @endif
                            @if ($location->hours_of_operation)
                                <div class="vt-contact-item">
                                    <i class="fas fa-clock"></i>
                                    <div class="vt-contact-details">
                                        <span class="vt-contact-label">HOURS OF OPERATION</span>
                                        <span class="vt-contact-value">{!! nl2br(e($location->hours_of_operation)) !!}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="vt-action-buttons">
                            <a href="{{ route('enrollment.start', ['location' => $location->slug, 'ref' => 'locations']) }}"
                                class="btn btn-enroll">Register Here</a>
                            @php
                                $routeMap = [
                                    'seminole' => 'frontend.locationSeminole',
                                    'st-petersburg' => 'frontend.locationStPetersburg',
                                    'pinellas-park' => 'frontend.locationPinellasPark',
                                    'montessori' => 'frontend.locationMontessori',
                                    'largo' => 'frontend.locationLargo',
                                ];
                                $routeName = $routeMap[$location->slug] ?? null;
                            @endphp
                            @if ($routeName && Route::has($routeName))
                                <a href="{{ route($routeName) }}" class="btn btn-foundation">More Information</a>
                            @endif
                        </div>
                    </div>

                    @if ($index % 2 == 0)
                        {{-- Map second for even indices (Seminole, St. Petersburg, Pinellas Park, Largo pattern) --}}
                        @include('frontend.components.google-map', [
                            'address' => $location->google_maps_address,
                        ])
                    @endif
                </div>
            @empty
                <div class="text-center py-5">
                    <p>No locations available at this time.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection
