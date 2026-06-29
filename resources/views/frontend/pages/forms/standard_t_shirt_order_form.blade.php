@extends('frontend.partials.master')

@section('title',
    'Standard Sprout T-Shirt Order
    Form')

@section('content')

    @include('frontend.components.form_header', [
        'title' => 'Standard Sprout T-Shirt Order Form',
        'text' =>
            'Orders are only placed at set times. Money is due at time of order or your order will not be placed. Please get with your director or DM for next order date!The t-shirt is a 50/50 blend short sleeve shirt',
    ])
    {{-- Form Section --}}
    <section class="form-section form-section-gradient">
        <div class="container">
            <div class="site_form site_form_standardSproutTShirtOrder">
                <form id="standardSproutTShirtOrderForm" method="POST" action="{{ route('form.standardTShirtOrder') }}"
                    novalidate>
                    @csrf
                    <div class="form-wrapper">
                        <!-- Left Form Section -->
                        <div class="form-left">
                            {{-- Success/Error Messages --}}
                            <div id="formMessage" class="form-message" style="display: none;"></div>

                            <div class="form-grid">

                                {{-- First Name / Last Name --}}
                                <div class="form-field">
                                    <label for="firstName">First Name*</label>
                                    <input type="text" id="firstName" name="first_name" class="form-input" required />
                                </div>

                                <div class="form-field">
                                    <label for="lastName">Last Name*</label>
                                    <input type="text" id="lastName" name="last_name" class="form-input" required />
                                </div>

                                <div class="form-field">
                                    <label for="location">Location*</label>
                                    <select id="location" name="location" class="form-select" required>
                                        <option value="seminole" selected>Seminole</option>
                                        <option value="pinellas_park">Pinellas Park</option>
                                        <option value="largo">Largo</option>
                                        <option value="st_petersburg">St. Petersburg</option>
                                        <option value="montessori">Montessori</option>
                                    </select>
                                </div>

                                <div class="form-field">
                                    <label for="size">Size*</label>
                                    <select id="size" name="size" class="form-select" required>
                                        <option value="">Select Size</option>
                                        <option value="small">Small</option>
                                        <option value="medium">Medium</option>
                                        <option value="large">Large</option>
                                        <option value="xlarge">X-Large</option>
                                        <option value="xxlarge">XX-Large</option>
                                    </select>
                                </div>

                                {{-- Color Checkboxes using Component --}}
                                @include('frontend.components.form_components.checkbox-group', [
                                    'fieldId' => 'colors',
                                    'label' => 'Check All That Apply',
                                    'name' => 'colors',
                                    'required' => true,
                                    'columns' => 4,
                                    'options' => [
                                        'tennessee_orange' => 'Tennessee Orange',
                                        'ash' => ['value' => 'ash', 'label' => 'Ash', 'checked' => true],
                                        'graphite_heather' => 'Graphite Heather',
                                        'light_pink' => 'Light Pink',
                                        'sand' => 'Sand',
                                        'black' => 'Black',
                                        'heloconia' => 'Heloconia',
                                        'navy' => 'Navy',
                                        'sports_royal' => 'Sports Royal',
                                        'safety_green' => 'Safety Green',
                                        'gravel' => 'Gravel',
                                        'carolina_blue' => 'Carolina Blue',
                                        'irish_green' => 'Irish Green',
                                        'maroon' => 'Maroon',
                                        'sport_grey' => 'Sport Grey',
                                        'daisy' => 'Daisy',
                                        'jade_dome' => 'Jade Dome',
                                        'orchid' => 'Orchid',
                                        'sports_scarlet' => 'Sports Scarlet',
                                        'safety_orange' => 'Safety Orange',
                                        'white' => 'White',
                                        'dark_heather' => 'Dark Heather',
                                        'red' => 'Red',
                                        'orange' => 'Orange',
                                        'texas_orange' => 'Texas Orange',
                                        'electric_green' => 'Electric Green',
                                        'light_blue' => 'Light Blue',
                                        'sapphire' => 'Sapphire',
                                        'dark_green' => 'Dark Green',
                                        'scarlet_red' => 'Scarlet Red',
                                        'royal' => 'Royal',
                                        'forest' => 'Forest',
                                        'kelly_green' => 'Kelly Green',
                                        'purple' => 'Purple',
                                        'azalea' => 'Azalea',
                                        'gold' => 'Gold',
                                        'lime' => 'Lime',
                                        'sports_dark_navy' => 'Sports Dark Navy',
                                        'dark_maroon' => 'Dark Maroon',
                                    ],
                                ])

                                {{-- Special Instructions --}}
                                <div class="form-field form-field-full">
                                    <label for="specialInstructions">Special Instructions</label>
                                    <div class="textarea-wrapper">
                                        <textarea id="specialInstructions" name="special_instructions" class="form-textarea" placeholder="Type here"></textarea>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="submit-btn" id="submitBtn">
                                <span class="btn-text">Submit Now</span>
                                <span class="btn-spinner" style="display: none;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M21 12a9 9 0 11-6.219-8.56" />
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Form submission with AJAX
                const form = document.getElementById('standardSproutTShirtOrderForm');
                const submitBtn = document.getElementById('submitBtn');
                const btnText = submitBtn.querySelector('.btn-text');
                const btnSpinner = submitBtn.querySelector('.btn-spinner');
                const formMessage = document.getElementById('formMessage');

                if (form) {
                    form.addEventListener('submit', function(event) {
                        event.preventDefault();

                        // Hide previous messages
                        formMessage.style.display = 'none';
                        formMessage.className = 'form-message';

                        // Show spinner and disable button
                        btnText.style.display = 'none';
                        btnSpinner.style.display = 'inline-block';
                        submitBtn.disabled = true;

                        // Create FormData
                        const formData = new FormData(form);

                        // AJAX submission
                        fetch(form.action, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Hide spinner and enable button
                                btnText.style.display = 'inline-block';
                                btnSpinner.style.display = 'none';
                                submitBtn.disabled = false;

                                if (data.success) {
                                    // Show success message
                                    formMessage.textContent = data.message;
                                    formMessage.className = 'form-message success';
                                    formMessage.style.display = 'block';

                                    // Reset form
                                    form.reset();

                                    // Redirect to thank you page after 2 seconds
                                    setTimeout(() => {
                                        window.location.href = '{{ route('frontend.thankYou') }}';
                                    }, 2000);
                                } else {
                                    // Show error message
                                    let errorMessage = data.message ||
                                        'An error occurred. Please try again.';

                                    // Add validation errors if present
                                    if (data.errors) {
                                        const errorList = Object.values(data.errors).flat().join('<br>');
                                        errorMessage += '<br>' + errorList;
                                    }

                                    formMessage.innerHTML = errorMessage;
                                    formMessage.className = 'form-message error';
                                    formMessage.style.display = 'block';

                                    // Scroll to message
                                    formMessage.scrollIntoView({
                                        behavior: 'smooth',
                                        block: 'nearest'
                                    });
                                }
                            })
                            .catch(error => {
                                // Hide spinner and enable button
                                btnText.style.display = 'inline-block';
                                btnSpinner.style.display = 'none';
                                submitBtn.disabled = false;

                                // Show error message
                                formMessage.textContent =
                                    'An error occurred while submitting the form. Please try again later.';
                                formMessage.className = 'form-message error';
                                formMessage.style.display = 'block';

                                console.error('Error:', error);
                            });
                    });
                }
            });
        </script>
    @endpush
@endsection
