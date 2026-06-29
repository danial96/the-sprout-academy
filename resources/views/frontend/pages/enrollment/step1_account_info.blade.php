@extends('frontend.partials.master')

@section('title', 'Enrollment - ' . $locationData['name'])

@section('content')
    <!-- Form Header -->
    @include('frontend.components.form_header', [
        'title' => 'THE SPROUT ACADEMY - ' . $locationData['name'],
    ])

    <!-- Enrollment Form Section -->
    <section class="enrollment-form-section">
        <div class="container">
            <div class="enrollment-form-wrapper">
                <!-- Progress Bar -->
                @include('frontend.components.enrollment.progress-bar', ['currentStep' => $currentStep])

                <!-- Welcome Message -->
                <div class="enrollment-welcome">
                    <p>Welcome! Begin by creating a new account. Enter yourself as the Primary Account Person.</p>
                </div>

                <!-- Divider Line -->
                <div class="enrollment-section-divider"></div>

                <!-- Form -->
                <div class="enrollment-form site_form">
                    <form id="enrollmentStep1Form" method="POST"
                        action="{{ route('enrollment.saveStep1', ['location' => $location]) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="referrer" value="{{ $referrer ?? '' }}">
                        <div id="formMessage" class="form-message" style="display: none;"></div>

                        <!-- PRIMARY ACCOUNT PERSON -->
                        <div class="enrollment-section" id="enrollment-form-primary-account-person">
                            <div class="section-header-wrapper">
                                <div class="section-header">
                                    <i class="far fa-user section-icon"></i>
                                    <h2 class="section-title-inner">PRIMARY ACCOUNT PERSON</h2>
                                </div>
                                <div class="section-required-note">
                                    <span class="required-asterisk">*</span> Indicates Required Field
                                </div>
                            </div>

                            <div class="form-grid">
                                <div class="form-field">
                                    <label for="firstName">First Name*</label>
                                    <input type="text" id="firstName" name="first_name" class="form-input"
                                        value="{{ $primaryContact && $primaryContact->first_name ? $primaryContact->first_name : '' }}"
                                        placeholder="Johnathan" required />
                                </div>
                                <div class="form-field">
                                    <label for="middleInitial">M.I.</label>
                                    <input type="text" id="middleInitial" name="middle_initial" class="form-input"
                                        value="{{ $primaryContact && $primaryContact->middle_initial ? $primaryContact->middle_initial : '' }}"
                                        maxlength="1" />
                                </div>
                                <div class="form-field">
                                    <label for="lastName">Last Name*</label>
                                    <input type="text" id="lastName" name="last_name" class="form-input"
                                        value="{{ $primaryContact && $primaryContact->last_name ? $primaryContact->last_name : '' }}" 
                                        placeholder="smith"
                                        required />
                                </div>
                                <div class="form-field">
                                    <label for="gender">Gender</label>
                                    <select id="gender" name="gender" class="form-select">
                                        <option value="">Select Gender</option>
                                        <option value="male"
                                            {{ $primaryContact && $primaryContact->gender == 'male' ? 'selected' : '' }}>
                                            Male</option>
                                        <option value="female"
                                            {{ $primaryContact && $primaryContact->gender == 'female' ? 'selected' : '' }}>
                                            Female</option>
                                        <option value="other"
                                            {{ $primaryContact && $primaryContact->gender == 'other' ? 'selected' : '' }}>
                                            Other</option>
                                    </select>
                                </div>
                                <div class="form-field">
                                    <label for="dateOfBirth">Date Of Birth</label>
                                    <input type="date" id="dateOfBirth" name="date_of_birth" class="form-input"
                                        value="{{ $primaryContact && $primaryContact->date_of_birth ? $primaryContact->date_of_birth->format('Y-m-d') : '' }}" />
                                </div>
                            </div>

                            <!-- Profile Picture -->
                            <div class="profile-section">
                                @include('frontend.components.enrollment.profile-picture', [
                                    'imageUrl' =>
                                        $primaryContact && $primaryContact->profile_image
                                            ? \Illuminate\Support\Facades\Storage::url(
                                                $primaryContact->profile_image)
                                            : asset('frontend/assets/home_page_images/enroll-avatar.png'),
                                    'name' =>
                                        ($primaryContact && $primaryContact->first_name
                                            ? $primaryContact->first_name
                                            : '') .
                                        ' ' .
                                        ($primaryContact && $primaryContact->last_name
                                            ? $primaryContact->last_name
                                            : ''),
                                    'fieldName' => 'profile_image',
                                    'showChangeButton' => true,
                                ])
                            </div>
                        </div>

                        <!-- Divider Line before ADDRESS -->
                        <div class="enrollment-section-divider"></div>

                        <!-- ADDRESS -->
                        <div class="enrollment-section" id="enrollment-form-address">
                            <div class="section-header">
                                <img src="{{ asset('frontend/assets/home_page_images/enroll-addr-icon.png') }}" alt="Address" class="section-icon-img">
                                <h2 class="section-title-inner">ADDRESS</h2>
                            </div>

                            <!-- First Row: 2 Address Fields -->
                            <div class="form-grid address-row-1">
                                <div class="form-field">
                                    <label for="addressLine1">Address Line 1</label>
                                    <input type="text" id="addressLine1" name="address_line_1" class="form-input"
                                        value="{{ $address->address_line_1 ?? '' }}" />
                                </div>
                                <div class="form-field">
                                    <label for="addressLine2">Address Line 2</label>
                                    <input type="text" id="addressLine2" name="address_line_2" class="form-input"
                                        value="{{ $address->address_line_2 ?? '' }}" />
                                </div>
                            </div>

                            <!-- Second Row: 3 Fields + 2 Checkboxes -->
                            <div class="form-grid address-row-2">
                                <div class="form-field">
                                    <label for="city">City</label>
                                    <input type="text" id="city" name="city" class="form-input"
                                        value="{{ $address->city ?? '' }}" />
                                </div>
                                <div class="form-field">
                                    <label for="state">State</label>
                                    <select id="state" name="state" class="form-select">
                                        <option value="">Select State</option>
                                        <option value="FL" {{ ($address->state ?? '') == 'FL' ? 'selected' : '' }}>
                                            Florida</option>
                                        <!-- Add more states as needed -->
                                    </select>
                                </div>
                                <div class="form-field">
                                    <label for="zipCode">Zip Code</label>
                                    <input type="text" id="zipCode" name="zip_code" class="form-input"
                                        value="{{ $address->zip_code ?? '' }}" />
                                </div>
                                <div class="form-field">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="is_physical" value="1" class="checkbox-input"
                                            {{ $address->is_physical ?? true ? 'checked' : '' }} />
                                        <span>Physical</span>
                                    </label>
                                </div>
                                <div class="form-field">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="is_mailing" value="1" class="checkbox-input"
                                            {{ $address->is_mailing ?? false ? 'checked' : '' }} />
                                        <span>Mailing</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Divider Line before PHONE -->
                        <div class="enrollment-section-divider"></div>

                        <!-- PHONE -->
                        <div class="enrollment-section" id="enrollment-form-phone">
                            <div class="section-header">
                                <img src="{{ asset('frontend/assets/home_page_images/enroll-tele-icon.png') }}" alt="Phone" class="section-icon-img">
                                <h2 class="section-title-inner">PHONE</h2>
                            </div>

                            <div id="phoneFieldsContainer">
                                @if (isset($phones) && count($phones) > 0)
                                    @foreach ($phones as $index => $phone)
                                        <div class="form-grid phone-field-row" data-phone-index="{{ $index }}">
                                            <div class="form-field">
                                                <label>Type</label>
                                                <select name="phone_type[]" class="form-select">
                                                    <option value="">Select Type</option>
                                                    <option value="home" {{ $phone->type == 'home' ? 'selected' : '' }}>
                                                        Home</option>
                                                    <option value="mobile"
                                                        {{ $phone->type == 'mobile' ? 'selected' : '' }}>Mobile</option>
                                                    <option value="work" {{ $phone->type == 'work' ? 'selected' : '' }}>
                                                        Work</option>
                                                </select>
                                            </div>
                                            <div class="form-field">
                                                <label>Area Code</label>
                                                <input type="text" name="phone_area_code[]" class="form-input phone-area-code"
                                                    value="{{ $phone->area_code ?? '' }}" maxlength="3"
                                                    placeholder="XXX" pattern="[0-9]{3}" />
                                            </div>
                                            <div class="form-field">
                                                <label>Phone Number</label>
                                                <input type="tel" name="phone_number[]" class="form-input phone-number"
                                                    value="{{ $phone->phone_number ?? '' }}" maxlength="8" placeholder="XXX-XXXX" pattern="[0-9-]{0,8}" />
                                            </div>
                                            @if ($index > 0)
                                                <div class="form-field">
                                                    <button type="button" class="btn-remove-phone"
                                                        onclick="removePhoneField(this)">×</button>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="form-grid phone-field-row" data-phone-index="0">
                                        <div class="form-field">
                                            <label>Type</label>
                                            <select name="phone_type[]" class="form-select">
                                                <option value="">Select Type</option>
                                                <option value="home">Home</option>
                                                <option value="mobile">Mobile</option>
                                                <option value="work">Work</option>
                                            </select>
                                        </div>
                                        <div class="form-field">
                                            <label>Area Code</label>
                                            <input type="text" name="phone_area_code[]" class="form-input phone-area-code"
                                                maxlength="3" placeholder="XXX" pattern="[0-9]{3}" />
                                        </div>
                                        <div class="form-field">
                                            <label>Phone Number</label>
                                            <input type="tel" name="phone_number[]" class="form-input phone-number"
                                                maxlength="8" placeholder="XXX-XXXX" pattern="[0-9-]{0,8}" />
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>

                        <!-- Divider Line after PHONE -->
                        <div class="enrollment-section-divider"></div>

                        <!-- Action Buttons Row -->
                        <div class="enrollment-actions-row-wrapper">
                            <div class="enrollment-actions" id="enrollment-form-action-btns">
                                <button type="submit" class="btn-enrollment btn-step2" data-action="step2">
                                    SAVE & GO TO STEP 2
                                </button>
                                <button type="submit" class="btn-enrollment btn-review" data-action="review">
                                    SAVE & GO TO REVIEW
                                </button>
                            </div>
                            <div class="phone-actions-wrapper">
                                <div
                                    style="display: flex; justify-content: flex-end; align-items: center; gap: 10px;">
                                    <i class="fas fa-plus btn-add-phone-icon" onclick="addPhoneField()"></i>
                                    <button type="button" class="btn-add-phone-text" onclick="addPhoneField()">
                                        Add New Phone
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('frontend/assets/js/enrollment-form.js') }}"></script>
    <script>
        // Profile image preview
        document.addEventListener('DOMContentLoaded', function() {
            // Profile image preview
            const profileImageInput = document.getElementById('profile_image');
            if (profileImageInput) {
                profileImageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            document.getElementById('profilePicturePreview').src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });

        // Add phone field
        function addPhoneField() {
            const container = document.getElementById('phoneFieldsContainer');
            const index = container.children.length;
            const newRow = document.createElement('div');
            newRow.className = 'form-grid phone-field-row';
            newRow.setAttribute('data-phone-index', index);
            newRow.innerHTML = `
            <div class="form-field">
                <label>Type</label>
                <select name="phone_type[]" class="form-select">
                    <option value="">Select Type</option>
                    <option value="home">Home</option>
                    <option value="mobile">Mobile</option>
                    <option value="work">Work</option>
                </select>
            </div>
            <div class="form-field">
                <label>Area Code</label>
                <input type="text" name="phone_area_code[]" class="form-input phone-area-code" maxlength="3" placeholder="XXX" pattern="[0-9]{3}" />
            </div>
            <div class="form-field">
                <label>Phone Number</label>
                <input type="tel" name="phone_number[]" class="form-input phone-number" maxlength="8" placeholder="XXX-XXXX" pattern="[0-9-]{0,8}" />
            </div>
            <div class="form-field">
                <button type="button" class="btn-remove-phone" onclick="removePhoneField(this)">×</button>
            </div>
        `;
            container.appendChild(newRow);
            // Attach validation handlers to new fields
            initPhoneFieldValidation(newRow);
        }

        // Initialize phone field validation
        function initPhoneFieldValidation(container) {
            // Area code validation - only numbers, exactly 3 digits
            const areaCodeInputs = container.querySelectorAll('.phone-area-code');
            areaCodeInputs.forEach(input => {
                input.addEventListener('input', function(e) {
                    // Remove non-numeric characters
                    this.value = this.value.replace(/[^0-9]/g, '');
                    // Limit to 3 digits
                    if (this.value.length > 3) {
                        this.value = this.value.substring(0, 3);
                    }
                });
                
                input.addEventListener('blur', function(e) {
                    // Validate on blur - must be exactly 3 digits if filled
                    if (this.value.length > 0 && this.value.length !== 3) {
                        this.setCustomValidity('Area code must be exactly 3 digits');
                        this.classList.add('error');
                    } else {
                        this.setCustomValidity('');
                        this.classList.remove('error');
                    }
                });
            });

            // Phone number validation - only numbers and dashes, max 8 characters (7 digits + 1 dash)
            // IMPORTANT: Phone number should NOT include area code
            const phoneInputs = container.querySelectorAll('.phone-number');
            phoneInputs.forEach(input => {
                input.addEventListener('input', function(e) {
                    // Allow numbers and dashes only
                    this.value = this.value.replace(/[^0-9-]/g, '');
                    // Auto-format: XXX-XXXX (7 digits total, no area code)
                    let value = this.value.replace(/-/g, '');
                    // Limit to 7 digits maximum (no area code allowed)
                    if (value.length > 7) {
                        value = value.substring(0, 7);
                    }
                    // Format as XXX-XXXX
                    if (value.length > 3) {
                        value = value.substring(0, 3) + '-' + value.substring(3, 7);
                    }
                    this.value = value;
                    // Limit to 8 characters (XXX-XXXX)
                    if (this.value.length > 8) {
                        this.value = this.value.substring(0, 8);
                    }
                });
                
                input.addEventListener('blur', function(e) {
                    // Validate on blur - should be exactly 7 digits (without area code)
                    const digits = this.value.replace(/[^0-9]/g, '');
                    if (this.value.length > 0) {
                        if (digits.length !== 7) {
                            this.setCustomValidity('Phone number must be exactly 7 digits (without area code)');
                            this.classList.add('error');
                        } else {
                            this.setCustomValidity('');
                            this.classList.remove('error');
                        }
                    } else {
                        this.setCustomValidity('');
                        this.classList.remove('error');
                    }
                });
            });
        }

        // Initialize validation for existing phone fields on page load
        document.addEventListener('DOMContentLoaded', function() {
            const phoneRows = document.querySelectorAll('.phone-field-row');
            phoneRows.forEach(row => {
                initPhoneFieldValidation(row);
            });
        });

        // Remove phone field
        function removePhoneField(button) {
            button.closest('.phone-field-row').remove();
        }
    </script>
@endpush
