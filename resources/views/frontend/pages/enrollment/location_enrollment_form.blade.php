@extends('frontend.partials.master')

@section('title', 'Enrollment - ' . $locationData['name'])

@section('content')
    <!-- Enrollment Form Section -->
    <section class="location-enrollment-form-section">
        <div class="location-enrollment-container">
            <div class="location-enrollment-card">
                <!-- Logo -->
                <div class="location-enrollment-logo">
                    <img src="{{ asset('frontend/assets/home_page_images/small-tree.png') }}" alt="The Sprout Academy">
                </div>

                <!-- Header -->
                <div class="location-enrollment-header">
                    <h1 class="location-enrollment-title">
                        THE SPROUT ACADEMY - <span class="location-name-orange">{{ $locationData['name'] }}</span>
                    </h1>
                </div>

                <!-- Location and Phone Info Card -->
                <div class="location-enrollment-info-card">
                    <div class="location-enrollment-info-location">{{ $locationData['name'] }}, FL</div>
                    <div class="location-enrollment-info-phone">{{ $locationData['phone'] }}</div>
                </div>

                <!-- Form -->
                <div class="location-enrollment-form-content">
                    <p class="location-enrollment-instruction">To begin, please enter your email address below.</p>

                    <form id="locationEnrollmentForm" method="POST"
                        action="{{ route('enrollment.start', ['location' => $location]) }}" novalidate>
                        @csrf
                        <input type="hidden" name="referrer" value="{{ $referrer ?? '' }}">

                        <div id="formMessage" class="form-message" style="display: none;"></div>

                        <!-- Email Field -->
                        <div class="form-field location-enrollment-email-field">
                            <label for="emailAddress">Email Address*</label>
                            <input type="email" id="emailAddress" name="email"
                                class="form-input location-enrollment-input" placeholder="Johnsmith@gmail.com" required
                                aria-label="Email address">
                        </div>

                        <!-- Privacy Policy Checkbox -->
                        <div class="location-enrollment-privacy">
                            <label class="location-enrollment-checkbox-label">
                                <input type="checkbox" id="privacyPolicy" name="privacy_policy"
                                    class="checkbox-input location-enrollment-checkbox" value="1" required>
                                <span class="location-enrollment-checkbox-text">By Using This Site You Agree That You Have
                                    Read, Understand, And Agree To Our Privacy Policy.</span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn location-enrollment-submit-btn" id="submitBtn">
                            GO
                        </button>
                    </form>

                </div>
            </div>
        </div>

        <!-- Background Sprout Icon -->
        {{-- <div class="location-enrollment-bg-icon">
            <img src="{{ asset('frontend/assets/home_page_images/gallery-img-icon.png') }}" alt="Sprout Icon" aria-hidden="true">
        </div> --}}
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('locationEnrollmentForm');
            const formMessage = document.getElementById('formMessage');
            const submitBtn = document.getElementById('submitBtn');

            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Validate checkbox
                    const privacyCheckbox = document.getElementById('privacyPolicy');
                    if (!privacyCheckbox.checked) {
                        formMessage.textContent = 'Please agree to the Privacy Policy to continue.';
                        formMessage.className = 'form-message error';
                        formMessage.style.display = 'block';
                        return;
                    }

                    // Hide previous messages
                    formMessage.style.display = 'none';

                    // Disable button
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Loading...';

                    // Create FormData
                    const formData = new FormData(form);

                    // AJAX submission
                    fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            }
                        })
                        .then(response => {
                            return response.json().then(data => ({
                                status: response.status,
                                data: data
                            }));
                        })
                        .then(result => {
                            if (result.status === 200 && result.data.success) {
                                // Success - redirect to step1
                                window.location.href = result.data.redirect_url ||
                                    '{{ route('enrollment.form', ['location' => $location]) }}';
                            } else {
                                // Error
                                let errorMessage = 'An error occurred. Please try again.';
                                if (result.data.message) {
                                    errorMessage = result.data.message;
                                }
                                if (result.data.errors) {
                                    const errorList = Object.values(result.data.errors).flat().join(
                                        '<br>');
                                    errorMessage += '<br>' + errorList;
                                }
                                formMessage.innerHTML = errorMessage;
                                formMessage.className = 'form-message error';
                                formMessage.style.display = 'block';

                                // Re-enable button
                                submitBtn.disabled = false;
                                submitBtn.textContent = 'GO';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            formMessage.textContent = 'An error occurred. Please try again later.';
                            formMessage.className = 'form-message error';
                            formMessage.style.display = 'block';

                            // Re-enable button
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'GO';
                        });
                });
            }
        });
    </script>
@endpush
