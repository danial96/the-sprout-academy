@extends('frontend.partials.master')

@section('title', 'Enrollment - Review - ' . $locationData['name'])

@section('content')
    <!-- Form Header -->
    @include('frontend.components.form_header', [
        'title' => 'THE SPROUT ACADEMY - ' . $locationData['name'],
    ])

    <!-- Enrollment Review Section -->
    <section class="enrollment-review-section">
        <div class="container">
            <div class="enrollment-review-wrapper">
                <!-- Progress Bar -->
                @include('frontend.components.enrollment.progress-bar', ['currentStep' => $currentStep])

                <!-- Review Content -->
                <div class="review-content">
                    <!-- Left Column - Location Info -->
                    <div class="review-left">
                        <div class="location-info-card">
                            <div class="location-info-item">
                                <i class="fas fa-map-marker-alt location-icon" aria-hidden="true"></i>
                                <div class="location-info-details">
                                    <span class="location-label">LOCATION ADDRESS:</span>
                                    <span class="location-value">{{ $locationData['address'] }}</span>
                                </div>
                            </div>
                            <div class="location-info-item">
                                <span class="location-icon" aria-hidden="true">
                                    <img src="{{ asset('frontend/assets/home_page_images/phone-icon-white.png') }}"
                                        alt="Phone" class="location-icon-image location-icon-image--orange">
                                </span>
                                <div class="location-info-details">
                                    <span class="location-label">PHONE:</span>
                                    <span class="location-value">{{ $locationData['phone'] }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Map -->
                        @include('frontend.components.google-map', [
                            'address' => $locationData['map_address'],
                        ])
                    </div>

                    <!-- Right Column - Review Cards -->
                    <div class="review-right">
                        <!-- ACCOUNT INFO -->
                        @php
                            $primaryContact = $enrollment
                                ? $enrollment->contacts->where('is_primary', true)->first()
                                : null;
                        @endphp
                        @if ($enrollment && $primaryContact)
                            <div class="review-card">
                                <div class="review-card-header">
                                    <h3 class="review-card-title">ACCOUNT INFO</h3>
                                </div>
                                <div class="review-card-content">
                                    <div class="review-profile">
                                        <img src="{{ $primaryContact && $primaryContact->profile_image ? (str_starts_with($primaryContact->profile_image, 'http') ? $primaryContact->profile_image : \Illuminate\Support\Facades\Storage::url($primaryContact->profile_image)) : asset('frontend/assets/home_page_images/enroll-avatar.png') }}"
                                            alt="{{ $primaryContact && $primaryContact->first_name ? $primaryContact->first_name : 'Profile' }}"
                                            class="review-profile-image"
                                            onerror="this.src='{{ asset('frontend/assets/home_page_images/enroll-avatar.png') }}'" />
                                        <div class="review-profile-info">
                                            <div class="review-name">
                                                {{ $primaryContact && $primaryContact->first_name ? $primaryContact->first_name : 'N/A' }}
                                            </div>
                                            <div class="review-detail">
                                                {{ $primaryContact && $primaryContact->gender ? ucfirst($primaryContact->gender) : 'Not Specified' }}
                                            </div>
                                            <div class="review-detail">
                                                {{ $primaryContact && $primaryContact->date_of_birth ? $primaryContact->date_of_birth->format('F d, Y') : 'DOB not Specified' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- CHILDREN INFO -->
                        @if ($enrollment && $enrollment->children && count($enrollment->children) > 0)
                            @foreach ($enrollment->children as $child)
                                <div class="review-card">
                                    <div class="review-card-header">
                                        <h3 class="review-card-title">CHILDREN INFO</h3>
                                    </div>
                                    <div class="review-card-content">
                                        <div class="review-profile">
                                            <img src="{{ $child->profile_image ? (str_starts_with($child->profile_image, 'http') ? $child->profile_image : \Illuminate\Support\Facades\Storage::url($child->profile_image)) : asset('frontend/assets/home_page_images/enroll-avatar.png') }}"
                                                alt="{{ $child->first_name ?? 'Child' }}" class="review-profile-image"
                                                onerror="this.src='{{ asset('frontend/assets/home_page_images/enroll-avatar.png') }}'" />
                                            <div class="review-profile-info">
                                                <div class="review-name">{{ $child->first_name ?? 'N/A' }}</div>
                                                <div class="review-detail">{{ ucfirst($child->gender ?? 'Not Specified') }}
                                                </div>
                                                <div class="review-detail">
                                                    {{ $child->date_of_birth ? $child->date_of_birth->format('F d, Y') : 'DOB not Specified' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <!-- EMERGENCY CONTACTS -->
                        @php
                            $nonPrimaryContacts =
                                $enrollment && $enrollment->contacts
                                    ? $enrollment->contacts->where('is_primary', false)
                                    : collect([]);
                        @endphp
                        @if ($enrollment && $enrollment->contacts && count($nonPrimaryContacts) > 0)
                            @foreach ($enrollment->contacts->where('is_primary', false) as $contact)
                                <div class="review-card">
                                    <div class="review-card-header">
                                        <h3 class="review-card-title">EMERGENCY CONTACTS</h3>
                                    </div>
                                    @if ($contact->relationship_type)
                                        <div class="review-relationship-badge">
                                            {{ ucfirst($contact->relationship_type) }} to</div>
                                    @endif
                                    <div class="review-card-content">
                                        <div class="review-profile">
                                            <img src="{{ $contact->profile_image ? (str_starts_with($contact->profile_image, 'http') ? $contact->profile_image : \Illuminate\Support\Facades\Storage::url($contact->profile_image)) : asset('frontend/assets/home_page_images/enroll-avatar.png') }}"
                                                alt="{{ $contact->first_name ?? 'Contact' }}"
                                                class="review-profile-image"
                                                onerror="this.src='{{ asset('frontend/assets/home_page_images/enroll-avatar.png') }}'" />
                                            <div class="review-profile-info">
                                                <div class="review-name">{{ $contact->first_name ?? 'N/A' }}</div>
                                                <div class="review-detail">
                                                    {{ ucfirst($contact->gender ?? 'Not Specified') }}</div>
                                                <div class="review-detail">
                                                    {{ $contact->date_of_birth ? $contact->date_of_birth->format('F d, Y') : 'DOB not Specified' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <!-- RELATIONSHIP -->
                        @php
                            $nonPrimaryContacts =
                                $enrollment && $enrollment->contacts
                                    ? $enrollment->contacts->where('is_primary', false)
                                    : collect([]);
                        @endphp
                        @if ($enrollment && $enrollment->contacts && count($nonPrimaryContacts) > 0)
                            @foreach ($enrollment->contacts->where('is_primary', false) as $contact)
                                <div class="review-card">
                                    <div class="review-card-header">
                                        <h3 class="review-card-title">RELATIONSHIP</h3>
                                    </div>
                                    <div class="review-card-content">
                                            @if ($contact->relationship_type)
                                                <div class="review-relationship-badge">
                                                    {{ ucfirst($contact->relationship_type) }} to</div>
                                            @endif
                                        <div class="review-profile">
                                            <img src="{{ $contact->profile_image ? (str_starts_with($contact->profile_image, 'http') ? $contact->profile_image : \Illuminate\Support\Facades\Storage::url($contact->profile_image)) : asset('frontend/assets/home_page_images/enroll-avatar.png') }}"
                                                alt="{{ $contact->first_name ?? 'Contact' }}"
                                                class="review-profile-image"
                                                onerror="this.src='{{ asset('frontend/assets/home_page_images/enroll-avatar.png') }}'" />
                                            <div class="review-profile-info">
                                                <div class="review-name">{{ $contact->first_name ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Incomplete Steps Warning -->
                @if (!$isComplete && !empty($incompleteSteps))
                    <div class="enrollment-warning-message">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div class="warning-content">
                            <strong>Please Complete All Steps</strong>
                            <p>You have skipped some steps. Please complete the following steps before submitting:</p>
                            <ul class="incomplete-steps-list">
                                @if (in_array(2, $incompleteSteps))
                                    <li><a href="{{ route('enrollment.step2', ['location' => $location]) }}">Step 2: Children Info</a></li>
                                @endif
                                @if (in_array(3, $incompleteSteps))
                                    <li><a href="{{ route('enrollment.step3', ['location' => $location]) }}">Step 3: Emergency Contacts</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Submit Form -->
                <form id="enrollmentSubmitForm" method="POST"
                    action="{{ route('enrollment.submit', ['location' => $location]) }}">
                    @csrf
                    <div id="formMessage" class="enrollment-message" style="display: none;"></div>
                    <div class="enrollment-actions">
                        <button type="submit" class="btn-enrollment btn-submit" {{ !$isComplete ? 'disabled' : '' }}>
                            <span class="btn-text">SUBMIT ENROLLMENT</span>
                            <span class="btn-spinner" style="display: none;">
                                <i class="fas fa-spinner fa-spin"></i>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    @push('scripts')
        <script src="{{ asset('frontend/assets/js/enrollment-form.js') }}"></script>
    @endpush
@endsection
